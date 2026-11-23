@extends('adminlte::page')

@section('title', 'Tambah Rekening - Media Wisata Admin')

@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1><i class="fas fa-plus text-danger"></i> Tambah Rekening Bank</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.bank-accounts.index') }}">Rekening Bank</a></li>
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
                    <h3 class="card-title"><i class="fas fa-pen"></i> Form Tambah Rekening</h3>
                </div>
                <form action="{{ route('admin.bank-accounts.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label for="bank_name">Nama Bank <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('bank_name') is-invalid @enderror"
                                   id="bank_name" name="bank_name"
                                   value="{{ old('bank_name') }}" required autofocus
                                   placeholder="mis: BCA, Mandiri, BNI, BRI">
                            @error('bank_name')<span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>

                        <div class="form-group">
                            <label for="account_number">Nomor Rekening <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('account_number') is-invalid @enderror"
                                   id="account_number" name="account_number"
                                   value="{{ old('account_number') }}" required
                                   placeholder="1234567890">
                            @error('account_number')<span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>

                        <div class="form-group">
                            <label for="account_holder">Atas Nama <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('account_holder') is-invalid @enderror"
                                   id="account_holder" name="account_holder"
                                   value="{{ old('account_holder') }}" required
                                   placeholder="MEDIA WISATA">
                            @error('account_holder')<span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>

                        <div class="form-group">
                            <label for="logo_path">Logo Bank (opsional)</label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input @error('logo_path') is-invalid @enderror"
                                       id="logo_path" name="logo_path" accept="image/jpeg,image/png,image/jpg">
                                <label class="custom-file-label" for="logo_path">Pilih file...</label>
                            </div>
                            <small class="text-muted">Format: JPG/PNG, max 2MB</small>
                            @error('logo_path')<span class="invalid-feedback d-block">{{ $message }}</span>@enderror
                        </div>

                        <div class="form-group">
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input"
                                       id="is_active" name="is_active" value="1" checked>
                                <label class="custom-control-label" for="is_active">Active (tampil di halaman customer)</label>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-save"></i> Simpan
                        </button>
                        <a href="{{ route('admin.bank-accounts.index') }}" class="btn btn-default">
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
    // Show selected filename in custom-file-input
    document.querySelector('#logo_path').addEventListener('change', function(e) {
        let fileName = e.target.files[0]?.name || 'Pilih file...';
        let label = e.target.nextElementSibling;
        label.innerHTML = fileName;
    });
</script>
@endpush