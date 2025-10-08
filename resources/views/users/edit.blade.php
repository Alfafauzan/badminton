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
                <div class="card-header d-flex justify-content-end">

                    <a class="btn btn-primary mx-2 px-3 py-2 rounded" href="{{ route('users.index') }}">Back To
                        @yield('title')<i class="fas fa-plus mx-2"></i></a>
                </div>
                <div class="card-body">

                    {{-- isi content --}}
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-gray-900">
                            <form action="{{ route('users.update', $user->id) }}" method="post">
                                @csrf
                                <div class="flex flex-col">
                                    <label for="name">Nama</label>
                                    <div class="my-3">
                                        <input value="{{ old('name', $user->name) }}" type="text" name="name"
                                            id="" class="w-[500px] rounded rounded-s border-gray-400"
                                            placeholder="Masukan username">
                                        @error('name')
                                            <div class="text-red-400 font-medium">
                                                <p>{{ $message }}</p>
                                            </div>
                                        @enderror
                                    </div>
                                    <label for="name">Email</label>
                                    <div class="my-3">
                                        <input value="{{ old('email', $user->email) }}" type="text" name="email"
                                            id="" class="w-[500px] rounded rounded-s border-gray-400"
                                            placeholder="Masukan Email">
                                        @error('email')
                                            <div class="text-red-400 font-medium">
                                                <p>{{ $message }}</p>
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="grid grid-cols-4 mb-4">
                                    @if ($roles->isNotEmpty())
                                        @foreach ($roles as $role)
                                            <div class="mt-3">

                                                <input {{ $hasRole->contains($role->id) ? 'checked' : '' }} type="checkbox"
                                                    class="rounded" value="{{ $role->name }}" name="role[]"
                                                    id="role-{{ $role->id }}">
                                                <label for="role-{{ $role->id }}">{{ $role->name }}</label>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                                <button class="p-2 my-2 rounded-l bg-blue-500 text-white">SUBMIT</button>
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
<!-- Modal -->
{{-- <div class="modal fade" id="EditPermissions" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
      <div class="modal-content">
          <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Edit Role</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
              </button>
          </div>
          <div class="modal-body">
            <div class="card">
              <div class="card-body">
                  <form action="{{ route('role.update', $role->id) }}" method="post">
                      @csrf
                      <div class="mb-3">
                          <label for="name" class="form-label">Nama</label>
                          <input value="{{ old('name', $role->name) }}" type="text" name="name"
                              id="name" class="form-control w-50" placeholder="Masukan nama permission">
                          @error('name')
                              <div class="text-danger fw-semibold mt-1">
                                  <p>{{ $message }}</p>
                              </div>
                          @enderror
                      </div>

                      <div class="row mb-3">
                          @if ($permissions->isNotEmpty())
                              @foreach ($permissions as $permission)
                                  <div class="col-md-3">
                                      <div class="form-check">
                                          <input
                                              {{ $haspermissions->contains($permission->name) ? 'checked' : '' }}
                                              type="checkbox" class="form-check-input"
                                              value="{{ $permission->name }}" name="permission[]"
                                              id="permission-{{ $permission->id }}">
                                          <label class="form-check-label" for="permission-{{ $permission->id }}">
                                              {{ $permission->name }}
                                          </label>
                                      </div>
                                  </div>
                              @endforeach
                          @endif
                      </div>

              </div>
          </div>
          </div>
          <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button  type="submit" class="btn btn-primary">Update</button>
            </div>
          </form>
      </div>
  </div>
</div> --}}
