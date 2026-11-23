@extends('adminlte::page')

@section('title', 'Pemesanan - Media Wisata Admin')

@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1><i class="fas fa-shopping-cart text-danger"></i> Pemesanan</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item active">Pemesanan</li>
                </ol>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <!-- Stat cards -->
    <div class="row mb-3">
        <div class="col-lg-2 col-md-4 col-6">
            <a href="{{ route('admin.bookings.index', ['status' => 'pending_dp']) }}"
               class="small-box bg-warning p-2 rounded text-center text-white d-block">
                <h5 class="mb-0">{{ $statusCounts['pending_dp'] }}</h5>
                <small>Menunggu DP</small>
            </a>
        </div>
        <div class="col-lg-2 col-md-4 col-6">
            <a href="{{ route('admin.bookings.index', ['status' => 'dp_paid']) }}"
               class="small-box bg-info p-2 rounded text-center text-white d-block">
                <h5 class="mb-0">{{ $statusCounts['dp_paid'] }}</h5>
                <small>DP Lunas</small>
            </a>
        </div>
        <div class="col-lg-2 col-md-4 col-6">
            <a href="{{ route('admin.bookings.index', ['status' => 'awaiting_pelunasan']) }}"
               class="small-box bg-primary p-2 rounded text-center text-white d-block">
                <h5 class="mb-0">{{ $statusCounts['awaiting_pelunasan'] }}</h5>
                <small>Menunggu Verif</small>
            </a>
        </div>
        <div class="col-lg-2 col-md-4 col-6">
            <a href="{{ route('admin.bookings.index', ['status' => 'lunas']) }}"
               class="small-box bg-success p-2 rounded text-center text-white d-block">
                <h5 class="mb-0">{{ $statusCounts['lunas'] }}</h5>
                <small>Lunas</small>
            </a>
        </div>
        <div class="col-lg-2 col-md-4 col-6">
            <a href="{{ route('admin.bookings.index', ['status' => 'selesai']) }}"
               class="small-box bg-secondary p-2 rounded text-center text-white d-block">
                <h5 class="mb-0">{{ $statusCounts['selesai'] }}</h5>
                <small>Selesai</small>
            </a>
        </div>
        <div class="col-lg-2 col-md-4 col-6">
            <a href="{{ route('admin.bookings.index', ['status' => 'cancelled']) }}"
               class="small-box bg-danger p-2 rounded text-center text-white d-block">
                <h5 class="mb-0">{{ $statusCounts['cancelled'] }}</h5>
                <small>Dibatalkan</small>
            </a>
        </div>
    </div>

    <!-- Filter & search -->
    <div class="row mb-3">
        <div class="col-12">
            <form method="GET" action="{{ route('admin.bookings.index') }}" class="card card-outline card-danger">
                <div class="card-body">
                    <div class="row align-items-end">
                        <div class="col-md-6">
                            <label for="search">Cari</label>
                            <input type="text" class="form-control" id="search" name="search"
                                   value="{{ request('search') }}"
                                   placeholder="Kode booking / nama / email / telepon">
                        </div>
                        <div class="col-md-4">
                            <label for="status">Status</label>
                            <select class="form-control" id="status" name="status">
                                <option value="">Semua Status</option>
                                <option value="pending_dp" @selected(request('status') === 'pending_dp')>Menunggu DP</option>
                                <option value="dp_paid" @selected(request('status') === 'dp_paid')>DP Lunas</option>
                                <option value="awaiting_pelunasan" @selected(request('status') === 'awaiting_pelunasan')>Menunggu Verifikasi</option>
                                <option value="lunas" @selected(request('status') === 'lunas')>Lunas</option>
                                <option value="selesai" @selected(request('status') === 'selesai')>Selesai</option>
                                <option value="cancelled" @selected(request('status') === 'cancelled')>Dibatalkan</option>
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

    <!-- Tabel pemesanan -->
    <div class="row">
        <div class="col-12">
            <div class="card card-danger card-outline">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-list"></i> Daftar Pemesanan ({{ $bookings->total() }})
                    </h3>
                </div>
                <div class="card-body table-responsive p-0">
                    <table class="table table-striped table-valign-middle">
                        <thead>
                            <tr>
                                <th width="60">No</th>
                                <th>Kode Booking</th>
                                <th>Customer</th>
                                <th>Paket</th>
                                <th width="100">Tgl Berangkat</th>
                                <th width="60">Pax</th>
                                <th width="120">Total</th>
                                <th width="140">Status</th>
                                <th width="80">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($bookings as $index => $booking)
                                <tr>
                                    <td>{{ $bookings->firstItem() + $index }}</td>
                                    <td>
                                        <strong>{{ $booking->booking_code }}</strong>
                                        <br>
                                        <small class="text-muted">{{ $booking->created_at->format('d M Y H:i') }}</small>
                                    </td>
                                    <td>
                                        {{ $booking->full_name }}
                                        <br>
                                        <small class="text-muted">{{ $booking->email }}</small>
                                    </td>
                                    <td>{{ Str::limit($booking->package->name ?? '-', 30) }}</td>
                                    <td>{{ $booking->departure_date->format('d M Y') }}</td>
                                    <td>{{ $booking->number_of_participants }}</td>
                                    <td>{{ $booking->formatted_total_price }}</td>
                                    <td>{!! $booking->status_badge !!}</td>
                                    <td>
                                        <a href="{{ route('admin.bookings.show', $booking) }}"
                                           class="btn btn-info btn-sm" title="Lihat detail">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="text-center text-muted py-4">
                                        <i class="fas fa-inbox fa-2x mb-2"></i><br>
                                        Belum ada pemesanan.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="card-footer">
                    {{ $bookings->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection