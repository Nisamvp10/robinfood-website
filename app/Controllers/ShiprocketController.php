<?php

//use CodeIgniter\HTTP\Exceptions\HTTPException;
namespace App\Controllers;
use CodeIgniter\Controller;
use App\Services\ShiprocketService;
use App\Models\CustomerOrderModel;
use App\Models\CustomerOrderItemsModel;
use App\Models\ProductManageModel;
use App\Models\ProductModel;

class ShiprocketController extends Controller
{
    protected $shiprocket;
    protected $customerOrderModel;
    protected $shiprocketService;
    protected $customerOrderItemsModel;
    protected $productManageModel;
    protected $productModel;

    public function __construct()
    {
        $this->shiprocket = new ShiprocketService();
        $this->customerOrderModel = new CustomerOrderModel();
        $this->shiprocketService = new ShiprocketService();
        $this->customerorderitemsModel = new CustomerOrderItemsModel();
        $this->productManageModel = new ProductManageModel();
        $this->productModel = new productModel();
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
        $orderItems = $this->customerorderitemsModel->where('customer_order_id', $orderId)->findAll();
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
        print_r($response);exit();

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
}