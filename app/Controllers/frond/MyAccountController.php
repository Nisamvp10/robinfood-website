<?php
namespace App\Controllers\frond;
use CodeIgniter\Controller;
use App\Models\UsersregistrationsModel;
use App\Models\CustomerOrderModel;
use App\Models\CustomerOrderItemsModel;
use App\Models\ShippingAddressModel;


class MyAccountController extends Controller
{
    protected $usersregistrationsModel;
    protected $customerOrdersModel;
    protected $customerOrderItemsModel;
    protected $shippingAddressModel;
    function __construct()
    {
        $this->usersregistrationsModel = new UsersregistrationsModel();
        $this->customerOrdersModel = new CustomerOrderModel();
        $this->customerOrderItemsModel = new CustomerOrderItemsModel();
        $this->shippingAddressModel = new ShippingAddressModel();
    }
    public function index()
    { 
        $thisUser = session('user');
        $userData = $this->usersregistrationsModel->select('name,phone,email')->where('id', $thisUser['userId'])->get()->getRow();
        $recentOrders = $this->customerOrdersModel->select('customer_orders.*,COUNT(coi.id) as total_items')
        ->where('user_id', $thisUser['userId'])->orderBy('id', 'DESC')
        ->join('customer_orders_items as coi','coi.customer_order_id = customer_orders.id','left')
        ->groupBy('customer_orders.id')
        ->findAll(8);
        $orders = $this->customerOrdersModel->select('customer_orders.*,COUNT(coi.id) as total_items')
        ->where('user_id', $thisUser['userId'])->orderBy('id', 'DESC')
        ->join('customer_orders_items as coi','coi.customer_order_id = customer_orders.id','left')
        ->groupBy('customer_orders.id')
        ->findAll();
        $defaultSHippingAddress = $this->shippingAddressModel->where('user_id', $thisUser['userId'])->where('is_default', 1)->get()->getRow();
        return view('frontend/myaccount/index',compact('userData','recentOrders','orders','defaultSHippingAddress'));
    }
}