<?php
namespace App\Controllers;

use App\Controllers\BaseController;

class OfferController extends BaseController
{
    public function index()
    {
        return view('frontend/offers');
    }
}