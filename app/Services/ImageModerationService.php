<?php

namespace App\Services;

class ImageModerationService
{
   protected string $apiUser;
protected string $apiSecret;
protected string $endpoint;

public function __construct()
{
    $this->apiUser = env('SIGHTENGINE_USER');
    $this->apiSecret = env('SIGHTENGINE_SECRET');
    $this->endpoint = env('SIGHTENGINE_ENDPOINT');
}
    public function moderateFromUrl(string $imageUrl): array
    {
        $params = [
            'url' => $imageUrl,
            'models' => 'nudity-2.1,offensive-2.0,faces,scam,text-content,gore-2.0,text,qr-content,violence',
            'api_user' => $this->apiUser,
            'api_secret' => $this->apiSecret,
        ];

        $ch = curl_init($this->endpoint . '?' . http_build_query($params));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($ch);
        curl_close($ch);

        return json_decode($response, true);
    }
}
