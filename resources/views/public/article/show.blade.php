@extends('layouts.public')
@section('title', $article->title)

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-9">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('article.index') }}">Articles</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ Str::limit($article->title, 30) }}</li>
                    </ol>
                </nav>

                <div class="article-header mb-4">
                    @if ($article->category)
                        {{-- DIUBAH: Menggunakan ->id, bukan ->slug --}}
                        <a href="{{ route('article.by_category', $article->category->id) }}"
                            class="badge bg-danger mb-2 text-decoration-none">{{ $article->category->name }}</a>
                    @endif
                    <h1 class="display-5 fw-bold">{{ $article->title }}</h1>
                    <p class="text-muted">Oleh: {{ $article->author }} | Dipublikasikan:
                        {{ $article->created_at->format('d F Y') }}</p>
                    <img src="{{ asset($article->image) }}" class="my-3 img-fluid rounded" alt="{{ $article->title }}">
                </div>

                <div class="article-body fs-5 text-justify">
                    {!! $article->text !!}
                </div>
            </div>
        </div>
    </div>

    <style>
        .text-justify {
            text-align: justify
        }
    </style>
@endsection
