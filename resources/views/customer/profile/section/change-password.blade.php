{{-- Form ganti password --}}
<section class="section-cream py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white border-0 py-3">
                        <h5 class="mb-0 fw-bold">
                            <i class="bi bi-shield-lock text-primary me-2"></i>
                            Ganti Password
                        </h5>
                    </div>
                    <div class="card-body p-4">
                        <form action="{{ route('profile.password') }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label for="current_password" class="form-label">Password Saat Ini <span class="text-danger">*</span></label>
                                <input type="password"
                                       class="form-control @error('current_password') is-invalid @enderror"
                                       id="current_password" name="current_password" required>
                                @error('current_password')<span class="invalid-feedback">{{ $message }}</span>@enderror
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label">Password Baru <span class="text-danger">*</span></label>
                                <input type="password"
                                       class="form-control @error('password') is-invalid @enderror"
                                       id="password" name="password" required minlength="8">
                                <small class="text-muted">Minimal 8 karakter</small>
                                @error('password')<span class="invalid-feedback">{{ $message }}</span>@enderror
                            </div>

                            <div class="mb-4">
                                <label for="password_confirmation" class="form-label">Konfirmasi Password Baru <span class="text-danger">*</span></label>
                                <input type="password"
                                       class="form-control"
                                       id="password_confirmation" name="password_confirmation" required>
                            </div>

                            <button type="submit" class="btn btn-primary rounded-pill px-4">
                                <i class="bi bi-key me-2"></i> Ubah Password
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>