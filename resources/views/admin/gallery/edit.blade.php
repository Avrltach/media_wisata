@extends('adminlte::page')

@section('title', 'Edit Foto - Media Wisata Admin')

@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1><i class="fas fa-edit text-warning"></i> Edit Foto Galeri</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.gallery.index') }}">Galeri</a></li>
                    <li class="breadcrumb-item active">Edit</li>
                </ol>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-8">
            <div class="card card-warning card-outline">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-pen"></i> Form Edit Foto</h3>
                </div>
                <form action="{{ route('admin.gallery.update', $gallery) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        <!-- Foto saat ini -->
                        <div class="form-group">
                            <label>Foto Saat Ini</label><br>
                            <img src="{{ $gallery->image_url }}" alt="{{ $gallery->title }}"
                                 class="img-thumbnail" style="max-width:300px;">
                        </div>

                        <div class="form-group">
                            <label for="title">Judul Foto <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror"
                                   id="title" name="title"
                                   value="{{ old('title', $gallery->title) }}" required autofocus>
                            @error('title')<span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>

                        <div class="form-group">
                            <label for="description">Deskripsi (opsional)</label>
                            <textarea class="form-control" id="description" name="description" rows="3">{{ old('description', $gallery->description) }}</textarea>
                        </div>

                        <div class="form-group">
                            <label for="image_path">Ganti Foto (opsional)</label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input @error('image_path') is-invalid @enderror"
                                       id="image_path" name="image_path" accept="image/jpeg,image/png,image/jpg">
                                <label class="custom-file-label" for="image_path">Pilih file baru...</label>
                            </div>
                            <small class="text-muted">Kosongkan jika tidak ingin ganti foto. Format JPG/PNG, max 5MB</small>
                            @error('image_path')<span class="invalid-feedback d-block">{{ $message }}</span>@enderror

                            <div id="image-preview" class="mt-2" style="display:none;">
                                <img src="" id="preview-img" class="img-thumbnail" style="max-width:300px;">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="category">Kategori</label>
                            <select class="form-control" id="category" name="category">
                                <option value="">- Pilih kategori -</option>
                                <option value="tour" @selected(old('category', $gallery->category) === 'tour')>Tour / Paket Wisata</option>
                                <option value="event" @selected(old('category', $gallery->category) === 'event')>Event Organizer</option>
                                <option value="transport" @selected(old('category', $gallery->category) === 'transport')>Sewa Transport</option>
                                <option value="testimoni" @selected(old('category', $gallery->category) === 'testimoni')>Testimoni Customer</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input"
                                       id="is_published" name="is_published" value="1"
                                       {{ old('is_published', $gallery->is_published) ? 'checked' : '' }}>
                                <label class="custom-control-label" for="is_published">Publish</label>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-warning">
                            <i class="fas fa-save"></i> Update Foto
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
    document.querySelector('#image_path').addEventListener('change', function(e) {
        let fileName = e.target.files[0]?.name || 'Pilih file baru...';
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