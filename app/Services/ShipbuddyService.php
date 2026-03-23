<?php

namespace App\Services;

class ShipbuddyService
{
    protected $baseUrl;
    protected $token;
    public function __construct()
    {
        $this->token  = getenv('shipbudddy.api_key');
        $this->baseUrl = 'https://seller.shypbuddy.net/api/';
        $this->client = \Config\Services::curlrequest([
            'timeout' => 30
        ]);
    }

  public function request($endpoint, $method = 'POST', $data = [])
    {
        $url = $this->baseUrl . $endpoint;

        $ch = curl_init();

        $headers = [
            'Content-Type: application/json',
            'Authorization: Bearer ' .$this->token
        ];

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        // Method handling
        if ($method == 'POST') {
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        } elseif ($method == 'PUT' || $method == 'PATCH' || $method == 'DELETE') {
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        } elseif ($method == 'GET') {
            curl_setopt($ch, CURLOPT_HTTPGET, true);
        }

        // Debug (optional)
        curl_setopt($ch, CURLOPT_VERBOSE, true);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if (curl_errno($ch)) {
            return [
                'status' => false,
                'error' => curl_error($ch)
            ];
        }
        curl_close($ch);

        return [
            'status_code' => $httpCode,
            'response' => json_decode($response, true),
            'raw' => $response
        ];
    }
}
