@extends('layouts.public')
@section('title', 'Semua Artikel')

@section('content')
    <div class="container py-5">

        <div class="grid ">
            <a href="{{ route('article.index') }}"
                class="g-col-6 g-col-md-4 btn btn-primary {{ !isset($activeCategory) ? 'active' : '' }}">Semua
                Kategori</a>
            @foreach ($categories as $category)
                <a href="{{ route('article.by_category', $category->id) }}"
                    class="g-col-6 g-col-md-4 btn btn-primary{{ isset($activeCategory) && $activeCategory->id == $category->id ? 'active' : '' }}">
                    {{ $category->name }}
                </a>
            @endforeach
        </div>


        <h1 class="display-5 fw-bold mb-4">
            @if (isset($activeCategory))
                {{ $activeCategory->name }}
            @else
                Semua Artikel
            @endif
        </h1>
        <div class="row g-4">
            @forelse ($articles as $article)
                <div class="col-md-4">
                    <div class="card h-100 border-0 shadow-sm news-card">
                        <img src="{{ asset($article->image) }}" class="card-img-top" alt="{{ $article->title }}">
                        <div class="card-body d-flex flex-column">
                            @if ($article->category)
                                <a href="{{ route('article.by_category', $article->category->id) }}"
                                    class="badge bg-primary mb-2 align-self-start text-decoration-none">{{ $article->category->name }}</a>
                            @endif

                            <a href="{{ route('article.show', $article->id) }}"
                                class="text-decoration-none text-dark stretched-link">{{ $article->title }}</a>
                            </h5>
                            <p class="card-text text-muted small mt-auto">
                                {{ $article->created_at->diffForHumans() }}</p>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="alert alert-warning text-center">Tidak ada artikel yang ditemukan.</div>
                </div>
            @endforelse
        </div>
        <div class="mt-5">{{ $articles->links() }}</div>





    </div>
@endsection
