@if($companyProfile->maps_embed)
    <section class="bg-white pb-5">
        <div class="container-fluid px-0">
            <div class="ratio ratio-21x9" style="min-height: 400px;">
                {!! $companyProfile->maps_embed !!}
            </div>
        </div>
    </section>
@endif