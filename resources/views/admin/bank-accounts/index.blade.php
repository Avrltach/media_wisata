@extends('adminlte::page')

@section('title', 'Rekening Bank - Media Wisata Admin')

@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1><i class="fas fa-university text-danger"></i> Rekening Bank</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item active">Rekening Bank</li>
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
                        <i class="fas fa-list"></i> Daftar Rekening ({{ $bankAccounts->total() }})
                    </h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.bank-accounts.create') }}" class="btn btn-danger btn-sm">
                            <i class="fas fa-plus"></i> Tambah Rekening
                        </a>
                    </div>
                </div>
                <div class="card-body table-responsive p-0">
                    <table class="table table-striped table-valign-middle">
                        <thead>
                            <tr>
                                <th width="60">No</th>
                                <th width="80">Logo</th>
                                <th>Bank</th>
                                <th>No. Rekening</th>
                                <th>Pemilik</th>
                                <th width="100">Status</th>
                                <th width="120">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($bankAccounts as $index => $bank)
                                <tr>
                                    <td>{{ $bankAccounts->firstItem() + $index }}</td>
                                    <td>
                                        @if($bank->logo_path)
                                            <img src="{{ $bank->logo_url }}" alt="{{ $bank->bank_name }}"
                                                 style="width:40px;height:40px;object-fit:contain;">
                                        @else
                                            <div class="bg-light d-flex align-items-center justify-content-center"
                                                 style="width:40px;height:40px;font-weight:bold;color:#666;">
                                                {{ strtoupper(substr($bank->bank_name, 0, 2)) }}
                                            </div>
                                        @endif
                                    </td>
                                    <td><strong>{{ $bank->bank_name }}</strong></td>
                                    <td><code>{{ $bank->account_number }}</code></td>
                                    <td>{{ $bank->account_holder }}</td>
                                    <td>
                                        @if($bank->is_active)
                                            <span class="badge badge-success">Active</span>
                                        @else
                                            <span class="badge badge-secondary">Non-active</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.bank-accounts.edit', $bank) }}"
                                           class="btn btn-warning btn-sm" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.bank-accounts.destroy', $bank) }}"
                                              method="POST" style="display:inline;"
                                              onsubmit="return confirm('Hapus rekening ini?')">
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
                                        <i class="fas fa-inbox fa-2x mb-2"></i><br>
                                        Belum ada rekening bank.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="card-footer">
                    {{ $bankAccounts->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection