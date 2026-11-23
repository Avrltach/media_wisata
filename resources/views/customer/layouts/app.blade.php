<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Media Wisata') — Jasa Perjalanan Wisata & Transportasi</title>
    <meta name="description" content="@yield('meta_description', 'Media Wisata — Travel agent lokal Banyumas. Paket wisata, sewa transport, dan event organizer.')">

    <!-- Google Fonts: Poppins + Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Bootstrap 5.3.3 CSS (CDN) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons 1.11.3 (CDN) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    <!-- Inline style: brand colors Media Wisata + custom components -->
    <style>
        :root {
            --mw-primary: #EC3138;
            --mw-primary-dark: #c9282e;
            --mw-secondary: #FFF112;
            --mw-dark: #1E2430;
            --mw-text-dark: #0C0F14;
            --mw-cream: #FFF8E7;
            --mw-gray: #8A94A6;
            --mw-shadow: rgba(0, 0, 0, 0.08);
            --mw-shadow-hover: rgba(236, 49, 56, 0.15);
        }

        body {
            font-family: 'Inter', sans-serif;
            color: var(--mw-text-dark);
            overflow-x: hidden;
        }

        h1, h2, h3, h4, h5, h6 {
            font-family: 'Poppins', sans-serif;
            font-weight: 700;
            color: var(--mw-text-dark);
            line-height: 1.2;
        }

        a { color: var(--mw-primary); text-decoration: none; transition: color 0.3s ease; }
        a:hover { color: var(--mw-primary-dark); }

        /* === Bootstrap Primary override → Media Wisata merah === */
        .btn-primary {
            --bs-btn-bg: var(--mw-primary);
            --bs-btn-border-color: var(--mw-primary);
            --bs-btn-hover-bg: var(--mw-primary-dark);
            --bs-btn-hover-border-color: var(--mw-primary-dark);
            --bs-btn-active-bg: var(--mw-primary-dark);
            --bs-btn-active-border-color: var(--mw-primary-dark);
            --bs-btn-disabled-bg: var(--mw-primary);
            --bs-btn-disabled-border-color: var(--mw-primary);
        }
        .btn-outline-primary {
            --bs-btn-color: var(--mw-primary);
            --bs-btn-border-color: var(--mw-primary);
            --bs-btn-hover-bg: var(--mw-primary);
            --bs-btn-hover-border-color: var(--mw-primary);
            --bs-btn-active-bg: var(--mw-primary);
            --bs-btn-active-border-color: var(--mw-primary);
        }
        .text-primary { color: var(--mw-primary) !important; }
        .bg-primary { background-color: var(--mw-primary) !important; }
        .bg-cream { background-color: var(--mw-cream) !important; }
        .bg-dark-footer { background-color: var(--mw-dark) !important; }
        .border-primary { border-color: var(--mw-primary) !important; }

        /* === Navbar === */
        .mw-navbar {
            background-color: transparent;
            transition: all 0.3s ease;
            padding: 1rem 0;
        }
        .mw-navbar.scrolled,
        .page-inner .mw-navbar {
            background-color: #ffffff;
            box-shadow: 0 2px 20px var(--mw-shadow);
            padding: 0.5rem 0;
        }
        .mw-navbar .nav-link {
            color: rgba(255, 255, 255, 0.9);
            font-weight: 500;
            font-size: 0.95rem;
            padding: 0.5rem 1rem !important;
            transition: color 0.3s ease;
        }
        .mw-navbar.scrolled .nav-link,
        .page-inner .mw-navbar .nav-link {
            color: var(--mw-text-dark);
        }
        .mw-navbar .nav-link:hover,
        .mw-navbar .nav-link.active {
            color: var(--mw-secondary) !important;
        }
        .mw-navbar.scrolled .nav-link:hover,
        .mw-navbar.scrolled .nav-link.active,
        .page-inner .mw-navbar .nav-link:hover,
        .page-inner .mw-navbar .nav-link.active {
            color: var(--mw-primary) !important;
        }
        .mw-navbar .navbar-brand img {
            height: 40px;
            transition: height 0.3s ease;
        }
        .mw-navbar.scrolled .navbar-brand img,
        .page-inner .mw-navbar .navbar-brand img {
            height: 36px;
        }
        /* Di page-home (hero), tombol outline putih. Di page-inner (solid navbar), outline merah */
        .page-home .mw-navbar .btn-outline-light {
            border-color: rgba(255,255,255,0.8);
            color: #fff;
        }
        .page-home .mw-navbar .btn-outline-light:hover {
            background-color: #fff;
            color: var(--mw-text-dark);
        }
        .page-inner .mw-navbar .btn-outline-light {
            border-color: var(--mw-primary);
            color: var(--mw-primary);
        }
        .page-inner .mw-navbar .btn-outline-light:hover {
            background-color: var(--mw-primary);
            color: #fff;
        }

        /* === Section === */
        section { padding: 80px 0; }
        .section-cream { background-color: var(--mw-cream); }
        .section-dark { background-color: var(--mw-dark); color: #fff; }
        .section-dark h1, .section-dark h2, .section-dark h3, .section-dark h4 { color: #fff; }

        /* === Card hover === */
        .mw-card { transition: transform 0.3s ease, box-shadow 0.3s ease; }
        .mw-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 12px 32px var(--mw-shadow-hover) !important;
        }

        /* === Badge === */
        .badge-mw-yellow { background-color: var(--mw-secondary); color: var(--mw-text-dark); }
        .badge-mw-red { background-color: var(--mw-primary); color: #fff; }

        /* === WhatsApp floating button === */
        .whatsapp-float {
            position: fixed;
            bottom: 24px;
            right: 24px;
            width: 60px;
            height: 60px;
            background-color: #25D366;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 30px;
            box-shadow: 0 4px 16px rgba(37, 211, 102, 0.4);
            z-index: 999;
            transition: all 0.3s ease;
            text-decoration: none;
        }
        .whatsapp-float:hover {
            background-color: #1da851;
            color: white;
            transform: scale(1.1);
        }
        .whatsapp-float::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
            border-radius: 50%;
            background-color: #25D366;
            z-index: -1;
            animation: mw-pulse 2s infinite;
        }
        @keyframes mw-pulse {
            0% { transform: scale(1); opacity: 0.7; }
            70% { transform: scale(1.5); opacity: 0; }
            100% { transform: scale(1.5); opacity: 0; }
        }

        /* === Footer === */
        .mw-footer {
            background-color: var(--mw-dark);
            color: rgba(255, 255, 255, 0.7);
            padding: 60px 0 20px;
        }
        .mw-footer h5 {
            color: #fff;
            font-family: 'Poppins', sans-serif;
            font-size: 1.1rem;
            margin-bottom: 1.5rem;
            font-weight: 600;
        }
        .mw-footer a {
            color: rgba(255, 255, 255, 0.7);
            display: block;
            padding: 0.4rem 0;
            font-size: 0.9rem;
            text-decoration: none;
            transition: color 0.3s ease, padding-left 0.3s ease;
        }
        .mw-footer a:hover { color: var(--mw-secondary); padding-left: 4px; }
        .mw-footer .footer-logo { height: 50px; margin-bottom: 1rem; }
        .mw-footer .social-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.1);
            color: #fff;
            margin-right: 8px;
            transition: all 0.3s ease;
            text-decoration: none;
        }
        .mw-footer .social-icon:hover {
            background: var(--mw-primary);
            color: #fff;
            transform: translateY(-3px);
        }
        .mw-footer .footer-bottom {
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            padding-top: 20px;
            margin-top: 40px;
            font-size: 0.85rem;
            text-align: center;
        }

        /* === Hero placeholder untuk test === */
        .hero-placeholder {
            min-height: 100vh;
            display: flex;
            align-items: center;
            background: linear-gradient(135deg, rgba(12,15,20,0.7), rgba(236,49,56,0.4)),
                        url('https://images.unsplash.com/photo-1469474968028-56623f02e42e?w=1600') center/cover;
            color: #fff;
        }
        .hero-page {
            min-height: 280px;
            display: flex;
            align-items: center;
            background-image: linear-gradient(135deg, rgba(12,15,20,0.8), rgba(236,49,56,0.5)),
                            var(--hero-bg, url('https://images.unsplash.com/photo-1469474968028-56623f02e42e?w=1600'));
            background-size: cover;
            background-position: center;
            color: #fff;
            text-align: center;
            margin-top: 72px;
            padding: 60px 0; 
        }
        
        .hero-placeholder h1 { color: #fff; font-size: 3.5rem; font-weight: 800; }
        .hero-placeholder p { font-size: 1.2rem; max-width: 600px; }

        /* === Responsive === */
        @media (max-width: 768px) {
            .hero-placeholder h1 { font-size: 2.2rem; }
            .hero-placeholder p { font-size: 1rem; }
            section { padding: 50px 0; }
            .whatsapp-float { width: 50px; height: 50px; font-size: 24px; bottom: 16px; right: 16px; }
        }
    </style>

    @stack('styles')
</head>
<body class="{{ $isHome ?? false ? 'page-home' : 'page-inner' }}">

    <!-- Navbar -->
    @include('customer.partials.navbar')

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    @include('customer.partials.footer')

    <!-- WhatsApp Floating Button -->
    @include('customer.partials.whatsapp-button')

    <!-- Bootstrap 5 JS Bundle (includes Popper) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Inline JS: navbar scroll behavior -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const navbar = document.querySelector('.mw-navbar');
            const body = document.body;

            // Hanya page-home yang punya transparent → solid behavior
            if (navbar && body.classList.contains('page-home')) {
                const handleScroll = () => {
                    if (window.scrollY > 50) {
                        navbar.classList.add('scrolled');
                    } else {
                        navbar.classList.remove('scrolled');
                    }
                };
                window.addEventListener('scroll', handleScroll);
                handleScroll();
            }

            // Active menu link berdasarkan URL
            const currentPath = window.location.pathname;
            document.querySelectorAll('.mw-navbar .nav-link').forEach(link => {
                const href = link.getAttribute('href');
                if (href === currentPath) {
                    link.classList.add('active');
                } else if (href && currentPath !== '/' && currentPath.startsWith(href) && href !== '/') {
                    link.classList.add('active');
                }
            });

            // Tutup mobile menu saat klik di luar
            const navbarCollapse = document.querySelector('#navbarMain');
            if (navbarCollapse) {
                document.addEventListener('click', function(e) {
                    if (!navbarCollapse.contains(e.target) && !e.target.closest('.navbar-toggler')) {
                        const bsCollapse = bootstrap.Collapse.getInstance(navbarCollapse);
                        if (bsCollapse && navbarCollapse.classList.contains('show')) {
                            bsCollapse.hide();
                        }
                    }
                });
            }
        });
    </script>

    @stack('scripts')
</body>
</html>