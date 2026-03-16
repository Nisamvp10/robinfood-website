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
        $page = "Track Your Order";
      //  $trackingNumber = $this->request->getPost('trackingNumber');
       $trackingId = $this->request->getPost('trackingNumber');
        $tracking = $this->shipbuddyService->trackShipment($trackingId);
        print_r($tracking);

        return $this->response->setJSON($tracking);



      //  return view('frontend/product-tracking', compact('page'));
    }
}