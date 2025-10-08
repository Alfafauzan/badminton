<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Routing\Controller;
use Illuminate\Support\Str;

class ArticleController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:view articles')->only(['index']);
        $this->middleware('permission:edit articles')->only(['edit', 'update']);
        $this->middleware('permission:create articles')->only(['create', 'store']);
        $this->middleware('permission:delete articles')->only(['destroy']);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $articles = Article::orderBy('created_at', 'ASC')->paginate(25);
        $category = Category::orderBy('created_at', 'ASC');
        return view('articles.list', [
            'articles' => $articles,
            'category' => $category,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categori = Category::orderBy('created_at', 'ASC')->paginate(25);
        return view('articles.create', [
            'categori' => $categori,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $valid = Validator::make(
            $request->all(),
            [
                'title' => 'required|string|max:255',
                'text' => 'required|string',
                'author' => 'required|string|max:50',
                'category_id' => 'required|exists:categories,id',
                'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            ],
            ['title.required' => 'Masukan judul artcle terlebih dahulu', 'title.max' => 'Judul yang anda masukkan terlalu banyak', 'text.required' => 'Masukan isi content artcle terlebih dahulu', 'author.required' => 'Masukan nama author terlebih dahulu', 'author.max' => 'Nama author terlalu panjang', 'category_id.required' => 'Pilih category untuk article'],
        );
        if ($valid->fails()) {
            // Redirect jika validasi gagal
            return redirect()->route('articles.create')->withErrors($valid)->withInput();
        }
        $article = new Article();
        $article->title = strip_tags($request->title);
        $article->text = strip_tags($request->text);
        $article->author = strip_tags($request->author);
        $article->category_id = $request->category_id;

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('asset/img'), $filename);
            $article->image = 'asset/img/' . $filename;
        }

        $article->save();
        activity()
            ->causedBy(auth()->user())
            ->performedOn($article)
            ->withProperties(['title' => $article->title])
            ->log('Membuat artikel');

        return redirect()->route('articles.index')->with('Berhasil', 'Article berhasil ditambah');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $article = Article::findOrFail($id);

        return view('articles.edit', [
            'article' => $article,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */ public function update(Request $request, string $id)
    {
        $article = Article::findOrFail($id);

        $valid = Validator::make($request->all(), [
            'title' => 'required|string|min:5|max:255',
            'author' => 'required|string|min:5|max:100',
            'text' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($valid->fails()) {
            return redirect()->route('articles.edit', $id)->withInput()->withErrors($valid);
        }
        $oldData = $article->only(['title', 'text', 'author', 'category_id', 'image']);
        $article->title = strip_tags($request->title);
        $article->text = strip_tags($request->text);
        $article->author = strip_tags($request->author);
        $article->category_id = $request->category_id;

        // Cek jika ada gambar baru di-upload
        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada
            if ($article->image && file_exists(public_path($article->image))) {
                unlink(public_path($article->image));
            }

            $file = $request->file('image');
            $filename = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/articles'), $filename);
            $article->image = 'uploads/articles/' . $filename;
        }

        $article->save();
        activity()
        ->causedBy(auth()->user())
        ->performedOn($article)
        ->withProperties([
            'old' => $oldData,
            'new' => $article->only(['title', 'text', 'author', 'category_id', 'image']),
        ])
        ->log('Mengubah artikel');

        return redirect()->route('articles.index')->with('Berhasil', 'Article berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $id = $request->id;
        $article = Article::find($id);

        if ($article == null) {
            session()->flash('error', 'Article tidak di temukan');
            return response()->json([
                'status' => false,
            ]);
        }

        $article->delete();
        activity()
            ->causedBy(auth()->user())
            ->performedOn($article)
            ->withProperties(['title' => $article->title])
            ->log('Menghapus artikel');

        session()->flash('Berhasil', 'Article berhasil di hapus');
        return response()->json([
            'status' => true,
        ]);
    }
}
