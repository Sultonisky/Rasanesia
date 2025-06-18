@extends('backend.layouts.app')

@section('title', 'Detail User')

@section('contents')
    <h1 class="h3 mb-4 text-gray-800">Detail User</h1>

    <div class="row">
        <!-- Foto -->
        <div class="col-md-4 mb-3">
            <div class="card shadow text-center">
                <div class="card-body">
                    <h5 class="mb-3">Foto Profil</h5>
                    @if ($user->foto)
                        <img src="{{ asset('storage/' . $user->foto) }}" class="img-fluid rounded"
                            style="max-height: 300px; object-fit: cover;">
                    @else
                        <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}" class="img-fluid rounded"
                            style="max-height: 300px; object-fit: cover;">
                    @endif
                </div>
            </div>
        </div>

        <!-- Info User -->
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-body">
                    <h5 class="card-title">Informasi Lengkap</h5>
                    <table class="table table-borderless">
                        <tr>
                            <th>Nama</th>
                            <td>{{ $user->name }}</td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td>{{ $user->email }}</td>
                        </tr>
                        <tr>
                            <th>Role</th>
                            <td>
                                <span class="badge badge-{{ $user->role == 'admin' ? 'primary' : 'secondary' }}">
                                    {{ ucfirst($user->role) }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <th>Terdaftar Sejak</th>
                            <td>{{ $user->created_at->format('d M Y, H:i') }}</td>
                        </tr>
                    </table>

                    <a href="{{ route('users.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
