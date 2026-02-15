<?php
namespace App\Controllers;

class CommonController extends BaseController {

    public function terms() {
        $page = "Terms and  Conditions";
        return view('frontend/terms-and-conditions',compact('page'));
    }
}