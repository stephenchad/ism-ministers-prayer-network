<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactMessage;
use App\Mail\PrayerRequest;
use App\Models\Contact;
use App\Models\PrayerRequest as PrayerRequestModel;
use App\Models\Coordinator;
use App\Models\SiteStat;
use App\Models\PageContent;

class ContactController extends Controller
{
    public function index(){
        $coordinators = Coordinator::where('is_active', true)
                                 ->orderBy('sort_order')
                                 ->take(3)
                                 ->get();
        
        $contactStats = SiteStat::getForPage('about'); // Reuse about stats for contact page
        
        // Fetch page content for contact page
        $pageContents = PageContent::getForPage('contact');
        
        return view('front.contact', compact('coordinators', 'contactStats', 'pageContents'));
    }

    public function sendContact(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string'
        ]);

        try {
            // Save to database first
            Contact::create([
                'name' => $request->name,
                'email' => $request->email,
                'subject' => $request->subject,
                'message' => $request->message
            ]);

            // Try to send email (optional)
            try {
                Mail::to('info@ismprayernetwork.org')->send(new ContactMessage($request->all()));
            } catch (\Exception $emailError) {
                // Email failed but database save succeeded
            }
            
            return back()->with('success', 'Thank you for your message. We have received it and will get back to you soon!');
        } catch (\Exception $e) {
            return back()->with('error', 'Sorry, there was an error sending your message. Please try again.');
        }
    }

    public function sendPrayerRequest(Request $request)
    {
        $request->validate([
            'name' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'prayer_type' => 'required|string',
            'prayer_request' => 'required|string'
        ]);

        try {
            // Save to database first
            PrayerRequestModel::create([
                'name' => $request->name,
                'email' => $request->email,
                'prayer_type' => $request->prayer_type,
                'prayer_request' => $request->prayer_request
            ]);

            // Try to send email notification (optional)
            try {
                Mail::to('prayer@ismprayernetwork.org')->send(new PrayerRequest($request->all()));
            } catch (\Exception $emailError) {
                // Email failed but database save succeeded
            }
            
            return back()->with('success', 'Your prayer request has been submitted. Our prayer team will lift you up in prayer.');
        } catch (\Exception $e) {
            return back()->with('error', 'Sorry, there was an error submitting your prayer request. Please try again.');
        }
    }
}
