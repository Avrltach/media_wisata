@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1><i class="fas fa-tachometer-alt text-danger"></i> Dashboard</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item active">Dashboard</li>
                </ol>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <!-- Welcome Header -->
    <div class="row">
        <div class="col-12">
            <div class="callout callout-danger">
                <h5><i class="fas fa-info-circle"></i> Selamat datang, {{ auth()->user()->name }}!</h5>
                <p>Anda login sebagai <strong>Administrator</strong>. Berikut ringkasan aktivitas Media Wisata hari ini.</p>
            </div>
        </div>
    </div>

    <!-- Stat Cards Row 1 -->
    <div class="row">
        <div class="col-lg-3 col-6">
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3>{{ $stats['total_packages'] }}</h3>
                    <p>Total Paket</p>
                </div>
                <div class="icon">
                    <i class="fas fa-suitcase"></i>
                </div>
                <a href="#" class="small-box-footer">
                    Lihat detail <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ $stats['total_bookings'] }}</h3>
                    <p>Total Pemesanan</p>
                </div>
                <div class="icon">
                    <i class="fas fa-shopping-cart"></i>
                </div>
                <a href="#" class="small-box-footer">
                    Lihat detail <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{ $stats['pending_dp_bookings'] }}</h3>
                    <p>Menunggu DP</p>
                </div>
                <div class="icon">
                    <i class="fas fa-clock"></i>
                </div>
                <a href="#" class="small-box-footer">
                    Lihat detail <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>Rp {{ number_format($stats['total_revenue'], 0, ',', '.') }}</h3>
                    <p>Total Pendapatan</p>
                </div>
                <div class="icon">
                    <i class="fas fa-money-bill-wave"></i>
                </div>
                <a href="#" class="small-box-footer">
                    Lihat detail <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Stat Cards Row 2 -->
    <div class="row">
        <div class="col-lg-3 col-6">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ $stats['dp_paid_bookings'] }}</h3>
                    <p>DP Sudah Bayar</p>
                </div>
                <div class="icon">
                    <i class="fas fa-check-circle"></i>
                </div>
                <a href="#" class="small-box-footer">
                    Lihat detail <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box bg-primary">
                <div class="inner">
                    <h3>{{ $stats['awaiting_pelunasan'] }}</h3>
                    <p>Menunggu Verifikasi</p>
                </div>
                <div class="icon">
                    <i class="fas fa-hourglass-half"></i>
                </div>
                <a href="#" class="small-box-footer">
                    Lihat detail <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ $stats['lunas_bookings'] }}</h3>
                    <p>Pesanan Lunas</p>
                </div>
                <div class="icon">
                    <i class="fas fa-check-double"></i>
                </div>
                <a href="#" class="small-box-footer">
                    Lihat detail <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box bg-secondary">
                <div class="inner">
                    <h3>{{ $stats['unread_contacts'] }}</h3>
                    <p>Pesan Belum Dibaca</p>
                </div>
                <div class="icon">
                    <i class="fas fa-envelope"></i>
                </div>
                <a href="#" class="small-box-footer">
                    Lihat detail <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Recent Bookings Table -->
    <div class="row">
        <div class="col-md-7">
            <div class="card card-danger card-outline">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-shopping-cart"></i> Pemesanan Terbaru
                    </h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body p-0">
                    <table class="table table-striped table-valign-middle">
                        <thead>
                            <tr>
                                <th>Kode</th>
                                <th>Customer</th>
                                <th>Paket</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentBookings as $booking)
                                <tr>
                                    <td><strong>{{ $booking->booking_code }}</strong></td>
                                    <td>{{ $booking->full_name }}</td>
                                    <td>{{ Str::limit($booking->package->name ?? '-', 25) }}</td>
                                    <td>{!! $booking->status_badge !!}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted py-4">
                                        <i class="fas fa-inbox fa-2x mb-2"></i><br>
                                        Belum ada pemesanan
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Pending Verifications Table -->
        <div class="col-md-5">
            <div class="card card-warning card-outline">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-hourglass-half"></i> Perlu Verifikasi Pembayaran
                    </h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body p-0">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Booking</th>
                                <th>Nominal</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($pendingVerifications as $transaction)
                                <tr>
                                    <td>
                                        <strong>{{ $transaction->booking->booking_code }}</strong><br>
                                        <small class="text-muted">{{ $transaction->booking->full_name }}</small>
                                    </td>
                                    <td>{{ $transaction->formatted_amount }}</td>
                                    <td>
                                        <button class="btn btn-xs btn-warning btn-flat">
                                            <i class="fas fa-eye"></i> Verifikasi
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center text-muted py-4">
                                        <i class="fas fa-check-circle fa-2x mb-2 text-success"></i><br>
                                        Tidak ada yang perlu diverifikasi
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
<script>
    // Auto-refresh dashboard tiap 5 menit (optional)
    // setTimeout(() => location.reload(), 300000);
</script>
@endpush