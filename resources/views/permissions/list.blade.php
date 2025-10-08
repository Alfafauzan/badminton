@extends('layouts.app')
@section('title', 'Permissions')
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
                    <button type="button" class=" btn btn-primary mx-2 px-3 py-2 rounded" data-toggle="modal"
                        data-target="#exampleModal">
                        Create
                        @yield('title')
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


                    {{-- isi content --}}
                    <table class="table table-striped table-bordered w-100">
                        <thead class="table-light">
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Name</th>
                                <th scope="col">Created</th>
                                <th scope="col" class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($permissions->isNotEmpty())
                                @foreach ($permissions as $permission)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $permission->name }}</td>
                                        <td>{{ \Carbon\Carbon::parse($permission->created_at)->format('d M, Y') }}</td>
                                        <td class="text-center">
                                            <a href="{{ route('permissions.edit', $permission->id) }}"
                                                class="btn btn-warning btn-sm me-2 text-white">
                                                Edit
                                            </a>

                                            <a href="javascript:void(0);" onclick="deletePermission({{ $permission->id }})"
                                                class="btn btn-danger btn-sm">
                                                Delete
                                            </a>

                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                    {{ $permissions->links() }}
                    {{-- Akhir Content --}}
                </div>
                {{-- End Card Body --}}
            </div>
            <!-- End Card -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    @include('permissions.create')

    <script type="text/javascript">
        function deletePermission(id) {
            if (confirm("Apa kamu yakin ingin menghapus nya?")) {
                $.ajax({
                    url: "{{ route('permissions.destroy') }}",
                    type: 'delete',
                    data: {
                        id: id
                    },
                    dataType: 'json',
                    headers: {
                        'x-csrf-token': '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        window.location.href = '{{ route('permissions.index') }}'
                    }
                });
            }
        }
    </script>


@endsection
