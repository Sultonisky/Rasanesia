@extends('backend.layouts.app')

@section('contents')
    <h1 class="h3 mb-4 text-gray-800">Edit Favorit</h1>

    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="{{ route('admin.favorites.update', $favorite->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="user_id">Pilih Pengguna</label>
                    <select name="user_id" id="user_id" class="form-control @error('user_id') is-invalid @enderror" required>
                        <option value="">-- Pilih Pengguna --</option>
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}" {{ old('user_id', $favorite->user_id) == $user->id ? 'selected' : '' }}>
                                {{ $user->name }} ({{ $user->email }})
                            </option>
                        @endforeach
                    </select>
                    @error('user_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="recipe_id">Pilih Resep</label>
                    <select name="recipe_id" id="recipe_id" class="form-control @error('recipe_id') is-invalid @enderror" required>
                        <option value="">-- Pilih Resep --</option>
                        @foreach ($recipes as $recipe)
                            <option value="{{ $recipe->id }}" {{ old('recipe_id', $favorite->recipe_id) == $recipe->id ? 'selected' : '' }}>
                                {{ $recipe->name }} {{ $recipe->province ? '(' . $recipe->province . ')' : '' }}
                            </option>
                        @endforeach
                    </select>
                    @error('recipe_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Perbarui
                    </button>
                    <a href="{{ route('admin.favorites.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Preview Card -->
    <div class="card shadow">
        <div class="card-header">
            <h5 class="mb-0"><i class="fas fa-eye"></i> Preview Favorit Saat Ini</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <h6>Pengguna:</h6>
                    <div class="d-flex align-items-center">
                        @if ($favorite->user->foto)
                            <img src="{{ asset('storage/' . $favorite->user->foto) }}" 
                                class="rounded-circle mr-2" width="40" height="40" 
                                style="object-fit: cover;">
                        @else
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($favorite->user->name) }}&size=40" 
                                class="rounded-circle mr-2">
                        @endif
                        <div>
                            <div class="font-weight-bold">{{ $favorite->user->name }}</div>
                            <small class="text-muted">{{ $favorite->user->email }}</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <h6>Resep:</h6>
                    <div class="d-flex align-items-center">
                        @if ($favorite->recipe->foto)
                            @if (Str::startsWith($favorite->recipe->foto, ['http://', 'https://']))
                                <img src="{{ $favorite->recipe->foto }}" 
                                    class="rounded mr-2" width="40" height="40" 
                                    style="object-fit: cover;">
                            @else
                                <img src="{{ asset('storage/' . $favorite->recipe->foto) }}" 
                                    class="rounded mr-2" width="40" height="40" 
                                    style="object-fit: cover;">
                            @endif
                        @else
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($favorite->recipe->name) }}&size=40" 
                                class="rounded mr-2">
                        @endif
                        <div>
                            <div class="font-weight-bold">{{ $favorite->recipe->name }}</div>
                            <small class="text-muted">{{ $favorite->recipe->province ?? 'Tidak ada daerah' }}</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Initialize select2 for better UX
    $('#user_id, #recipe_id').select2({
        placeholder: "Pilih opsi...",
        allowClear: true
    });
});
</script>
@endpush 