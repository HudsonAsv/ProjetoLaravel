<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class TextModerationService
{
    protected string $apiKey;

    public function __construct()
    {
        $this->apiKey = env('PERSPECTIVE_API_KEY');
    }

    public function isToxic(string $text): bool
    {
        $url = 'https://commentanalyzer.googleapis.com/v1alpha1/comments:analyze?key=' . $this->apiKey;

        $payload = [
            'comment' => ['text' => $text],
            'languages' => ['pt'],
            'requestedAttributes' => ['TOXICITY' => []]
        ];

        $response = Http::post($url, $payload);

        if ($response->successful()) {
            $score = $response->json()['attributeScores']['TOXICITY']['summaryScore']['value'];
            return $score >= 0.7;
        }

        return false;
    }
}
