<?php

namespace App\Controllers;
use CodeIgniter\HTTP\Exceptions\HTTPException;

use App\Services\ShiprocketService;

class ShiprocketController extends BaseController
{
    protected $shiprocket;

    public function __construct()
    {
        $this->shiprocket = new ShiprocketService();
    }

    public function index()
    {
        $pickup_locations = $this->shiprocket->getPickupLocations();
        $shipping_address = $pickup_locations['data']['shipping_address'];
          
        $pickup_location_name = "";
        $pickup_location_id = 0;
        $pickup_pincode = '';
        if(!empty($pickup_locations)){
            foreach ($shipping_address as $pickup_location) {
                if($pickup_location['pickup_location'] == 'Home'){
                    $pickup_location_id = $pickup_location['id'];
                    $pickup_location_name = $pickup_location['pickup_location'];
                    $pickup_pincode = $pickup_location['pin_code'];
                    break;
                }
            }
         }
        $weight = 5;
        $cod = 1;
        $lenghth = 30;
        $breadth = 30;
        $height = 30;
        $shippingCharge = $this->shiprocket->getShippingCharges($pickup_pincode, '679585', $weight, $cod, $lenghth, $breadth, $height);
        $shipest_shiping_carge=0;
        $shipest_courier = [];
        if (!empty($shippingCharge['data']['available_courier_companies'])) {

            $couriers = $shippingCharge['data']['available_courier_companies'];

            usort($couriers, function ($a, $b) {
                return $a['freight_charge'] <=> $b['freight_charge'];
            });

            // Cheapest courier
            $cheapestCourier = $couriers[0];

            // Data to save
            $shippingData = [
                'courier_company_id'      => $cheapestCourier['courier_company_id'],
                'courier_name'            => $cheapestCourier['courier_name'],
                'shipping_charge'         => $cheapestCourier['freight_charge'],
                'estimated_delivery_days' => $cheapestCourier['estimated_delivery_days'],
                'etd'                     => $cheapestCourier['etd'],
                //'courier_id'              => $cheapestCourier['courier_id'],
                'rate'                    => $cheapestCourier['rate'],
                'cod'                     => $cheapestCourier['cod'],
                'created_at'              => date('Y-m-d H:i:s'),
            ];

            // Save to database 
           // $this->db->insert('shipping_details', $shippingData);
           print_r($shippingData);
          
        }

        $order = [

            "order_id" => "WEB" . time(),

            "order_date" => date("Y-m-d H:i"),

            "pickup_location" => $pickup_location_name,

            "billing_customer_name" => "Nisam",

            "billing_last_name" => "Kmk",

            "billing_address" => "Veliyathparambil House Kanjiramukku po ",

            "billing_city" => "Karingalathani",

            "billing_state" => "Kerala",

            "billing_country" => "India",

            "billing_pincode" => "679585",

            "billing_phone" => "7403312120",

            "billing_email" => "diary536@gmail.com",

            "shipping_is_billing" => true,

            "order_items" => [
                [
                    "name" => "Puttupodi",
                    "sku" => "SKU001",
                    "units" => 1,
                    "selling_price" => 250
                ],

            ],

            "payment_method" => "Prepaid",

            "sub_total" => 250,

            "length" => $lenghth,

            "breadth" => $breadth,

            "height" => $height,

            "weight" => $weight

        ];

        $response = $this->shiprocket->createOrder($order);

        echo "<pre>";
        print_r($response);
    }
}