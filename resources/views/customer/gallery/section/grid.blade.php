<section class="bg-white py-5">
    <div class="container">
        @if($galleries->isNotEmpty())
            <div class="row g-3">
                @foreach($galleries as $gallery)
                    <div class="col-lg-3 col-md-4 col-6">
                        <div class="ratio ratio-1x1">
                            <img src="{{ $gallery->image_url }}" class="rounded shadow-sm" alt="{{ $gallery->title }}" style="object-fit: cover;">
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="mt-5">{{ $galleries->links() }}</div>
        @else
            <div class="text-center text-muted py-5">
                <i class="bi bi-images fs-1 d-block mb-2"></i>
                Belum ada foto galeri.
            </div>
        @endif
    </div>
</section>