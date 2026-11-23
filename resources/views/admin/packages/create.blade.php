@extends('adminlte::page')

@section('title', 'Tambah Paket - Media Wisata Admin')

@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1><i class="fas fa-plus text-danger"></i> Tambah Paket Wisata</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.packages.index') }}">Paket</a></li>
                    <li class="breadcrumb-item active">Tambah</li>
                </ol>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <form action="{{ route('admin.packages.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <!-- Kolom kiri: Info utama -->
            <div class="col-md-8">
                <div class="card card-danger card-outline">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fas fa-info-circle"></i> Informasi Paket</h3>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="name">Nama Paket <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror"
                                   id="name" name="name" value="{{ old('name') }}" required autofocus
                                   placeholder="mis: Paket Wisata Bromo Midnight 3D2N">
                            @error('name')<span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="category">Kategori <span class="text-danger">*</span></label>
                                    <select class="form-control @error('category') is-invalid @enderror"
                                            id="category" name="category" required>
                                        <option value="">- Pilih -</option>
                                        <option value="paket_wisata" @selected(old('category') === 'paket_wisata')>Paket Wisata</option>
                                        <option value="event_organizer" @selected(old('category') === 'event_organizer')>Event Organizer</option>
                                        <option value="sewa_transport" @selected(old('category') === 'sewa_transport')>Sewa Transport</option>
                                    </select>
                                    @error('category')<span class="invalid-feedback">{{ $message }}</span>@enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="price">Harga per Pax (Rp) <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Rp</span>
                                        </div>
                                        <input type="number" class="form-control @error('price') is-invalid @enderror"
                                               id="price" name="price" value="{{ old('price') }}" required min="0"
                                               placeholder="1500000">
                                    </div>
                                    @error('price')<span class="invalid-feedback">{{ $message }}</span>@enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="duration">Durasi <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('duration') is-invalid @enderror"
                                           id="duration" name="duration" value="{{ old('duration') }}" required
                                           placeholder="mis: 3D2N, 1 Day, 5 Hours">
                                    @error('duration')<span class="invalid-feedback">{{ $message }}</span>@enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="location">Lokasi <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('location') is-invalid @enderror"
                                   id="location" name="location" value="{{ old('location') }}" required
                                   placeholder="mis: Gunung Bromo, Jawa Timur">
                            @error('location')<span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>

                        <div class="form-group">
                            <label for="description">Deskripsi Paket</label>
                            <textarea class="form-control" id="description" name="description" rows="4">{{ old('description') }}</textarea>
                        </div>

                        <div class="form-group">
                            <label for="itinerary">Itinerary <small class="text-muted">(1 aktivitas per baris)</small></label>
                            <textarea class="form-control" id="itinerary" name="itinerary" rows="5">{{ old('itinerary') }}</textarea>
                            <small class="text-muted">Contoh: "Hari 1: Pickup Jakarta - Bromo"</small>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="included_facilities">Fasilitas Termasuk <small class="text-muted">(1 per baris)</small></label>
                                    <textarea class="form-control" id="included_facilities" name="included_facilities" rows="5">{{ old('included_facilities') }}</textarea>
                                    <small class="text-muted">Contoh: "Transport AC", "Makan 3x"</small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="excluded_facilities">Fasilitas Tidak Termasuk <small class="text-muted">(1 per baris)</small></label>
                                    <textarea class="form-control" id="excluded_facilities" name="excluded_facilities" rows="5">{{ old('excluded_facilities') }}</textarea>
                                    <small class="text-muted">Contoh: "Tiket pesawat", "Asuransi"</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Upload foto -->
                <div class="card card-danger card-outline">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fas fa-images"></i> Foto Paket</h3>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="main_image">Foto Utama <small class="text-muted">(thumbnail)</small></label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input @error('main_image') is-invalid @enderror"
                                       id="main_image" name="main_image" accept="image/jpeg,image/png,image/jpg">
                                <label class="custom-file-label" for="main_image">Pilih file...</label>
                            </div>
                            <small class="text-muted">Format JPG/PNG, max 5MB. Disarankan 1200x800 px</small>
                            @error('main_image')<span class="invalid-feedback d-block">{{ $message }}</span>@enderror
                            <div id="main-preview" class="mt-2" style="display:none;">
                                <img src="" id="main-preview-img" class="img-thumbnail" style="max-width:200px;">
                            </div>
                        </div>

                        <hr>

                        <div class="form-group">
                            <label>Foto Galeri Tambahan <small class="text-muted">(boleh lebih dari 1)</small></label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input @error('gallery_images') is-invalid @enderror"
                                       id="gallery_images" name="gallery_images[]" accept="image/jpeg,image/png,image/jpg" multiple>
                                <label class="custom-file-label" for="gallery_images">Pilih beberapa file...</label>
                            </div>
                            <small class="text-muted">Format JPG/PNG, max 5MB per file. Bisa pilih banyak sekaligus.</small>
                            @error('gallery_images')<span class="invalid-feedback d-block">{{ $message }}</span>@enderror
                            <div id="gallery-preview" class="mt-2 row"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Kolom kanan: Pengaturan -->
            <div class="col-md-4">
                <div class="card card-danger card-outline">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fas fa-cog"></i> Pengaturan</h3>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="sort_order">Urutan Tampil</label>
                            <input type="number" class="form-control" id="sort_order" name="sort_order"
                                   value="{{ old('sort_order', 0) }}" min="0">
                            <small class="text-muted">Angka kecil tampil lebih dulu</small>
                        </div>

                        <div class="form-group">
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input"
                                       id="is_featured" name="is_featured" value="1"
                                       {{ old('is_featured') ? 'checked' : '' }}>
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
                                       {{ old('is_active', true) ? 'checked' : '' }}>
                                <label class="custom-control-label" for="is_active">
                                    <strong>Active</strong>
                                    <small class="d-block text-muted">Paket tampil di website customer</small>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-danger btn-block">
                            <i class="fas fa-save"></i> Simpan Paket
                        </button>
                        <a href="{{ route('admin.packages.index') }}" class="btn btn-default btn-block mt-2">
                            <i class="fas fa-times"></i> Batal
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection

@push('js')
<script>
    // Preview main image
    document.querySelector('#main_image').addEventListener('change', function(e) {
        let fileName = e.target.files[0]?.name || 'Pilih file...';
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

    // Preview multiple gallery images
    document.querySelector('#gallery_images').addEventListener('change', function(e) {
        let files = e.target.files;
        let label = e.target.nextElementSibling;
        label.innerHTML = files.length + ' file dipilih';

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