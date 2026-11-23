@extends('adminlte::page')

@section('title', 'Testimoni - Media Wisata Admin')

@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1><i class="fas fa-comments text-danger"></i> Testimoni</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item active">Testimoni</li>
                </ol>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <!-- Stat cards -->
    <div class="row mb-3">
        <div class="col-md-4 col-sm-4 col-12">
            <a href="{{ route('admin.testimonials.index') }}" class="small-box bg-danger p-3 rounded text-center text-white d-block">
                <h4 class="mb-0">{{ $stats['total'] }}</h4>
                <small>Total Testimoni</small>
            </a>
        </div>
        <div class="col-md-4 col-sm-4 col-12">
            <a href="{{ route('admin.testimonials.index', ['status' => 'pending']) }}" class="small-box bg-warning p-3 rounded text-center text-white d-block">
                <h4 class="mb-0">{{ $stats['pending'] }}</h4>
                <small>Menunggu Approval</small>
            </a>
        </div>
        <div class="col-md-4 col-sm-4 col-12">
            <a href="{{ route('admin.testimonials.index', ['status' => 'approved']) }}" class="small-box bg-success p-3 rounded text-center text-white d-block">
                <h4 class="mb-0">{{ $stats['approved'] }}</h4>
                <small>Approved</small>
            </a>
        </div>
    </div>

    <!-- Filter -->
    <div class="row mb-3">
        <div class="col-12">
            <form method="GET" action="{{ route('admin.testimonials.index') }}" class="card card-outline card-danger">
                <div class="card-body">
                    <div class="row align-items-end">
                        <div class="col-md-6">
                            <label for="search">Cari</label>
                            <input type="text" class="form-control" id="search" name="search"
                                   value="{{ request('search') }}"
                                   placeholder="Nama atau isi testimoni">
                        </div>
                        <div class="col-md-3">
                            <label for="status">Status</label>
                            <select class="form-control" id="status" name="status">
                                <option value="">Semua</option>
                                <option value="pending" @selected(request('status') === 'pending')>Pending</option>
                                <option value="approved" @selected(request('status') === 'approved')>Approved</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="rating">Rating Minimal</label>
                            <select class="form-control" id="rating" name="rating">
                                <option value="">Semua Rating</option>
                                <option value="5" @selected(request('rating') === '5')>5 bintang</option>
                                <option value="4" @selected(request('rating') === '4')>4+ bintang</option>
                                <option value="3" @selected(request('rating') === '3')>3+ bintang</option>
                                <option value="2" @selected(request('rating') === '2')>2+ bintang</option>
                                <option value="1" @selected(request('rating') === '1')>1+ bintang</option>
                            </select>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Tabel testimoni -->
    <div class="row">
        <div class="col-12">
            <div class="card card-danger card-outline">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-list"></i> Daftar Testimoni ({{ $testimonials->total() }})
                    </h3>
                </div>
                <div class="card-body table-responsive p-0">
                    <table class="table table-striped table-valign-middle">
                        <thead>
                            <tr>
                                <th width="60">No</th>
                                <th>Nama</th>
                                <th>Testimoni</th>
                                <th width="120">Rating</th>
                                <th width="100">Status</th>
                                <th width="120">Tanggal</th>
                                <th width="80">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($testimonials as $index => $testimonial)
                                <tr>
                                    <td>{{ $testimonials->firstItem() + $index }}</td>
                                    <td>
                                        <strong>{{ $testimonial->name }}</strong>
                                        @if($testimonial->booking)
                                            <br><small class="text-muted">{{ $testimonial->booking->booking_code }}</small>
                                        @endif
                                    </td>
                                    <td>{{ Str::limit($testimonial->message, 80) }}</td>
                                    <td>
                                        <span class="text-warning">{{ $testimonial->stars }}</span>
                                        <small>({{ $testimonial->rating }}/5)</small>
                                    </td>
                                    <td>
                                        @if($testimonial->is_approved)
                                            <span class="badge badge-success">Approved</span>
                                        @else
                                            <span class="badge badge-warning">Pending</span>
                                        @endif
                                    </td>
                                    <td><small>{{ $testimonial->created_at->format('d M Y') }}</small></td>
                                    <td>
                                        <a href="{{ route('admin.testimonials.show', $testimonial) }}"
                                           class="btn btn-info btn-sm" title="Lihat detail">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <form action="{{ route('admin.testimonials.destroy', $testimonial) }}"
                                              method="POST" style="display:inline;"
                                              onsubmit="return confirm('Hapus testimoni ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" title="Hapus">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center text-muted py-4">
                                        <i class="fas fa-comments fa-2x mb-2"></i><br>
                                        Belum ada testimoni.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="card-footer">
                    {{ $testimonials->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection