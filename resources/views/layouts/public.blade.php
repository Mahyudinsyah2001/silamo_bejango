<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SILAMO BEJANGO</title>
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;800&display=swap" rel="stylesheet">
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- AOS Animation -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('img/logo_silamo_bejango.png') }}">

    <style>
        :root {
            --primary: #f39c12;
            /* Admin Orange */
            --secondary: #222d32;
            /* Admin Charcoal */
            --accent: #2c3b41;
            --bg-light: #ecf0f5;
            /* Admin Content BG */
        }

        body {
            font-family: 'Outfit', sans-serif;
            background-color: var(--bg-light);
            color: #333;
        }

        .navbar {
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
            background: white;
            padding: 15px 0;
        }

        .navbar-brand {
            font-weight: 800;
            font-size: 1.4rem;
            letter-spacing: -1px;
        }

        .brand-icon-wrapper {
            background: var(--primary);
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(243, 156, 18, 0.3);
        }

        .brand-text {
            display: flex;
            flex-direction: column;
            line-height: 1;
            margin-left: 8px;
        }

        .brand-text span:first-child {
            color: var(--secondary) !important;
        }

        .brand-text span:last-child {
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-top: 2px;
            color: #666;
            font-weight: 600;
        }

        .nav-link {
            font-weight: 600;
            color: #475569 !important;
            transition: all 0.3s ease;
            font-size: 0.95rem;
            position: relative;
        }

        .nav-link:hover,
        .nav-link.active {
            color: var(--secondary) !important;
        }

        /* Animasi Garis Bawah Navigasi */
        .nav-link::after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            bottom: 2px;
            left: 50%;
            background-color: var(--primary);
            transition: all 0.3s ease;
            transform: translateX(-50%);
            border-radius: 2px;
        }

        .nav-link:hover::after,
        .nav-link.active::after {
            width: 70%;
        }

        /* Animasi Tombol Global */
        .btn-primary {
            background: var(--primary);
            border: none;
            padding: 10px 25px;
            font-weight: 600;
            border-radius: 8px;
            transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
        }

        .btn-secondary {
            background: var(--secondary);
            border: none;
            padding: 10px 25px;
            font-weight: 600;
            border-radius: 8px;
            transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
        }

        .btn-outline-primary {
            border: 2px solid var(--primary);
            color: var(--primary);
            padding: 8px 25px;
            font-weight: 600;
            border-radius: 8px;
            transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
        }

        .btn:hover {
            transform: translateY(-3px) scale(1.02);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.12) !important;
        }

        .btn:active {
            transform: translateY(0) scale(0.98);
        }

        .btn-outline-primary:hover {
            background: var(--primary);
            color: white;
        }

        /* Animasi Kartu / Panel */
        .glass-card,
        .card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 16px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.4);
            transition: all 0.4s cubic-bezier(0.25, 0.8, 0.25, 1);
        }

        .glass-card:hover,
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
        }

        /* Animasi Input Form */
        .form-control,
        .form-select {
            transition: all 0.3s ease !important;
        }

        .form-control:focus,
        .form-select:focus {
            transform: translateY(-2px);
            box-shadow: 0 8px 15px rgba(243, 156, 18, 0.15) !important;
            border-color: var(--primary) !important;
        }

        .hero-section {
            background: linear-gradient(135deg, rgba(34, 45, 50, 0.95), rgba(44, 59, 65, 0.85)), url('https://images.unsplash.com/photo-1541888086225-eceb0521ca49?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80') center/cover;
            color: white;
            padding: 120px 0;
            min-height: 80vh;
            display: flex;
            align-items: center;
        }

        .hero-title {
            font-size: 3.5rem;
            font-weight: 800;
            margin-bottom: 20px;
            line-height: 1.2;
            color: #fff;
        }

        .hero-subtitle {
            font-size: 1.2rem;
            font-weight: 300;
            opacity: 0.9;
            margin-bottom: 30px;
            color: rgba(255, 255, 255, 0.8);
        }

        .footer {
            background: var(--secondary);
            color: white;
            padding: 40px 0 20px;
            margin-top: 60px;
            border-top: 5px solid var(--primary);
        }

        .footer a {
            color: #adb5bd;
            text-decoration: none;
            transition: all 0.3s ease;
            display: inline-block;
        }

        .footer a:hover {
            color: var(--primary);
            transform: translateX(5px);
        }

        /* ===== RESPONSIVE MOBILE ===== */
        @media (max-width: 991.98px) {
            .hero-section {
                padding: 80px 0 60px;
                min-height: auto;
                text-align: center;
            }

            .hero-title {
                font-size: 2.2rem;
                letter-spacing: -1px !important;
            }

            .hero-subtitle {
                font-size: 1rem;
            }

            .hero-section .d-flex {
                justify-content: center;
            }
        }

        @media (max-width: 575.98px) {
            .hero-section {
                padding: 60px 0 50px;
            }

            .hero-title {
                font-size: 1.75rem;
                line-height: 1.3;
            }

            .hero-subtitle {
                font-size: 0.9rem;
            }

            /* Tombol di hero stack rapi di HP kecil */
            .hero-section .d-flex.flex-wrap {
                flex-direction: column;
                align-items: center;
            }

            .hero-section .btn {
                width: 100%;
                max-width: 300px;
            }

            /* Navbar brand subtitle sembunyi di HP kecil */
            .brand-text span:last-child {
                display: none;
            }

            /* Footer rapi di HP */
            .footer .row>div {
                text-align: center;
                margin-bottom: 2.5rem !important;
            }

            .footer .row>div:last-child {
                margin-bottom: 1rem !important;
            }

            .footer .list-unstyled {
                display: inline-block;
                text-align: left;
            }

            .footer .d-flex {
                justify-content: flex-start;
            }

            .footer .col-lg-5 .list-unstyled {
                width: 100%;
                max-width: 300px;
                margin: 0 auto;
            }

            .footer a:hover {
                transform: none;
            }
        }
    </style>
</head>

<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg sticky-top">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="{{ route('home') }}">
                <img src="{{ asset('img/logo_silamo_bejango.png') }}" alt="Logo" class="me-2"
                    style="height: 45px; width: auto; object-fit: contain;">
                <span class="brand-text">
                    <span class="fw-bold">SILAMO BEJANGO</span>
                    <span class="text-muted">LAPAS KELAS IIA SUMBAWA BESAR</span>
                </span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav align-items-center">
                    <li class="nav-item"><a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}"
                            href="{{ route('home') }}">Home</a></li>
                    <li class="nav-item"><a class="nav-link {{ request()->routeIs('antrian.cek') ? 'active' : '' }}"
                            href="{{ route('antrian.cek') }}">Cek Antrian</a></li>
                    <li class="nav-item"><a class="nav-link {{ request()->routeIs('informasi') ? 'active' : '' }}"
                            href="{{ route('informasi') }}">Informasi</a></li>
                    <li class="nav-item"><a class="nav-link {{ request()->routeIs('kontak') ? 'active' : '' }}"
                            href="{{ route('kontak') }}">Kontak</a></li>
                    <li class="nav-item ms-lg-3 mt-3 mt-lg-0">
                        <a class="btn btn-primary shadow-sm" href="{{ route('antrian.create') }}">Ambil Antrian <i
                                class="fa-solid fa-arrow-right ms-1"></i></a>
                    </li>
                    <li class="nav-item ms-lg-2 mt-2 mt-lg-0 border-start ps-3 d-none d-lg-block">
                        <a class="nav-link text-muted" href="{{ route('login') }}" title="Login Admin"><i
                                class="fa-solid fa-user-lock"></i></a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div style="min-height: calc(100vh - 200px);">
        @yield('content')
    </div>

    <!-- Footer -->
    <footer class="footer py-4">
        <div class="container">
            <div class="text-center text-sm opacity-50">
                &copy; {{ date('Y') }} Lembaga Pemasyarakatan Kelas IIA Sumbawa Besar. Hak Cipta Dilindungi.
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        AOS.init({
            once: true,
            duration: 800
        });
    </script>
    @stack('scripts')
</body>

</html>