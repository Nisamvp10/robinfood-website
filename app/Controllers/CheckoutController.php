<?php
namespace App\Controllers;

use CodeIgniter\Controller;

class CheckoutController extends Controller
{
    public function index()
    {
        $page = "Checkout";
        return view('frontend/checkout/index', compact('page'));
    }
}