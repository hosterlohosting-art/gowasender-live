<?php

namespace App\Traits;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

trait DeviceTrait
{
    /**
     * Get the base URL for the WhatsApp API
     */
    private function getApiBaseUrl()
    {
        return config('services.whatsapp.url');
    }

    /**
     * Create a new session (instance) on the Node.js server
     */
    public function createSession($sessionId)
    {
        try {
            $response = Http::post($this->getApiBaseUrl() . '/sessions/add', [
                'sessionId' => $sessionId,
            ]);

            return $response->json();
        } catch (\Exception $e) {
            Log::error('WhatsApp API Error (createSession): ' . $e->getMessage());
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    /**
     * Get the QR code for a session
     */
    public function getSessionQR($sessionId)
    {
        try {
            // Some APIs might return the QR in the add session response, 
            // others might have a separate endpoint.
            $response = Http::get($this->getApiBaseUrl() . '/sessions/qr/' . $sessionId);
            return $response->json();
        } catch (\Exception $e) {
            Log::error('WhatsApp API Error (getSessionQR): ' . $e->getMessage());
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    /**
     * Check the status of a session
     */
    public function getSessionStatus($sessionId)
    {
        try {
            $response = Http::get($this->getApiBaseUrl() . '/sessions/status/' . $sessionId);
            return $response->json();
        } catch (\Exception $e) {
            Log::error('WhatsApp API Error (getSessionStatus): ' . $e->getMessage());
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    /**
     * Delete a session
     */
    public function deleteSession($sessionId)
    {
        try {
            $response = Http::delete($this->getApiBaseUrl() . '/sessions/delete/' . $sessionId);
            return $response->json();
        } catch (\Exception $e) {
            Log::error('WhatsApp API Error (deleteSession): ' . $e->getMessage());
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    /**
     * Send a text message via the unofficial API
     */
    public function sendDeviceMessage($sessionId, $to, $text)
    {
        try {
            $response = Http::post($this->getApiBaseUrl() . '/messages/send', [
                'sessionId' => $sessionId,
                'to' => $to,
                'text' => $text,
            ]);

            return $response->json();
        } catch (\Exception $e) {
            Log::error('WhatsApp API Error (sendDeviceMessage): ' . $e->getMessage());
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }
}
