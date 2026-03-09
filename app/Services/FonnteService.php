<?php

namespace App\Services;

use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class FonnteService
{
    protected $token;

    public function __construct(?string $token = null)
    {
        $this->token = $token;
    }

    /**
     * Kirim pesan ke WhatsApp
     *
     * @return array|null
     */
    public function send(array $messages)
    {
        $payload = [
            'data' => json_encode($messages),
        ];

        try {
            $response = Http::withHeaders([
                'Authorization' => $this->token,
            ])->timeout(10) // timeout 10 detik
                ->post('https://api.fonnte.com/send', $payload);

            // jika status code bukan 200, anggap error
            if (! $response->successful()) {
                Log::error('Fonnte API Error', [
                    'status' => $response->status(),
                    'body' => $response->body(),
                ]);

                return null;
            }

            // log response sukses (opsional)
            Log::info('Fonnte API Response', [
                'response' => $response->json(),
            ]);

            return $response->json();

        } catch (Exception $e) {
            Log::error('Fonnte API Exception', [
                'message' => $e->getMessage(),
            ]);

            return null;
        }
    }
}
