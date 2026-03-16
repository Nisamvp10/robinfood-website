<?php
namespace App\Services;

class ShipbuddyService
{
    private $apiKey;
    private $baseUrl;
    public function __construct()
    {
        $this->apiKey = getenv('shipbudddy.api_key');
        $this->baseUrl = getenv('shipbudddy.baseUrl');
    }
    private function request($endpoint, $method="GET", $data=[])
    {
        $client = \Config\Services::curlrequest();

        $options = [
            'headers' => [
                'Authorization' => 'Bearer ' . $this->apiKey,
                'Content-Type' => 'application/json'
            ]
        ];

        if ($method == "POST") {
            $options['json'] = $data;
        }

        $response = $client->request($method, $this->baseUrl.$endpoint, $options);

        return json_decode($response->getBody(), true);
    }

    public function createShipment($data)
    {
        return $this->request("shipments/create", "POST", $data);
    }

    public function trackShipment($trackingNumber)
    {
        return $this->request("shipments/track/".$trackingNumber, "GET");
    }
}