<?php

namespace App\Services;
use Illuminate\Support\Facades\Log;
use GuzzleHttp\Client;
use App\Models\Reply;

class ChatbotService
{
    public function generateResponse($userMessage, $apiKey, $behavior)
{
    $url = 'https://api.openai.com/v1/chat/completions';

    $headers = [
        'Authorization' => 'Bearer ' . $apiKey,
        'Content-Type' => 'application/json',
    ];

    $data = [
        'messages' => [
            ['role' => 'system', 'content' => $behavior],
            ['role' => 'user', 'content' => $userMessage],
        ],
        'model' => 'gpt-3.5-turbo', // Add the model parameter
    ];

    $client = new Client(['headers' => $headers]);

    try {
        $response = $client->post($url, [
            'json' => $data,
        ]);

        $responseData = json_decode($response->getBody(), true);

        $botMessage = $responseData['choices'][0]['message']['content'];

        return $botMessage;
    } catch (\Exception $e) {
        // Log the error
        \Log::error('Error during API request: ' . $e->getMessage());

        // Return a default response or handle the error as needed
        return 'An error occurred while processing your request.';
    }
}

}
