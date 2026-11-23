<nav class="navbar navbar-expand-lg mw-navbar fixed-top">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center" href="{{ route('home') }}">
            <img src="{{ $companyProfile->logo_url }}" alt="{{ $companyProfile->name }}">
        </a>
        <button class="navbar-toggler" type="button"
                data-bs-toggle="collapse" data-bs-target="#navbarMain"
                aria-controls="navbarMain" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarMain">
            <ul class="navbar-nav mx-auto">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('home') }}">Beranda</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('about') }}">Tentang Kami</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('packages.index') }}">Paket Wisata</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('gallery') }}">Galeri</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('contact') }}">Kontak</a>
                </li>
            </ul>
            <div class="d-flex align-items-center gap-2">
                @guest
                    <a href="{{ route('login') }}" class="btn btn-primary btn-sm rounded-pill px-3">
                        <i class="bi bi-box-arrow-in-right"></i> Login
                    </a>
                    <a href="{{ route('register') }}" class="btn btn-dark btn-sm rounded-pill px-3">
                        <i class="bi bi-person-plus"></i> Daftar
                    </a>
                @else
                    {{-- Logged in (customer atau admin): tombol Profile --}}
                    <a href="{{ route('profile.show') }}" class="btn btn-dark btn-sm rounded-pill px-3">
                        <i class="bi bi-person-circle"></i> Profile
                    </a>
                @endguest
            </div>
        </div>
    </div>
</nav>