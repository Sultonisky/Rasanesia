@extends('frontend.layouts.app')

@section('title', 'Edit Resep - Rasanesia')

@section('styles')
<link rel="stylesheet" href="{{ asset('assets/css/frontend-recipes.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
@endsection

@section('content')
<div class="title">
    <div class="logo-container">
        <img src="{{ asset('assets/img/chef_hat.png') }}" alt="Logo" class="logo-img">
        <span class="logo-text">Edit Resep</span>
    </div>
</div>

<div class="recipe-form-container">
    <form action="{{ route('recipes.update', $recipe->id) }}" method="POST" enctype="multipart/form-data" class="recipe-form">
        @csrf
        @method('PUT')
        
        <div class="form-group">
            <label for="name">
                <i class="fas fa-utensils"></i>
                Nama Resep
            </label>
            <input type="text" id="name" name="name" value="{{ old('name', $recipe->name) }}" required class="form-control" placeholder="Masukkan nama resep yang menarik...">
            @error('name')
                <span class="error-message">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="description">
                <i class="fas fa-align-left"></i>
                Deskripsi
            </label>
            <textarea id="description" name="description" rows="3" required class="form-control" placeholder="Jelaskan tentang resep ini, rasa, dan keunikan yang membuatnya istimewa...">{{ old('description', $recipe->description) }}</textarea>
            @error('description')
                <span class="error-message">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="province">
                <i class="fas fa-map-marker-alt"></i>
                Provinsi (Opsional)
            </label>
            <select id="province" name="province" class="form-control">
                <option value="">Pilih Provinsi Asal Resep</option>
                <option value="Aceh" {{ old('province', $recipe->province) == 'Aceh' ? 'selected' : '' }}>Aceh</option>
                <option value="Sumatera Utara" {{ old('province', $recipe->province) == 'Sumatera Utara' ? 'selected' : '' }}>Sumatera Utara</option>
                <option value="Sumatera Barat" {{ old('province', $recipe->province) == 'Sumatera Barat' ? 'selected' : '' }}>Sumatera Barat</option>
                <option value="Riau" {{ old('province', $recipe->province) == 'Riau' ? 'selected' : '' }}>Riau</option>
                <option value="Kepulauan Riau" {{ old('province', $recipe->province) == 'Kepulauan Riau' ? 'selected' : '' }}>Kepulauan Riau</option>
                <option value="Jambi" {{ old('province', $recipe->province) == 'Jambi' ? 'selected' : '' }}>Jambi</option>
                <option value="Sumatera Selatan" {{ old('province', $recipe->province) == 'Sumatera Selatan' ? 'selected' : '' }}>Sumatera Selatan</option>
                <option value="Bangka Belitung" {{ old('province', $recipe->province) == 'Bangka Belitung' ? 'selected' : '' }}>Bangka Belitung</option>
                <option value="Bengkulu" {{ old('province', $recipe->province) == 'Bengkulu' ? 'selected' : '' }}>Bengkulu</option>
                <option value="Lampung" {{ old('province', $recipe->province) == 'Lampung' ? 'selected' : '' }}>Lampung</option>
                <option value="DKI Jakarta" {{ old('province', $recipe->province) == 'DKI Jakarta' ? 'selected' : '' }}>DKI Jakarta</option>
                <option value="Banten" {{ old('province', $recipe->province) == 'Banten' ? 'selected' : '' }}>Banten</option>
                <option value="Jawa Barat" {{ old('province', $recipe->province) == 'Jawa Barat' ? 'selected' : '' }}>Jawa Barat</option>
                <option value="Jawa Tengah" {{ old('province', $recipe->province) == 'Jawa Tengah' ? 'selected' : '' }}>Jawa Tengah</option>
                <option value="DI Yogyakarta" {{ old('province', $recipe->province) == 'DI Yogyakarta' ? 'selected' : '' }}>DI Yogyakarta</option>
                <option value="Jawa Timur" {{ old('province', $recipe->province) == 'Jawa Timur' ? 'selected' : '' }}>Jawa Timur</option>
                <option value="Bali" {{ old('province', $recipe->province) == 'Bali' ? 'selected' : '' }}>Bali</option>
                <option value="Nusa Tenggara Barat" {{ old('province', $recipe->province) == 'Nusa Tenggara Barat' ? 'selected' : '' }}>Nusa Tenggara Barat</option>
                <option value="Nusa Tenggara Timur" {{ old('province', $recipe->province) == 'Nusa Tenggara Timur' ? 'selected' : '' }}>Nusa Tenggara Timur</option>
                <option value="Kalimantan Barat" {{ old('province', $recipe->province) == 'Kalimantan Barat' ? 'selected' : '' }}>Kalimantan Barat</option>
                <option value="Kalimantan Tengah" {{ old('province', $recipe->province) == 'Kalimantan Tengah' ? 'selected' : '' }}>Kalimantan Tengah</option>
                <option value="Kalimantan Selatan" {{ old('province', $recipe->province) == 'Kalimantan Selatan' ? 'selected' : '' }}>Kalimantan Selatan</option>
                <option value="Kalimantan Timur" {{ old('province', $recipe->province) == 'Kalimantan Timur' ? 'selected' : '' }}>Kalimantan Timur</option>
                <option value="Kalimantan Utara" {{ old('province', $recipe->province) == 'Kalimantan Utara' ? 'selected' : '' }}>Kalimantan Utara</option>
                <option value="Sulawesi Utara" {{ old('province', $recipe->province) == 'Sulawesi Utara' ? 'selected' : '' }}>Sulawesi Utara</option>
                <option value="Gorontalo" {{ old('province', $recipe->province) == 'Gorontalo' ? 'selected' : '' }}>Gorontalo</option>
                <option value="Sulawesi Tengah" {{ old('province', $recipe->province) == 'Sulawesi Tengah' ? 'selected' : '' }}>Sulawesi Tengah</option>
                <option value="Sulawesi Barat" {{ old('province', $recipe->province) == 'Sulawesi Barat' ? 'selected' : '' }}>Sulawesi Barat</option>
                <option value="Sulawesi Selatan" {{ old('province', $recipe->province) == 'Sulawesi Selatan' ? 'selected' : '' }}>Sulawesi Selatan</option>
                <option value="Sulawesi Tenggara" {{ old('province', $recipe->province) == 'Sulawesi Tenggara' ? 'selected' : '' }}>Sulawesi Tenggara</option>
                <option value="Maluku" {{ old('province', $recipe->province) == 'Maluku' ? 'selected' : '' }}>Maluku</option>
                <option value="Maluku Utara" {{ old('province', $recipe->province) == 'Maluku Utara' ? 'selected' : '' }}>Maluku Utara</option>
                <option value="Papua" {{ old('province', $recipe->province) == 'Papua' ? 'selected' : '' }}>Papua</option>
                <option value="Papua Barat" {{ old('province', $recipe->province) == 'Papua Barat' ? 'selected' : '' }}>Papua Barat</option>
            </select>
            @error('province')
                <span class="error-message">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="ingredients">
                <i class="fas fa-shopping-basket"></i>
                Bahan-bahan
            </label>
            <textarea id="ingredients" name="ingredients" rows="6" required class="form-control" placeholder="Masukkan bahan-bahan yang diperlukan dengan format yang jelas...&#10;&#10;Contoh:&#10;- 500g daging sapi&#10;- 2 siung bawang putih&#10;- 1 sendok makan garam">{{ old('ingredients', $recipe->ingredients) }}</textarea>
            @error('ingredients')
                <span class="error-message">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="steps">
                <i class="fas fa-list-ol"></i>
                Langkah-langkah
            </label>
            <textarea id="steps" name="steps" rows="8" required class="form-control" placeholder="Masukkan langkah-langkah memasak secara berurutan...&#10;&#10;Contoh:&#10;1. Panaskan minyak dalam wajan&#10;2. Tumis bawang putih hingga harum&#10;3. Masukkan daging dan aduk rata">{{ old('steps', $recipe->steps) }}</textarea>
            @error('steps')
                <span class="error-message">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="foto">
                <i class="fas fa-camera"></i>
                Foto Resep (Opsional)
            </label>
            @if($recipe->foto)
                <div class="current-photo">
                    <img src="{{ asset('storage/' . $recipe->foto) }}" alt="Foto resep saat ini" class="recipe-photo">
                    <p>Foto saat ini</p>
                </div>
            @endif
            <input type="file" id="foto" name="foto" accept="image/*" class="form-control">
            <small class="form-text">
                <i class="fas fa-info-circle"></i>
                Format: JPG, PNG, JPEG. Maksimal 2MB. Biarkan kosong jika tidak ingin mengubah foto.
            </small>
            @error('foto')
                <span class="error-message">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i>
                Simpan Perubahan
            </button>
            <a href="{{ route('my-recipes') }}" class="btn btn-secondary">
                <i class="fas fa-times"></i>
                Batal
            </a>
        </div>
    </form>
</div>
@endsection