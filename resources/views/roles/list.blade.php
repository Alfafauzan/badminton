@extends('layouts.app')
@section('title', 'Roles')

@section('content')
    <!-- Content Wrapper -->
    <div class="content-wrapper">

        <!-- Page Header -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1><i class="fas fa-user mx-2"></i> @yield('title')</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#"><i class="nav-icon fas fa-home"></i> Dashboard</a>
                            </li>
                            <li class="breadcrumb-item active">@yield('title')</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>
        {{-- End Header --}}

        <!-- Main Content -->
        <section class="content">
            <div class="card">
                <div class="card-header d-flex justify-content-end">
                    <button type="button" class=" btn btn-primary mx-2 px-3 py-2 rounded" data-toggle="modal"
                        data-target="#CreateRole">
                        Create
                        @yield('title')
                    </button>
                </div>
                <div class="card-body">

                    {{-- Pesan Kesalahan --}}
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
                    {{-- End Pesan Kesalahan --}}

                    {{-- Isi  --}}
                    <table class="table table-bordered table-striped w-100">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Permission</th>
                                <th>Guard</th>
                                <th>Created</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($role as $index => $roles)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $roles->name }}</td>
                                    <td>{{ $roles->permissions->pluck('name')->implode(', ') }}</td>
                                    <td>{{ $roles->guard_name }}</td>
                                    <td>{{ \Carbon\Carbon::parse($roles->created_at)->format('d M, Y') }}</td>
                                    <td class="text-center">
                                        <a class="btn btn-warning btn-sm me-2 text-white"
                                            href="{{ route('role.edit', $roles->id) }}">Edit</a>

                                        <a href="javascript:void(0);" onclick="deleteRole({{ $roles->id }})"
                                            class="btn btn-sm btn-danger">Delete</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{-- End Isi  --}}

                    {{ $role->links() }}

                </div>
                {{-- End Card Body --}}
            </div>
            {{-- End Card --}}
        </section>
        {{-- End Main Content --}}
    </div>
    {{-- End Wrapper --}}

    @include('roles.create')
    <script type="text/javascript">
        function deleteRole(id) {
            if (confirm("Apa kamu yakin ingin menghapus nya?")) {
                $.ajax({
                    url: "{{ route('role.destroy') }}",
                    type: 'delete',
                    data: {
                        id: id
                    },
                    dataType: 'json',
                    headers: {
                        'x-csrf-token': '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        window.location.href = '{{ route('role.index') }}'
                    }
                });
            }
        }
    </script>

@endsection
