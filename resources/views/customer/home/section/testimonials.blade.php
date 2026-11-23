{{-- TESTIMONI SECTION — 3 card testimonial dari DB --}}
<section class="bg-white py-5">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-bold mb-2">Apa Kata Pelanggan Kami</h2>
            <p class="text-muted">Cerita dari mereka yang sudah berpetualang bersama kami</p>
        </div>

        <div class="row g-4">
            @forelse($testimonials as $testimonial)
                <div class="col-md-4">
                    <div class="card mw-card shadow-sm border-0 h-100 p-4">
                        <div class="text-warning mb-3" style="font-size: 1.2rem;">
                            {{ $testimonial->stars }}
                        </div>
                        <p class="text-muted mb-4" style="font-style: italic;">
                            "{{ Str::limit($testimonial->message, 150) }}"
                        </p>
                        <div class="d-flex align-items-center">
                            <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 50px; height: 50px;">
                                <i class="bi bi-person-fill"></i>
                            </div>
                            <div>
                                <h6 class="mb-0 fw-bold">{{ $testimonial->name }}</h6>
                                <small class="text-muted">Pelanggan Media Wisata</small>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center text-muted py-5">
                    <i class="bi bi-chat-quote fs-1 d-block mb-2"></i>
                    Belum ada testimoni.
                </div>
            @endforelse
        </div>
    </div>
</section>