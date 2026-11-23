@extends('adminlte::page')

@section('title', 'Detail Transaksi - Media Wisata Admin')

@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1><i class="fas fa-receipt text-danger"></i> Detail Transaksi</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.transactions.index') }}">Pembayaran</a></li>
                    <li class="breadcrumb-item active">Detail</li>
                </ol>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <!-- Alert verify/reject action -->
    @if($transaction->type === 'pelunasan' && $transaction->method === 'manual_transfer' && $transaction->status === 'pending')
        <div class="alert alert-warning">
            <i class="fas fa-exclamation-triangle"></i>
            <strong>Transaksi ini membutuhkan verifikasi Anda.</strong>
            <br>
            Periksa bukti pembayaran di bawah, lalu klik <strong>Verify</strong> jika valid atau <strong>Reject</strong> jika tidak valid.
        </div>
    @endif

    <div class="row">
        <!-- Kolom kiri: detail transaksi -->
        <div class="col-md-8">
            <!-- Info transaksi -->
            <div class="card card-info card-outline">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-info-circle"></i> Informasi Transaksi</h3>
                </div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tr>
                            <th width="35%">ID Transaksi</th>
                            <td><code>#{{ $transaction->id }}</code></td>
                        </tr>
                        <tr>
                            <th>Jenis Pembayaran</th>
                            <td>
                                <span class="badge badge-{{ $transaction->type === 'dp' ? 'info' : 'primary' }}">
                                    {{ $transaction->type_label }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <th>Metode</th>
                            <td>{{ $transaction->method_label }}</td>
                        </tr>
                        <tr>
                            <th>Nominal</th>
                            <td><strong class="text-danger">{{ $transaction->formatted_amount }}</strong></td>
                        </tr>
                        <tr>
                            <th>Status</th>
                            <td>{!! $transaction->status_badge !!}</td>
                        </tr>
                        <tr>
                            <th>Dibuat</th>
                            <td>{{ $transaction->created_at->format('d M Y H:i') }}</td>
                        </tr>
                        @if($transaction->payment_date)
                            <tr>
                                <th>Tanggal Pembayaran</th>
                                <td>{{ $transaction->payment_date->format('d M Y H:i') }}</td>
                            </tr>
                        @endif
                        @if($transaction->verified_at)
                            <tr>
                                <th>Diverifikasi pada</th>
                                <td>{{ $transaction->verified_at->format('d M Y H:i') }}</td>
                            </tr>
                            <tr>
                                <th>Diverifikasi oleh</th>
                                <td>{{ $transaction->verifier?->name ?? '-' }}</td>
                            </tr>
                        @endif
                    </table>
                </div>
            </div>

            <!-- Midtrans info (kalau DP via Midtrans) -->
            @if($transaction->method === 'midtrans' && ($transaction->midtrans_order_id || $transaction->midtrans_transaction_id))
                <div class="card card-info card-outline">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fas fa-credit-card"></i> Detail Midtrans</h3>
                    </div>
                    <div class="card-body">
                        <table class="table table-borderless">
                            @if($transaction->midtrans_order_id)
                                <tr>
                                    <th width="35%">Order ID</th>
                                    <td><code>{{ $transaction->midtrans_order_id }}</code></td>
                                </tr>
                            @endif
                            @if($transaction->midtrans_transaction_id)
                                <tr>
                                    <th>Transaction ID</th>
                                    <td><code>{{ $transaction->midtrans_transaction_id }}</code></td>
                                </tr>
                            @endif
                            @if($transaction->midtrans_payment_type)
                                <tr>
                                    <th>Payment Type</th>
                                    <td><code>{{ $transaction->midtrans_payment_type }}</code></td>
                                </tr>
                            @endif
                            @if($transaction->midtrans_va_number)
                                <tr>
                                    <th>VA Number</th>
                                    <td><code>{{ $transaction->midtrans_va_number }}</code></td>
                                </tr>
                            @endif
                        </table>
                    </div>
                </div>
            @endif

            <!-- Payment proof (kalau pelunasan manual transfer) -->
            @if($transaction->method === 'manual_transfer' && $transaction->payment_proof)
                <div class="card card-warning card-outline">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fas fa-file-image"></i> Bukti Pembayaran</h3>
                    </div>
                    <div class="card-body text-center">
                        <a href="{{ $transaction->payment_proof_url }}" target="_blank">
                            <img src="{{ $transaction->payment_proof_url }}" alt="Bukti bayar"
                                 class="img-fluid rounded" style="max-height:500px;cursor:zoom-in;">
                        </a>
                        <p class="mt-2">
                            <small class="text-muted">
                                <i class="fas fa-search-plus"></i> Klik gambar untuk lihat full size
                            </small>
                        </p>
                        <a href="{{ $transaction->payment_proof_url }}" download class="btn btn-default btn-sm">
                            <i class="fas fa-download"></i> Download
                        </a>
                    </div>
                </div>
            @endif
        </div>

        <!-- Kolom kanan: booking info + actions -->
        <div class="col-md-4">
            <!-- Booking terkait -->
            <div class="card card-info card-outline">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-shopping-cart"></i> Pesanan Terkait</h3>
                </div>
                <div class="card-body">
                    <p class="mb-1">
                        <small class="text-muted">Kode Booking:</small><br>
                        <strong>{{ $transaction->booking->booking_code }}</strong>
                    </p>
                    <p class="mb-1">
                        <small class="text-muted">Customer:</small><br>
                        {{ $transaction->booking->full_name }}
                    </p>
                    <p class="mb-1">
                        <small class="text-muted">Paket:</small><br>
                        {{ Str::limit($transaction->booking->package?->name ?? '-', 30) }}
                    </p>
                    <p class="mb-1">
                        <small class="text-muted">Status Pesanan:</small><br>
                        {!! $transaction->booking->status_badge !!}
                    </p>
                </div>
                <div class="card-footer">
                    <a href="{{ route('admin.bookings.show', $transaction->booking) }}"
                       class="btn btn-info btn-block btn-sm">
                        <i class="fas fa-eye"></i> Lihat Detail Pesanan
                    </a>
                </div>
            </div>

            <!-- Action buttons -->
            @if($transaction->type === 'pelunasan' && $transaction->method === 'manual_transfer' && $transaction->status === 'pending')
                <div class="card card-success card-outline">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fas fa-gavel"></i> Aksi Verifikasi</h3>
                    </div>
                    <div class="card-body">
                        <p class="mb-3">Verifikasi pembayaran ini jika bukti transfer sudah valid.</p>
                        <form action="{{ route('admin.transactions.verify', $transaction) }}" method="POST"
                              onsubmit="return confirm('Verifikasi pembayaran ini? Status pesanan akan menjadi LUNAS.')">
                            @csrf
                            <button type="submit" class="btn btn-success btn-block">
                                <i class="fas fa-check-circle"></i> Verify Pembayaran
                            </button>
                        </form>
                        <form action="{{ route('admin.transactions.reject', $transaction) }}" method="POST"
                              onsubmit="return confirm('Tolak pembayaran ini? Customer dapat upload ulang bukti.')">
                            @csrf
                            <button type="submit" class="btn btn-danger btn-block mt-2">
                                <i class="fas fa-times-circle"></i> Reject Pembayaran
                            </button>
                        </form>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-12">
            <a href="{{ route('admin.transactions.index') }}" class="btn btn-default">
                <i class="fas fa-arrow-left"></i> Kembali ke Daftar Transaksi
            </a>
        </div>
    </div>
@endsection