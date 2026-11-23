@extends('adminlte::page')

@section('title', 'Pesan Masuk - Media Wisata Admin')

@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1><i class="fas fa-envelope text-danger"></i> Pesan Masuk</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item active">Pesan Masuk</li>
                </ol>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <!-- Stat cards -->
    <div class="row mb-3">
        <div class="col-md-4 col-sm-4 col-12">
            <div class="small-box bg-danger p-3 rounded text-center text-white">
                <h4 class="mb-0">{{ $stats['total'] }}</h4>
                <small>Total Pesan</small>
            </div>
        </div>
        <div class="col-md-4 col-sm-4 col-12">
            <div class="small-box bg-warning p-3 rounded text-center text-white">
                <h4 class="mb-0">{{ $stats['unread'] }}</h4>
                <small>Belum Dibaca</small>
            </div>
        </div>
        <div class="col-md-4 col-sm-4 col-12">
            <div class="small-box bg-success p-3 rounded text-center text-white">
                <h4 class="mb-0">{{ $stats['read'] }}</h4>
                <small>Sudah Dibaca</small>
            </div>
        </div>
    </div>

    <!-- Tabel pesan -->
    <div class="row">
        <div class="col-12">
            <div class="card card-danger card-outline">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-inbox"></i> Daftar Pesan ({{ $contacts->total() }})
                    </h3>
                </div>
                <div class="card-body table-responsive p-0">
                    <table class="table table-striped table-valign-middle">
                        <thead>
                            <tr>
                                <th width="60">No</th>
                                <th width="50"></th>
                                <th>Pengirim</th>
                                <th>Subjek</th>
                                <th>Pesan</th>
                                <th width="130">Tanggal</th>
                                <th width="80">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($contacts as $index => $contact)
                                <tr class="{{ !$contact->is_read ? 'font-weight-bold bg-light' : '' }}">
                                    <td>{{ $contacts->firstItem() + $index }}</td>
                                    <td>
                                        @if(!$contact->is_read)
                                            <i class="fas fa-circle text-warning" title="Belum dibaca"></i>
                                        @else
                                            <i class="fas fa-check text-muted" title="Sudah dibaca"></i>
                                        @endif
                                    </td>
                                    <td>
                                        {{ $contact->name }}
                                        <br>
                                        <small class="text-muted">{{ $contact->email }}</small>
                                        @if($contact->phone)
                                            <br><small class="text-muted"><i class="fas fa-phone"></i> {{ $contact->phone }}</small>
                                        @endif
                                    </td>
                                    <td>{{ $contact->subject ?: '(tanpa subjek)' }}</td>
                                    <td>{{ Str::limit($contact->message, 80) }}</td>
                                    <td><small>{{ $contact->created_at->format('d M Y H:i') }}</small></td>
                                    <td>
                                        <a href="{{ route('admin.contacts.show', $contact) }}"
                                           class="btn btn-info btn-sm" title="Baca pesan">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <form action="{{ route('admin.contacts.destroy', $contact) }}"
                                              method="POST" style="display:inline;"
                                              onsubmit="return confirm('Hapus pesan ini?')">
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
                                        Belum ada pesan masuk.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="card-footer">
                    {{ $contacts->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection