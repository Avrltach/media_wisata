@extends('adminlte::page')

@section('title', 'Detail Testimoni - Media Wisata Admin')

@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1><i class="fas fa-comment text-danger"></i> Detail Testimoni</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.testimonials.index') }}">Testimoni</a></li>
                    <li class="breadcrumb-item active">Detail</li>
                </ol>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <!-- Alert action -->
    @if(!$testimonial->is_approved)
        <div class="alert alert-warning">
            <i class="fas fa-exclamation-triangle"></i>
            <strong>Testimoni ini menunggu approval Anda.</strong>
            <br>
            Periksa konten testimoni, lalu klik <strong>Approve</strong> untuk menampilkan di website atau <strong>Reject</strong> untuk menyembunyikan.
        </div>
    @endif

    <div class="row">
        <!-- Kolom kiri: isi testimoni -->
        <div class="col-md-8">
            <div class="card card-info card-outline">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-quote-left"></i> Isi Testimoni</h3>
                </div>
                <div class="card-body">
                    <div class="text-center mb-3">
                        <span style="font-size:24px;color:#FFD700;">{{ $testimonial->stars }}</span>
                        <br>
                        <small class="text-muted">{{ $testimonial->rating }} dari 5 bintang</small>
                    </div>
                    <blockquote class="blockquote">
                        <p class="mb-0" style="white-space:pre-line;font-size:16px;">"{{ $testimonial->message }}"</p>
                        <footer class="blockquote-footer mt-2">
                            <cite>{{ $testimonial->name }}</cite>
                        </footer>
                    </blockquote>
                </div>
            </div>

            <!-- Booking terkait (jika ada) -->
            @if($testimonial->booking)
                <div class="card card-info card-outline">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fas fa-link"></i> Pesanan Terkait</h3>
                    </div>
                    <div class="card-body">
                        <p class="mb-1">
                            <small class="text-muted">Kode Booking:</small><br>
                            <strong>{{ $testimonial->booking->booking_code }}</strong>
                        </p>
                        <p class="mb-1">
                            <small class="text-muted">Paket:</small><br>
                            {{ $testimonial->booking->package?->name ?? '-' }}
                        </p>
                        <p class="mb-1">
                            <small class="text-muted">Tanggal Berangkat:</small><br>
                            {{ $testimonial->booking->departure_date->format('d M Y') }}
                        </p>
                    </div>
                    <div class="card-footer">
                        <a href="{{ route('admin.bookings.show', $testimonial->booking) }}"
                           class="btn btn-info btn-sm btn-block">
                            <i class="fas fa-eye"></i> Lihat Detail Pesanan
                        </a>
                    </div>
                </div>
            @endif
        </div>

        <!-- Kolom kanan: info + actions -->
        <div class="col-md-4">
            <div class="card card-info card-outline">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-info-circle"></i> Info Penulis</h3>
                </div>
                <div class="card-body">
                    <p class="mb-1">
                        <small class="text-muted">Nama:</small><br>
                        <strong>{{ $testimonial->name }}</strong>
                    </p>
                    @if($testimonial->user)
                        <p class="mb-1">
                            <small class="text-muted">Akun:</small><br>
                            {{ $testimonial->user->email }}
                        </p>
                    @endif
                    <p class="mb-1">
                        <small class="text-muted">Status:</small><br>
                        @if($testimonial->is_approved)
                            <span class="badge badge-success">Approved</span>
                        @else
                            <span class="badge badge-warning">Pending</span>
                        @endif
                    </p>
                    <p class="mb-1">
                        <small class="text-muted">Dikirim:</small><br>
                        {{ $testimonial->created_at->format('d M Y H:i') }}
                    </p>
                </div>
            </div>

            <!-- Action buttons -->
            <div class="card card-success card-outline">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-gavel"></i> Aksi Moderasi</h3>
                </div>
                <div class="card-body">
                    @if(!$testimonial->is_approved)
                        <form action="{{ route('admin.testimonials.approve', $testimonial) }}" method="POST"
                              onsubmit="return confirm('Approve testimoni ini? Akan tampil di website.')">
                            @csrf
                            <button type="submit" class="btn btn-success btn-block">
                                <i class="fas fa-check-circle"></i> Approve Testimoni
                            </button>
                        </form>
                    @else
                        <form action="{{ route('admin.testimonials.reject', $testimonial) }}" method="POST"
                              onsubmit="return confirm('Reject testimoni ini? Akan disembunyikan dari website.')">
                            @csrf
                            <button type="submit" class="btn btn-warning btn-block">
                                <i class="fas fa-times-circle"></i> Unapprove (Sembunyikan)
                            </button>
                        </form>
                    @endif

                    <form action="{{ route('admin.testimonials.destroy', $testimonial) }}" method="POST"
                          onsubmit="return confirm('Hapus permanen testimoni ini? Tindakan tidak dapat dibatalkan.')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-block mt-2">
                            <i class="fas fa-trash"></i> Hapus Permanen
                        </button>
                    </form>
                </div>
            </div>

            <a href="{{ route('admin.testimonials.index') }}" class="btn btn-default btn-block">
                <i class="fas fa-arrow-left"></i> Kembali ke Daftar
            </a>
        </div>
    </div>
@endsection