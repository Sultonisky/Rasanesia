@extends('backend.layouts.app')


@section('contents')
    <h1 class="h3 mb-4 text-gray-800">Detail Resep</h1>

    <div class="row">
        <div class="col-md-5 mb-4">
            <div class="card shadow">
                <div class="card-body text-center">
                    @if ($recipe->foto)
                        @if (Str::startsWith($recipe->foto, ['http://', 'https://']))
                            <img src="{{ $recipe->foto }}" class="img-fluid rounded mb-3" style="max-height: 300px; object-fit: cover;">
                        @else
                            <img src="{{ asset('storage/' . $recipe->foto) }}" class="img-fluid rounded mb-3" style="max-height: 300px; object-fit: cover;">
                        @endif
                    @else
                        <img src="https://via.placeholder.com/400x300?text=Tidak+Ada+Foto" class="img-fluid rounded mb-3">
                    @endif
                    <h4 class="font-weight-bold">{{ $recipe->name }}</h4>
                    <p class="text-muted">Dibuat oleh: {{ $recipe->user->name ?? '-' }}</p>
                    <a href="{{ route('admin.recipes.index') }}" class="btn btn-secondary btn-sm">← Kembali ke daftar</a>
                </div>
            </div>
        </div>

        <div class="col-md-7 mb-4">
            <div class="accordion shadow" id="accordionRecipe">
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingDesc">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapseDesc" aria-expanded="true" aria-controls="collapseDesc">
                            📌 Deskripsi
                        </button>
                    </h2>
                    <div id="collapseDesc" class="accordion-collapse collapse show" aria-labelledby="headingDesc"
                        data-bs-parent="#accordionRecipe">
                        <div class="accordion-body">
                            {{ $recipe->description }}
                        </div>
                    </div>
                </div>

                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingIngredients">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapseIngredients" aria-expanded="false" aria-controls="collapseIngredients">
                            🥕 Bahan-Bahan
                        </button>
                    </h2>
                    <div id="collapseIngredients" class="accordion-collapse collapse" aria-labelledby="headingIngredients"
                        data-bs-parent="#accordionRecipe">
                        <div class="accordion-body">
                            <pre style="white-space: pre-wrap;">{{ $recipe->ingredients }}</pre>
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingProvince">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapseProvince" aria-expanded="false" aria-controls="collapseProvince">
                            🏙️ Provinsi
                        </button>
                    </h2>
                    <div id="collapseProvince" class="accordion-collapse collapse" aria-labelledby="headingProvince"
                        data-bs-parent="#accordionRecipe">
                        <div class="accordion-body">
                            <pre style="white-space: pre-wrap;">{{ $recipe->province }}</pre>
                        </div>
                    </div>
                </div>

                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingSteps">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapseSteps" aria-expanded="false" aria-controls="collapseSteps">
                            👨‍🍳 Langkah-langkah
                        </button>
                    </h2>
                    <div id="collapseSteps" class="accordion-collapse collapse" aria-labelledby="headingSteps"
                        data-bs-parent="#accordionRecipe">
                        <div class="accordion-body">
                            <pre style="white-space: pre-wrap;">{{ $recipe->steps }}</pre>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
