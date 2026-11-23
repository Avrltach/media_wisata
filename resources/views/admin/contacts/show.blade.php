@extends('adminlte::page')

@section('title', 'Detail Pesan - Media Wisata Admin')

@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1><i class="fas fa-envelope-open text-danger"></i> Detail Pesan</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.contacts.index') }}">Pesan Masuk</a></li>
                    <li class="breadcrumb-item active">Detail</li>
                </ol>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-8">
            <!-- Isi pesan -->
            <div class="card card-info card-outline">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-paperclip"></i>
                        {{ $contact->subject ?: '(tanpa subjek)' }}
                    </h3>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <small class="text-muted">Pesan:</small>
                        <div class="p-3 bg-light rounded mt-1" style="white-space:pre-line;font-size:15px;">
{{ $contact->message }}
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick reply via WhatsApp -->
            <div class="card card-success card-outline">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-reply"></i> Balas Pesan</h3>
                </div>
                <div class="card-body">
                    <p class="mb-2">Balas pesan ini dengan cepat via:</p>
                    @if($contact->phone)
                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $contact->phone) }}"
                           target="_blank" class="btn btn-success">
                            <i class="fab fa-whatsapp"></i> WhatsApp ({{ $contact->phone }})
                        </a>
                    @endif
                    <a href="mailto:{{ $contact->email }}?subject=Re: {{ $contact->subject ?: 'Pesan dari Media Wisata' }}"
                       class="btn btn-info {{ $contact->phone ? 'ml-2' : '' }}">
                        <i class="fas fa-envelope"></i> Email
                    </a>
                </div>
            </div>
        </div>

        <!-- Kolom kanan: info pengirim + actions -->
        <div class="col-md-4">
            <div class="card card-info card-outline">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-user"></i> Info Pengirim</h3>
                </div>
                <div class="card-body">
                    <p class="mb-1">
                        <small class="text-muted">Nama:</small><br>
                        <strong>{{ $contact->name }}</strong>
                    </p>
                    <p class="mb-1">
                        <small class="text-muted">Email:</small><br>
                        <a href="mailto:{{ $contact->email }}">{{ $contact->email }}</a>
                    </p>
                    @if($contact->phone)
                        <p class="mb-1">
                            <small class="text-muted">Telepon:</small><br>
                            {{ $contact->phone }}
                        </p>
                    @endif
                    <p class="mb-1">
                        <small class="text-muted">Diterima:</small><br>
                        {{ $contact->created_at->format('d M Y H:i') }}
                    </p>
                    <p class="mb-0">
                        <small class="text-muted">Status:</small><br>
                        @if($contact->is_read)
                            <span class="badge badge-success">Sudah Dibaca</span>
                        @else
                            <span class="badge badge-warning">Belum Dibaca</span>
                        @endif
                    </p>
                </div>
                <div class="card-footer">
                    <form action="{{ route('admin.contacts.mark-unread', $contact) }}" method="POST"
                          onsubmit="return confirm('Tandai pesan ini sebagai belum dibaca?')">
                        @csrf
                        <button type="submit" class="btn btn-warning btn-block btn-sm">
                            <i class="fas fa-envelope"></i> Tandai Belum Dibaca
                        </button>
                    </form>
                    <form action="{{ route('admin.contacts.destroy', $contact) }}" method="POST"
                          onsubmit="return confirm('Hapus pesan ini permanen?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-block btn-sm mt-2">
                            <i class="fas fa-trash"></i> Hapus Pesan
                        </button>
                    </form>
                </div>
            </div>

            <a href="{{ route('admin.contacts.index') }}" class="btn btn-default btn-block">
                <i class="fas fa-arrow-left"></i> Kembali ke Daftar
            </a>
        </div>
    </div>
@endsection