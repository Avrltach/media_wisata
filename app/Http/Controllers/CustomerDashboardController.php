<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class CustomerDashboardController extends Controller
{
    public function index(): View
    {
        return view('customer.dashboard');
    }
}