<section class="bg-white py-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h2 class="fw-bold mb-3">{{ $companyProfile->name }}</h2>
                <p style="white-space: pre-line;">{{ $companyProfile->description }}</p>
                @if($companyProfile->founded_year)
                    <p class="mt-3"><strong>Berdiri sejak:</strong> {{ $companyProfile->founded_year }}</p>
                @endif
            </div>
            <div class="col-md-4 text-center">
                <img src="{{ $companyProfile->logo_url }}" alt="{{ $companyProfile->name }}" class="img-fluid" style="max-height: 200px;">
            </div>
        </div>
    </div>
</section>