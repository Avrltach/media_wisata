@extends('adminlte::page')

@section('title', 'Edit Paket - Media Wisata Admin')

@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1><i class="fas fa-edit text-warning"></i> Edit Paket</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.packages.index') }}">Paket</a></li>
                    <li class="breadcrumb-item active">Edit</li>
                </ol>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <form action="{{ route('admin.packages.update', $package) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="row">
            <!-- Kolom kiri: Info utama -->
            <div class="col-md-8">
                <div class="card card-warning card-outline">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fas fa-info-circle"></i> Informasi Paket</h3>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="name">Nama Paket <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror"
                                   id="name" name="name" value="{{ old('name', $package->name) }}" required autofocus>
                            @error('name')<span class="invalid-feedback">{{ $message }}</span>@enderror
                            <small class="text-muted">Slug: <code>{{ $package->slug }}</code></small>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="category">Kategori <span class="text-danger">*</span></label>
                                    <select class="form-control" id="category" name="category" required>
                                        <option value="paket_wisata" @selected(old('category', $package->category) === 'paket_wisata')>Paket Wisata</option>
                                        <option value="event_organizer" @selected(old('category', $package->category) === 'event_organizer')>Event Organizer</option>
                                        <option value="sewa_transport" @selected(old('category', $package->category) === 'sewa_transport')>Sewa Transport</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="price">Harga per Pax (Rp) <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend"><span class="input-group-text">Rp</span></div>
                                        <input type="number" class="form-control" id="price" name="price"
                                               value="{{ old('price', $package->price) }}" required min="0">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="duration">Durasi <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="duration" name="duration"
                                           value="{{ old('duration', $package->duration) }}" required>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="location">Lokasi <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="location" name="location"
                                   value="{{ old('location', $package->location) }}" required>
                        </div>

                        <div class="form-group">
                            <label for="description">Deskripsi Paket</label>
                            <textarea class="form-control" id="description" name="description" rows="4">{{ old('description', $package->description) }}</textarea>
                        </div>

                        <div class="form-group">
                            <label for="itinerary">Itinerary <small class="text-muted">(1 aktivitas per baris)</small></label>
                            <textarea class="form-control" id="itinerary" name="itinerary" rows="5">{{ old('itinerary', $package->itinerary) }}</textarea>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="included_facilities">Fasilitas Termasuk</label>
                                    <textarea class="form-control" id="included_facilities" name="included_facilities" rows="5">{{ old('included_facilities', $package->included_facilities) }}</textarea>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="excluded_facilities">Fasilitas Tidak Termasuk</label>
                                    <textarea class="form-control" id="excluded_facilities" name="excluded_facilities" rows="5">{{ old('excluded_facilities', $package->excluded_facilities) }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Upload foto: main image -->
                <div class="card card-warning card-outline">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fas fa-image"></i> Foto Utama</h3>
                    </div>
                    <div class="card-body">
                        @if($package->main_image)
                            <div class="mb-2">
                                <label>Foto Saat Ini:</label><br>
                                <img src="{{ $package->main_image_url }}" alt="Main image"
                                     class="img-thumbnail" style="max-width:200px;">
                            </div>
                        @endif
                        <div class="form-group">
                            <label for="main_image">Ganti Foto Utama (opsional)</label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="main_image" name="main_image" accept="image/jpeg,image/png,image/jpg">
                                <label class="custom-file-label" for="main_image">Pilih file baru...</label>
                            </div>
                            <small class="text-muted">Kosongkan jika tidak ingin ganti. Format JPG/PNG, max 5MB</small>
                            <div id="main-preview" class="mt-2" style="display:none;">
                                <img src="" id="main-preview-img" class="img-thumbnail" style="max-width:200px;">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Galeri foto yang sudah ada + upload baru -->
                <div class="card card-warning card-outline">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-images"></i> Foto Galeri
                            <span class="badge badge-light ml-2">{{ $package->images->count() }} foto</span>
                        </h3>
                    </div>
                    <div class="card-body">
                        @if($package->images->isNotEmpty())
                            <label>Foto Galeri Saat Ini:</label>
                            <div class="row mb-3">
                                @foreach($package->images as $image)
                                    <div class="col-md-3 col-sm-4 col-6 mb-2">
                                        <div class="position-relative">
                                            <img src="{{ $image->image_url }}" alt="Gallery"
                                                 class="img-thumbnail" style="width:100%;height:120px;object-fit:cover;">
                                            <form action="{{ route('admin.packages.images.destroy', [$package, $image]) }}"
                                                  method="POST" style="position:absolute;top:5px;right:5px;"
                                                  onsubmit="return confirm('Hapus foto ini dari galeri paket?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm rounded-circle"
                                                        style="width:24px;height:24px;padding:0;font-size:10px;">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <hr>
                        @endif

                        <div class="form-group">
                            <label for="gallery_images">Tambah Foto Galeri Baru (opsional)</label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="gallery_images" name="gallery_images[]" accept="image/jpeg,image/png,image/jpg" multiple>
                                <label class="custom-file-label" for="gallery_images">Pilih beberapa file...</label>
                            </div>
                            <small class="text-muted">Bisa pilih banyak sekaligus</small>
                            <div id="gallery-preview" class="mt-2 row"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Kolom kanan: Pengaturan -->
            <div class="col-md-4">
                <div class="card card-warning card-outline">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fas fa-cog"></i> Pengaturan</h3>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="sort_order">Urutan Tampil</label>
                            <input type="number" class="form-control" id="sort_order" name="sort_order"
                                   value="{{ old('sort_order', $package->sort_order) }}" min="0">
                        </div>

                        <div class="form-group">
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input"
                                       id="is_featured" name="is_featured" value="1"
                                       {{ old('is_featured', $package->is_featured) ? 'checked' : '' }}>
                                <label class="custom-control-label" for="is_featured">
                                    <strong>Featured</strong>
                                    <small class="d-block text-muted">Tampil di halaman home</small>
                                </label>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input"
                                       id="is_active" name="is_active" value="1"
                                       {{ old('is_active', $package->is_active) ? 'checked' : '' }}>
                                <label class="custom-control-label" for="is_active">
                                    <strong>Active</strong>
                                    <small class="d-block text-muted">Paket tampil di website</small>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-warning btn-block">
                            <i class="fas fa-save"></i> Update Paket
                        </button>
                        <a href="{{ route('admin.packages.index') }}" class="btn btn-default btn-block mt-2">
                            <i class="fas fa-times"></i> Batal
                        </a>
                        <a href="{{ route('admin.packages.show', $package) }}" class="btn btn-info btn-block mt-2">
                            <i class="fas fa-eye"></i> Lihat Detail
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection

@push('js')
<script>
    document.querySelector('#main_image').addEventListener('change', function(e) {
        let fileName = e.target.files[0]?.name || 'Pilih file baru...';
        e.target.nextElementSibling.innerHTML = fileName;
        if (e.target.files[0]) {
            let reader = new FileReader();
            reader.onload = function(ev) {
                document.querySelector('#main-preview-img').src = ev.target.result;
                document.querySelector('#main-preview').style.display = 'block';
            };
            reader.readAsDataURL(e.target.files[0]);
        }
    });

    document.querySelector('#gallery_images').addEventListener('change', function(e) {
        let files = e.target.files;
        e.target.nextElementSibling.innerHTML = files.length + ' file dipilih';
        let previewContainer = document.querySelector('#gallery-preview');
        previewContainer.innerHTML = '';
        Array.from(files).forEach(file => {
            let reader = new FileReader();
            reader.onload = function(ev) {
                let col = document.createElement('div');
                col.className = 'col-4 mb-2';
                col.innerHTML = `<img src="${ev.target.result}" class="img-thumbnail" style="width:100%;height:80px;object-fit:cover;">`;
                previewContainer.appendChild(col);
            };
            reader.readAsDataURL(file);
        });
    });
</script>
@endpush