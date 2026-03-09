<?php
namespace App\Controllers\frond;

use App\Controllers\BaseController;
use App\Models\CustomerOrderModel;
use App\Models\CustomerOrderItemsModel;

class PaymentSuccessController extends BaseController {
    protected $customerOrders;
    protected $customerOrderItems;
    function __construct() {
        $this->customerOrders = new CustomerOrderModel();
        $this->customerOrderItems = new CustomerOrderItemsModel();
    }

    function index($orderID) {
        $page = "success";
        $orders  = $this->customerOrders->where('order_number',$orderID)->get()->getRow();
       // $orderItems = $this->customerOrderItems->where('customer_order_id',$orders->id)->findAll();
        $data = [];
        if($orders) {
            if($orders->status == 'confirmed') {
                $data['status'] = 'Confirmed';
                $data['success'] = true;
                $data['message'] = 'Your order has been confirmed';
                $data['transactionId'] = $orderID;
            }else{
                $data['status'] = 'Failed';
                $data['success'] = false;
                $data['message'] = 'Your order has been failed';
                $data['transactionId'] = $orderID;
            }
        }
        return view('frontend/order-success',compact('orders','orderItems','data'));

    }
}