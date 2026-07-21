<?php

namespace App\Services;

class ShiprocketService
{
    protected $baseUrl = "https://apiv2.shiprocket.in/v1/external/";
    protected $token;

    public function __construct()
    {
        $this->token = $this->generateToken();

        if (!$this->token) {
            throw new \Exception("Unable to generate Shiprocket Token.");
        }
    }

    /**
     * Generate JWT Token
     */
    private function generateToken()
    {
        $response = $this->sendRequest(
            "POST",
            $this->baseUrl . "auth/login",
            [
                "email"    => env("shiprocket.email"),
                "password" => env("shiprocket.password")
            ],
            false
        );

        return $response['token'] ?? null;
    }

    /**
     * Common API Request
     */
    private function sendRequest($method, $url, $data = [], $useToken = true)
    {
        $ch = curl_init();

        $headers = [
            "Content-Type: application/json",
            "Accept: application/json"
        ];

        if ($useToken && !empty($this->token)) {
            $headers[] = "Authorization: Bearer " . $this->token;
        }

        curl_setopt_array($ch, [
            CURLOPT_URL            => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST  => strtoupper($method),
            CURLOPT_HTTPHEADER     => $headers,
            CURLOPT_SSL_VERIFYPEER => true,
            CURLOPT_TIMEOUT        => 30
        ]);

        if (strtoupper($method) != "GET" && !empty($data)) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        }

        $response = curl_exec($ch);

        if (curl_errno($ch)) {

            return [
                'status' => false,
                'error'  => curl_error($ch)
            ];
        }

        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        curl_close($ch);

        $result = json_decode($response, true);

        $result['http_code'] = $httpCode;

        return $result;
    }

    /**
     * Get Pickup Locations
     */
    public function getPickupLocations()
    {
        return $this->sendRequest(
            "GET",
            $this->baseUrl . "settings/company/pickup"
        );
    }

    /**
     * Create Order
     */
    public function createOrder($data)
    {
        return $this->sendRequest(
            "POST",
            $this->baseUrl . "orders/create/adhoc",
            $data
        );
    }

    /**
     * Track Shipment
     */
    public function trackShipment($awb)
    {
        return $this->sendRequest(
            "GET",
            $this->baseUrl . "courier/track/awb/" . $awb
        );
    }

    /**
     * Cancel Order
     */
    public function cancelOrder($orderId)
    {
        return $this->sendRequest(
            "POST",
            $this->baseUrl . "orders/cancel",
            [
                "ids" => [$orderId]
            ]
        );
    }

    /**
     * Return Token
     */
    public function getToken()
    {
        return $this->token;
    }

    public function getShippingCharges($pickupPincode, $deliveryPincode, $weight, $cod = 0, $length = 10, $breadth = 10, $height = 5)
    {
      
        $url = $this->baseUrl . "courier/serviceability?" . http_build_query([
            "pickup_postcode"   => $pickupPincode,
            "delivery_postcode" => $deliveryPincode,
            "cod"               => $cod,
            "weight"            => $weight,
            "length"            => $length,
            "breadth"           => $breadth,
            "height"            => $height
        ]);

        return $this->sendRequest("GET", $url);
    }

}