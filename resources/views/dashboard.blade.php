<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard - Lensa Media Management</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f4f7f6;

        }
    </style>
</head>

<body>
    <main>
        {{-- Kontainer utama untuk memposisikan semua konten di tengah halaman --}}
        <div class="d-flex vh-100 justify-content-center align-items-center">
            <div class="container text-center">

                <h1 class="display-4 fw-bold">Lensa Media Management</h1>

                <p class="lead text-muted mt-2 mb-4">
                    Selamat datang, {{ Auth::user()->name }}!
                </p>

                <div class="card shadow-sm border-0 col-lg-8 col-md-10 mx-auto">
                    <div class="card-body p-4 p-md-5">
                        <h5 class="card-title fw-semibold mb-3">Pilih Modul Akses</h5>
                        <p class="card-text text-muted small mb-4">Pilih modul di bawah ini sesuai dengan role yang Anda
                            miliki untuk memulai.</p>

                        <div class="row justify-content-center g-3 mt-4">
                            @foreach ($roles as $role)
                                <div class="col-12 col-sm-6 col-md-4">
                                    @if (Auth::user()->hasRole($role->name))
                                        @php
                                            // Logika untuk ikon bisa tetap di sini
                                            $icon = 'fa-cogs'; // Ikon default
                                            if (strtolower($role->name) == 'admin') {
                                                $icon = 'fa-user-shield';
                                            }
                                            if (strtolower($role->name) == 'writer') {
                                                $icon = 'fa-pencil-alt';
                                            } // Asumsi role Anda 'writer'
                                        @endphp


                                        <a href="{{ route('role.select', $role->name) }}"
                                            class="btn btn-primary btn-lg w-100 d-flex flex-column p-3">
                                            <i class="fas {{ $icon }} fa-2x mb-2"></i>
                                            <span class="fw-semibold">{{ $role->name }}</span>
                                        </a>
                                    @else
                                        {{-- JIKA PENGGUNA TIDAK MEMILIKI ROLE (TOMBOL DISABLE) --}}
                                        <button type="button"
                                            class="btn btn-outline-secondary btn-lg w-100 d-flex flex-column p-3 disabled"
                                            title="Akses Dibatasi">
                                            <i class="fas fa-lock fa-2x mb-2"></i>
                                            <span class="fw-semibold">{{ $role->name }}</span>
                                        </button>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="mt-4">
                    <a class="btn btn-link text-secondary" href="{{ route('logout') }}"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        Logout
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </div>

            </div>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
