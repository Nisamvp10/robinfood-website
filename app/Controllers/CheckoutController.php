<?php
namespace App\Controllers;

use CodeIgniter\Controller;
use App\Services\CartService;
use App\Models\CustomerOrderModel;
use App\Models\ShippingAddressModel;
use App\Models\CustomerOrderItemsModel;
use App\Models\UsersregistrationsModel;
use App\Models\ProductModel;
use App\Models\ProductManageModel;
use App\Models\CouponcodeModel;

class CheckoutController extends Controller
{
    protected CartService $cart;
    protected $customerOrderModel;
    protected $shippingAddressModel;
    protected $customerOrderItemsModel;
    protected $userModel;
    protected $productModel;
    protected $productManageModel;
    protected $couponcodeModel;
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
    private function generateOrderNumber()
    {
        $prefix = 'ORD';
        $date = date('Ymd');

        $lastOrder = $this->customerOrderModel
            ->like('order_number', $prefix . '-' . $date, 'after')
            ->orderBy('id', 'DESC')
            ->first();

        if ($lastOrder) {
            $lastNumber = (int) substr($lastOrder['order_number'], -5);
            $newNumber = str_pad($lastNumber + 1, 5, '0', STR_PAD_LEFT);
        } else {
            $newNumber = '00001';
        }

        return $prefix . '-' . $date . '-' . $newNumber;
    }

    public function placeOrder() {
        $address_id = $this->request->getPost('address_id');
        $payment_method = $this->request->getPost('payment_method') ?? 'cod';
        $user = session()->get('user');
        $status = ($user && isset($user['isLoggedIn']) && $user['isLoggedIn'] === true);
        $minimumOrderAmount = getappdata('minimum_order_amount');
        $totalAmount = 0;
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
            foreach($cartItems as $item){
                $totalAmount += $item['subtotal'];
            }
            $coupenDiscount = ($cart['coupon_discount'] !=0)?$cart['coupon_discount']:0;
            $taxAmount = round($totalAmount * ($tax / 100));
            $totalAmount = $totalAmount + $taxAmount - $coupenDiscount; 
            if($totalAmount < $minimumOrderAmount){
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Minimum order amount is '.money_format_custom($minimumOrderAmount),
                    'url' => base_url('checkout')
                ]);
            }
            
            //$db = \Config\Database::connect();
            //$db->transStart();
            //4 create order
            $address_id = $this->shippingAddressModel->where('user_id', $user['userId'])->where('is_default', 1)->get()->getRow()->id;
            $orderData = [
                'user_id' => $user['userId'],
                'order_number' => $this->generateOrderNumber(),
                'tax' => $tax,
                'coupen_code_id' => $cart['couponcode_id'],
                'discount' => $cart['coupon_discount'],
                'address_id' => $address_id,
                'sub_total' => $totalAmount,
                'total_amount' => $totalAmount,
                'payment_method' => $payment_method,
                'coupon_id' => $cart['couponcode_id'],
                'coupon_discount' => $coupenDiscount,
                'payment_status' => 'pending',
                'status' => 'pending',
                'created_at' => date('Y-m-d H:i:s')
            ];
            
            $order = $this->customerOrderModel->insert($orderData);
            if($order){
                $order_id = $this->customerOrderModel->insertID();
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
                    //select product id from productmanagement 
                    $productManage = $this->productManageModel->where('id', $item['product_id'])->first();
                    //product stock update 
                    $currentStock = $this->productModel->where('id', $productManage['product_id'])->first();
                    $blanceQty = $currentStock['current_stock'] - $item['quantity'];
                    $this->productModel->update( $productManage['product_id'], ['current_stock' => $blanceQty]);
                }

                //payment method COD
                if($payment_method == 'cod'){
                    $this->customerOrderModel->update($order_id, ['payment_status' => 'unpaid','status' => 'confirmed']); 
                    //clear cart 
                    $this->cart->deleteCart($cart['id']);
                    //mail template 
                    $this->sendOrderMail($order_id);
                  //  $db->transComplete();
                    return $this->response->setJSON([
                        'success' => true,
                        'message' => 'Order placed successfully',
                        'url' => base_url('order-details/'.$order_id)
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
                'message' => 'Please login to place order',
                'url' => base_url('login')
            ]);
        }
    }
    private function sendOrderMail($order_id){
        $emailService = \Config\Services::email();
        $order = $this->customerOrderModel->find($order_id);
        $order_items = $this->customerOrderItemsModel->where('customer_orders_items.customer_order_id', $order_id)->
        join('product_management', 'product_management.id = customer_orders_items.product_id')
        ->get()
        ->getResultArray();
        $shippingAddress = $this->shippingAddressModel->where('id', $order['address_id'])->get()->getRow();
        $user = $this->userModel->where('id', $order['user_id'])->get()->getRow();
        $emailService->setTo($user->email);
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
}