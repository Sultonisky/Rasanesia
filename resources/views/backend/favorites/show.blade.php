@extends('backend.layouts.app')

@section('contents')
    <h1 class="h3 mb-4 text-gray-800">Detail Favorit</h1>

    <div class="row">
        <div class="col-md-6 mb-4">
            <div class="card shadow">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-user"></i> Informasi Pengguna</h5>
                </div>
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        @if ($favorite->user->foto)
                            <img src="{{ asset('storage/' . $favorite->user->foto) }}" 
                                class="rounded-circle mr-3" width="80" height="80" 
                                style="object-fit: cover;">
                        @else
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($favorite->user->name) }}&size=80" 
                                class="rounded-circle mr-3">
                        @endif
                        <div>
                            <h5 class="mb-1">{{ $favorite->user->name }}</h5>
                            <p class="text-muted mb-1">{{ $favorite->user->email }}</p>
                            <span class="badge badge-{{ $favorite->user->role == 'admin' ? 'danger' : 'primary' }}">
                                {{ ucfirst($favorite->user->role) }}
                            </span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <small class="text-muted">Bergabung Sejak</small>
                            <p class="mb-0">{{ $favorite->user->created_at->format('d M Y') }}</p>
                        </div>
                        <div class="col-6">
                            <small class="text-muted">Email Terverifikasi</small>
                            <p class="mb-0">
                                @if($favorite->user->email_verified_at)
                                    <span class="badge badge-success">Ya</span>
                                @else
                                    <span class="badge badge-warning">Belum</span>
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 mb-4">
            <div class="card shadow">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-utensils"></i> Informasi Resep</h5>
                </div>
                <div class="card-body">
                    <div class="text-center mb-3">
                        @if ($favorite->recipe->foto)
                            @if (Str::startsWith($favorite->recipe->foto, ['http://', 'https://']))
                                <img src="{{ $favorite->recipe->foto }}" 
                                    class="img-fluid rounded" style="max-height: 200px; object-fit: cover;">
                            @else
                                <img src="{{ asset('storage/' . $favorite->recipe->foto) }}" 
                                    class="img-fluid rounded" style="max-height: 200px; object-fit: cover;">
                            @endif
                        @else
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($favorite->recipe->name) }}&size=200" 
                                class="img-fluid rounded">
                        @endif
                    </div>
                    <h5 class="mb-2">{{ $favorite->recipe->name }}</h5>
                    <p class="text-muted mb-2">{{ Str::limit($favorite->recipe->description, 150) }}</p>
                    <div class="row">
                        <div class="col-6">
                            <small class="text-muted">Asal Daerah</small>
                            <p class="mb-0">{{ $favorite->recipe->province ?? 'Tidak ada' }}</p>
                        </div>
                        <div class="col-6">
                            <small class="text-muted">Dibuat Oleh</small>
                            <p class="mb-0">{{ $favorite->recipe->user->name ?? 'Tidak ada' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header">
            <h5 class="mb-0"><i class="fas fa-info-circle"></i> Informasi Favorit</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <small class="text-muted">Tanggal Dibuat</small>
                    <p class="mb-0">{{ $favorite->created_at->format('d M Y H:i:s') }}</p>
                </div>
                <div class="col-md-6">
                    <small class="text-muted">Terakhir Diperbarui</small>
                    <p class="mb-0">{{ $favorite->updated_at->format('d M Y H:i:s') }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="text-center">
        <a href="{{ route('admin.favorites.edit', $favorite->id) }}" class="btn btn-warning">
            <i class="fas fa-edit"></i> Edit
        </a>
        <a href="{{ route('admin.favorites.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali ke Daftar
        </a>
    </div>
@endsection 