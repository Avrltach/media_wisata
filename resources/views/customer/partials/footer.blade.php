<footer class="mw-footer">
    <div class="container">
        <div class="row gy-4">

            <!-- Kolom 1: Logo + About + Social -->
            <div class="col-lg-4 col-md-6">
                <img src="{{ $companyProfile->logo_url }}" alt="{{ $companyProfile->name }}" class="footer-logo">
                <p class="mb-3">
                    {{ Str::limit($companyProfile->description, 150) }}
                </p>
                <div class="d-flex">
                    @if($companyProfile->instagram)
                        <a href="{{ $companyProfile->instagram }}" target="_blank" class="social-icon">
                            <i class="bi bi-instagram"></i>
                        </a>
                    @endif
                    @if($companyProfile->facebook)
                        <a href="{{ $companyProfile->facebook }}" target="_blank" class="social-icon">
                            <i class="bi bi-facebook"></i>
                        </a>
                    @endif
                    @if($companyProfile->tiktok)
                        <a href="{{ $companyProfile->tiktok }}" target="_blank" class="social-icon">
                            <i class="bi bi-tiktok"></i>
                        </a>
                    @endif
                </div>
            </div>

            <!-- Kolom 2: Navigasi -->
            <div class="col-lg-2 col-md-6 col-6">
                <h5>Navigasi</h5>
                <a href="{{ route('home') }}">Beranda</a>
                <a href="{{ route('about') }}">Tentang Kami</a>
                <a href="{{ route('packages.index') }}">Paket Wisata</a>
                <a href="{{ route('gallery') }}">Galeri</a>
                <a href="{{ route('contact') }}">Kontak</a>
            </div>

            <!-- Kolom 3: Layanan -->
            <div class="col-lg-2 col-md-6 col-6">
                <h5>Layanan</h5>
                <a href="{{ route('packages.index', ['category' => 'paket_wisata']) }}">Paket Wisata</a>
                <a href="{{ route('packages.index', ['category' => 'event_organizer']) }}">Event Organizer</a>
                <a href="{{ route('packages.index', ['category' => 'sewa_transport']) }}">Sewa Transport</a>
            </div>

            <!-- Kolom 4: Kontak -->
            <div class="col-lg-4 col-md-6">
                <h5>Kontak Kami</h5>
                <p class="mb-2">
                    <i class="bi bi-geo-alt me-2"></i>
                    {{ Str::limit($companyProfile->address, 80) }}
                </p>
                @if($companyProfile->phone)
                    <p class="mb-2">
                        <i class="bi bi-telephone me-2"></i>
                        {{ $companyProfile->phone }}
                    </p>
                @endif
                @if($companyProfile->email)
                    <p class="mb-2">
                        <i class="bi bi-envelope me-2"></i>
                        {{ $companyProfile->email }}
                    </p>
                @endif
                @if($companyProfile->operating_hours)
                    <p class="mb-0">
                        <i class="bi bi-clock me-2"></i>
                        {{ $companyProfile->operating_hours }}
                    </p>
                @endif
            </div>
        </div>

        <!-- Bottom bar -->
        <div class="footer-bottom">
            &copy; {{ date('Y') }} {{ $companyProfile->name }}. All rights reserved.
            @if($companyProfile->founded_year)
                <span class="ms-2">| Berdiri sejak {{ $companyProfile->founded_year }}</span>
            @endif
        </div>
    </div>
</footer>