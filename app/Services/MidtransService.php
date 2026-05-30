<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class MidtransService
{
    protected string $serverKey;
    protected string $clientKey;
    protected bool $isProduction;
    protected string $baseUrl;

    public function __construct()
    {
        $this->serverKey = config('services.midtrans.server_key') ?? '';
        $this->clientKey = config('services.midtrans.client_key') ?? '';
        $this->isProduction = config('services.midtrans.is_production', false);
        
        $this->baseUrl = $this->isProduction
            ? 'https://app.midtrans.com'
            : 'https://app.sandbox.midtrans.com';
    }

    /**
     * Get Midtrans Snap Token
     */
    public function getSnapToken(array $params): ?string
    {
        $url = $this->baseUrl . '/snap/v1/transactions';
        $auth = base64_encode($this->serverKey . ':');

        try {
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
                'Authorization' => 'Basic ' . $auth,
            ])->post($url, $params);

            if ($response->successful()) {
                return $response->json()['token'] ?? null;
            }

            Log::error('Midtrans API Error: ' . $response->body());
            return null;
        } catch (\Exception $e) {
            Log::error('Midtrans Exception: ' . $e->getMessage());
            return null;
        }
    }
}
