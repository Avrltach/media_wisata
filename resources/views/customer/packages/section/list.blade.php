<section class="bg-white py-5">
    <div class="container">
        @if($packages->isNotEmpty())
            <div class="row g-4">
                @foreach($packages as $package)
                    <div class="col-lg-3 col-md-6">
                        <div class="card mw-card shadow-sm border-0 h-100">
                            <div class="position-relative">
                                <img src="{{ $package->main_image_url }}" class="card-img-top" alt="{{ $package->name }}" style="height: 200px; object-fit: cover;">
                                <span class="badge badge-mw-yellow position-absolute top-0 end-0 m-2">{{ $package->duration }}</span>
                            </div>
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title fw-bold">{{ Str::limit($package->name, 30) }}</h5>
                                <p class="card-text text-muted small flex-grow-1">{{ Str::limit($package->description, 80) }}</p>
                                <div class="d-flex justify-content-between align-items-center mt-3">
                                    <span class="fw-bold text-primary">{{ $package->formatted_price }}</span>
                                    <a href="#" class="btn btn-primary btn-sm rounded-pill">Detail</a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="mt-5">{{ $packages->links() }}</div>
        @else
            <div class="text-center text-muted py-5">
                <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                Belum ada paket wisata.
            </div>
        @endif
    </div>
</section>