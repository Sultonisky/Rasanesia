@extends('backend.layouts.app')

@section('contents')
    <h1 class="h3 mb-4 text-gray-800">Tambah Favorit</h1>

    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="{{ route('admin.favorites.store') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label for="user_id">Pilih Pengguna</label>
                    <select name="user_id" id="user_id" class="form-control @error('user_id') is-invalid @enderror" required>
                        <option value="">-- Pilih Pengguna --</option>
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
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
                            <option value="{{ $recipe->id }}" {{ old('recipe_id') == $recipe->id ? 'selected' : '' }}>
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
                        <i class="fas fa-save"></i> Simpan
                    </button>
                    <a href="{{ route('admin.favorites.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                </div>
            </form>
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