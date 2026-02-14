<?php
namespace App\Controllers;
use CodeIgniter\Controllers;
class ContactController extends BaseController
{
    public function index()
    {
        $page = "Industries";
        return view('frontend/contact-us',compact('page'));
    }
}
