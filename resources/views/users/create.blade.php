<!-- Modal Create User -->
<div class="modal fade" id="CreateUsers" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
      <div class="modal-content">
          <div class="modal-header">
              <h5 class="modal-title">Create Users</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
              </button>
          </div>
          <form action="{{ route('users.store') }}" method="post">
              @csrf
              <div class="modal-body">
                  <div class="flex flex-col">
                      <label for="name">Name</label>
                      <div class="my-2">
                          <input type="text" name="name" value="{{ old('name') }}"
                              class="w-full form-control border-gray-400 rounded" placeholder="Masukan nama user">
                          @error('name')
                              <div class="text-danger mt-1">{{ $message }}</div>
                          @enderror
                      </div>

                      <label for="email">Email</label>
                      <div class="my-2">
                          <input type="email" name="email" value="{{ old('email') }}"
                              class="w-full form-control border-gray-400 rounded" placeholder="Masukan email user">
                          @error('email')
                              <div class="text-danger mt-1">{{ $message }}</div>
                          @enderror
                      </div>

                      <label for="role">Roles</label>
                      <div class="my-2">
                          <select name="role" class="form-control" required>
                              <option value="">-- Pilih Role --</option>
                              @foreach ($roles as $role)
                                  <option value="{{ $role->id }}"
                                      {{ old('role') == $role->id ? 'selected' : '' }}>
                                      {{ $role->name }}
                                  </option>
                              @endforeach
                          </select>
                          @error('role')
                              <div class="text-danger mt-1">{{ $message }}</div>
                          @enderror
                      </div>
                  </div>
              </div>
              <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                  <button type="submit" class="btn btn-primary">Create</button>
              </div>
          </form>
      </div>
  </div>
</div>
