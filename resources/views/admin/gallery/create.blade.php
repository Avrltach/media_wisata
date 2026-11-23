@extends('adminlte::page')

@section('title', 'Tambah Foto - Media Wisata Admin')

@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1><i class="fas fa-plus text-danger"></i> Tambah Foto Galeri</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.gallery.index') }}">Galeri</a></li>
                    <li class="breadcrumb-item active">Tambah</li>
                </ol>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-8">
            <div class="card card-danger card-outline">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-pen"></i> Form Tambah Foto</h3>
                </div>
                <form action="{{ route('admin.gallery.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label for="title">Judul Foto <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror"
                                   id="title" name="title" value="{{ old('title') }}" required autofocus
                                   placeholder="mis: Trip Bromo 2025">
                            @error('title')<span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>

                        <div class="form-group">
                            <label for="description">Deskripsi (opsional)</label>
                            <textarea class="form-control" id="description" name="description" rows="3">{{ old('description') }}</textarea>
                        </div>

                        <div class="form-group">
                            <label for="image_path">Foto <span class="text-danger">*</span></label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input @error('image_path') is-invalid @enderror"
                                       id="image_path" name="image_path" accept="image/jpeg,image/png,image/jpg" required>
                                <label class="custom-file-label" for="image_path">Pilih file...</label>
                            </div>
                            <small class="text-muted">Format: JPG/PNG, max 5MB. Disarankan ukuran 1200x800 px</small>
                            @error('image_path')<span class="invalid-feedback d-block">{{ $message }}</span>@enderror

                            <div id="image-preview" class="mt-2" style="display:none;">
                                <img src="" id="preview-img" class="img-thumbnail" style="max-width:300px;">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="category">Kategori (opsional)</label>
                            <select class="form-control" id="category" name="category">
                                <option value="">- Pilih kategori -</option>
                                <option value="tour" @selected(old('category') === 'tour')>Tour / Paket Wisata</option>
                                <option value="event" @selected(old('category') === 'event')>Event Organizer</option>
                                <option value="transport" @selected(old('category') === 'transport')>Sewa Transport</option>
                                <option value="testimoni" @selected(old('category') === 'testimoni')>Testimoni Customer</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input"
                                       id="is_published" name="is_published" value="1" checked>
                                <label class="custom-control-label" for="is_published">Publish (tampil di website)</label>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-save"></i> Upload Foto
                        </button>
                        <a href="{{ route('admin.gallery.index') }}" class="btn btn-default">
                            <i class="fas fa-times"></i> Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('js')
<script>
    // Preview image sebelum upload
    document.querySelector('#image_path').addEventListener('change', function(e) {
        let fileName = e.target.files[0]?.name || 'Pilih file...';
        e.target.nextElementSibling.innerHTML = fileName;

        if (e.target.files[0]) {
            let reader = new FileReader();
            reader.onload = function(ev) {
                document.querySelector('#preview-img').src = ev.target.result;
                document.querySelector('#image-preview').style.display = 'block';
            };
            reader.readAsDataURL(e.target.files[0]);
        }
    });
</script>
@endpush