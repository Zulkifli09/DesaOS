<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class WhatsAppWebhookController extends Controller
{
    /**
     * Handle incoming messages from WhatsApp Gateway
     */
    public function handle(Request $request)
    {
        // Verify Authorization token
        $token = $request->bearerToken();
        if ($token !== config('whatsapp.webhook_token')) {
            Log::warning('Unauthorized Webhook attempt: ' . $request->ip());
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $messageData = $request->input('message');
        
        if (!$messageData) {
            return response()->json(['error' => 'Bad Request'], 400);
        }

        // For Milestone 31, we just log it to verify the foundation works
        // Bot logic (Milestone 32+) will be implemented here or dispatched as a Job
        Log::info('WhatsApp Webhook Received: ', [
            'remoteJid' => $messageData['key']['remoteJid'] ?? 'unknown',
            'pushName' => $messageData['pushName'] ?? 'unknown',
            'content' => $this->extractMessageContent($messageData)
        ]);

        return response()->json(['success' => true]);
    }

    /**
     * Helper to extract text from Baileys message object
     */
    private function extractMessageContent(array $msg): string
    {
        $message = $msg['message'] ?? [];
        
        if (isset($message['conversation'])) {
            return $message['conversation'];
        }
        
        if (isset($message['extendedTextMessage']['text'])) {
            return $message['extendedTextMessage']['text'];
        }

        return '[Non-text message]';
    }
}
