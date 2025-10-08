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

                    <a class="btn btn-primary mx-2 px-3 py-2 rounded" href="{{ route('role.index') }}">Back To
                        @yield('title')<i class="fas fa-plus mx-2"></i></a>
                </div>
                <div class="card-body">

                    {{-- isi content --}}
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

                                <button type="submit" class="btn btn-primary">SUBMIT</button>
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
