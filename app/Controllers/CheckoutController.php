<?php
namespace App\Controllers;

use CodeIgniter\Controller;
use App\Services\CartService;
use App\Services\PaymentGateway;
use App\Models\CustomerOrderModel;
use App\Models\ShippingAddressModel;
use App\Models\CustomerOrderItemsModel;
use App\Models\UsersregistrationsModel;
use App\Models\ProductModel;
use App\Models\ProductManageModel;
use App\Models\CouponcodeModel;
use App\Services\ShipbuddyService;
use App\Services\ShippingCharge;
use App\Models\ShippingchargeModel;
use App\Services\ShiprocketService;
use App\Controllers\ShiprocketController;
//thi controller in controllers frond folder 
use Razorpay\Api\Api;
use App\Controllers\front\RazorpayController; 

class CheckoutController extends Controller
{
    protected CartService $cart;
    protected PaymentGateway $paymentGateway;
    protected $customerOrderModel;
    protected $shippingAddressModel;
    protected $customerOrderItemsModel;
    protected $userModel;
    protected $productModel;
    protected $productManageModel;
    protected $couponcodeModel;
    protected $shipbuddyService;
    protected $shippingCharge;
    protected $shiprocketService;
    protected $shiprocketController;
    public function __construct()
    {
        $this->cart = new CartService();
        $this->customerOrderModel = new CustomerOrderModel();
        $this->shippingAddressModel = new ShippingAddressModel();
        $this->customerOrderItemsModel = new CustomerOrderItemsModel();
        $this->userModel = new UsersregistrationsModel();
        $this->productModel = new ProductModel();
        $this->productManageModel = new ProductManageModel();
        $this->couponcodeModel = new CouponcodeModel();
        $this->paymentGateway = new PaymentGateway();
        $this->shipbuddyService = new ShipbuddyService();
        $this->shippingCharge = new ShippingCharge();
        $this->shiprocketService = new ShiprocketService();
        $this->shiprocketController = new ShiprocketController();
    }
    public function index()
    {
        $page = "Checkout";
        return view('frontend/checkout/index', compact('page'));
    }

    public function isLogin() {

        $user = session()->get('user');
        $status = ($user && isset($user['isLoggedIn']) && $user['isLoggedIn'] === true);
        return $this->response->setJSON([
            'status' => $status
        ]);
    }

    function userLogin() {
        $user = session()->get('user');
        $status = ($user && isset($user['isLoggedIn']) && $user['isLoggedIn'] === true);
        return $status;
    }
    private function generateOrderNumber($orderId)
    {
        // $prefix = 'ORD';
        // $date = date('Ymd');
        // //last order id 
        // $lastOrder = $this->customerOrderModel->like('order_number', $prefix . '-' . $date, 'after')->orderBy('id', 'DESC')->first();

        // if ($lastOrder) {
        //     //last id last orderId unique 
        //     $lastNumber = (int) substr($lastOrder['order_number'], -5);
        //     $newNumber = str_pad($lastNumber + 1, 5, '0', STR_PAD_LEFT);
        // } else {
        //     $newNumber = '00001';
        // }
        return 'ORD-' . date('Ymd') . '-' . str_pad($orderId, 6, '0', STR_PAD_LEFT);

    }

    public function placeOrder() {
        $address_id = $this->request->getPost('address_id');
        $payment_method = $this->request->getPost('payment_method') ?? 'gateway'; //gateway
        $shippingchargeModel = new ShippingchargeModel();
        
        helper('cookie');
        $sessionId = get_cookie('cart_session');

        $pickup_locations = $this->shiprocketService->getPickupLocations();
        $shipping_address = $pickup_locations['data']['shipping_address'];
          
        $pickup_location_name = "";
        $pickup_location_id = 0;
        $pickup_pincode = '';
        if(!empty($pickup_locations)){
            foreach ($shipping_address as $pickup_location) {
                if($pickup_location['pickup_location'] == 'warehouse'){
                    $pickup_location_id = $pickup_location['id'];
                    $pickup_location_name = $pickup_location['pickup_location'];
                    $pickup_pincode = $pickup_location['pin_code'];
                    break;
                }
            }
         }


        $weight  = 0.5;
        $lenghth = 0.5;
        $breadth = 0.5;
        $height  = 0.5;


        $userSession = session()->get('user');
        $isLoggedIn = ($userSession && isset($userSession['isLoggedIn']) && $userSession['isLoggedIn'] === true);
        $status = $isLoggedIn || $sessionId; // Allow if logged in or has a session id
        $minimumOrderAmount = getappdata('minimum_order_amount');
        $itemSum = 0;
        $tax = getappdata('tax');

        if ($status) {
            //2 get cart data
            $cart = $this->cart->getMyCart();
            if(!$cart){
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Cart is empty',
                    'url' => base_url('checkout')
                ]);
            }
            //3 get cart items 
            $cartItems = $this->cart->getCartItems();
            if(empty($cartItems)){
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Cart is empty',
                    'url' => base_url('checkout')
                ]);
            }
           
            //check item stock
            foreach($cartItems as $item){
                $productmange = $this->productManageModel->where('id', $item['product_id'])->first();
                // Product Manage not found
                if (!$productmange) {
                    return $this->response->setJSON([
                        'success' => false,
                        'message' => 'Product not found.',
                        'url' => base_url('checkout')
                    ]);
                }
                $totalStock = $this->productModel->where('id', $productmange['product_id'])->first();
                if (!$totalStock) {
                    return $this->response->setJSON([
                        'success' => false,
                        'message' => 'Product not found.',
                        'url' => base_url('checkout')
                    ]);
                }
                //availabale stock
                $availableStock = (int) $totalStock['current_stock'];
                // Cart quantity
                $cartQty = (int) $item['quantity'];

                 if ($availableStock <= 0) {
                    return $this->response->setJSON([
                        'success' => false,
                        'message' => $totalStock['product_name'] . ' is out of stock. Please remove it from your cart.',
                        'url' => base_url('checkout')
                    ]);
                }
                // Insufficient stock
                if ($cartQty > $availableStock) {
                    return $this->response->setJSON([
                            'success' => false,
                            'message' => $totalStock['product_name'] .' has only ' . $availableStock .' item(s) available, but you requested ' . $cartQty . '.',
                            'url' => base_url('checkout')
                    ]);
                }
            }
            foreach($cartItems as $item){
                $itemSum += $item['subtotal'];
            }
            $coupenDiscount = ($cart['coupon_discount'] !=0)?$cart['coupon_discount']:0;
            $subTotal  = $itemSum - $coupenDiscount; 
            $taxAmount = round($subTotal * ($tax / 100));
         
            $totalAmount = $subTotal + $taxAmount; 
            //add on shipping charge 
            $state = $this->shippingAddressModel->where('id',decryptor($address_id))->get()->getRow();
            //stateSHippingCharge = $shippingchargeModel->where('state',$state->state)->first();
            if(empty($state->state ) ) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Please Enter valid state',
                    'url' => base_url('checkout')
                ]);
            }
            $shippingcharge = $this->shippingCharge->calculate($totalAmount,$state->state);
            $totalAmount+=$shippingcharge;
          
            if($totalAmount < $minimumOrderAmount){
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Minimum order amount is '.money_format_custom($minimumOrderAmount),
                    'url' => base_url('checkout')
                ]);
            }
          
            //4 create order
            if ($isLoggedIn) {
                $address = $this->shippingAddressModel->where('user_id', $userSession['userId'])->where('is_default', 1)->get()->getRow();
                $userData = $this->userModel->where('id', $userSession['userId'])->get()->getRow();
            } else {
                $address = $this->shippingAddressModel->where('session_id', $sessionId)->where('is_default', 1)->get()->getRow();
            }
           
            if (!$address) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Please provide a shipping address',
                    'url' => base_url('checkout')
                ]);
            }
            //block outof countory order allowed only india 
            $allowedCountries = ['India','IN','india'];
            if(!in_array($address->country, $allowedCountries)){
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Out of country order not allowed',
                    'url' => base_url('checkout')
                ]);
            }
            
            //shipping charge 
            $shippingCharge = $this->shippingCharge->calculate($totalAmount, $address->state);
            $shippingCharge = ($shippingCharge > 0) ? $shippingCharge : 0;


            $shippingAddress = [
                'name'  => $address->full_name,
                'email' => $address->email,
                'phone' => $address->phone,
                'address'   => $address->address_line1,
                'city'  =>$address->city,
                'state' => $address->state,
                'post'  => $address->postal_code,
                'country'   => $address->country,

            ];
          
            $orderData = [
                'user_id' => $isLoggedIn ? $userSession['userId'] : 0,
               // 'order_number' => $orderNumber,
                'tax' => $taxAmount,
                'shipping_charge' => $shippingCharge,
                'coupen_code_id' => $cart['couponcode_id'],
                'discount' => $cart['coupon_discount'],
                'address_id' => $address->id,
                'shipping_address' => json_encode($shippingAddress,true),
                'sub_total' => $itemSum,
                'total_amount' => $totalAmount,
                'payment_method' => $payment_method,
                'coupon_id' => $cart['couponcode_id'],
                'coupon_discount' => $coupenDiscount,
                'payment_status' => 'pending',
                'status' => 'pending',
                'created_at' => date('Y-m-d H:i:s')
            ];
            if($payment_method == 'gateway'){
                
               //$order = $this->paymentGateway->createOrder($totalAmount, 'INR', $orderData['order_number']);
                // $order = $this->paymentGateway->createOrder($totalAmount,$orderData['order_number']);
                // $orderNumber = $this->generateOrderNumber();

                $order_id = $this->customerOrderModel->insert($orderData,true);
                $orderNumber = $this->generateOrderNumber($order_id);
                $this->customerOrderModel->update($order_id, ['order_number' => $orderNumber]);
                $order = $this->paymentGateway->createOrder($totalAmount,$orderNumber);


                if(isset($order['id'])){

                    //$orderData['gateway_order_id'] = $order['id'];
                    $this->customerOrderModel->update($order_id, ['gateway_order_id' => $order['id']]);//

                    //$order_id = $this->customerOrderModel->insert($orderData,true);
                    foreach($cartItems as $item){
                        $orderItemData = [
                            'customer_order_id' => $order_id,
                            'product_id' => $item['product_id'],
                            'qty' => $item['quantity'],
                            'price' => $item['price'],
                            'subtotal' => $item['subtotal'],
                            'created_at' => date('Y-m-d H:i:s')
                        ];
                        $this->customerOrderItemsModel->insert($orderItemData);
                    }
                    
                    return $this->response->setJSON([
                        'success'=>true,
                        'razorpay_order_id'=>$order['id'],
                        'amount'=>$totalAmount * 100,
                        'key'=>env('payment.keyId'),
                        'order_id'=>$order_id
                    ]);

                }
            }
            $order = $this->customerOrderModel->insert($orderData);
            $order_id = $this->customerOrderModel->insertID();
            $orderNumber = $this->generateOrderNumber($order_id);
            //update order number
            $this->customerOrderModel->update($order_id, ['order_number' => $orderNumber]);
            if($order){

                $packageList = [];
             
                foreach($cartItems as $item){
                    $orderItemData = [
                        'customer_order_id' => $order_id,
                        'product_id' => $item['product_id'],
                        'qty' => $item['quantity'],
                        'price' => $item['price'],
                        'subtotal' => $item['subtotal'],
                        'type' => $payment_method,
                        'created_at' => date('Y-m-d H:i:s')
                    ];

                    

                    $this->customerOrderItemsModel->insert($orderItemData);
                    //select product id from productmanagement 
                    $productManage = $this->productManageModel->where('id', $item['product_id'])->first();
                    //product stock update 
                    $currentStock = $this->productModel->where('id', $productManage['product_id'])->first();
                    $blanceQty = $currentStock['current_stock'] - $item['quantity'];
                    $this->productModel->update( $productManage['product_id'], ['current_stock' => $blanceQty]);
                    $packageList[] = [
                        "name" => $productManage['product_title'],
                        "units" => (int)$item['quantity'],
                        "selling_price" => (int)$item['price'],
                        // "category" => 'General',
                        "sku" => $currentStock['sku'],
                        //"hsnCode" => (string) "1234",//$currentStock['hsn_code']
                    ];
                }
                //payment method COD
                if($payment_method == 'cod'){

                    //get user details like email and phone \\ is cart_session \\ is user_id
                
                    $this->customerOrderModel->update($order_id, ['payment_status' => 'unpaid','status' => 'confirmed']); 

                    //clear cart 
                    $this->cart->deleteCart($cart['id']);
                    //mail template 
                    $this->sendOrderMail($order_id);
                  //  $db->transComplete();
                    return $this->response->setJSON([
                        'success' => true,
                        'message' => 'Order placed successfully',
                        'type' => $payment_method,
                        'url' => base_url('order-success/'.$orderNumber)
                    ]);
                }
                
                
            }else{
                //dd($this->customerOrderModel->errors());
               // $db->transRollback();
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Order placement failed',
                    'url' => base_url('checkout')
                ]);
            }
           
        } else {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Your cart is empty or session expired',
                'url' => base_url('checkout')
            ]);
        }
    }

    //verify 
    public function verifyPayment()
    {
        $keyId     = env('payment.keyId');
        $keySecret = env('payment.keySecret');

        try {

            /* ----------------------------------------------------
            * 1. GET RAZORPAY PAYMENT DETAILS
            * ---------------------------------------------------- */

            $paymentId = trim((string) $this->request->getPost('razorpay_payment_id'));
            $gatewayOrderId = trim((string) $this->request->getPost('razorpay_order_id'));
            $signature = trim((string) $this->request->getPost('razorpay_signature'));

            if (empty($paymentId) || empty($gatewayOrderId) || empty($signature)) {

                return $this->response->setJSON([
                    'status'  => false,
                    'message' => 'Invalid payment response'
                ]);
            }
            /* ----------------------------------------------------
            * 2. GET LOCAL ORDER
            * ---------------------------------------------------- */

            $order = $this->customerOrderModel->where('gateway_order_id', $gatewayOrderId)->first();
            if (!$order) {

                return $this->response->setJSON([
                    'status'  => false,
                    'message' => 'Order not found'
                ]);
            }
            /* ----------------------------------------------------
            * 3. CHECK IF ALREADY PAID
            * ---------------------------------------------------- */
            if ($order['payment_status'] === 'paid') {

                return $this->response->setJSON([
                    'status'  => true,
                    'order_id' => $order['order_number'],
                    'message' => 'Payment already verified'
                ]);
            }
            /* ----------------------------------------------------
            * 4. VERIFY RAZORPAY SIGNATURE
            * ---------------------------------------------------- */
            $generatedSignature = hash_hmac('sha256', $gatewayOrderId . '|' . $paymentId, $keySecret);
            if (!hash_equals($generatedSignature, $signature)) {
                return $this->response->setJSON([
                    'status'  => false,
                    'message' => 'Invalid payment signature'
                ]);
            }
            /* ----------------------------------------------------
            * 5. CHECK PAYMENT FROM RAZORPAY
            * ---------------------------------------------------- */
            $ch = curl_init();

            curl_setopt_array($ch, [
                CURLOPT_URL            => 'https://api.razorpay.com/v1/payments/' . urlencode($paymentId),
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_HTTPAUTH       => CURLAUTH_BASIC,
                CURLOPT_USERPWD        => $keyId . ':' . $keySecret,
                CURLOPT_TIMEOUT        => 30,
                CURLOPT_CONNECTTIMEOUT => 10,
                CURLOPT_SSL_VERIFYPEER => true,
                CURLOPT_SSL_VERIFYHOST => 2
            ]);
            $response = curl_exec($ch);
            $curlError = curl_error($ch);
            $httpCode  = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);
            if ($response === false || !empty($curlError)) {
                log_message('error','Razorpay payment API error: ' . $curlError);
                return $this->response->setJSON([
                    'status'  => false,
                    'order_id' => $order['order_number'],
                    'message' => 'Unable to verify payment with Razorpay'
                ]);
            }
            $payment = json_decode($response, true);


            if (!is_array($payment)) {

                log_message('error','Invalid Razorpay response: ' . $response);

                return $this->response->setJSON([
                    'status'  => false,
                    'order_id' => $order['order_number'],
                    'message' => 'Invalid payment response from Razorpay'
                ]);
            }
            if ($httpCode < 200 || $httpCode >= 300) {
                log_message('error','Razorpay HTTP error: ' . $response);
                return $this->response->setJSON([
                    'status'  => false,
                    'order_id' => $order['order_number'],
                    'message' => 'Razorpay payment verification failed'
                ]);
            }
            /* ----------------------------------------------------
            * 6. CHECK PAYMENT STATUS
            * ---------------------------------------------------- */

            if (!isset($payment['status']) || $payment['status'] !== 'captured') {

                return $this->response->setJSON([
                    'status'  => false,
                    'order_id' => $order['order_number'],
                    'message' => 'Payment not completed'
                ]);
            }

            /* ----------------------------------------------------
            * 7. VERIFY PAYMENT AMOUNT
            * ---------------------------------------------------- */

            // Optional but highly recommended.
            // Razorpay amount is in paise.

            if (isset($payment['amount']) && isset($order['grand_total'])) {

                $razorpayAmount = (float) $payment['amount'] / 100;
                $orderAmount    = (float) $order['grand_total'];

                if (round($razorpayAmount, 2) !== round($orderAmount, 2)) {

                    log_message('error','Payment amount mismatch. Order: ' .$orderAmount .' Razorpay: ' .$razorpayAmount);

                    return $this->response->setJSON([
                        'status'  => false,
                        'order_id' => $order['order_number'],
                        'message' => 'Payment amount mismatch'
                    ]);
                }
            }

            /* ----------------------------------------------------
            * 8. GET ORDER ITEMS
            * ---------------------------------------------------- */
            $orderItems = $this->customerOrderItemsModel->where('customer_order_id', $order['id'])->findAll();
            if (empty($orderItems)) {
                return $this->response->setJSON([
                    'status'  => false,
                    'order_id' => $order['order_number'],
                    'message' => 'Order items not found'
                ]);
            }
            /* ----------------------------------------------------
            * 9. UPDATE STOCK
            * ---------------------------------------------------- */
            foreach ($orderItems as $item) {

                $productManage = $this->productManageModel->where('id', $item['product_id'])->first();
                if (!$productManage) {
                    log_message('error','Product manage record not found: ' . $item['product_id']);
                    continue;
                }
                $productId = $productManage['product_id'];
                $currentStock = $this->productModel->where('id', $productId)->first();
                if (!$currentStock) {
                    log_message('error','Product record not found: ' . $productId);

                    continue;
                }


                $currentQty = (float) $currentStock['current_stock'];
                $orderQty   = (float) $item['qty'];

                $balanceQty = $currentQty - $orderQty;

                if ($balanceQty < 0) {
                    $balanceQty = 0;
                }


                $this->productModel->where('id', $productId)->set(['current_stock' => $balanceQty])->update();
            }

            /* ----------------------------------------------------
            * 10. UPDATE ORDER PAYMENT STATUS
            * ---------------------------------------------------- */

            $this->customerOrderModel
                ->where('id', $order['id'])
                ->set([
                    'payment_status'    => 'paid',
                    'status'            => 'confirmed',
                    'payment_id'        => $paymentId,
                    'payment_signature' => $signature,
                    'updated_at'        => date('Y-m-d H:i:s')
                ])
                ->update();


            /* ----------------------------------------------------
            * 11. DELETE CART
            * ---------------------------------------------------- */

            $cart = $this->cart->getMyCart();

            if (!empty($cart) && !empty($cart['id'])) {

                $this->cart->deleteCart($cart['id']);
            }


            /* ----------------------------------------------------
            * 12. SEND ORDER EMAIL
            * ---------------------------------------------------- */

            try {

                $this->sendOrderMail($order['id']);

            } catch (\Throwable $e) {

                log_message(
                    'error',
                    'Order email error: ' . $e->getMessage()
                );
            }


            /* ----------------------------------------------------
            * 13. CREATE SHIPROCKET ORDER
            * ---------------------------------------------------- */

            $shiprocketData = null;

            try {

                /*
                * IMPORTANT:
                *
                * Do NOT call another controller action here
                * if readyToShip() returns setJSON().
                *
                * Ideally readyToShip() should be converted into
                * a service method that returns an array.
                */

                $shiprocketData = $this->readyToShip($order['id']);

            } catch (\Throwable $e) {

                log_message(
                    'error',
                    'Shiprocket error: ' . $e->getMessage()
                );

                $shiprocketData = [
                    'status'  => false,
                    'message' => 'Shiprocket order creation failed'
                ];
            }


            /* ----------------------------------------------------
            * 14. FINAL RESPONSE
            * ---------------------------------------------------- */

            return $this->response->setJSON([
                'status'            => true,
                'order_id'          => $order['order_number'],
                'message'           => 'Payment successful',
                'shiprocket_status' => $shiprocketData
            ]);

        } catch (\Throwable $e) {

            log_message(
                'error',
                'Payment verification exception: ' .
                $e->getMessage() .
                ' | File: ' .
                $e->getFile() .
                ' | Line: ' .
                $e->getLine()
            );

            return $this->response->setJSON([
                'status'  => false,
                'message' => 'Payment verification failed'
            ]);
        }
    }

    
    public function readyToShip($orderId)
    {
        $validate = [
            'status'  => 400,
            'success' => false,
            'message' => ''
        ];

       

        $encryptedOrderId =  $orderId; //decryptor($this->request->getPost('orderId')) ??

        if (empty($encryptedOrderId)) {
            $validate['message'] = 'Order ID is required';
            return $this->response->setJSON($validate);
        }

        $orderId = $encryptedOrderId;
        if (empty($orderId)) {
            $validate['message'] = 'Invalid order ID';
            return $this->response->setJSON($validate);
        }

        $orderData = $this->customerOrderModel->where('id', $orderId)->first();
        if (empty($orderData)) {
            $validate['message'] = 'Order not found';
            return $this->response->setJSON($validate);
        }
        /*
        |--------------------------------------------------------------------------
        | 3. Payment Check
        |--------------------------------------------------------------------------
        |
        | For Razorpay prepaid orders, do NOT create Shiprocket order until
        | payment is confirmed.
        |
        */

        $paymentMethod = strtolower(trim($orderData['payment_method'] ?? ''));

        $paymentStatus = strtolower(trim($orderData['payment_status'] ?? ''));

        if (in_array($paymentMethod, ['gateway', 'cod'])&& !in_array($paymentStatus, ['paid', 'unpaid', 'pending'])) {
            $validate['message'] = 'Payment is not completed. Shipment cannot be created.';
            return $this->response->setJSON($validate);
        }

        if (!empty($orderData['awb_code'])) {

            $validate['status']  = 200;
            $validate['success'] = true;
            $validate['message'] = 'AWB already assigned';
            $validate['awb_code'] = $orderData['awb_code'];
            $validate['shipment_id'] = $orderData['shipment_id'] ?? null;
            $validate['courier_name'] = $orderData['courier_name'] ?? null;

            return $this->response->setJSON($validate);
        }

        
        $userShippingAddress = $orderData['shipping_address'] ?? '';
        if (empty($userShippingAddress)) {
            $validate['message'] = 'Shipping address not found';
            return $this->response->setJSON($validate);
        }
        $userShippingAddress = json_decode($userShippingAddress,true);
        if (!is_array($userShippingAddress)) {
            $validate['message'] = 'Invalid shipping address';
            return $this->response->setJSON($validate);
        }

        /*
        |--------------------------------------------------------------------------
        | 6. Required Address Fields
        |--------------------------------------------------------------------------
        */

        $requiredAddressFields = [
            'name',
            'address',
            'city',
            'state',
            'country',
            'post',
            'phone',
            'email'
        ];

        foreach ($requiredAddressFields as $field) {

            if (empty($userShippingAddress[$field])) {

                $validate['message'] = 'Shipping address field missing: ' . $field;

                return $this->response->setJSON($validate);
            }
        }

        /*
        |--------------------------------------------------------------------------
        | 7. Country Validation
        |--------------------------------------------------------------------------
        */
        $country = strtolower(trim($userShippingAddress['country']));
        if ($country !== 'india' && $country !== 'in') {
            $validate['message'] ='Out of country order not allowed';
            return $this->response->setJSON($validate);
        }
        $shippingCountry = ($country === 'in') ? 'India' : $userShippingAddress['country'];

        /*
        |--------------------------------------------------------------------------
        | 8. Pincode Validation
        |--------------------------------------------------------------------------
        */

        $pincode = preg_replace('/\D/','',$userShippingAddress['post']);
        $pincode = substr($pincode, 0, 6);
        if (strlen($pincode) !== 6) {
            $validate['message'] ='Invalid shipping pincode';
            return $this->response->setJSON($validate);
        }
        /*
        |--------------------------------------------------------------------------
        | 9. Get Shiprocket Pickup Locations
        |--------------------------------------------------------------------------
        */

        $pickupLocationsResponse = $this->shiprocketService->getPickupLocations();
        if (empty($pickupLocationsResponse) || empty($pickupLocationsResponse['data']['shipping_address'])) {
            $validate['message'] = 'Unable to get Shiprocket pickup locations';
            return $this->response->setJSON($validate);
        }

        $shippingAddresses = $pickupLocationsResponse['data']['shipping_address'];

        /*
        |--------------------------------------------------------------------------
        | 10. Find Pickup Location
        |--------------------------------------------------------------------------
        */
        $pickupAddress = getappdata('pickup_address') ?? 'warehouse';
        $pickupLocationName = '';
        $pickupLocationId   = 0;
        $pickupPincode      = '';

        foreach ($shippingAddresses as $pickupLocation) {

            if (strtolower(trim($pickupLocation['pickup_location'] ?? '')) === strtolower(trim($pickupAddress))) {
                $pickupLocationId = $pickupLocation['id'] ?? 0;
                $pickupLocationName = $pickupLocation['pickup_location'] ?? '';
                $pickupPincode = $pickupLocation['pin_code'] ?? '';
                break;
            }
        }

        if (empty($pickupLocationName)) {
            $validate['message'] = 'Shiprocket pickup location not found: ' . $pickupAddress;
            return $this->response->setJSON($validate);
        }

        /*
        |--------------------------------------------------------------------------
        | 11. Default Package Dimensions
        |--------------------------------------------------------------------------
        */

        $weight  = 0.5;
        $length  = 0.5;
        $breadth = 0.5;
        $height  = 0.5;


        /*
        |--------------------------------------------------------------------------
        | 12. Order Subtotal
        |--------------------------------------------------------------------------
        */
        $subTotal = (float) ($orderData['sub_total'] ?? 0);

        /*
        |--------------------------------------------------------------------------
        | 13. Get Order Items
        |--------------------------------------------------------------------------
        */
        $orderItems = $this->customerOrderItemsModel->where('customer_order_id', $orderId)->findAll();
        if (empty($orderItems)) {
            $validate['message'] = 'Order items not found';
            return $this->response->setJSON($validate);
        }

        /*
        |--------------------------------------------------------------------------
        | 14. Build Shiprocket Order Items
        |--------------------------------------------------------------------------
        */
        $shiprocketOrderItems = [];

        foreach ($orderItems as $items) {
            $productManage = $this->productManageModel->select('product_management.*,product_management.product_id as pid, shipping_configration.*,products.sku,products.current_stock')
                ->join('shipping_configration','shipping_configration.product_id = product_management.id','left')
                ->join('products','products.id = product_management.product_id')
                ->where('product_management.id',$items['product_id'])
                ->first();


            if (empty($productManage)) {
                continue;
            }

            /*
            |--------------------------------------------------------------------------
            | Product Stock / SKU
            |--------------------------------------------------------------------------
            */
            $currentStock = $this->productModel->where('id',$productManage['pid'])->first();
            /*
            |--------------------------------------------------------------------------
            | Shipping Status
            |--------------------------------------------------------------------------
            */

            if (isset($productManage['shipping_status']) && $productManage['shipping_status'] == 3) {
                $qty = (float) ($items['qty'] ?? 1);
                /*
                |--------------------------------------------------------------------------
                | Weight
                |--------------------------------------------------------------------------
                */
                $productWeight = (float) ($productManage['weight'] ?? 0);
                if ($productWeight > 0) {

                    if (!empty($productManage['is_multiple']) && $productManage['is_multiple'] == 1) {
                        $weight += $productWeight * $qty;
                    } else {
                        $weight += $productWeight;
                    }
                }
                /*
                |--------------------------------------------------------------------------
                | Length
                |--------------------------------------------------------------------------
                */

                $productLength = (float) ($productManage['length'] ?? 0);
                if ($productLength > 0) {
                    if (!empty($productManage['is_multiple']) && $productManage['is_multiple'] == 1) {
                        $length += $productLength * $qty;

                    } else {
                        $length += $productLength;
                    }
                }

                /*
                |--------------------------------------------------------------------------
                | Breadth
                |--------------------------------------------------------------------------
                */
                $productBreadth =(float) ($productManage['breadth'] ?? 0);
                if ($productBreadth > 0) {
                    if (!empty($productManage['is_multiple']) && $productManage['is_multiple'] == 1) {
                        $breadth += $productBreadth * $qty;
                    } else {
                        $breadth += $productBreadth;
                    }
                }

                /*
                |--------------------------------------------------------------------------
                | Height
                |--------------------------------------------------------------------------
                */

                $productHeight = (float) ($productManage['height'] ?? 0);
                if ($productHeight > 0) {
                    if (!empty($productManage['is_multiple']) && $productManage['is_multiple'] == 1) {
                        $height += $productHeight * $qty;
                    } else {
                        $height += $productHeight;
                    }
                }

                /*
                |--------------------------------------------------------------------------
                | Shiprocket Item
                |--------------------------------------------------------------------------
                */
                $shiprocketOrderItems[] = [
                    'name' => $productManage['product_title'] ?? '',
                    'sku' => $currentStock['sku'] ?? '',
                    'units' =>(int) $qty,
                    'selling_price' =>(float) ($items['price'] ?? 0)
                ];
            }
        }

        if (empty($shiprocketOrderItems)) {

            $validate['message'] = 'No shippable products found in this order';
            return $this->response->setJSON($validate);
        }
        /*
        |--------------------------------------------------------------------------
        | 15. Check Existing Shiprocket Shipment
        |--------------------------------------------------------------------------
        */
        if (!empty($orderData['shipment_id']) && empty($orderData['awb_code'])) {

            /*
            |--------------------------------------------------------------------------
            | Shipment already created.
            | Only assign courier.
            |--------------------------------------------------------------------------
            */

            $shipmentId =$orderData['shipment_id'];
            $assignCourier =$this->shiprocketService->assignCourier($shipmentId);
            if (!empty($assignCourier['awb_assign_status']) && $assignCourier['awb_assign_status'] == 1) {
                $data =$assignCourier['response']['data'] ?? [];
                $awbCode = $data['awb_code'] ?? null;

                if (empty($awbCode)) {
                    $validate['message'] = 'Courier assigned but AWB was not returned';
                    return $this->response->setJSON($validate);
                }

                /*
                |--------------------------------------------------------------------------
                | Save AWB
                |--------------------------------------------------------------------------
                */

                $awbData = [
                    'order_id' => $data['order_id'] ?? $orderData['order_id'] ?? null,
                    'shipment_id' => $data['shipment_id'] ?? $orderData['shipment_id'],
                    'awb_code' => $awbCode,
                    'courier_company_id' => $data['courier_company_id'] ?? null,
                    'courier_name' => $data['courier_name'] ?? null,
                    'shipping_status' => 'AWB Assigned'
                ];

                $this->customerOrderModel->update($orderId, $awbData);

                $validate['status'] = 200;
                $validate['success'] = true;
                $validate['message'] = 'AWB Assigned';
                $validate['awb_code'] = $awbCode;
                $validate['shipment_id'] = $awbData['shipment_id'];
                $validate['courier_name'] = $awbData['courier_name'];
                return $this->response->setJSON($validate);
            }


            /*
            |--------------------------------------------------------------------------
            | AWB Assignment Failed
            |--------------------------------------------------------------------------
            */

            $error = $assignCourier['response']['data']['awb_assign_error'] ?? $assignCourier['message'] ?? 'Unable to assign courier';
            $this->customerOrderModel->update($orderId,['shipping_status' =>'AWB Assign Failed']);
            $validate['message'] = $error;
            return $this->response->setJSON($validate);
        }

        /*
        |--------------------------------------------------------------------------
        | 16. Create Shiprocket Order
        |--------------------------------------------------------------------------
        */
        $shiprocketOrderId = 'WEB' . time() . $orderId;

        /*
        |--------------------------------------------------------------------------
        | Payment Method
        |--------------------------------------------------------------------------
        */

        $shiprocketPaymentMethod = in_array($paymentMethod,['cod', 'cash_on_delivery']) ? 'COD' : 'Prepaid';
        /*
        |--------------------------------------------------------------------------
        | 17. Shiprocket Order Data
        |--------------------------------------------------------------------------
        */

        $order = [
            'order_id' =>$shiprocketOrderId,
            'order_date' => date('Y-m-d H:i'),
            'pickup_location' =>$pickupLocationName,
            'billing_customer_name' => $userShippingAddress['name'],
            'billing_last_name' => '',
            'billing_address' => $userShippingAddress['address'],
            'billing_city' => $userShippingAddress['city'],
            'billing_state' => $userShippingAddress['state'],
            'billing_country' => $shippingCountry,
            'billing_pincode' => $pincode,
            'billing_phone' => preg_replace('/\D/', '', $userShippingAddress['phone']),
            'billing_email' => $userShippingAddress['email'],
            'shipping_is_billing' => true,
            'order_items' => $shiprocketOrderItems,
            'payment_method' => $shiprocketPaymentMethod,
            'sub_total' => $subTotal,
            'length' =>round($length, 2),
            'breadth' =>round($breadth, 2),
            'height' =>round($height, 2),
            'weight' =>round($weight, 2)
        ];

        /*
        | 18. Create Shiprocket Order
        |--------------------------------------------------------------------------
        */
        $response =$this->shiprocketService->createOrder($order);

        /*
        |--------------------------------------------------------------------------
        | 19. Shiprocket Create Order Failed
        |--------------------------------------------------------------------------
        */

        if (empty($response) || empty($response['shipment_id'])) {

            $error = $response['message'] ?? $response['error'] ?? 'Unable to create Shiprocket order';
            $this->customerOrderModel->update($orderId,['shipping_status' =>'Order Failed']);
            $validate['message'] = $error;
            return $this->response->setJSON($validate);
        }

        /*
        |--------------------------------------------------------------------------
        | 20. Save Shiprocket Order
        |--------------------------------------------------------------------------
        */

        $shippingResponseData = [

            'order_id' =>$response['order_id'] ?? $shiprocketOrderId,
            'shipment_id' =>$response['shipment_id'],
            'shipping_status' =>$response['status'] ?? 'Order Created',
            'awb_code' =>$response['awb_code'] ?? null,
            'courier_company_id' =>$response['courier_company_id'] ?? null,
            'courier_name' =>$response['courier_name'] ?? null
        ];

        $this->customerOrderModel->update($orderId, $shippingResponseData);


        /*
        |--------------------------------------------------------------------------
        | 21. If Shiprocket Already Returned AWB
        |--------------------------------------------------------------------------
        */
        if (!empty($response['awb_code'])) {

            $validate['status'] = 200;
            $validate['success'] = true;
            $validate['message'] = 'Order created and AWB assigned';
            $validate['awb_code'] = $response['awb_code'];
            $validate['shipment_id'] =$response['shipment_id'];
            $validate['courier_name'] = $response['courier_name'] ?? null;

            return $this->response->setJSON($validate);
        }

        /*
        |--------------------------------------------------------------------------
        | 22. Assign Courier
        |--------------------------------------------------------------------------
        */
        $assignCourier =$this->shiprocketService->assignCourier($response['shipment_id']);
        /*
        |--------------------------------------------------------------------------
        | 23. Courier Assignment Successful
        |--------------------------------------------------------------------------
        */

        if (!empty($assignCourier['awb_assign_status']) && $assignCourier['awb_assign_status'] == 1) {
            $data = $assignCourier['response']['data'] ?? [];
            $awbCode = $data['awb_code'] ?? null;
            /*
            |--------------------------------------------------------------------------
            | AWB Missing
            |--------------------------------------------------------------------------
            */

            if (empty($awbCode)) {
                $validate['message'] = 'Courier assigned but AWB was not returned';
                return $this->response->setJSON($validate);
            }
            /*
            |--------------------------------------------------------------------------
            | Save AWB + Courier
            |--------------------------------------------------------------------------
            */
            $awbData = [
                'order_id' => $data['order_id'] ?? $response['order_id'] ?? $shiprocketOrderId,
                'shipment_id' =>$data['shipment_id'] ?? $response['shipment_id'],
                'awb_code' => $awbCode,
                'courier_company_id' =>$data['courier_company_id'] ?? null,
                'courier_name' =>$data['courier_name'] ?? null,
                'shipping_status' =>'AWB Assigned'
            ];
            $this->customerOrderModel->update($orderId,$awbData);
            /*
            |--------------------------------------------------------------------------
            | Success Response
            |--------------------------------------------------------------------------
            */
            $validate['status'] = 200;
            $validate['success'] = true;
            $validate['message'] = 'AWB Assigned';
            $validate['awb_code'] = $awbCode;
            $validate['shipment_id'] = $awbData['shipment_id'];
            $validate['courier_company_id'] = $awbData['courier_company_id'];
            $validate['courier_name'] = $awbData['courier_name'];
            return $this->response->setJSON($validate);
        }
        /*
        |--------------------------------------------------------------------------
        | 24. Courier Assignment Failed
        |--------------------------------------------------------------------------
        */
        $error = $assignCourier['response']['data']['awb_assign_error'] ?? $assignCourier['message'] ?? $response['message'] ?? 'Unable to assign courier';
        $this->customerOrderModel->update($orderId,['shipping_status' =>'AWB Assign Failed']);
        $validate['message'] = $error;
        return $this->response->setJSON($validate);
    }

    // close verify 
     function sendOrderMail($order_id){
        $this->usermail($order_id);
        $emailService = \Config\Services::email();
        $order = $this->customerOrderModel->find($order_id);
        $order_items = $this->customerOrderItemsModel->where('customer_orders_items.customer_order_id', $order_id)->
        join('product_management', 'product_management.id = customer_orders_items.product_id')
        ->get()
        ->getResultArray();

        //check login he is logged in send mail to user email else send to $shipping address email
        $shippingAddress = json_decode($order['shipping_address'], true);
    
        $email = getappdata('email');
        $pgeTitle = getappdata('company_name');
        $emailService->setTo('nisamvp10@gmail.com',$pgeTitle);
        $emailService->setSubject('Order Placed');
        $emailService->setMessage(view('frontend/email/product_placed_to_admin', compact('order', 'order_items','shippingAddress')));  
        $emailService->send();
        
    }

    function usermail($order_id){
        $emailService = \Config\Services::email();
        $order = $this->customerOrderModel->find($order_id);
        $order_items = $this->customerOrderItemsModel->where('customer_orders_items.customer_order_id', $order_id)->
        join('product_management', 'product_management.id = customer_orders_items.product_id')
        ->get()
        ->getResultArray();
        $email = getappdata('email');
        $pgeTitle = getappdata('company_name');
        //check login he is logged in send mail to user email else send to $shipping address email
        $shippingAddress = json_decode($order['shipping_address'], true);
        $user = [];
            //user not login set gust details for user
            if($order['user_id'] == 0){
                $user = [
                    'name' => $shippingAddress['name'],
                    'email' => $shippingAddress['email'],
                    'phone' => $shippingAddress['phone'],
                ];
                  $mailTo = (!empty($shippingAddress['email'])) ? $shippingAddress['email'] : $user['email'];
            }else{
                $user = $this->userModel->where('id', $order['user_id'])->first();
                $mailTo = (!empty($shippingAddress['email'])) ? $shippingAddress['email'] : $user['email'];
            }

        $emailService->setTo($mailTo, $pgeTitle);
        $emailService->setSubject('Order Placed');
        $emailService->setMessage(view('frontend/email/order_placed', compact('order', 'order_items','user','shippingAddress')));  
        $emailService->send();
    }

    public function applyCoupon(){
        if(!$this->request->isAJAX()){
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Invalid request',
                'url' => base_url('checkout')
            ]);
        }
        $rules = [
            'coupon_code' => 'required'
        ];
        if(!$this->validate($rules)){
            return $this->response->setJSON([
                'success' => false,
                'errors' => $this->validator->getErrors(),
            ]);
        }
        $coupon_code = $this->request->getPost('coupon_code');
        $coupon = $this->cart->couponCodeApply($coupon_code);
        if($coupon['status'] == 'success'){
            return $this->response->setJSON([
                'success' => true,
                'message' => $coupon['message'],
                'url' => base_url('checkout')
            ]);
        }else{
            return $this->response->setJSON([
                'success' => false,
                'message' => $coupon['message'],
                'url' => base_url('checkout')
            ]);
        }
        
    }
    function removeCoupon() {

          if(!$this->request->isAJAX()){
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Invalid request',
                'url' => base_url('checkout')
            ]);
        }
        $coupon = $this->cart->removeCoupon();
        if($coupon['status'] == 'success'){
            return $this->response->setJSON([
                'success' => true,
                'message' => $coupon['message'],
                'url' => base_url('checkout')
            ]);
        }else{
            return $this->response->setJSON([
                'success' => false,
                'message' => $coupon['message'],
                'url' => base_url('checkout')
            ]);
        }
    }

    public function cancelOrder() {
        $orderId = $this->request->getPost('order_id');
        if($orderId) {
            $this->customerOrderModel->where('gateway_order_id',$orderId)->set(['payment_status'=>3,'status'=>3])->update();
        }
      return true;  
    }
}