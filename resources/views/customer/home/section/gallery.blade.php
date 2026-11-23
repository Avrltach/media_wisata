{{-- GALERI PREVIEW SECTION — Grid foto dari DB --}}
<section class="section-cream py-5">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-bold mb-2">Galeri Media Wisata</h2>
            <p class="text-muted">Dokumentasi kegiatan dan perjalanan kami</p>
        </div>

        <div class="row g-2">
            @forelse($galleries as $gallery)
                <div class="col-lg-3 col-md-4 col-6">
                    <div class="ratio ratio-1x1">
                        <img src="{{ $gallery->image_url }}" class="rounded shadow-sm object-fit-cover" alt="{{ $gallery->title }}" style="object-fit: cover;">
                    </div>
                </div>
            @empty
                <div class="col-12 text-center text-muted py-5">
                    <i class="bi bi-images fs-1 d-block mb-2"></i>
                    Belum ada foto galeri.
                </div>
            @endforelse
        </div>

        @if($galleries->isNotEmpty())
            <div class="text-center mt-4">
                <a href="{{ route('gallery') }}" class="btn btn-outline-primary rounded-pill px-4">
                    Lihat Semua Foto <i class="bi bi-arrow-right ms-2"></i>
                </a>
            </div>
        @endif
    </div>
</section>