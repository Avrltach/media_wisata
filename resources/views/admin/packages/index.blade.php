@extends('adminlte::page')

@section('title', 'Paket Wisata - Media Wisata Admin')

@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1><i class="fas fa-suitcase text-danger"></i> Paket Wisata</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item active">Paket Wisata</li>
                </ol>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <!-- Filter & Search -->
    <div class="row mb-3">
        <div class="col-12">
            <form method="GET" action="{{ route('admin.packages.index') }}" class="card card-outline card-danger">
                <div class="card-body">
                    <div class="row align-items-end">
                        <div class="col-md-4">
                            <label for="search">Cari</label>
                            <input type="text" class="form-control" id="search" name="search"
                                   value="{{ request('search') }}" placeholder="Nama paket / lokasi">
                        </div>
                        <div class="col-md-3">
                            <label for="category">Kategori</label>
                            <select class="form-control" id="category" name="category">
                                <option value="">Semua Kategori</option>
                                <option value="paket_wisata" @selected(request('category') === 'paket_wisata')>Paket Wisata</option>
                                <option value="event_organizer" @selected(request('category') === 'event_organizer')>Event Organizer</option>
                                <option value="sewa_transport" @selected(request('category') === 'sewa_transport')>Sewa Transport</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="status">Status</label>
                            <select class="form-control" id="status" name="status">
                                <option value="">Semua Status</option>
                                <option value="1" @selected(request('status') === '1')>Aktif</option>
                                <option value="0" @selected(request('status') === '0')>Non-aktif</option>
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

    <!-- Tabel paket -->
    <div class="row">
        <div class="col-12">
            <div class="card card-danger card-outline">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-list"></i> Daftar Paket ({{ $packages->total() }})
                    </h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.packages.create') }}" class="btn btn-danger btn-sm">
                            <i class="fas fa-plus"></i> Tambah Paket
                        </a>
                    </div>
                </div>
                <div class="card-body table-responsive p-0">
                    <table class="table table-striped table-valign-middle">
                        <thead>
                            <tr>
                                <th width="60">No</th>
                                <th width="80">Foto</th>
                                <th>Nama Paket</th>
                                <th width="130">Kategori</th>
                                <th width="120">Harga</th>
                                <th width="80">Durasi</th>
                                <th width="80">Status</th>
                                <th width="150">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($packages as $index => $package)
                                <tr>
                                    <td>{{ $packages->firstItem() + $index }}</td>
                                    <td>
                                        @if($package->main_image)
                                            <img src="{{ $package->main_image_url }}" alt="{{ $package->name }}"
                                                 style="width:60px;height:45px;object-fit:cover;border-radius:4px;">
                                        @else
                                            <div class="bg-light d-flex align-items-center justify-content-center text-muted"
                                                 style="width:60px;height:45px;border-radius:4px;">
                                                <i class="fas fa-image"></i>
                                            </div>
                                        @endif
                                    </td>
                                    <td>
                                        <strong>{{ $package->name }}</strong>
                                        <br>
                                        <small class="text-muted">
                                            <i class="fas fa-map-marker-alt"></i> {{ $package->location }}
                                        </small>
                                        @if($package->is_featured)
                                            <span class="badge badge-warning ml-1">
                                                <i class="fas fa-star"></i> Featured
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($package->category === 'paket_wisata')
                                            <span class="badge badge-primary">Paket Wisata</span>
                                        @elseif($package->category === 'event_organizer')
                                            <span class="badge badge-info">Event Organizer</span>
                                        @else
                                            <span class="badge badge-secondary">Sewa Transport</span>
                                        @endif
                                    </td>
                                    <td><strong>{{ $package->formatted_price }}</strong></td>
                                    <td>{{ $package->duration }}</td>
                                    <td>
                                        @if($package->is_active)
                                            <span class="badge badge-success">Active</span>
                                        @else
                                            <span class="badge badge-secondary">Non-active</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.packages.show', $package) }}"
                                           class="btn btn-info btn-sm" title="Lihat detail">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.packages.edit', $package) }}"
                                           class="btn btn-warning btn-sm" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.packages.destroy', $package) }}"
                                              method="POST" style="display:inline;"
                                              onsubmit="return confirm('Hapus paket ini? Semua foto juga akan dihapus.')">
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
                                    <td colspan="8" class="text-center text-muted py-4">
                                        <i class="fas fa-suitcase fa-2x mb-2"></i><br>
                                        Belum ada paket.
                                        <br>
                                        <a href="{{ route('admin.packages.create') }}" class="btn btn-danger btn-sm mt-2">
                                            <i class="fas fa-plus"></i> Tambah Paket Pertama
                                        </a>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="card-footer">
                    {{ $packages->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection