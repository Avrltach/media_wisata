<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminTransactionController extends Controller
{

    public function index(Request $request): View
    {
        $query = Transaction::with(['booking.user', 'booking.package']);

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('need_verification') && $request->boolean('need_verification')) {
            $query->where('type', 'pelunasan')
                  ->where('method', 'manual_transfer')
                  ->where('status', 'pending');
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->whereHas('booking', function ($b) use ($search) {
                    $b->where('booking_code', 'like', "%{$search}%")
                      ->orWhere('full_name', 'like', "%{$search}%");
                })->orWhere('midtrans_order_id', 'like', "%{$search}%");
            });
        }

        $transactions = $query->latest()->paginate(10)->withQueryString();

        $pendingVerificationCount = Transaction::where('type', 'pelunasan')
            ->where('method', 'manual_transfer')
            ->where('status', 'pending')
            ->count();

        return view('admin.transactions.index', compact('transactions', 'pendingVerificationCount'));
    }


    public function show(Transaction $transaction): View
    {
        $transaction->load(['booking.user', 'booking.package', 'verifier']);

        return view('admin.transactions.show', compact('transaction'));
    }


    public function verify(Transaction $transaction): RedirectResponse
    {
        if ($transaction->type !== 'pelunasan') {
            return back()->with('error', 'Hanya transaksi pelunasan yang dapat diverifikasi.');
        }

        if ($transaction->method !== 'manual_transfer') {
            return back()->with('error', 'Transaksi Midtrans tidak perlu diverifikasi manual.');
        }

        if ($transaction->status !== 'pending') {
            return back()->with('error', 'Transaksi ini tidak dapat diverifikasi (status: ' . $transaction->status . ').');
        }

        $transaction->update([
            'status'       => 'verified',
            'verified_by'  => auth()->id(),
            'verified_at'  => now(),
            'payment_date' => $transaction->payment_date ?? now(),
        ]);

        $transaction->booking->update(['status' => 'lunas']);

        return redirect()
            ->route('admin.transactions.show', $transaction)
            ->with('success', 'Pembayaran pelunasan berhasil diverifikasi. Status pesanan: LUNAS.');
    }


    public function reject(Transaction $transaction): RedirectResponse
    {
        if ($transaction->status !== 'pending') {
            return back()->with('error', 'Hanya transaksi pending yang dapat ditolak.');
        }

        $transaction->update(['status' => 'failed']);

        if ($transaction->type === 'pelunasan') {
            $transaction->booking->update(['status' => 'dp_paid']);
        }

        return redirect()
            ->route('admin.transactions.show', $transaction)
            ->with('success', 'Transaksi ditolak. Customer dapat upload ulang bukti pembayaran.');
    }
}