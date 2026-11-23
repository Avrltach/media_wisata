<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\CompanyProfile;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Auto-bind companyProfile ke semua view customer (navbar + footer butuh ini)
        View::composer('customer.*', function ($view) {
            $view->with('companyProfile', CompanyProfile::getInstance());
        });
    }
}