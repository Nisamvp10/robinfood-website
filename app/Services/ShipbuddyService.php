<?php

namespace App\Services;

class ShipbuddyService
{
    protected $apiKey;
    protected $baseUrl;
    protected $client;

    public function __construct()
    {
        $this->apiKey  = getenv('shipbudddy.api_key');
        $this->baseUrl = rtrim(getenv('shipbudddy.baseUrl'), '/') . '/';

        $this->client = \Config\Services::curlrequest([
            'timeout' => 30
        ]);
    }

    private function request($endpoint, $method = 'GET', $data = [])
    {
        
    }

    public function createShypBuddyOrder($data)
    {
        // ✅ 1. Token (IMPORTANT: trim)
            $token = trim($this->apiKey); // set your token here

            // ✅ 2. API URL
            $url = "https://seller.shypbuddy.net/api/orderApi/createOrder";

            // ✅ 3. Request Data (FIXED: India pickup address + removed risky fields)
            $data = [
                "orderData" => [
                    "deliveryType" => "FORWARD",
                    "isDangerousGoods" => "n",
                    "paymentMode" => "prepaid",
                    "length" => 10,
                    "breadth" => 10,
                    "height" => 15,
                    "packageCount" => 1,
                    "shippingMode" => "air",
                    "deadWeight" => 0.5
                    // ❌ removed deliveryPartner (can cause 403 if not enabled)
                ],

                "customerAddressList" => [
                    "fullName" => "Nisam vp",
                    "contactNumber" => "7403312120",
                    "email" => "nisamvp10@email.com",
                    "alternateNumber" => "8129229753",
                    "buyerCompanyName" => "Pexla Pvt Ltd",
                    "buyerGstin" => "",
                    "address" => "B-404, Silver Heights, Sector 7",
                    "landmark" => "Near City Mall",
                    "pincode" => 679584,
                    "createdAt" => date('c'),
                    "city" => "Malappuram",
                    "state" => "Kerala"
                ],

                "packageList" => [
                    [
                        "name" => "Gaming Laptop",
                        "qty" => 1,
                        "price" => 82000,
                        "category" => "Electronics",
                        "sku" => "LAP-GM-001",
                        "hsnCode" => "847130"
                    ]
                ],

                // ✅ FIXED: Indian pickup address (VERY IMPORTANT)
                "pickUpAddress" => [
                    "address" => "Your Warehouse Address",
                    "landmark" => "Near Bus Stand",
                    "pincode" => 676102,
                    "city" => "Malappuram",
                    "state" => "Kerala",
                    "country" => "India"
                ]
            ];

            $payload = json_encode($data);

            // ✅ 4. cURL INIT
            $ch = curl_init($url);

            curl_setopt_array($ch, [
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_POST => true,
                CURLOPT_POSTFIELDS => $payload,
                CURLOPT_HTTPHEADER => [
                    "Content-Type: application/json",
                    "Authorization: Bearer " . $token
                ],
                CURLOPT_TIMEOUT => 30,
                CURLOPT_CONNECTTIMEOUT => 10,
                CURLOPT_VERBOSE => true
            ]);

            // ✅ 5. Execute
            $response = curl_exec($ch);

            // ✅ 6. Debug Info
            $error = curl_error($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

            curl_close($ch);

            // ✅ 7. Output Response
            echo "<pre>";
            echo "HTTP CODE: " . $httpCode . "\n\n";

            if ($error) {
                echo "CURL ERROR:\n" . $error . "\n\n";
            }

            echo "RAW RESPONSE:\n";
            print_r($response);

            echo "\n\nDECODED RESPONSE:\n";
            print_r(json_decode($response, true));
    }

    public function trackShipment($trackingNumber)
    {
        return $this->request('shipments/track/' . $trackingNumber);
    }
}