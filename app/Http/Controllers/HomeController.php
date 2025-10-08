<?php

// app/Http/Controllers/HomeController.php
namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class HomeController extends Controller
{

    public function home()
    {
        $data = [
            'userCount'       => User::count(),
            'roleCount'       => Role::count(),
            'permissionCount' => Permission::count(),
            'articleCount'    => Article::count(),
            'categoryCount'   => Category::count(),
        ];
        return view('dash', $data);
    }


    public function dashboard()
    {
        $roles = Role::all();
        return view('dashboard', compact('roles'));
    }

    /**
     * Mengganti peran aktif dan mengarahkan ke halaman yang relevan.
     */
    public function selectRole($roleName)
    {
        $user = Auth::user();

        if (!$user->hasRole($roleName)) {
            return redirect()->route('dashboard')->with('error', 'Anda tidak memiliki akses ke peran tersebut.');
        }
        session(['selected_role' => $roleName]);

        return redirect()->route('dash')
                         ->with('success', 'Berhasil beralih ke peran ' . $roleName);
    }
    
    public function index()
    {
      
        $mainArticle = Article::with('category')->latest()->first();

        $latestArticles = Article::with('category')
            ->latest()
            ->when($mainArticle, function ($query) use ($mainArticle) {
                return $query->where('id', '!=', $mainArticle->id);
            })
            ->take(3)
            ->get();

        return view('public.home', compact('mainArticle', 'latestArticles'));
    }

    // Metode untuk About Us (bisa tetap di sini)
    public function showAboutUs()
    {
        return view('public.about');
    }
}
