<?php

namespace App\Services;

use App\Models\ShiprocketTokenModel;

class ShiprocketService
{
    protected $baseUrl = "https://apiv2.shiprocket.in/v1/external/";
    protected $token;
    protected $tokenModel;

    public function __construct()
    {
        $this->tokenModel = new ShiprocketTokenModel();
        $this->token = $this->getValidToken();

        if (!$this->token) {
            throw new \Exception("Unable to generate Shiprocket Token.");
        }
    }

    /**
     * Get Token From Database or Generate New One
     */
    private function getValidToken()
    {
        $row = $this->tokenModel->first();

        if ($row) {

            if (strtotime($row['expires_at']) > time()) {
                return $row['token'];
            }

        }

        return $this->generateToken();
    }

    /**
     * Login and Save Token
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

        if (!isset($response['token'])) {
            return null;
        }

        $token = $response['token'];

        /*
         Shiprocket token is usually valid for about 10 days.
         Change if Shiprocket changes their expiry.
        */

        $expires = date('Y-m-d H:i:s', strtotime('+9 days'));

        $existing = $this->tokenModel->first();

        if ($existing) {

            $this->tokenModel->update($existing['id'], [
                'token' => $token,
                'expires_at' => $expires
            ]);

        } else {

            $this->tokenModel->insert([
                'token' => $token,
                'expires_at' => $expires
            ]);

        }

        return $token;
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
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => strtoupper($method),
            CURLOPT_HTTPHEADER => $headers,
            CURLOPT_SSL_VERIFYPEER => true,
            CURLOPT_CONNECTTIMEOUT => 10,
            CURLOPT_TIMEOUT => 30
        ]);

        if (strtoupper($method) != "GET" && !empty($data)) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        }

        $response = curl_exec($ch);

        if (curl_errno($ch)) {

            curl_close($ch);

            return [
                'status' => false,
                'error' => curl_error($ch)
            ];
        }

        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        curl_close($ch);

        $result = json_decode($response, true);

        if (!is_array($result)) {
            $result = [];
        }

        $result['http_code'] = $httpCode;

        /*
         Token Expired?
         Login Again Automatically
        */

        if ($httpCode == 401 && $useToken) {

            $this->token = $this->generateToken();

            if ($this->token) {

                return $this->sendRequest(
                    $method,
                    $url,
                    $data,
                    true
                );

            }

        }

        return $result;
    }

    /**
     * Pickup Locations
     */
    public function getPickupLocations()
    {
        return $this->sendRequest(
            "GET",
            $this->baseUrl . "settings/company/pickup"
        );
    }

    /**
     * Shipping Charges
     */
    public function getShippingCharges($pickupPincode,$deliveryPincode,$weight,$cod = 0,$length = 10,$breadth = 10,$height = 5) {

        $url = $this->baseUrl . "courier/serviceability?" . http_build_query([
            "pickup_postcode" => $pickupPincode,
            "delivery_postcode" => $deliveryPincode,
            "cod" => $cod,
            "weight" => $weight,
            "length" => $length,
            "breadth" => $breadth,
            "height" => $height
        ]);

        return $this->sendRequest("GET", $url);
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
     * Return Current Token
     */
    public function getToken()
    {
        return $this->token;
    }

    public function assignCourier($shipmentId)
    {
        return $this->sendRequest(
            "POST",
            $this->baseUrl . "courier/assign/awb",
            [
                "shipment_id" => $shipmentId
            ]
        );
    }
}