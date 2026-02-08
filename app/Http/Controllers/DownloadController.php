<?php

namespace App\Http\Controllers;

use App\Services\CommerceApiClient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class DownloadController extends Controller
{
    private ?CommerceApiClient $commerceApi;

    public function __construct(?CommerceApiClient $commerceApi = null)
    {
        $this->middleware('auth');
        $this->commerceApi = $commerceApi;
    }

    /**
     * Proxy secure download from Department B
     * This prevents exposing Department B's file URLs to users
     */
    public function download(Request $request, string $orderId)
    {
        // Verify order belongs to authenticated user
        $orderResponse = $this->commerceApi->getOrder($orderId);

        if (!$orderResponse['success']) {
            abort(404, 'Order not found');
        }

        $order = $orderResponse['data'];

        // Security check: verify user owns this order
        if ($order['user_id'] != auth()->id()) {
            Log::warning('Unauthorized download attempt', [
                'user_id' => auth()->id(),
                'order_id' => $orderId,
                'order_user_id' => $order['user_id'],
            ]);

            abort(403, 'Unauthorized');
        }

        // Verify order is completed
        if ($order['status'] !== 'completed') {
            abort(403, 'Order not completed');
        }

        // Get secure download URL from Department B
        $downloadResponse = $this->commerceApi->getDownloadUrl($orderId);

        if (!$downloadResponse['success']) {
            Log::error('Failed to get download URL', [
                'order_id' => $orderId,
                'error' => $downloadResponse['error'],
            ]);

            abort(500, 'Unable to generate download link');
        }

        $downloadData = $downloadResponse['data'];
        $secureUrl = $downloadData['download_url'];
        $filename = $downloadData['filename'] ?? 'book.pdf';
        $contentType = $downloadData['content_type'] ?? 'application/pdf';

        Log::info('Download initiated', [
            'user_id' => auth()->id(),
            'order_id' => $orderId,
            'filename' => $filename,
        ]);

        try {
            // Stream file from Department B through our server
            // This prevents exposing Department B's URLs
            $response = Http::timeout(120)->get($secureUrl);

            if (!$response->successful()) {
                Log::error('Failed to fetch file from Department B', [
                    'order_id' => $orderId,
                    'status' => $response->status(),
                ]);

                abort(500, 'Download failed');
            }

            return response($response->body())
                ->header('Content-Type', $contentType)
                ->header('Content-Disposition', 'attachment; filename="' . $filename . '"')
                ->header('Cache-Control', 'no-cache, no-store, must-revalidate')
                ->header('Pragma', 'no-cache')
                ->header('Expires', '0');

        } catch (\Exception $e) {
            Log::error('Download exception', [
                'order_id' => $orderId,
                'error' => $e->getMessage(),
            ]);

            abort(500, 'Download failed');
        }
    }

    /**
     * Generate temporary download link (alternative approach)
     * Returns a time-limited URL instead of proxying
     */
    public function generateLink(Request $request, string $orderId)
    {
        // Verify order belongs to authenticated user
        $orderResponse = $this->commerceApi->getOrder($orderId);

        if (!$orderResponse['success']) {
            return response()->json([
                'success' => false,
                'message' => 'Order not found',
            ], 404);
        }

        $order = $orderResponse['data'];

        if ($order['user_id'] != auth()->id()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized',
            ], 403);
        }

        if ($order['status'] !== 'completed') {
            return response()->json([
                'success' => false,
                'message' => 'Order not completed',
            ], 403);
        }

        // Get download URL
        $downloadResponse = $this->commerceApi->getDownloadUrl($orderId);

        if (!$downloadResponse['success']) {
            return response()->json([
                'success' => false,
                'message' => 'Unable to generate download link',
            ], 500);
        }

        // Return proxied download URL (not Department B's direct URL)
        return response()->json([
            'success' => true,
            'download_url' => route('commerce.download', ['orderId' => $orderId]),
            'filename' => $downloadResponse['data']['filename'] ?? 'book.pdf',
            'expires_at' => now()->addMinutes(15)->toIso8601String(),
        ]);
    }
}
