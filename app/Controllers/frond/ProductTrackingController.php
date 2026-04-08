<?php
namespace App\Controllers\frond;

use App\Controllers\BaseController;
use App\Services\ShipbuddyService;

class ProductTrackingController extends BaseController
{
    protected $shipbuddyService;

    public function __construct()
    {
        $this->shipbuddyService = new ShipbuddyService();
    }   
    public function index()
    {
        $page = "Product Tracking";
        return view('frontend/product-tracking', compact('page'));
    }

   public function trackOrder()
    {
        $orderId = 'ORD' . time();

        // $payload = [
        //     "orderData" => [
        //         "deliveryType" => "FORWARD",
        //         "isDangerousGoods" => "n",
        //         "paymentMode" => "cod",
        //         "length" => 10,
        //         "breadth" => 10,
        //         "height" => 10,
        //         "warehouseName" => "robin food",
        //         "packageCount" => 1,
        //         "shippingMode" => "surface",
        //         "deadWeight" => 0.5
        //     ],
        //     "customerAddressList" => [
        //          "fullName" => "Test User",
        //         "contactNumber" => "9999999999",
        //         "email" => "nisamvp10@gmail.com",
        //         "alternateNumber" => "9999999999",
        //         "address" => "Kerala Address",
        //         "landmark" => "Near Area",
        //         "pincode" => 676505,
        //         "city" => "Malappuram",
        //         "state" => "Kerala",
        //         "country" => "India"              
        //     ],
        //     "packageList" => [
        //         [
        //             "name" => "Test Product",
        //             "qty" => 1,
        //             "price" => 500,
        //             "category" => "General",
        //             "sku" => "SKU001",
        //             "hsnCode" => "1234"
        //         ]
        //     ]
        // ];

        $payload = [
        "orderData"=> [
            "deliveryType"=> "FORWARD",
            "isDangerousGoods"=> "n",
            "paymentMode"=> "prepaid",
            "length"=> 10,
            "warehouseName" => "robin food",
            "breadth"=> 10,
            "height"=> 15,
            "packageCount"=> 2,
            "shippingMode"=> "air",
            "deadWeight"=> 0.5,
            //"deliveryPartner"=> "bluedart surface"
        ],
        "customerAddressList"=> [
            "fullName"=> "Rahul Kumar",
            "contactNumber"=> "9876543210",
            "email"=> "rahul.kumar@email.com",
            "alternateNumber"=> "8765432109",
            "buyerCompanyName"=> "Tech Solutions Pvt Ltd",
            "buyerGstin"=> "27AAPFU0939F1ZV",
            "address"=> "B-404, Silver Heights, Sector 7",
            "landmark"=> "Near City Mall",
            "pincode"=> 110001,
            "createdAt"=> "2024-03-21T10:30:00Z",
            "city"=> "Mumbai",
            "state"=> "Maharashtra"
        ],
        "packageList"=> [
            [
            "name"=> "Gaming Laptop",
            "qty"=> 1,
            "price"=> 82,
            "category"=> "Electronics",
            "sku"=> "LAP-GM-001",
            "hsnCode"=> "847130"
            ],
            [
            "name"=> "Wireless Mouse",
            "qty"=> 2,
            "price"=> 12,
            "category"=> "Electronics",
            "sku"=> "ACC-MS-002",
            "hsnCode"=> "847160"
            ]   
        ],
            "pickUpAddress"=> [
                "address"=> "2285 N Hobart Blvd, Los Angeles",
                "landmark"=> "Hollywood Hills",
                "pincode"=> 400064,
                "city"=> "LA",
                "state"=> "Cali",
                "country"=> "USA"
            ]
            ];


        $res = $this->shipbuddyService->request('orderApi/createOrder', 'POST', $payload);

        // Save response
        // $this->model->insert([
        //     'order_id' => $orderId,
        //     'response' => json_encode($res),
        //     'status'   => $res['status'] ?? 'created'
        // ]);

        return $this->response->setJSON($res);
    }
}