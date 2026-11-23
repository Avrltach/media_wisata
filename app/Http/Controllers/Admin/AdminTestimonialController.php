<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminTestimonialController extends Controller
{
   
    public function index(Request $request): View
    {
        $query = Testimonial::with(['user', 'booking']);

        if ($request->filled('status')) {
            if ($request->status === 'pending') {
                $query->where('is_approved', false);
            } elseif ($request->status === 'approved') {
                $query->where('is_approved', true);
            }
        }

        if ($request->filled('rating')) {
            $query->where('rating', '>=', $request->rating);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('message', 'like', "%{$search}%");
            });
        }

        $testimonials = $query->latest()->paginate(10)->withQueryString();

        $stats = [
            'total'    => Testimonial::count(),
            'pending'  => Testimonial::where('is_approved', false)->count(),
            'approved' => Testimonial::where('is_approved', true)->count(),
        ];

        return view('admin.testimonials.index', compact('testimonials', 'stats'));
    }


    public function show(Testimonial $testimonial): View
    {
        $testimonial->load(['user', 'booking.package']);

        return view('admin.testimonials.show', compact('testimonial'));
    }


    public function approve(Testimonial $testimonial): RedirectResponse
    {
        $testimonial->update(['is_approved' => true]);

        return redirect()
            ->route('admin.testimonials.show', $testimonial)
            ->with('success', 'Testimoni berhasil di-approve. Sekarang tampil di website.');
    }


    public function reject(Testimonial $testimonial): RedirectResponse
    {
        $testimonial->update(['is_approved' => false]);

        return redirect()
            ->route('admin.testimonials.show', $testimonial)
            ->with('success', 'Testimoni berhasil di-reject. Tidak akan tampil di website.');
    }


    public function destroy(Testimonial $testimonial): RedirectResponse
    {
        $testimonial->delete();

        return redirect()
            ->route('admin.testimonials.index')
            ->with('success', 'Testimoni berhasil dihapus.');
    }
}