<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WhatsAppGatewayService
{
    protected string $baseUrl;
    protected string $apiKey;

    public function __construct()
    {
        $this->baseUrl = config('whatsapp.gateway_url');
        $this->apiKey = config('whatsapp.api_key');
    }

    /**
     * Get gateway status
     */
    public function getStatus(): array
    {
        try {
            $response = Http::withHeaders([
                'x-api-key' => $this->apiKey
            ])->get("{$this->baseUrl}/api/status");

            if ($response->successful()) {
                return $response->json();
            }
            
            return ['status' => 'error', 'message' => 'Gateway returned ' . $response->status()];
        } catch (\Exception $e) {
            Log::error("WhatsApp Gateway getStatus Error: " . $e->getMessage());
            return ['status' => 'offline', 'message' => $e->getMessage()];
        }
    }

    /**
     * Get QR Code for pairing
     */
    public function getQrCode(): array
    {
        try {
            $response = Http::withHeaders([
                'x-api-key' => $this->apiKey
            ])->get("{$this->baseUrl}/api/qr");

            if ($response->successful()) {
                return $response->json();
            }
            
            return ['status' => 'error', 'message' => 'Gateway returned ' . $response->status()];
        } catch (\Exception $e) {
            Log::error("WhatsApp Gateway getQrCode Error: " . $e->getMessage());
            return ['status' => 'offline', 'message' => $e->getMessage()];
        }
    }

    /**
     * Logout and destroy session
     */
    public function logout(): array
    {
        try {
            $response = Http::withHeaders([
                'x-api-key' => $this->apiKey
            ])->post("{$this->baseUrl}/api/logout");

            if ($response->successful()) {
                return $response->json();
            }
            
            return ['success' => false, 'error' => 'Gateway returned ' . $response->status()];
        } catch (\Exception $e) {
            Log::error("WhatsApp Gateway logout Error: " . $e->getMessage());
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }

    /**
     * Send text message
     * 
     * @param string $jid Target phone number (e.g. 08123456789 or 628123456789)
     * @param string $text Message content
     */
    public function sendMessage(string $jid, string $text): array
    {
        try {
            $response = Http::withHeaders([
                'x-api-key' => $this->apiKey
            ])->post("{$this->baseUrl}/api/send", [
                'jid' => $jid,
                'type' => 'text',
                'text' => $text,
            ]);

            if ($response->successful()) {
                return $response->json();
            }
            
            Log::warning("Failed to send WA message to {$jid}. Response: " . $response->body());
            return ['success' => false, 'error' => 'Gateway returned ' . $response->status()];
        } catch (\Exception $e) {
            Log::error("WhatsApp Gateway sendMessage Error: " . $e->getMessage());
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }
}
