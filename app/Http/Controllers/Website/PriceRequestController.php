<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;

class PriceRequestController extends Controller
{
    public function index()
    {
        return view('website.price-request');
    }
}
