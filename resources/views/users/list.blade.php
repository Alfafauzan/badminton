@extends('layouts.app')
@section('title', 'Users')

@section('content')
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

        <!-- Main Content -->
        <section class="content">
            <div class="card">
                <div class="card-header d-flex justify-content-end">
                    <button type="button" class=" btn btn-primary mx-2 px-3 py-2 rounded" data-toggle="modal"
                        data-target="#CreateUsers">
                        Create
                        @yield('title')
                        <i class="fas fa-plus mx-1"></i>
                    </button>
                </div>
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
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Roles</th>
                                <th>Created</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($users->isNotEmpty())
                                @foreach ($users as $user)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $user->roles->pluck('name')->implode(', ') }}</td>
                                        <td>{{ \Carbon\Carbon::parse($user->created_at)->format('d M, Y') }}</td>
                                        <td class="text-center">
                                            <a class="btn btn-warning btn-sm me-2"
                                                href="{{ route('users.edit', $user->id) }}">Edit</a>
                                            <button class="btn btn-danger btn-sm"
                                                onclick="deleteuser({{ $user->id }})">Delete</button>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="6" class="text-center">No users found.</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>

                    {{-- Bootstrap pagination --}}
                    {{ $users->links('pagination::bootstrap-4') }}
                </div>
            </div>
        </section>
    </div>

    {{-- Modal Create --}}
    @include('users.create')

    {{-- Delete Script --}}
    <script type="text/javascript">
        function deleteuser(id) {
            if (confirm("Apa kamu yakin ingin menghapus nya?")) {
                $.ajax({
                    url: "{{ route('users.destroy') }}",
                    type: 'delete',
                    data: {
                        id: id
                    },
                    dataType: 'json',
                    headers: {
                        'x-csrf-token': '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        window.location.href = '{{ route('users.index') }}'
                    }
                });
            }
        }
    </script>
@endsection
