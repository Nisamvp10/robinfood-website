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
        $client = \Config\Services::curlrequest();
        try {
            $options = [
                'headers' => [
                    'Content-Type'  => 'application/json',
                    'Authorization' => 'Bearer ' . $this->token,
                ]
            ];

            if ($method !== 'GET') {
                $options['json'] = $data;
            }
echo "<pre>";
print_r($options);
exit;
            $response = $client->request($method, $this->baseUrl . $endpoint, $options);

            return json_decode($response->getBody(), true);

        } catch (\Exception $e) {
            return [
                'status' => false,
                'error'  => $e->getMessage()
            ];
        }
    }
}