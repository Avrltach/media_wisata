@extends('adminlte::page')

@section('title', 'FAQ - Media Wisata Admin')

@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1><i class="fas fa-question-circle text-danger"></i> FAQ</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item active">FAQ</li>
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
                        <i class="fas fa-list"></i> Daftar FAQ ({{ $faqs->total() }})
                    </h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.faqs.create') }}" class="btn btn-danger btn-sm">
                            <i class="fas fa-plus"></i> Tambah FAQ
                        </a>
                    </div>
                </div>
                <div class="card-body table-responsive p-0">
                    <table class="table table-striped table-valign-middle">
                        <thead>
                            <tr>
                                <th width="60">No</th>
                                <th>Pertanyaan</th>
                                <th width="150">Kategori</th>
                                <th width="80">Urutan</th>
                                <th width="100">Status</th>
                                <th width="120">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($faqs as $index => $faq)
                                <tr>
                                    <td>{{ $faqs->firstItem() + $index }}</td>
                                    <td>
                                        <strong>{{ Str::limit($faq->question, 80) }}</strong>
                                        <br>
                                        <small class="text-muted">{{ Str::limit($faq->answer, 100) }}</small>
                                    </td>
                                    <td>
                                        @if($faq->category)
                                            <span class="badge badge-info">{{ $faq->category }}</span>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>{{ $faq->sort_order }}</td>
                                    <td>
                                        @if($faq->is_published)
                                            <span class="badge badge-success">Published</span>
                                        @else
                                            <span class="badge badge-secondary">Draft</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.faqs.edit', $faq) }}"
                                           class="btn btn-warning btn-sm"
                                           title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.faqs.destroy', $faq) }}"
                                              method="POST"
                                              style="display:inline;"
                                              onsubmit="return confirm('Hapus FAQ ini?')">
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
                                    <td colspan="6" class="text-center text-muted py-4">
                                        <i class="fas fa-inbox fa-2x mb-2"></i><br>
                                        Belum ada FAQ. Klik tombol "Tambah FAQ" untuk membuat.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="card-footer">
                    {{ $faqs->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection