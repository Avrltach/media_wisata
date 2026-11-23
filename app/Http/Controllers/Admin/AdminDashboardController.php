<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Contact;
use App\Models\Package;
use App\Models\Transaction;
use Illuminate\View\View;

class AdminDashboardController extends Controller
{

    public function index(): View
    {
        $stats = [
            'total_packages'         => Package::count(),
            'total_bookings'         => Booking::count(),
            'pending_dp_bookings'    => Booking::where('status', 'pending_dp')->count(),
            'dp_paid_bookings'       => Booking::where('status', 'dp_paid')->count(),
            'awaiting_pelunasan'     => Booking::where('status', 'awaiting_pelunasan')->count(),
            'lunas_bookings'         => Booking::whereIn('status', ['lunas', 'selesai'])->count(),
            'pending_transactions'   => Transaction::where('status', 'pending')->count(),
            'unread_contacts'        => Contact::where('is_read', false)->count(),

            'total_revenue'          => Transaction::whereIn('status', ['verified', 'success'])->sum('amount'),
        ];

        $recentBookings = Booking::with(['user', 'package'])
            ->latest()
            ->limit(5)
            ->get();

        $pendingVerifications = Transaction::with(['booking.user', 'booking.package'])
            ->where('type', 'pelunasan')
            ->where('method', 'manual_transfer')
            ->where('status', 'pending')
            ->latest()
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentBookings', 'pendingVerifications'));
    }
}