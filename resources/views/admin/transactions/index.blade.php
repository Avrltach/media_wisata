@extends('adminlte::page')

@section('title', 'Pembayaran - Media Wisata Admin')

@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1><i class="fas fa-money-bill-wave text-danger"></i> Pembayaran</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item active">Pembayaran</li>
                </ol>
            </div>
        </div>
    </div>
@endsection

@section('content')
    @if($pendingVerificationCount > 0)
        <div class="alert alert-warning">
            <i class="fas fa-exclamation-triangle"></i>
            Ada <strong>{{ $pendingVerificationCount }}</strong> pembayaran pelunasan yang menunggu verifikasi Anda.
            <a href="{{ route('admin.transactions.index', ['need_verification' => 1]) }}" class="alert-link">
                Lihat daftar
            </a>
        </div>
    @endif

    <!-- Filter -->
    <div class="row mb-3">
        <div class="col-12">
            <form method="GET" action="{{ route('admin.transactions.index') }}" class="card card-outline card-danger">
                <div class="card-body">
                    <div class="row align-items-end">
                        <div class="col-md-4">
                            <label for="search">Cari</label>
                            <input type="text" class="form-control" id="search" name="search"
                                   value="{{ request('search') }}"
                                   placeholder="Kode booking / nama customer">
                        </div>
                        <div class="col-md-3">
                            <label for="type">Jenis</label>
                            <select class="form-control" id="type" name="type">
                                <option value="">Semua</option>
                                <option value="dp" @selected(request('type') === 'dp')>DP</option>
                                <option value="pelunasan" @selected(request('type') === 'pelunasan')>Pelunasan</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="status">Status</label>
                            <select class="form-control" id="status" name="status">
                                <option value="">Semua Status</option>
                                <option value="pending" @selected(request('status') === 'pending')>Pending</option>
                                <option value="success" @selected(request('status') === 'success')>Sukses</option>
                                <option value="verified" @selected(request('status') === 'verified')>Terverifikasi</option>
                                <option value="failed" @selected(request('status') === 'failed')>Gagal</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-danger btn-block">
                                <i class="fas fa-search"></i> Filter
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Tabel transaksi -->
    <div class="row">
        <div class="col-12">
            <div class="card card-danger card-outline">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-list"></i> Daftar Transaksi ({{ $transactions->total() }})
                    </h3>
                </div>
                <div class="card-body table-responsive p-0">
                    <table class="table table-striped table-valign-middle">
                        <thead>
                            <tr>
                                <th width="60">No</th>
                                <th>Kode Booking</th>
                                <th>Customer</th>
                                <th width="90">Jenis</th>
                                <th width="120">Metode</th>
                                <th width="120">Nominal</th>
                                <th width="100">Status</th>
                                <th width="100">Tanggal</th>
                                <th width="80">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($transactions as $index => $transaction)
                                <tr>
                                    <td>{{ $transactions->firstItem() + $index }}</td>
                                    <td>
                                        <strong>{{ $transaction->booking->booking_code ?? '-' }}</strong>
                                    </td>
                                    <td>{{ $transaction->booking->full_name ?? '-' }}</td>
                                    <td>
                                        @if($transaction->type === 'dp')
                                            <span class="badge badge-info">DP</span>
                                        @else
                                            <span class="badge badge-primary">Pelunasan</span>
                                        @endif
                                    </td>
                                    <td>
                                        <small>{{ $transaction->method_label }}</small>
                                        @if($transaction->midtrans_payment_type)
                                            <br><code>{{ $transaction->midtrans_payment_type }}</code>
                                        @endif
                                    </td>
                                    <td><strong>{{ $transaction->formatted_amount }}</strong></td>
                                    <td>{!! $transaction->status_badge !!}</td>
                                    <td>
                                        @if($transaction->payment_date)
                                            <small>{{ $transaction->payment_date->format('d M Y') }}</small>
                                        @else
                                            <small class="text-muted">-</small>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.transactions.show', $transaction) }}"
                                           class="btn btn-info btn-sm" title="Lihat detail">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="text-center text-muted py-4">
                                        <i class="fas fa-inbox fa-2x mb-2"></i><br>
                                        Belum ada transaksi.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="card-footer">
                    {{ $transactions->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection