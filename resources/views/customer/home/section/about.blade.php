{{-- ABOUT SECTION — Short about + 3 service cards --}}
<section class="section-cream py-5">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-bold mb-3">Tentang Media Wisata</h2>
            <p class="text-muted mx-auto" style="max-width: 700px;">
                {{ Str::limit($companyProfile->description ?? 'Perusahaan jasa perjalanan wisata dan transportasi lokal Banyumas.', 200) }}
            </p>
        </div>

        <div class="row g-4">
            <div class="col-md-4">
                <div class="card mw-card shadow-sm border-0 h-100 text-center p-4">
                    <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-inline-flex align-items-center justify-content-center mx-auto mb-3" style="width: 60px; height: 60px;">
                        <i class="bi bi-suitcase-lg-fill fs-4"></i>
                    </div>
                    <h5 class="fw-bold">Paket Wisata</h5>
                    <p class="text-muted small mb-0">Paket wisata lengkap untuk berbagai destinasi di Indonesia.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card mw-card shadow-sm border-0 h-100 text-center p-4">
                    <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-inline-flex align-items-center justify-content-center mx-auto mb-3" style="width: 60px; height: 60px;">
                        <i class="bi bi-calendar-event-fill fs-4"></i>
                    </div>
                    <h5 class="fw-bold">Event Organizer</h5>
                    <p class="text-muted small mb-0">Jasa EO untuk gathering, seminar, workshop, dan acara lain.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card mw-card shadow-sm border-0 h-100 text-center p-4">
                    <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-inline-flex align-items-center justify-content-center mx-auto mb-3" style="width: 60px; height: 60px;">
                        <i class="bi bi-bus-front-fill fs-4"></i>
                    </div>
                    <h5 class="fw-bold">Sewa Transport</h5>
                    <p class="text-muted small mb-0">Sewa bus, MPV, dan shuttle untuk kebutuhan transportasi rombongan.</p>
                </div>
            </div>
        </div>
    </div>
</section>