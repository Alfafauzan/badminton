@extends('layouts.app')
@section('title', 'Article')
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
                {{-- Bagian Atas Table --}}
                @rolecan('create articles')
                <div class="card-header d-flex justify-content-end">
                    <a class="btn btn-primary mx-2 px-3 py-2 rounded" href="{{ route('articles.create') }}">
                        Create @yield('title') <i class="fas fa-plus mx-1"></i>
                    </a>
                </div>
                @endrolecan

                {{-- End Bagian Atas Table --}}
                <div class="card-body">
                    @if (Session::has('Berhasil'))
                        <div class="alert alert-success">
                            {{ Session::get('Berhasil') }}
                        </div>
                    @endif
                    @if (Session::has('error'))
                        <div class="alert alert-danger">
                            {{ Session::get('error') }}
                        </div>
                    @endif

                    <table class="table table-bordered table-hover">
                        <thead class="thead-light">
                            <tr>
                                <th>#</th>
                                <th>Title</th>
                                <th>Author</th>
                                <th>Categories</th>
                                <th>Created</th>
                                <th>Images</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($articles as $article)
                                <tr>
                                    <td class="align-middle">{{ $loop->iteration }}</td>
                                    <td class="align-middle">{{ $article->title }}</td>
                                    <td class="align-middle">{{ $article->author }}</td>
                                    <td class="align-middle">
                                        {{ $article->category ? $article->category->name : 'Tanpa Kategori' }}</td>
                                    <td class="align-middle">
                                        {{ \Carbon\Carbon::parse($article->created_at)->format('d M, Y') }}</td>
                                    <td class="align-middle"><img src="{{ asset($article->image) }}"
                                            alt="{{ $article->title }}" width="50">
                                    </td>
                                    <td class="text-center align-middle">
                                        @can('edit articles')
                                            <a class="btn btn-warning btn-sm mx-1"
                                                href="{{ route('articles.edit', $article->id) }}">Edit</a>
                                        @endcan

                                        <a class="btn btn-danger btn-sm mx-1" href="javascript:void(0);"
                                            onclick="deleteArticle({{ $article->id }})">Delete</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    {{ $articles->links() }}
                </div>

                {{-- End Card Body --}}
            </div>
            <!-- End Card -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <script type="text/javascript">
        function deleteArticle(id) {
            if (confirm("Apa kamu yakin ingin menghapus nya?")) {
                $.ajax({
                    url: "{{ route('articles.destroy') }}",
                    type: 'delete',
                    data: {
                        id: id
                    },
                    dataType: 'json',
                    headers: {
                        'x-csrf-token': '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        window.location.href = '{{ route('articles.index') }}'
                    }
                });
            }
        }
    </script>

@endsection
