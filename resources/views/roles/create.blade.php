
<div class="modal fade" id="CreateRole" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Create Role</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <form action="{{ route('role.store') }}" method="post">
                            @csrf

                            {{-- Input Nama --}}
                            <div class="mb-3">
                                <label for="name" class="form-label">Nama</label>
                                <input value="{{ old('name') }}" type="text" name="name" id="name"
                                    class="form-control" placeholder="Masukkan nama permission">
                                @error('name')
                                    <div class="text-danger mt-1">
                                        <small>{{ $message }}</small>
                                    </div>
                                @enderror
                            </div>

                            {{-- Daftar Permission --}}
                            <div class="mb-3">
                                <label class="form-label">Permissions</label>
                                <div class="row">
                                    @if ($permissions->isNotEmpty())
                                        @foreach ($permissions as $permission)
                                            <div class="col-md-3">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="permission[]"
                                                        value="{{ $permission->name }}"
                                                        id="permission-{{ $permission->id }}">
                                                    <label class="form-check-label"
                                                        for="permission-{{ $permission->id }}">
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
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Crate</button>
              </div>
            </form>
        </div>
    </div>
</div>
