<?php

namespace App\Http\Controllers;

use App\Models\CompanyProfile;
use App\Models\Faq;
use Illuminate\View\View;

class AboutController extends Controller
{
    public function index(): View
    {
        $faqs = Faq::published()->orderBy('sort_order')->limit(5)->get();
        return view('customer.about.about', 
        compact('faqs'));
    }
}