@extends('adminlte::page')

@section('title', 'Edit FAQ - Media Wisata Admin')

@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1><i class="fas fa-edit text-warning"></i> Edit FAQ</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.faqs.index') }}">FAQ</a></li>
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
                    <h3 class="card-title"><i class="fas fa-pen"></i> Form Edit FAQ</h3>
                </div>
                <form action="{{ route('admin.faqs.update', $faq) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        <div class="form-group">
                            <label for="question">Pertanyaan <span class="text-danger">*</span></label>
                            <input type="text"
                                   class="form-control @error('question') is-invalid @enderror"
                                   id="question"
                                   name="question"
                                   value="{{ old('question', $faq->question) }}"
                                   required
                                   autofocus>
                            @error('question')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="answer">Jawaban <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('answer') is-invalid @enderror"
                                      id="answer"
                                      name="answer"
                                      rows="5"
                                      required>{{ old('answer', $faq->answer) }}</textarea>
                            @error('answer')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="category">Kategori</label>
                                    <input type="text"
                                           class="form-control"
                                           id="category"
                                           name="category"
                                           value="{{ old('category', $faq->category) }}"
                                           placeholder="mis: Pemesanan, Pembayaran, Layanan">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="sort_order">Urutan Tampil</label>
                                    <input type="number"
                                           class="form-control"
                                           id="sort_order"
                                           name="sort_order"
                                           value="{{ old('sort_order', $faq->sort_order) }}"
                                           min="0">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Status</label>
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox"
                                               class="custom-control-input"
                                               id="is_published"
                                               name="is_published"
                                               value="1"
                                               {{ old('is_published', $faq->is_published) ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="is_published">Publish</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-warning">
                            <i class="fas fa-save"></i> Update FAQ
                        </button>
                        <a href="{{ route('admin.faqs.index') }}" class="btn btn-default">
                            <i class="fas fa-times"></i> Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection