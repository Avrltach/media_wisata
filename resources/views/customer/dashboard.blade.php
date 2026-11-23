@extends('customer.layouts.app')

@section('title', 'Dashboard — Media Wisata')

@section('content')
    <section class="bg-dark py-5 text-white" style="margin-top: 72px;">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h1 class="fw-bold mb-1">Selamat datang, {{ auth()->user()->name }}!</h1>
                    <p class="mb-0 opacity-75">Berikut ringkasan aktivitas pesanan Anda.</p>
                </div>
                <div class="col-md-4 text-md-end mt-3 mt-md-0">
                    <a href="{{ route('profile.show') }}" class="btn btn-outline-light rounded-pill px-3">
                        <i class="bi bi-person-circle"></i> Lihat Profile
                    </a>
                </div>
            </div>
        </div>
    </section>

    <section class="bg-white py-5">
        <div class="container">
            <div class="text-center py-5">
                <i class="bi bi-inbox text-muted" style="font-size: 4rem;"></i>
                <h3 class="mt-3">Dashboard akan diisi di Phase 6.9</h3>
                <p class="text-muted mb-4">Halaman ini akan menampilkan ringkasan pesanan, status pembayaran, dan statistik.</p>
                <a href="{{ route('customer.bookings.index') }}" class="btn btn-primary rounded-pill px-4">
                    <i class="bi bi-bag me-2"></i> Lihat Pesanan Saya
                </a>
            </div>
        </div>
    </section>
@endsection