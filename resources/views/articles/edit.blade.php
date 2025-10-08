@extends('layouts.app')
@section('title', 'Create Article')
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
                            <li class="breadcrumb-item"><a href="#"><i class="nav-icon fas fa-home"></i>Dashboard</a>
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
                    <a class="btn btn-secondary mx-2 px-3 py-2 rounded" href="{{ route('articles.index') }}">
                        <i class="fas fa-backward"></i> Back To @yield('title')
                    </a>
                </div>
                <div class="card-body">

                    {{-- isi content --}}
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-gray-900">
                            <form action="{{ route('articles.update', $article->id) }}" method="post"
                                enctype="multipart/form-data">
                                @csrf


                                <div class="form-group mb-3">
                                    <label for="title">Title</label>
                                    <input value="{{ old('title', $article->title) }}" type="text" name="title"
                                        class="form-control w-50" placeholder="Masukkan judul">
                                    @error('title')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="form-group mb-3">
                                    <label for="text">Content</label>
                                    <textarea name="text" class="form-control w-50" rows="6">{{ old('text', $article->text) }}</textarea>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="author">Author</label>
                                    <input value="{{ old('author', $article->author) }}" type="text" name="author"
                                        class="form-control w-50" placeholder="Masukkan nama author">
                                    @error('author')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="form-group mb-3">
                                    <label for="category_id">Category</label>
                                    <select name="category_id" class="form-control w-50" required>
                                        @foreach (\App\Models\Category::all() as $cat)
                                            <option value="{{ $cat->id }}"
                                                {{ old('category_id', $article->category_id) == $cat->id ? 'selected' : '' }}>
                                                {{ $cat->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <button class="btn btn-primary mt-2">Update</button>
                            </form>

                        </div>
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
