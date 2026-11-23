@extends('adminlte::page')

@section('title', 'Galeri - Media Wisata Admin')

@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1><i class="fas fa-images text-danger"></i> Galeri Foto</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item active">Galeri</li>
                </ol>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card card-danger card-outline">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-list"></i> Daftar Foto ({{ $galleries->total() }})
                    </h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.gallery.create') }}" class="btn btn-danger btn-sm">
                            <i class="fas fa-plus"></i> Tambah Foto
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        @forelse($galleries as $gallery)
                            <div class="col-md-3 col-sm-4 col-6 mb-3">
                                <div class="card card-outline card-{{ $gallery->is_published ? 'success' : 'secondary' }}">
                                    <img src="{{ $gallery->image_url }}" class="card-img-top"
                                         alt="{{ $gallery->title }}"
                                         style="height:180px;object-fit:cover;">
                                    <div class="card-body p-2">
                                        <h6 class="card-title mb-1" style="font-size:14px;line-height:1.3;">
                                            {{ Str::limit($gallery->title, 40) }}
                                        </h6>
                                        <p class="card-text small text-muted mb-1">
                                            @if($gallery->category)
                                                <span class="badge badge-info">{{ $gallery->category }}</span>
                                            @endif
                                            @if($gallery->is_published)
                                                <span class="badge badge-success">Published</span>
                                            @else
                                                <span class="badge badge-secondary">Draft</span>
                                            @endif
                                        </p>
                                        <div class="btn-group btn-group-sm mt-1 w-100">
                                            <a href="{{ route('admin.gallery.edit', $gallery) }}"
                                               class="btn btn-warning" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('admin.gallery.destroy', $gallery) }}"
                                                  method="POST"
                                                  onsubmit="return confirm('Hapus foto ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger" title="Hapus">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-12 text-center text-muted py-5">
                                <i class="fas fa-images fa-3x mb-3"></i><br>
                                <h5>Belum ada foto galeri</h5>
                                <p>Klik tombol "Tambah Foto" untuk menambah foto pertama</p>
                            </div>
                        @endforelse
                    </div>
                </div>
                <div class="card-footer">
                    {{ $galleries->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection