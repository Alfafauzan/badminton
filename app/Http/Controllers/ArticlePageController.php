<?php

// app/Http/Controllers/ArticlePageController.php
namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;

class ArticlePageController extends Controller
{
    // Menampilkan halaman daftar semua artikel
    public function index()
    {
        return view('public.article.index', [
            'articles' => Article::with('category')->latest()->paginate(9),
            'categories' => Category::has('articles')->orderBy('name', 'asc')->get()
        ]);
    }
    
    // Menampilkan artikel berdasarkan kategori
    public function showByCategory(Category $category)
    {
        return view('public.article.index', [
            // articles berisi $category yang mengambil semua article dengan kategori tersebut
            'articles' => $category->articles()->latest()->paginate(9),
            // categories berisi category yang memiliki article
            'categories' => Category::has('articles')->orderBy('name', 'asc')->get(),
            // mengambil data dari $category untuk memunculkan kategori yang aktif
            'activeCategory' => $category 
        ]);
    }

    // Menampilkan detail artikel
    public function show(Article $article)
    {
        return view('public.article.show', [
            'article' => $article
        ]);
    }
}