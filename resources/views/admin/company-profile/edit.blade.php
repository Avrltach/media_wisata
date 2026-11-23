@extends('adminlte::page')

@section('title', 'Profil Perusahaan - Media Wisata Admin')

@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1><i class="fas fa-building text-danger"></i> Profil Perusahaan</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item active">Profil Perusahaan</li>
                </ol>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="callout callout-info">
        <h5><i class="fas fa-info-circle"></i> Tentang Halaman Ini</h5>
        <p class="mb-0">
            Profil perusahaan adalah data tunggal (singleton) yang menampilkan info Media Wisata di halaman publik customer.
            Perubahan di sini langsung tampil di website (Tentang Kami, Kontak, Footer, dll).
        </p>
    </div>

    <form action="{{ route('admin.company-profile.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="row">
            <!-- Kolom kiri: info utama -->
            <div class="col-md-8">
                <!-- Informasi dasar -->
                <div class="card card-danger card-outline">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fas fa-info-circle"></i> Informasi Dasar</h3>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="name">Nama Perusahaan <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror"
                                   id="name" name="name" value="{{ old('name', $profile->name) }}" required autofocus>
                            @error('name')<span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>

                        <div class="form-group">
                            <label for="description">Deskripsi Perusahaan</label>
                            <textarea class="form-control" id="description" name="description" rows="5">{{ old('description', $profile->description) }}</textarea>
                            <small class="text-muted">Tentang perusahaan — tampil di halaman "Tentang Kami"</small>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="founded_year">Tahun Berdiri</label>
                                    <input type="number" class="form-control" id="founded_year" name="founded_year"
                                           value="{{ old('founded_year', $profile->founded_year) }}"
                                           min="1900" max="{{ date('Y') }}"
                                           placeholder="2015">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="operating_hours">Jam Operasional</label>
                                    <input type="text" class="form-control" id="operating_hours" name="operating_hours"
                                           value="{{ old('operating_hours', $profile->operating_hours) }}"
                                           placeholder="Senin-Sabtu, 08:00 - 17:00 WIB">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Kontak -->
                <div class="card card-danger card-outline">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fas fa-address-book"></i> Kontak</h3>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="address">Alamat Lengkap</label>
                            <textarea class="form-control" id="address" name="address" rows="3">{{ old('address', $profile->address) }}</textarea>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="phone">Telepon</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                        </div>
                                        <input type="text" class="form-control" id="phone" name="phone"
                                               value="{{ old('phone', $profile->phone) }}"
                                               placeholder="0281-123456">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                        </div>
                                        <input type="email" class="form-control @error('email') is-invalid @enderror"
                                               id="email" name="email"
                                               value="{{ old('email', $profile->email) }}"
                                               placeholder="info@mediawisata.com">
                                        @error('email')<span class="invalid-feedback">{{ $message }}</span>@enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="whatsapp">Nomor WhatsApp</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fab fa-whatsapp"></i></span>
                                </div>
                                <input type="text" class="form-control" id="whatsapp" name="whatsapp"
                                       value="{{ old('whatsapp', $profile->whatsapp) }}"
                                       placeholder="6281234567890 (format internasional, tanpa +)">
                            </div>
                            <small class="text-muted">Format: 62 di depan, tanpa tanda + atau spasi</small>
                        </div>
                    </div>
                </div>

                <!-- Social Media -->
                <div class="card card-danger card-outline">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fas fa-share-alt"></i> Media Sosial</h3>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="instagram">Instagram URL</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fab fa-instagram"></i></span>
                                </div>
                                <input type="url" class="form-control @error('instagram') is-invalid @enderror"
                                       id="instagram" name="instagram"
                                       value="{{ old('instagram', $profile->instagram) }}"
                                       placeholder="https://instagram.com/mediawisata">
                                @error('instagram')<span class="invalid-feedback">{{ $message }}</span>@enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="facebook">Facebook URL</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fab fa-facebook"></i></span>
                                </div>
                                <input type="url" class="form-control @error('facebook') is-invalid @enderror"
                                       id="facebook" name="facebook"
                                       value="{{ old('facebook', $profile->facebook) }}"
                                       placeholder="https://facebook.com/mediawisata">
                                @error('facebook')<span class="invalid-feedback">{{ $message }}</span>@enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="tiktok">TikTok URL</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fab fa-tiktok"></i></span>
                                </div>
                                <input type="url" class="form-control @error('tiktok') is-invalid @enderror"
                                       id="tiktok" name="tiktok"
                                       value="{{ old('tiktok', $profile->tiktok) }}"
                                       placeholder="https://tiktok.com/@mediawisata">
                                @error('tiktok')<span class="invalid-feedback">{{ $message }}</span>@enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Google Maps -->
                <div class="card card-danger card-outline">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fas fa-map-marked-alt"></i> Google Maps Embed</h3>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="maps_embed">Kode Embed Google Maps</label>
                            <textarea class="form-control" id="maps_embed" name="maps_embed" rows="4">{{ old('maps_embed', $profile->maps_embed) }}</textarea>
                            <small class="text-muted">
                                Cara dapatkan: buka
                                <a href="https://www.google.com/maps" target="_blank">Google Maps</a> →
                                cari lokasi → klik "Share" → pilih "Embed a map" → copy iframe code → paste di sini.
                            </small>
                        </div>

                        @if($profile->maps_embed)
                            <hr>
                            <label>Preview Maps:</label>
                            <div class="embed-responsive embed-responsive-16by9">
                                {!! $profile->maps_embed !!}
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Kolom kanan: logo + save -->
            <div class="col-md-4">
                <!-- Logo -->
                <div class="card card-danger card-outline">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fas fa-image"></i> Logo Perusahaan</h3>
                    </div>
                    <div class="card-body text-center">
                        @if($profile->logo_path)
                            <img src="{{ $profile->logo_url }}" alt="Logo {{ $profile->name }}"
                                 class="img-thumbnail mb-3" style="max-height:150px;">
                        @else
                            <div class="bg-light d-flex align-items-center justify-content-center text-muted mb-3"
                                 style="height:150px;border-radius:4px;">
                                <div>
                                    <i class="fas fa-image fa-3x"></i><br>
                                    <small>Belum ada logo</small>
                                </div>
                            </div>
                        @endif

                        <div class="form-group text-left">
                            <label for="logo_path">Upload Logo Baru (opsional)</label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input @error('logo_path') is-invalid @enderror"
                                       id="logo_path" name="logo_path" accept="image/jpeg,image/png,image/jpg">
                                <label class="custom-file-label" for="logo_path">Pilih file...</label>
                            </div>
                            <small class="text-muted">Format JPG/PNG, max 2MB. Disarankan background transparan (PNG).</small>
                            @error('logo_path')<span class="invalid-feedback d-block">{{ $message }}</span>@enderror

                            <div id="logo-preview" class="mt-2" style="display:none;">
                                <img src="" id="logo-preview-img" class="img-thumbnail" style="max-height:120px;">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Info record -->
                <div class="card card-info card-outline">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fas fa-database"></i> Info Record</h3>
                    </div>
                    <div class="card-body">
                        <p class="mb-1">
                            <small class="text-muted">ID Record:</small><br>
                            <code>#{{ $profile->id }}</code> (singleton)
                        </p>
                        <p class="mb-1">
                            <small class="text-muted">Dibuat:</small><br>
                            {{ $profile->created_at->format('d M Y H:i') }}
                        </p>
                        <p class="mb-0">
                            <small class="text-muted">Update terakhir:</small><br>
                            {{ $profile->updated_at->format('d M Y H:i') }}
                        </p>
                    </div>
                </div>

                <!-- Save button -->
                <div class="card card-danger card-outline">
                    <div class="card-body">
                        <button type="submit" class="btn btn-danger btn-block">
                            <i class="fas fa-save"></i> Simpan Perubahan
                        </button>
                        <a href="{{ route('admin.company-profile.edit') }}" class="btn btn-default btn-block mt-2">
                            <i class="fas fa-undo"></i> Reset
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection

@push('js')
<script>
    document.querySelector('#logo_path').addEventListener('change', function(e) {
        let fileName = e.target.files[0]?.name || 'Pilih file...';
        e.target.nextElementSibling.innerHTML = fileName;
        if (e.target.files[0]) {
            let reader = new FileReader();
            reader.onload = function(ev) {
                document.querySelector('#logo-preview-img').src = ev.target.result;
                document.querySelector('#logo-preview').style.display = 'block';
            };
            reader.readAsDataURL(e.target.files[0]);
        }
    });
</script>
@endpush