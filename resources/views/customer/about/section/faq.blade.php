{{-- FAQ SECTION — Accordion dari DB --}}
<section class="section-cream py-5">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-bold mb-2">Pertanyaan yang Sering Diajukan</h2>
            <p class="text-muted">Temukan jawaban atas pertanyaan umum seputar layanan kami</p>
        </div>

        <div class="row justify-content-center">
            {{-- ⬇️ Tambah id="faqAccordion" biar accordion behavior jalan --}}
            <div class="col-lg-8" id="faqAccordion">
                @forelse($faqs as $faq)
                    <div class="accordion-item border-0 mb-2 shadow-sm rounded-3 overflow-hidden bg-white">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed bg-white fw-semibold px-4 py-3" type="button" data-bs-toggle="collapse" data-bs-target="#faq-{{ $faq->id }}">
                                {{ $faq->question }}
                            </button>
                        </h2>
                        <div id="faq-{{ $faq->id }}" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            {{-- ⬇️ Tambah bg-white + padding lebih lega (px-4 py-3) + border-top separator --}}
                            <div class="accordion-body text-muted bg-white px-4 py-3" style="border-top: 1px solid #f0f0f0; line-height: 1.7;">
                                {{ $faq->answer }}
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center text-muted py-5">
                        <i class="bi bi-question-circle fs-1 d-block mb-2"></i>
                        Belum ada FAQ.
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</section>