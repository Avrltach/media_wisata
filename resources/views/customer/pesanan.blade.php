@extends('customer.layouts.app')

@section('title', 'Pesanan Saya — Media Wisata')

@section('content')
    <section class="bg-dark py-5 text-white" style="margin-top: 72px;">
        <div class="container">
            <h1 class="fw-bold mb-0">Pesanan Saya</h1>
        </div>
    </section>

    <section class="bg-white py-5">
        <div class="container">
            <div class="text-center py-5">
                <i class="bi bi-bag text-muted" style="font-size: 4rem;"></i>
                <h3 class="mt-3">Pesanan akan diisi di Phase 6.9</h3>
                <p class="text-muted mb-4">Daftar pesanan Anda akan muncul di sini, termasuk status pembayaran DP dan pelunasan.</p>
                <a href="{{ route('profile.show') }}" class="btn btn-outline-primary rounded-pill px-4">
                    <i class="bi bi-person-circle me-2"></i> Ke Halaman Profile
                </a>
            </div>
        </div>
    </section>
@endsection