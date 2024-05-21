  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
  <div class="text-center mb-4">
      <h3 class="mb-2 modal-title">Edit User</h3>
  </div>
  <form class="row g-3" method="post" action="{{ route('user.update', $data->id) }}">
      @csrf
      @method('PUT')
      <input type="hidden" name="password" value="{{ $data->password }}">
      <div class="col-12 col-md-6">
          <label class="form-label">Name</label>
          <input type="text" name="name" class="form-control" placeholder="Enter Text" value="{{ $data->name }}"
              required />
      </div>
      <div class="col-12 col-md-6">
          <label class="form-label">Username</label>
          <input type="text" name="username" class="form-control" placeholder="Enter Text"
              value="{{ $data->username }}" required />
      </div>
      <div class="col-12 col-md-6">
          <label class="form-label">Email</label>
          <input type="email" name="email" class="form-control" placeholder="example@domain.com"
              value="{{ $data->email }}" required />
      </div>
      <div class="col-12 col-md-6">
          <label class="form-label">Password</label>
          <input type="password" name="password2" class="form-control" placeholder="*****" />
          <small class="text-danger">Kosongkan jika tidak ingin merubah password</small>
      </div>
      <div class="col-12 col-md-6">
          <label class="form-label">Role</label>
          <select name="role" class="form-control" required>
              <option value="">-- Pilih --</option>
              @foreach ($role as $r)
                  <option value="{{ $r->name }}"
                      {{ $r->name == ($data->roles[0]->name ?? null) ? 'selected' : '' }}>
                      {{ ucwords($r->name) }}</option>
              @endforeach

          </select>
      </div>
      <div class="col-12 col-md-6">
          <label class="form-label">Status</label>
          <select name="status" class="form-control" required>
              <option value="">-- Pilih --</option>
              <option value="0" {{ $data->status == '0' ? 'selected' : '' }}>Pending</option>
              <option value="1" {{ $data->status == '1' ? 'selected' : '' }}>Active</option>
              <option value="2" {{ $data->status == '2' ? 'selected' : '' }}>Inactive</option>
          </select>
      </div>
      <div class="col-12 col-md-6">
          <label class="form-label">Sekolah</label>
          <select name="sekolah_id" class="form-control">
              <option value="">-- Pilih --</option>
              @foreach ($sekolah as $r)
                  <option value="{{ $r->id }}"
                      @if ($data->sekolah) {{ $data->sekolah->id == $r->id ? 'selected' : '' }} @endif>
                      {{ $r->nama }}</option>
              @endforeach
          </select>
      </div>


      <div class="col-12 text-center">
          <button type="submit" class="btn btn-primary me-sm-3 me-1">Submit</button>
          <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="modal" aria-label="Close">
              Cancel
          </button>
      </div>
  </form>
