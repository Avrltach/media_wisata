<section class="bg-dark py-5 text-center text-white" style="margin-top: 72px;">
    <div class="container">
        <div class="bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center mx-auto mb-3" style="width: 100px; height: 100px; font-size: 2.5rem;">
            <i class="bi bi-person-fill"></i>
        </div>
        <h1 class="fw-bold mb-1">{{ auth()->user()->name }}</h1>
        <p class="mb-0 opacity-75">{{ auth()->user()->email }}</p>
        <span class="badge {{ auth()->user()->isAdmin() ? 'bg-warning text-dark' : 'bg-secondary' }} mt-2">
            {{ auth()->user()->isAdmin() ? 'Admin' : 'Customer' }}
        </span>
    </div>
</section>