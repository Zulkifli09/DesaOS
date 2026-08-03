<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\WhatsAppGatewayService;
use Illuminate\Http\Request;

class WhatsAppController extends Controller
{
    protected WhatsAppGatewayService $waService;

    public function __construct(WhatsAppGatewayService $waService)
    {
        $this->waService = $waService;
    }

    /**
     * Display Gateway Dashboard and QR Code
     */
    public function index()
    {
        // Try to fetch connection status
        $statusData = $this->waService->getStatus();
        
        $isConnected = false;
        $qrCode = null;
        $status = 'offline';

        if (isset($statusData['status'])) {
            $status = $statusData['status'];
            if ($status === 'open') {
                $isConnected = true;
            } elseif ($status === 'qr') {
                // Fetch QR if available
                $qrData = $this->waService->getQrCode();
                if (isset($qrData['qr'])) {
                    $qrCode = $qrData['qr'];
                }
            }
        }

        return view('admin.whatsapp.index', compact('isConnected', 'status', 'qrCode'));
    }

    /**
     * Logout and restart session
     */
    public function logout()
    {
        $response = $this->waService->logout();

        if (isset($response['success']) && $response['success']) {
            return redirect()->back()->with('success', 'Berhasil memutuskan koneksi WhatsApp. Sesi telah direset.');
        }

        return redirect()->back()->with('error', 'Gagal memutuskan koneksi: ' . ($response['error'] ?? 'Unknown Error'));
    }
}
