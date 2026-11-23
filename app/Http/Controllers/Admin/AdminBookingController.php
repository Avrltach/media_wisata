<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminBookingController extends Controller
{
    
    public function index(Request $request): View
    {
        $query = Booking::with(['user', 'package']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('booking_code', 'like', "%{$search}%")
                  ->orWhere('full_name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        $bookings = $query->latest()->paginate(10)->withQueryString();

        $statusCounts = [
            'pending_dp'         => Booking::where('status', 'pending_dp')->count(),
            'dp_paid'            => Booking::where('status', 'dp_paid')->count(),
            'awaiting_pelunasan' => Booking::where('status', 'awaiting_pelunasan')->count(),
            'lunas'              => Booking::where('status', 'lunas')->count(),
            'selesai'            => Booking::where('status', 'selesai')->count(),
            'cancelled'          => Booking::where('status', 'cancelled')->count(),
        ];

        return view('admin.bookings.index', compact('bookings', 'statusCounts'));
    }


    public function show(Booking $booking): View
    {
        $booking->load([
            'user',
            'package.images',
            'participants',
            'transactions.verifier',
        ]);

        return view('admin.bookings.show', compact('booking'));
    }


    public function updateStatus(Request $request, Booking $booking): RedirectResponse
    {
        $validated = $request->validate([
            'status' => ['required', 'in:dp_paid,awaiting_pelunasan,lunas,selesai,cancelled'],
        ]);

        if ($booking->status === 'cancelled') {
            return back()->with('error', 'Pesanan yang sudah dibatalkan tidak dapat diubah statusnya.');
        }

        if ($booking->status === 'selesai') {
            return back()->with('error', 'Pesanan yang sudah selesai tidak dapat diubah statusnya.');
        }

        $allowedTransitions = [
            'pending_dp'         => ['cancelled'],
            'dp_paid'            => ['cancelled'],
            'awaiting_pelunasan' => ['cancelled'],
            'lunas'              => ['selesai', 'cancelled'],
        ];

        $allowed = $allowedTransitions[$booking->status] ?? [];

        if (!in_array($validated['status'], $allowed)) {
            return back()->with('error', 'Transisi status tidak valid untuk pesanan ini.');
        }

        $booking->update(['status' => $validated['status']]);

        $statusLabels = [
            'selesai'   => 'Selesai',
            'cancelled' => 'Dibatalkan',
        ];

        return redirect()
            ->route('admin.bookings.show', $booking)
            ->with('success', 'Status pesanan berhasil diubah menjadi: ' . ($statusLabels[$validated['status']] ?? $validated['status']));
    }
}