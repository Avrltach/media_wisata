<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class CustomerBookingController extends Controller
{
    public function index(): View
    {
        return view('customer.pesanan');
    }
}