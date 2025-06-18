@extends('backend.layouts.app')

@section('contents')
    <h1 class="h3 mb-4 text-gray-800">Tambah User</h1>

    <div class="row">
        <!-- Foto Preview -->
        <div class="col-md-4 mb-4">
            <div class="card shadow">
                <div class="card-body text-center">
                    <h5 class="mb-3">Foto Profil</h5>
                    <img src="https://ui-avatars.com/api/?name=User" class="img-thumbnail foto-preview"
                        style="width: 100%; max-height: 300px; object-fit: cover;" alt="Preview Foto">

                    <input type="file" name="foto" class="form-control mt-3" onchange="previewFoto()">
                    <small class="text-muted">Opsional, bisa ditambahkan nanti.</small>
                </div>
            </div>
        </div>

        <!-- Form Create -->
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-body">
                    <form id="formCreateUser" action="{{ route('users.store') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf

                        <!-- Name -->
                        <div class="form-group">
                            <label for="name">Nama</label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                                value="{{ old('name') }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                                value="{{ old('email') }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Role -->
                        <div class="form-group">
                            <label for="role">Role</label>
                            <select name="role" class="form-control @error('role') is-invalid @enderror">
                                <option value="user" {{ old('role') == 'user' ? 'selected' : '' }}>User</option>
                                <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                            </select>
                            @error('role')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Password -->
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" name="password"
                                class="form-control @error('password') is-invalid @enderror" required>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Tombol -->
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-plus-circle"></i> Simpan
                        </button>
                        <a href="{{ route('users.index') }}" class="btn btn-secondary">Kembali</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
