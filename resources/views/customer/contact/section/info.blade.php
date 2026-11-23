<section class="bg-white py-5">
    <div class="container">
        <div class="row g-4">
            <div class="col-md-4">
                <div class="text-center p-4">
                    <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                        <i class="bi bi-geo-alt-fill fs-4"></i>
                    </div>
                    <h5 class="fw-bold">Alamat</h5>
                    <p class="text-muted small">{{ $companyProfile->address }}</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="text-center p-4">
                    <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                        <i class="bi bi-telephone-fill fs-4"></i>
                    </div>
                    <h5 class="fw-bold">Telepon</h5>
                    <p class="text-muted small">{{ $companyProfile->phone }}</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="text-center p-4">
                    <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                        <i class="bi bi-envelope-fill fs-4"></i>
                    </div>
                    <h5 class="fw-bold">Email</h5>
                    <p class="text-muted small">{{ $companyProfile->email }}</p>
                    <p class="text-muted small">{{ $companyProfile->operating_hours }}</p>
                </div>
            </div>
        </div>
    </div>
</section>