@extends('layouts.public')
@section('title', 'Beranda')

@section('content')
    <section id="about" class="page-section active">
        {{-- Konten About Us tidak berubah, tetap sama seperti sebelumnya --}}
        <div class="container py-5">
            <div class="row justify-content-center text-center">
                <div class="col-lg-8">
                    <h1 class="display-4 fw-bold">Tentang LENSA.MEDIA</h1>
                    <p class="lead text-muted mt-3">Menyajikan berita dengan sudut pandang yang jernih, akurat, dan
                        terpercaya.</p>
                </div>
            </div>
            <div class="row mt-5">
                <div class="col-lg-6 mb-4 mb-lg-0">
                    <h3 class="fw-bold">Misi Kami</h3>
                    <p>Misi kami adalah untuk menjadi sumber informasi utama bagi masyarakat Indonesia dengan
                        menyajikan berita yang tidak hanya cepat, tetapi juga mendalam, informatif, dan mendidik.
                        Kami berkomitmen pada standar jurnalisme tertinggi, menjunjung tinggi etika, dan memastikan
                        setiap berita yang kami sajikan telah melalui proses verifikasi yang ketat.</p>
                </div>
                <div class="col-lg-6">
                    <img src="https://placehold.co/600x400/EEE/333?text=Ruang+Redaksi" class="img-fluid rounded"
                        alt="Ruang Redaksi">
                </div>
            </div>

            <div class="row text-center mt-5 pt-4">
                <h2 class="fw-bold mb-5">Tim Kami</h2>
                <div class="col-md-4">
                    <div class="team-member">
                        <img src="https://placehold.co/400x400/DDD/333?text=Foto" class="rounded-circle mb-3"
                            alt="Foto Tim">
                        <h5 class="fw-bold">Andi Wijaya</h5>
                        <p class="text-muted">Editor in Chief</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="team-member">
                        <img src="https://placehold.co/400x400/DDD/333?text=Foto" class="rounded-circle mb-3"
                            alt="Foto Tim">
                        <h5 class="fw-bold">Citra Lestari</h5>
                        <p class="text-muted">Head of Content</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="team-member">
                        <img src="https://placehold.co/400x400/DDD/333?text=Foto" class="rounded-circle mb-3"
                            alt="Foto Tim">
                        <h5 class="fw-bold">Budi Santoso</h5>
                        <p class="text-muted">Lead Journalist</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
