@extends('backend.layouts.app')


@section('contents')
    <h1 class="h3 mb-4 text-gray-800">Edit Resep</h1>

    <form action="{{ route('admin.recipes.update', $recipe->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="row">
            <div class="col-md-4 mb-4">
                <div class="card shadow">
                    <div class="card-body text-center">
                        <h5 class="mb-3">Foto Resep</h5>
                        <img id="recipe-foto-preview" src="{{ $recipe->foto ? (Str::startsWith($recipe->foto, ['http://', 'https://']) ? $recipe->foto : asset('storage/' . $recipe->foto)) : 'https://ui-avatars.com/api/?name=' . urlencode($recipe->name) . '&size=300' }}"
                            class="img-thumbnail foto-preview"
                            style="width: 100%; max-height: 300px; object-fit: cover;" alt="Preview Foto">

                        <input type="file" name="foto" class="form-control mt-3" onchange="previewFoto()"
                            accept="image/*">
                        <small class="text-muted">Kosongkan jika tidak ingin mengubah foto.</small>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="card shadow">
                    <div class="card-body">
                        <div class="form-group">
                            <label>Nama Resep</label>
                            <input type="text" name="name" class="form-control" value="{{ $recipe->name }}" required>
                        </div>

                        <div class="form-group">
                            <label>Deskripsi</label>
                            <textarea name="description" class="form-control" rows="3" required>{{ $recipe->description }}</textarea>
                        </div>

                        <div class="form-group">
                            <label>Bahan-Bahan</label>
                            <textarea name="ingredients" class="form-control" rows="4" required>{{ $recipe->ingredients }}</textarea>
                        </div>

                        <div class="form-group">
                            <label>Langkah-langkah</label>
                            <textarea name="steps" class="form-control" rows="4" required>{{ $recipe->steps }}</textarea>
                        </div>

                        <div class="form-group">
                            <label>Provinsi</label>
                            <input type="text" name="province" class="form-control" value="{{ $recipe->province }}"
                                placeholder="Contoh: Jawa Barat">
                        </div>

                        <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Perbarui</button>
                        <a href="{{ route('admin.recipes.index') }}" class="btn btn-secondary">Kembali</a>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
