<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BulkMessage;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Notifications\BulkMessageSent;

class BulkMessageController extends Controller
{
    public function index()
    {
        $bulkMessages = BulkMessage::with('sender')->orderBy('created_at', 'desc')->paginate(20);

        return view('admin.bulk-messages.index', compact('bulkMessages'));
    }

    public function create()
    {
        return view('admin.bulk-messages.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|in:email,sms',
            'subject' => 'required_if:type,email|max:255',
            'message' => 'required',
            'send_to_all' => 'sometimes|boolean',
            'recipients' => 'required_without:send_to_all|array',
            'recipients.*' => 'exists:users,id',
        ]);

        if ($request->has('send_to_all') && $request->send_to_all) {
            $recipients = User::all();
            $recipientIds = $recipients->pluck('id')->toArray();
        } else {
            $recipients = User::whereIn('id', $request->recipients)->get();
            $recipientIds = $request->recipients;
        }

        $bulkMessage = BulkMessage::create([
            'type' => $request->type,
            'subject' => $request->subject,
            'message' => $request->message,
            'recipients' => $recipientIds,
            'total_recipients' => count($recipientIds),
            'sent_by' => auth()->id(),
        ]);

        // Send the messages
        $this->sendBulkMessages($bulkMessage, $recipients);

        // Notify admins
        $admins = User::where('role', 'admin')->get();
        foreach ($admins as $admin) {
            $admin->notify(new BulkMessageSent($bulkMessage));
        }

        return redirect()->route('admin.bulk-messages.index')->with('success', 'Bulk message sent successfully!');
    }

    private function sendBulkMessages(BulkMessage $bulkMessage, $recipients)
    {
        $sentCount = 0;
        $failedRecipients = [];

        foreach ($recipients as $user) {
            try {
                if ($bulkMessage->type === 'email') {
                    $this->sendEmail($user, $bulkMessage);
                } elseif ($bulkMessage->type === 'sms') {
                    $this->sendSMS($user, $bulkMessage);
                }
                $sentCount++;
            } catch (\Exception $e) {
                Log::error('Failed to send bulk message to user ' . $user->id . ': ' . $e->getMessage());
                $failedRecipients[] = [
                    'user_id' => $user->id,
                    'email' => $user->email,
                    'mobile' => $user->mobile,
                    'error' => $e->getMessage(),
                ];
            }
        }

        $bulkMessage->update([
            'sent_count' => $sentCount,
            'failed_count' => count($failedRecipients),
            'failed_recipients' => $failedRecipients,
            'sent_at' => now(),
        ]);
    }

    private function sendEmail(User $user, BulkMessage $bulkMessage)
    {
        // Send as HTML email instead of raw text to render HTML tags properly
        Mail::html($bulkMessage->message, function ($message) use ($user, $bulkMessage) {
            $message->to($user->email)
                ->subject($bulkMessage->subject);
        });
    }

    private function sendSMS(User $user, BulkMessage $bulkMessage)
    {
        // This is a placeholder for SMS sending
        // You would integrate with an SMS gateway like Twilio, Nexmo, etc.
        // For now, we'll just log it

        if (empty($user->mobile)) {
            throw new \Exception('User has no mobile number');
        }

        // Example integration with a generic SMS API
        // Replace with your actual SMS gateway
        $response = Http::post('https://api.sms-gateway.com/send', [
            'to' => $user->mobile,
            'message' => $bulkMessage->message,
            'api_key' => config('services.sms.api_key'),
        ]);

        if (!$response->successful()) {
            throw new \Exception('SMS sending failed: ' . $response->body());
        }

        Log::info('SMS sent to ' . $user->mobile . ': ' . $bulkMessage->message);
    }

    public function show($id)
    {
        $bulkMessage = BulkMessage::with('sender')->findOrFail($id);

        return view('admin.bulk-messages.show', compact('bulkMessage'));
    }

    public function destroy($id)
    {
        $bulkMessage = BulkMessage::findOrFail($id);
        $bulkMessage->delete();

        return response()->json(['status' => true, 'message' => 'Bulk message deleted successfully.']);
    }
}
