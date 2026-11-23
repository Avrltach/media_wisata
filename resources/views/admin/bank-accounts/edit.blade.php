@extends('adminlte::page')

@section('title', 'Edit Rekening - Media Wisata Admin')

@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1><i class="fas fa-edit text-warning"></i> Edit Rekening Bank</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.bank-accounts.index') }}">Rekening Bank</a></li>
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
                    <h3 class="card-title"><i class="fas fa-pen"></i> Form Edit Rekening</h3>
                </div>
                <form action="{{ route('admin.bank-accounts.update', $bankAccount) }}"
                      method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        <div class="form-group">
                            <label for="bank_name">Nama Bank <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('bank_name') is-invalid @enderror"
                                   id="bank_name" name="bank_name"
                                   value="{{ old('bank_name', $bankAccount->bank_name) }}" required autofocus>
                            @error('bank_name')<span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>

                        <div class="form-group">
                            <label for="account_number">Nomor Rekening <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('account_number') is-invalid @enderror"
                                   id="account_number" name="account_number"
                                   value="{{ old('account_number', $bankAccount->account_number) }}" required>
                            @error('account_number')<span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>

                        <div class="form-group">
                            <label for="account_holder">Atas Nama <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('account_holder') is-invalid @enderror"
                                   id="account_holder" name="account_holder"
                                   value="{{ old('account_holder', $bankAccount->account_holder) }}" required>
                            @error('account_holder')<span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>

                        @if($bankAccount->logo_path)
                            <div class="form-group">
                                <label>Logo Saat Ini</label><br>
                                <img src="{{ $bankAccount->logo_url }}" alt="Logo {{ $bankAccount->bank_name }}"
                                     style="max-width:120px;max-height:80px;object-fit:contain;border:1px solid #ddd;padding:4px;border-radius:4px;">
                            </div>
                        @endif

                        <div class="form-group">
                            <label for="logo_path">Ganti Logo (opsional)</label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input @error('logo_path') is-invalid @enderror"
                                       id="logo_path" name="logo_path" accept="image/jpeg,image/png,image/jpg">
                                <label class="custom-file-label" for="logo_path">Pilih file baru...</label>
                            </div>
                            <small class="text-muted">Kosongkan jika tidak ingin ganti logo. Format JPG/PNG, max 2MB</small>
                            @error('logo_path')<span class="invalid-feedback d-block">{{ $message }}</span>@enderror
                        </div>

                        <div class="form-group">
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input"
                                       id="is_active" name="is_active" value="1"
                                       {{ old('is_active', $bankAccount->is_active) ? 'checked' : '' }}>
                                <label class="custom-control-label" for="is_active">Active</label>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-warning">
                            <i class="fas fa-save"></i> Update
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
    document.querySelector('#logo_path').addEventListener('change', function(e) {
        let fileName = e.target.files[0]?.name || 'Pilih file baru...';
        e.target.nextElementSibling.innerHTML = fileName;
    });
</script>
@endpush