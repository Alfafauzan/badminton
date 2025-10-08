@extends('layouts.public')
@section('title', 'Beranda')

@section('content')
    {{-- Hero Section untuk Berita Utama --}}
    @if ($mainArticle)
        {{-- DIUBAH: Menggunakan asset() untuk path gambar --}}
        <div class="hero-section h-5" style="background-image: url('{{ asset($mainArticle->image) }}');">
            <div class="hero-content">
                @if ($mainArticle->category)
                    {{-- DIUBAH: Menggunakan ->id, bukan ->slug --}}
                    <a href="{{ route('article.by_category', $mainArticle->category->id) }}"
                        class="badge bg-danger mb-2 text-decoration-none">{{ $mainArticle->category->name }}</a>
                @endif
                <h1>{{ $mainArticle->title }}</h1>
                {{-- DIUBAH: Menggunakan Str::limit pada kolom 'text' karena 'excerpt' tidak ada --}}
                <p class="d-none d-md-block">{{ Str::limit($mainArticle->text, 150) }}</p>
                {{-- DIUBAH: Menggunakan ->id, bukan ->slug --}}
                <a href="{{ route('article.show', $mainArticle->id) }}" class="btn btn-light">Baca Selengkapnya <i
                        class="fas fa-arrow-right"></i></a>
            </div>
        </div>
    @endif

    {{-- Berita Terkini --}}
    <div class="container py-5">
        <h2 class="mb-4 fw-bold">Berita Terkini</h2>
        <div class="row g-4">
            @forelse ($latestArticles as $article)
                <div class="col-md-4">
                    <div class="card h-100 border-0 shadow-sm news-card">
                        <img src="{{ asset($article->image) }}" class="card-img-top" alt="{{ $article->title }}">
                        <div class="card-body">
                            @if ($article->category)
                                {{-- DIUBAH: Menggunakan ->id, bukan ->slug --}}
                                <a href="{{ route('article.by_category', $article->category->id) }}"
                                    class="badge bg-primary mb-2 text-decoration-none">{{ $article->category->name }}</a>
                            @endif
                            <h5 class="card-title fw-bold">
                                {{-- DIUBAH: Menggunakan ->id, bukan ->slug --}}
                                <a href="{{ route('article.show', $article->id) }}"
                                    class="text-decoration-none text-dark stretched-link">{{ $article->title }}</a>
                            </h5>
                            <p class="card-text text-muted small">{{ $article->created_at->diffForHumans() }}</p>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <p class="text-center text-muted">Belum ada berita terkini.</p>
                </div>
            @endforelse
        </div>
    </div>
@endsection
