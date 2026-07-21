<?php
namespace App\Services;
use App\Models\ShippingchargeModel;
use App\Services\ShiprocketService;
use App\Services\CartService;
use App\Models\ShippingconfigrationModel;
class ShippingCharge{
    
    protected $shiprocket;

    protected $shippingconfigrationModel;

    public function __construct()
    {
        $this->shiprocket = new ShiprocketService();
        $this->shippingconfigrationModel = new ShippingconfigrationModel();
    }

    public function old_calculate($cartTotal, $state)
    {
        $model = new ShippingchargeModel();

        // Normalize state
        $state = ucfirst(strtolower(trim($state)));

        //  Free shipping (optional)
        if ($cartTotal >= 10000) {
            return 0;
        }
        if($state) {
             //  1. Match exact state (Kerala)
            $rule = $model->where('state', $state)->where('is_active', 1)->first();

            if ($rule) {
                return $rule['charge'];
            }

            //  2. Outside state rule
            $rule = $model->where(['is_outside'=> 1,'state' => $state])->where('is_active', 1)->first();

            if ($rule) {
                return $rule['charge'];
            }

        }
        //  3. Default fallback
        return 0;
    }

    public function calculate($cartTotal, $state)
    {
        $model = new ShippingchargeModel();
        $cartService = new CartService();
        $shippingAddress = $cartService->shippingAddress();
        $cartItems = $cartService->getCartItems();
        // product items id from cartItems
        $productIds = array_column($cartItems, 'product_id');
        $shippingInfo = $this->shippingconfigrationModel->whereIn('product_id',$productIds)->get()->getResultArray();
        $cod = 1;
        $cod = ($cod == 1) ? 1 : 0;



        // Create cart array indexed by product_id
        $cartData = [];
        foreach ($cartItems as $item) {
            $cartData[$item['product_id']] = $item;
        }

        $shippingInfo = $this->shippingconfigrationModel
            ->whereIn('product_id', $productIds)
            ->findAll();

        $totalWeight = 0;
        $totalLength = 0;
        $totalBreadth = 0;
        $totalHeight = 0;
        $totalShippingCost = 0;

        foreach ($shippingInfo as $info) {

            if ($info['shipping_status'] != 3) {
                continue;
            }

            $productId = $info['product_id'];

            if (!isset($cartData[$productId])) {
                continue;
            }

            $qty = $cartData[$productId]['quantity'];

            if ($info['is_multiple'] == 1) {

                // Weight and dimensions increase with quantity
                $totalWeight += $info['weight'] * $qty;
                $totalLength += $info['length'] * $qty;
                $totalBreadth += $info['breadth'] * $qty;
                $totalHeight += $info['height'] * $qty;

            } else {

                // Use only one package dimensions
                $totalWeight += $info['weight'];
                $totalLength += $info['length'];
                $totalBreadth += $info['breadth'];
                $totalHeight += $info['height'];
            }
        }

           

        
        if(!empty($shippingAddress)){
            $username = $shippingAddress['full_name'];
            $pincode = $shippingAddress['postal_code'];
            $country_code = $shippingAddress['country_code'];
            $state = $shippingAddress['state'];
            $city = $shippingAddress['city'];
            $address = $shippingAddress['address_line1'] .','.$shippingAddress['city'] .','.$shippingAddress['state'] .','.$shippingAddress['postal_code'] .','.$shippingAddress['country'];
            $phone = $country_code.str_replace(' ', '', $shippingAddress['phone']);
            $email = $shippingAddress['email'];

            if ($cartTotal >= 10000) {
                return 0;
            }

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



            // get cart items with shipping configration

        
            $shippingCharge = $this->shiprocket->getShippingCharges($pickup_pincode, $pincode, $totalWeight, $cod, $totalLength, $totalBreadth, $totalHeight);

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
                    $shipest_shiping_carge = $cheapestCourier['freight_charge'];
                    
                }
            return round($shipest_shiping_carge);
                
                
        }


        // Normalize state
        $state = ucfirst(strtolower(trim($state)));

        //  Free shipping (optional)
        
        if($state) {
            $rule = $model->where('state', $state)->where('is_active', 1)->first();
            print_r($rule);exit;
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
        $shippingCharge = $this->shiprocket->getShippingCharges($pickup_pincode, $pincode, $weight, $cod, $lenghth, $breadth, $height);
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
                $shipest_shiping_carge = $cheapestCourier['freight_charge'];
                
            }
             

        }
        //  3. Default fallback
        return 0;
    }

}