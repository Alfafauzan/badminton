<!DOCTYPE html>
<html lang="id">

<head>
    {{-- Semua isi <head> dari file HTML sebelumnya --}}
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'LENSA.MEDIA' }} - Portal Berita Modern</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f8f9fa;
            padding-top: 70px;
        }

        .page-section {
            display: none;
            animation: fadeIn 0.5s;
        }

        .page-section.active {
            display: block;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        .navbar-brand .brand-main {
            font-weight: 700;
        }

        .navbar-brand .brand-italic {
            font-weight: 400;
            font-style: italic;
        }

        .hero-section {
            position: relative;
            height: 60vh;
            background: url('https://placehold.co/1920x1080/333/FFF?text=Berita+Utama') no-repeat center center;
            background-size: cover;
            color: white;
            display: flex;
            align-items: flex-end;
            padding: 2rem;
        }

        .hero-section::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(to top, rgba(0, 0, 0, 0.8), transparent);
        }

        .hero-content {
            position: relative;
            z-index: 2;
        }

        .hero-content .badge {
            font-size: 0.9rem;
        }

        .hero-content h1 {
            font-size: 2.5rem;
            font-weight: 700;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
        }

        .news-card {
            transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
        }

        .news-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        }

        .news-card img {
            height: 200px;
            object-fit: cover;
        }

        .article-header img {
            width: 100%;
            height: auto;
            max-height: 500px;
            object-fit: cover;
            border-radius: 0.5rem;
        }

        .team-member img {
            width: 120px;
            height: 120px;
            object-fit: cover;
        }
    </style>

</head>

<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm fixed-top">
            <div class="container">
                {{-- DIUBAH: Link sekarang menggunakan route() helper Laravel --}}
                <a class="navbar-brand" href="{{ route('home') }}">
                    <span class="brand-main">LENSA</span><span class="brand-italic">.MEDIA</span>
                </a>
                <div class="offcanvas offcanvas-end text-bg-dark" tabindex="-1" id="offcanvasNavbar">
                    <div class="offcanvas-header">
                        <h5 class="offcanvas-title">LENSA.MEDIA</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas"
                            aria-label="Close"></button>
                    </div>
                    <div class="offcanvas-body">
                        <ul class="navbar-nav justify-content-center flex-grow-1 pe-3">
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}"
                                    href="{{ route('home') }}">Home</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('article.*') ? 'active' : '' }}"
                                    href="{{ route('article.index') }}">Articles</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('about') ? 'active' : '' }}"
                                    href="{{ route('about') }}">About Us</a>
                            </li>
                        </ul>
                    </div>
                </div>
                {{-- Ganti bagian tombol di navbar Anda dengan ini --}}
                <div class="d-flex align-items-center gap-2">
                    @guest
                        {{-- TAMPILAN UNTUK PENGUNJUNG (BELUM LOGIN) --}}
                        <a href="{{ route('login') }}" class="btn btn-outline-secondary text-white">Login</a>
                        <a href="{{ route('register') }}" class="btn btn-primary">Register</a>
                    @else
                        {{-- TAMPILAN UNTUK PENGGUNA YANG SUDAH LOGIN (DENGAN ATAU TANPA ROLE) --}}
                        <div class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle text-white" href="#" role="button"
                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-user-circle me-1"></i> {{ Auth::user()->name }}
                            </a>

                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">

                                {{-- DIUBAH: Pengecekan sekarang berdasarkan role, bukan permission --}}
                                {{-- Tampilkan link Dashboard hanya jika user memiliki role 'Admin' atau 'Writer' --}}
                                @if (Auth::user()->hasAnyRole(['Admin', 'Writer']))
                                    <a class="dropdown-item" href="{{ route('dashboard') }}">Dashboard</a>
                                    <div class="dropdown-divider"></div>
                                @endif

                                <a class="dropdown-item" href="{{ route('logout') }}"
                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i class="fas fa-sign-out-alt fa-fw me-2"></i> {{ __('Logout') }}
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </div>
                    @endguest

                    <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas"
                        data-bs-target="#offcanvasNavbar">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                </div>
            </div>
        </nav>
    </header>

    <main>
        @yield('content') {{-- Di sini konten dari halaman spesifik akan dimasukkan --}}
    </main>

    <footer class="bg-dark text-white pt-5 pb-4">
        {{-- Salin semua konten <footer> dari file HTML sebelumnya di sini --}}
        <div class="container text-center text-md-start">
            <div class="row">
                <div class="col-md-4 col-lg-5 mx-auto mt-3">
                    <h5 class="text-uppercase mb-4 fw-bold"><span class="brand-main">LENSA</span><span
                            class="brand-italic">.MEDIA</span></h5>
                    <p>Portal berita terdepan yang menyajikan informasi akurat, cepat, dan terpercaya dari berbagai
                        penjuru dunia. Ikuti kami untuk tetap update.</p>
                </div>
                <div class="col-md-2 col-lg-2 mx-auto mt-3">
                    <h5 class="text-uppercase mb-4 fw-bold">Kategori</h5>
                    <p><a href="#!" class="text-white-50 text-decoration-none">Teknologi</a></p>
                    <p><a href="#!" class="text-white-50 text-decoration-none">Olahraga</a></p>
                </div>
                <div class="col-md-4 col-lg-3 mx-auto mt-3">
                    <h5 class="text-uppercase mb-4 fw-bold">Kontak</h5>
                    <p><i class="fas fa-home me-3"></i> Jakarta, Indonesia</p>
                    <p><i class="fas fa-envelope me-3"></i> redaksi@lensa.media</p>
                    <p><i class="fas fa-phone me-3"></i> +62 21 1234 5678</p>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>
