@extends('backend.layouts.app')

@section('contents')
    <h1 class="h3 mb-4 text-gray-800">Edit User</h1>

    <form id="formEditUser" action="{{ route('users.update', $user->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <div class="row">
            <!-- Foto Preview -->
            <div class="col-md-4 mb-4">
                <div class="card shadow">
                    <div class="card-body text-center">
                        <h5 class="mb-3">Foto Profil</h5>
                        @if ($user->foto)
                            @if (Str::startsWith($user->foto, ['http://', 'https://']))
                                <img id="user-foto-preview" src="{{ $user->foto }}" 
                                    class="img-thumbnail foto-preview" 
                                    style="width: 100%; max-height: 300px; object-fit: cover;"
                                    alt="Preview Foto">
                            @else
                                <img id="user-foto-preview" src="{{ asset('storage/' . $user->foto) }}" 
                                    class="img-thumbnail foto-preview" 
                                    style="width: 100%; max-height: 300px; object-fit: cover;"
                                    alt="Preview Foto">
                            @endif
                        @else
                            <img id="user-foto-preview" src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&size=300" 
                                class="img-thumbnail foto-preview" 
                                style="width: 100%; max-height: 300px; object-fit: cover;"
                                alt="Preview Foto">
                        @endif

                        <input type="file" name="foto" class="form-control mt-3" onchange="previewFoto()" accept="image/*">
                        <small class="text-muted">Kosongkan jika tidak ingin mengubah foto.</small>
                    </div>
                </div>
            </div>

            <!-- Form Edit -->
            <div class="col-md-8">
                <div class="card shadow">
                    <div class="card-body">
                        <!-- Name -->
                        <div class="form-group">
                            <label for="name">Nama</label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                                value="{{ old('name', $user->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                                value="{{ old('email', $user->email) }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Role -->
                        <div class="form-group">
                            <label for="role">Role</label>
                            <select name="role" class="form-control @error('role') is-invalid @enderror">
                                <option value="user" {{ $user->role == 'user' ? 'selected' : '' }}>User</option>
                                <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                            </select>
                            @error('role')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Password -->
                        <div class="form-group">
                            <label for="password">Password Baru</label>
                            <input type="password" name="password"
                                class="form-control @error('password') is-invalid @enderror"
                                placeholder="Kosongkan jika tidak diubah">
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Tombol -->
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Simpan Perubahan
                        </button>
                        <a href="{{ route('users.index') }}" class="btn btn-secondary">Kembali</a>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
