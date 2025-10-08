@extends('layouts.app')
@section('title', 'Permissions')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>@yield('title')</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#"><i class="nav-icon fas fa-home"></i> Dashboard</a>
                            </li>
                            <li class="breadcrumb-item active">@yield('title')</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">

            <!-- Default box -->
            <div class="card">
                <div class="card-header ">
                    <a class="btn btn-secondary mx-2 px-3 py-2 rounded" href="{{ route('permissions.index') }}">
                        <i class="fas fa-backward"></i> Back To @yield('title')
                    </a>
                </div>
                <div class="card-body">

                    {{-- isi content --}}
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-4">
                        <form action="{{ route('permissions.update', $permission->id) }}" method="post">
                            @csrf


                            <div class="mb-3">
                                <label for="name" class="form-label">Nama</label>
                                <input type="text" name="name" id="name"
                                    value="{{ old('name', $permission->name) }}"
                                    class="form-control @error('name') is-invalid @enderror"
                                    placeholder="Masukan nama permission" style="max-width: 500px;">
                                @error('name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-primary">
                                Update
                            </button>
                        </form>
                    </div>
                    {{-- Akhir Content --}}
                </div>

            </div>
            <!-- /.card -->

        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection
