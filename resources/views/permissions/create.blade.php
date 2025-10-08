<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Create Permission</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="bg-white p-3 rounded shadow-sm">
                    <form action="{{ route('permissions.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label">Nama</label>
                            <input value="{{ old('name') }}" type="text" name="name"
                                class="form-control w-50 @error('name') is-invalid @enderror"
                                placeholder="Masukan nama permission">
                            @error('name')
                                <div class="text-danger mt-1">
                                    <small>{{ $message }}</small>
                                </div>
                            @enderror
                        </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Crate</button>
                </form>
            </div>
        </div>
    </div>
</div>
