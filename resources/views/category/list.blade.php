@extends('layouts.app')
@section('title', 'Category')
@section('content')

    <div class="content-wrapper">
        {{-- Section Header --}}
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
            </div>
        </section>
        {{-- End Section Header --}}

        <!-- Main content -->
        <section class="content">
            <!-- Default box -->
            <div class="card">
                {{-- Bagian Atas Table --}}
                <div class="card-header d-flex justify-content-end">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#CreateCategory">
                        Create @yield('title')
                    </button>
                </div>

                {{-- End Bagian Atas Table --}}

                {{-- Pesan Kesalahan --}}
                <div class="card-body">
                    @if (Session::has('Berhasil'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ Session::get('Berhasil') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if (Session::has('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ Session::get('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    {{-- End Pesan Kesalahan --}}

                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Name</th>
                                <th>Created</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($categories->isNotEmpty())
                                @foreach ($categories as $i => $cat)
                                    <tr>
                                        <td>{{ $i + $categories->firstItem() }}</td>
                                        <td>{{ $cat->name }}</td>
                                        <td>{{ \Carbon\Carbon::parse($cat->created_at)->format('d M, Y') }}</td>
                                        <td class="text-center">
                                            <a href="{{ route('categories.edit', $cat->id) }}"
                                                class="btn btn-warning btn-sm">Edit</a>
                                            <button class="btn btn-danger btn-sm"
                                                onclick="deletePermission({{ $cat->id }})">Delete</button>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="4" class="text-center">Data belum tersedia</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>

                    {{ $categories->links() }}

                </div>
            </div>
            {{-- End Card Body --}}
    </div>
    <!-- End Card -->
    </section>
    <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    @include('category.create')

    <script type="text/javascript">
        function deletePermission(id) {
            if (confirm("Apa kamu yakin ingin menghapusnya?")) {
                $.ajax({
                    url: "{{ route('categories.destroy') }}",
                    type: 'DELETE',
                    data: {
                        id: id,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        window.location.reload();
                    }
                });
            }
        }
    </script>



@endsection
