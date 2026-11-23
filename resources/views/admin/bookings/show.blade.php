@extends('adminlte::page')

@section('title', 'Detail Pemesanan ' . $booking->booking_code . ' - Media Wisata Admin')

@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>
                    <i class="fas fa-shopping-cart text-danger"></i>
                    Detail Pemesanan
                    <small class="text-muted">{{ $booking->booking_code }}</small>
                </h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.bookings.index') }}">Pemesanan</a></li>
                    <li class="breadcrumb-item active">{{ $booking->booking_code }}</li>
                </ol>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <!-- Header status + actions -->
    <div class="row mb-3">
        <div class="col-12">
            <div class="callout callout-{{ 
                $booking->status === 'lunas' || $booking->status === 'selesai' ? 'success' : 
                ($booking->status === 'cancelled' ? 'danger' : 'info') 
            }}">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="mb-1">Status Pesanan: {!! $booking->status_badge !!}</h5>
                        <p class="mb-0">
                            Dibuat: <strong>{{ $booking->created_at->format('d M Y H:i') }}</strong> |
                            Berangkat: <strong>{{ $booking->departure_date->format('d M Y') }}</strong>
                        </p>
                    </div>
                    <div>
                        @if($booking->status === 'lunas')
                            <form action="{{ route('admin.bookings.status', $booking) }}" method="POST" style="display:inline;"
                                  onsubmit="return confirm('Tandai pesanan ini sebagai SELESAI?')">
                                @csrf
                                <input type="hidden" name="status" value="selesai">
                                <button type="submit" class="btn btn-success btn-sm">
                                    <i class="fas fa-check"></i> Tandai Selesai
                                </button>
                            </form>
                        @endif
                        @if(!in_array($booking->status, ['cancelled', 'selesai']))
                            <form action="{{ route('admin.bookings.status', $booking) }}" method="POST" style="display:inline;"
                                  onsubmit="return confirm('Yakin batalkan pesanan ini? Tindakan tidak dapat dibatalkan.')">
                                @csrf
                                <input type="hidden" name="status" value="cancelled">
                                <button type="submit" class="btn btn-danger btn-sm">
                                    <i class="fas fa-ban"></i> Batalkan Pesanan
                                </button>
                            </form>
                        @endif
                        <a href="{{ route('admin.bookings.index') }}" class="btn btn-default btn-sm">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Kolom kiri: customer + package info -->
        <div class="col-md-8">
            <!-- Customer info -->
            <div class="card card-info card-outline">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-user"></i> Data Pemesan</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Nama:</strong><br>{{ $booking->full_name }}</p>
                            <p><strong>Email:</strong><br>{{ $booking->email }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Telepon:</strong><br>{{ $booking->phone }}</p>
                            <p><strong>WhatsApp:</strong><br>
                                <a href="https://wa.me/{{ $booking->whatsapp }}" target="_blank" class="text-success">
                                    <i class="fab fa-whatsapp"></i> {{ $booking->whatsapp }}
                                </a>
                            </p>
                        </div>
                    </div>
                    @if($booking->user)
                        <hr>
                        <p class="mb-0">
                            <small class="text-muted">
                                <i class="fas fa-info-circle"></i>
                                Akun terdaftar: {{ $booking->user->email }} (sejak {{ $booking->user->created_at->format('M Y') }})
                            </small>
                        </p>
                    @endif
                </div>
            </div>

            <!-- Package info -->
            <div class="card card-info card-outline">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-suitcase"></i> Paket yang Dipesan</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            @if($booking->package && $booking->package->main_image)
                                <img src="{{ $booking->package->main_image_url }}" alt="{{ $booking->package->name }}"
                                     class="img-fluid rounded">
                            @else
                                <div class="bg-light d-flex align-items-center justify-content-center text-muted"
                                     style="height:150px;border-radius:4px;">
                                    <i class="fas fa-image fa-2x"></i>
                                </div>
                            @endif
                        </div>
                        <div class="col-md-8">
                            <h5>{{ $booking->package->name ?? '(Paket dihapus)' }}</h5>
                            <p class="mb-1">
                                <i class="fas fa-map-marker-alt text-muted"></i> {{ $booking->package->location ?? '-' }}
                            </p>
                            <p class="mb-1">
                                <i class="fas fa-clock text-muted"></i> Durasi: {{ $booking->package->duration ?? '-' }}
                            </p>
                            <p class="mb-1">
                                <i class="fas fa-users text-muted"></i> Jumlah Peserta: <strong>{{ $booking->number_of_participants }} orang</strong>
                            </p>
                            <p class="mb-1">
                                <i class="fas fa-calendar text-muted"></i> Tanggal Berangkat: <strong>{{ $booking->departure_date->format('d M Y') }}</strong>
                            </p>
                            @if($booking->package)
                                <a href="{{ route('admin.packages.show', $booking->package) }}" class="btn btn-info btn-sm mt-2">
                                    <i class="fas fa-eye"></i> Lihat Detail Paket
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Participants (jika lebih dari 1) -->
            @if($booking->participants->isNotEmpty())
                <div class="card card-info card-outline">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-users"></i> Data Peserta Rombongan ({{ $booking->participants->count() }})
                        </h3>
                    </div>
                    <div class="card-body p-0">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th width="50">No</th>
                                    <th>Nama</th>
                                    <th width="150">No. Identitas</th>
                                    <th width="80">Gender</th>
                                    <th width="60">Usia</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($booking->participants as $i => $participant)
                                    <tr>
                                        <td>{{ $i + 1 }}</td>
                                        <td>{{ $participant->name }}</td>
                                        <td>{{ $participant->id_number ?: '-' }}</td>
                                        <td>
                                            @if($participant->gender === 'L')
                                                <span class="badge badge-info">Laki-laki</span>
                                            @elseif($participant->gender === 'P')
                                                <span class="badge badge-danger">Perempuan</span>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td>{{ $participant->age ?: '-' }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif

            <!-- Notes -->
            @if($booking->notes)
                <div class="card card-warning card-outline">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fas fa-sticky-note"></i> Catatan dari Customer</h3>
                    </div>
                    <div class="card-body">
                        <p style="white-space:pre-line;">{{ $booking->notes }}</p>
                    </div>
                </div>
            @endif
        </div>

        <!-- Kolom kanan: payment info -->
        <div class="col-md-4">
            <!-- Ringkasan harga -->
            <div class="card card-success card-outline">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-money-bill-wave"></i> Ringkasan Pembayaran</h3>
                </div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tr>
                            <th>Harga Paket / pax</th>
                            <td class="text-right">{{ $booking->package->formatted_price ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Jumlah Peserta</th>
                            <td class="text-right">{{ $booking->number_of_participants }} pax</td>
                        </tr>
                        <tr style="border-top:2px solid #dee2e6;">
                            <th>Total Harga</th>
                            <td class="text-right"><strong>{{ $booking->formatted_total_price }}</strong></td>
                        </tr>
                        <tr>
                            <th>DP (30%)</th>
                            <td class="text-right text-info">{{ $booking->formatted_dp_amount }}</td>
                        </tr>
                        <tr>
                            <th>Sisa Pelunasan</th>
                            <td class="text-right text-danger"><strong>{{ $booking->formatted_pelunasan_amount }}</strong></td>
                        </tr>
                    </table>
                </div>
            </div>

            <!-- Transaksi DP -->
            @if($booking->dpTransaction)
                <div class="card card-info card-outline">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-receipt"></i> Transaksi DP
                            <span class="badge badge-light ml-2">{{ $booking->dpTransaction->status_badge }}</span>
                        </h3>
                    </div>
                    <div class="card-body">
                        <p class="mb-1">
                            <small class="text-muted">Metode:</small><br>
                            <strong>{{ $booking->dpTransaction->method_label }}</strong>
                            @if($booking->dpTransaction->midtrans_payment_type)
                                <code class="ml-1">{{ $booking->dpTransaction->midtrans_payment_type }}</code>
                            @endif
                        </p>
                        <p class="mb-1">
                            <small class="text-muted">Nominal:</small><br>
                            <strong>{{ $booking->dpTransaction->formatted_amount }}</strong>
                        </p>
                        @if($booking->dpTransaction->payment_date)
                            <p class="mb-1">
                                <small class="text-muted">Tgl Bayar:</small><br>
                                {{ $booking->dpTransaction->payment_date->format('d M Y H:i') }}
                            </p>
                        @endif
                        <a href="{{ route('admin.transactions.show', $booking->dpTransaction) }}"
                           class="btn btn-info btn-sm btn-block mt-2">
                            <i class="fas fa-eye"></i> Detail Transaksi
                        </a>
                    </div>
                </div>
            @endif

            <!-- Transaksi Pelunasan -->
            @if($booking->pelunasanTransaction)
                <div class="card card-{{ $booking->pelunasanTransaction->status === 'verified' ? 'success' : 'warning' }} card-outline">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-receipt"></i> Transaksi Pelunasan
                            <span class="badge badge-light ml-2">{{ $booking->pelunasanTransaction->status_badge }}</span>
                        </h3>
                    </div>
                    <div class="card-body">
                        <p class="mb-1">
                            <small class="text-muted">Metode:</small><br>
                            <strong>{{ $booking->pelunasanTransaction->method_label }}</strong>
                        </p>
                        <p class="mb-1">
                            <small class="text-muted">Nominal:</small><br>
                            <strong>{{ $booking->pelunasanTransaction->formatted_amount }}</strong>
                        </p>
                        @if($booking->pelunasanTransaction->payment_date)
                            <p class="mb-1">
                                <small class="text-muted">Tgl Bayar:</small><br>
                                {{ $booking->pelunasanTransaction->payment_date->format('d M Y H:i') }}
                            </p>
                        @endif
                        @if($booking->pelunasanTransaction->verified_at)
                            <p class="mb-1">
                                <small class="text-muted">Diverifikasi oleh:</small><br>
                                {{ $booking->pelunasanTransaction->verifier?->name ?? '-' }}
                                <br><small>{{ $booking->pelunasanTransaction->verified_at->format('d M Y H:i') }}</small>
                            </p>
                        @endif
                        <a href="{{ route('admin.transactions.show', $booking->pelunasanTransaction) }}"
                           class="btn btn-{{ $booking->pelunasanTransaction->status === 'verified' ? 'success' : 'warning' }} btn-sm btn-block mt-2">
                            <i class="fas fa-eye"></i> Detail Transaksi
                        </a>
                    </div>
                </div>
            @elseif($booking->isDpPaid() && !$booking->isLunas())
                <div class="card card-warning card-outline card-outline-tabs">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fas fa-hourglass-half"></i> Menunggu Pelunasan</h3>
                    </div>
                    <div class="card-body">
                        <p>Customer belum upload bukti pelunasan.</p>
                        <p class="mb-0">
                            <small class="text-muted">
                                Sisa tagihan: <strong>{{ $booking->formatted_pelunasan_amount }}</strong>
                            </small>
                        </p>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection