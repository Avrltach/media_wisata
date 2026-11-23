<?php

use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\CustomerBookingController;
use App\Http\Controllers\CustomerDashboardController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Routes (no auth) — Customer Frontend
|--------------------------------------------------------------------------
*/
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/tentang', [AboutController::class, 'index'])->name('about');
Route::get('/paket', [PackageController::class, 'index'])->name('packages.index');
Route::get('/galeri', [GalleryController::class, 'index'])->name('gallery');
Route::get('/kontak', [ContactController::class, 'index'])->name('contact');

/*
|--------------------------------------------------------------------------
| Customer Authenticated Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:customer'])->group(function () {
    Route::get('/dashboard', [CustomerDashboardController::class, 'index'])->name('customer.dashboard');
    Route::get('/pesanan', [CustomerBookingController::class, 'index'])->name('customer.bookings.index');
});
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.show');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');
});
/*
|--------------------------------------------------------------------------
| Admin Auth Routes
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->middleware('guest:admin')->name('admin.')->group(function () {
    Route::get('/login', [AdminAuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AdminAuthController::class, 'login'])->name('login.post');
});


/*
|--------------------------------------------------------------------------
| Admin Authenticated Routes
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->middleware(['auth:admin', 'role:admin'])->name('admin.')->group(function () {
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');
    Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');

    // Phase 9A
    Route::resource('faqs', \App\Http\Controllers\Admin\AdminFaqController::class);
    Route::resource('bank-accounts', \App\Http\Controllers\Admin\AdminBankAccountController::class);
    Route::resource('gallery', \App\Http\Controllers\Admin\AdminGalleryController::class);

    // Phase 9B
    Route::resource('packages', \App\Http\Controllers\Admin\AdminPackageController::class);
    Route::delete('packages/{package}/images/{image}', [\App\Http\Controllers\Admin\AdminPackageController::class, 'deleteImage'])
        ->name('packages.images.destroy');

    // Phase 9C
    Route::get('bookings', [\App\Http\Controllers\Admin\AdminBookingController::class, 'index'])->name('bookings.index');
    Route::get('bookings/{booking}', [\App\Http\Controllers\Admin\AdminBookingController::class, 'show'])->name('bookings.show');
    Route::post('bookings/{booking}/status', [\App\Http\Controllers\Admin\AdminBookingController::class, 'updateStatus'])->name('bookings.status');

    Route::get('transactions', [\App\Http\Controllers\Admin\AdminTransactionController::class, 'index'])->name('transactions.index');
    Route::get('transactions/{transaction}', [\App\Http\Controllers\Admin\AdminTransactionController::class, 'show'])->name('transactions.show');
    Route::post('transactions/{transaction}/verify', [\App\Http\Controllers\Admin\AdminTransactionController::class, 'verify'])->name('transactions.verify');
    Route::post('transactions/{transaction}/reject', [\App\Http\Controllers\Admin\AdminTransactionController::class, 'reject'])->name('transactions.reject');

    // Phase 9D
    Route::get('testimonials', [\App\Http\Controllers\Admin\AdminTestimonialController::class, 'index'])->name('testimonials.index');
    Route::get('testimonials/{testimonial}', [\App\Http\Controllers\Admin\AdminTestimonialController::class, 'show'])->name('testimonials.show');
    Route::post('testimonials/{testimonial}/approve', [\App\Http\Controllers\Admin\AdminTestimonialController::class, 'approve'])->name('testimonials.approve');
    Route::post('testimonials/{testimonial}/reject', [\App\Http\Controllers\Admin\AdminTestimonialController::class, 'reject'])->name('testimonials.reject');
    Route::delete('testimonials/{testimonial}', [\App\Http\Controllers\Admin\AdminTestimonialController::class, 'destroy'])->name('testimonials.destroy');

    Route::get('contacts', [\App\Http\Controllers\Admin\AdminContactController::class, 'index'])->name('contacts.index');
    Route::get('contacts/{contact}', [\App\Http\Controllers\Admin\AdminContactController::class, 'show'])->name('contacts.show');
    Route::post('contacts/{contact}/mark-unread', [\App\Http\Controllers\Admin\AdminContactController::class, 'markAsUnread'])->name('contacts.mark-unread');
    Route::delete('contacts/{contact}', [\App\Http\Controllers\Admin\AdminContactController::class, 'destroy'])->name('contacts.destroy');

    // Phase 9E
    Route::get('company-profile/edit', [\App\Http\Controllers\Admin\AdminCompanyProfileController::class, 'edit'])->name('company-profile.edit');
    Route::put('company-profile', [\App\Http\Controllers\Admin\AdminCompanyProfileController::class, 'update'])->name('company-profile.update');
});
    require __DIR__.'/auth.php';
