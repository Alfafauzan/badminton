@extends('layouts.app')
@section('title', 'Users')

@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Dashboard</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Dashboard</li>
                        </ol>
                    </div>
                </div>{{-- Menampilkan Notifikasi Sukses/Error dari Redirect --}}
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                @if (session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif

            </div>
        </div>
        <section class="content">
            <div class="container-fluid">
                <p>Menampilkan statistik untuk peran: <strong
                        class="text-primary">{{ session('selected_role', 'Default') }}</strong></p>

                <div class="row">

                    {{-- Boks Statistik untuk ADMIN --}}
                    @rolecan('view users')
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-warning">
                            <div class="inner">
                                <h3>{{ $userCount }}</h3>
                                <p>Total Pengguna</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-person-add"></i>
                            </div>
                            <a href="{{ route('users.index') }}" class="small-box-footer">Lihat Detail <i
                                    class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    @endrolecan

                    @rolecan('view roles')
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-danger">
                            <div class="inner">
                                <h3>{{ $roleCount }}</h3>
                                <p>Total Peran (Roles)</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-user-tag"></i>
                            </div>
                            <a href="{{ route('role.index') }}" class="small-box-footer">Lihat Detail <i
                                    class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    @endrolecan

                    @rolecan('view permissions')
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-secondary">
                            <div class="inner">
                                <h3>{{ $permissionCount }}</h3>
                                <p>Total Izin (Permissions)</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-key"></i>
                            </div>
                            <a href="{{ route('permissions.index') }}" class="small-box-footer">Lihat Detail <i
                                    class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    @endrolecan

                    {{-- Boks Statistik untuk WRITER --}}
                    @rolecan('view articles')
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-info">
                            <div class="inner">
                                <h3>{{ $articleCount }}</h3>
                                <p>Total Artikel</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-newspaper"></i>
                            </div>
                            <a href="{{ route('articles.index') }}" class="small-box-footer">Lihat Detail <i
                                    class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    @endrolecan

                    @rolecan('view categories')
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-success">
                            <div class="inner">
                                <h3>{{ $categoryCount }}</h3>
                                <p>Total Kategori</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-sitemap"></i>
                            </div>
                            <a href="{{ route('categories.index') }}" class="small-box-footer">Lihat Detail <i
                                    class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    @endrolecan
                    @rolecan('view activity log')
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-dark">
                            <div class="inner">
                                <h3>Log</h3>
                                <p>Activity Log</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-history"></i>
                            </div>
                            <a href="{{ route('activity.index') }}" class="small-box-footer">
                                Lihat Log <i class="fas fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>
                    @endrolecan

                </div>
            </div>
        </section>
    </div>
@endsection
