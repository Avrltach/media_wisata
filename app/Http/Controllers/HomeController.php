<?php

namespace App\Http\Controllers;

use App\Models\CompanyProfile;
use App\Models\Faq;
use App\Models\Gallery;
use App\Models\Package;
use App\Models\Testimonial;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $packages = Package::active()->latest()->limit(8)->get();
        $galleries = Gallery::published()->latest()->limit(8)->get();
        $testimonials = Testimonial::approved()->latest()->limit(3)->get();
        $faqs = Faq::published()->orderBy('sort_order')->limit(5)->get();

        return view('customer.home.home', compact(
            'packages',
            'galleries',
            'testimonials',
            'faqs'
        ));
    }
}