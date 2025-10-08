<?php

use App\Http\Controllers\ActivityLogController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\ArticlePageController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\Api\CovidDataController; // <-- Import controller kita

Route::get('/dashboard-covid', [CovidDataController::class, 'showDashboard']);

// Halaman awal saat di buka

Route::get('/', [HomeController::class, 'index'])->name('home');

// Rute untuk halaman daftar artikel dan filter per kategori
Route::get('/article', [ArticlePageController::class, 'index'])->name('article.index');

// DIUBAH: :slug dihapus, sekarang menggunakan ID secara default
Route::get('/article/category/{category}', [ArticlePageController::class, 'showByCategory'])->name('article.by_category');

// DIUBAH: :slug dihapus, sekarang menggunakan ID secara default
Route::get('/article/{article}', [ArticlePageController::class, 'show'])->name('article.show');

// Rute untuk halaman About Us
Route::get('/about-us', [HomeController::class, 'showAboutUs'])->name('about');

// Auth
// login
// routes/web.php

// Kelompokkan rute yang hanya boleh diakses oleh GUEST (pengunjung)
Route::middleware(['guest'])->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});


// Tambahkan ini di dalam grup middleware auth
Route::middleware(['auth','role.access'])->group(function () {

    Route::get('/select-role/{roleName}', [HomeController::class, 'selectRole'])->name('role.select');
    Route::get('/dashboard', [HomeController::class, 'dashboard'])->name('dashboard');
    

    // Halaman Utama Management User
    Route::get('/home', [HomeController::class, 'home'])->name('dash');

    Route::get('/activity-log', [ActivityLogController::class, 'index'])->name('activity.index');
    Route::post('/activity-log/restore/{activity}', [ActivityLogController::class, 'restore'])->name('activity.restore');

    // permissions
    Route::get('/permissions', [PermissionController::class, 'index'])->name('permissions.index');
    Route::get('/permissions/create', [PermissionController::class, 'create'])->name('permissions.create');
    Route::post('/permissions', [PermissionController::class, 'store'])->name('permissions.store');
    Route::get('/permissions/{id}/edit', [PermissionController::class, 'edit'])->name('permissions.edit');
    Route::post('/permissions/{id}', [PermissionController::class, 'update'])->name('permissions.update');
    Route::delete('/permissions', [PermissionController::class, 'destroy'])->name('permissions.destroy');

    // Role
    Route::get('/role', [RoleController::class, 'index'])->name('role.index');
    Route::get('/role/create', [RoleController::class, 'create'])->name('role.create');
    Route::post('/role', [RoleController::class, 'store'])->name('role.store');
    Route::get('/role/{id}/edit', [RoleController::class, 'edit'])->name('role.edit');
    Route::post('/role/{id}', [RoleController::class, 'update'])->name('role.update');
    Route::delete('/role', [RoleController::class, 'destroy'])->name('role.destroy');

    //  //article
    Route::get('/articles', [ArticleController::class, 'index'])->name('articles.index');
    Route::get('/articles/create', [ArticleController::class, 'create'])->name('articles.create');
    Route::post('/articles', [ArticleController::class, 'store'])->name('articles.store');
    Route::get('/articles/{id}/edit', [ArticleController::class, 'edit'])->name('articles.edit');
    Route::post('/articles/{id}', [ArticleController::class, 'update'])->name('articles.update');
    Route::delete('/articles', [ArticleController::class, 'destroy'])->name('articles.destroy');

    // Users
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::get('/users/{id}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::post('/users/{id}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users', [UserController::class, 'destroy'])->name('users.destroy');

    Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
    Route::get('/categories/create', [CategoryController::class, 'create'])->name('categories.create');
    Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
    Route::get('/categories/{id}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
    Route::post('/categories/{id}', [CategoryController::class, 'update'])->name('categories.update');
    Route::delete('/categories', [CategoryController::class, 'destroy'])->name('categories.destroy');

    
});
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');