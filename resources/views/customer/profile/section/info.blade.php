{{-- Quick info + actions --}}
<section class="bg-white py-4 border-bottom">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h5 class="mb-1">Informasi Akun</h5>
                <p class="text-muted mb-0 small">Kelola data profile dan password Anda di sini.</p>
            </div>
            <div class="col-md-6 text-md-end mt-3 mt-md-0">
                <a href="{{ route('customer.dashboard') }}" class="btn btn-outline-primary btn-sm rounded-pill px-3 me-2">
                    <i class="bi bi-grid"></i> Dashboard
                </a>
                <a href="{{ route('customer.bookings.index') }}" class="btn btn-outline-primary btn-sm rounded-pill px-3 me-2">
                    <i class="bi bi-bag"></i> Pesanan Saya
                </a>
                @if(auth()->user()->isAdmin())
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-warning btn-sm rounded-pill px-3 me-2">
                        <i class="bi bi-shield-lock"></i> Admin Panel
                    </a>
                @endif
                <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                    @csrf
                    <button type="submit" class="btn btn-outline-danger btn-sm rounded-pill px-3">
                        <i class="bi bi-box-arrow-right"></i> Keluar
                    </button>
                </form>
            </div>
        </div>
    </div>
</section>