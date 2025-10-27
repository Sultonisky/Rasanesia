@extends('frontend.layouts.app')

@push('styles')
    <link href="{{ asset('assets/css/favorite.css') }}" rel="stylesheet">
@endpush

@section('content')
    <div class="favorite-page">
        <div class="back-button">
            <a href="{{ route('main-home') }}" title="Kembali ke Beranda">
                <i class="fas fa-arrow-left"></i>
            </a>
            <h2>Resep Favorit Saya</h2>
        </div>

        <div class="card-grid">
            @forelse($favorites as $recipe)
                <div class="card">
                    <a href="{{ route('recipe.show', $recipe->id) }}" class="card-link">
                        <img src="{{ Str::startsWith($recipe->foto, ['http://', 'https://']) ? $recipe->foto : asset('storage/' . $recipe->foto) }}"
                            alt="{{ $recipe->name }}" loading="lazy">

                        <div class="card-content">
                            <div class="card-title">{{ $recipe->name }}</div>

                            <div class="card-region">
                                <i class="fas fa-map-marker-alt"></i>
                                <span>{{ $recipe->province ?: 'Tidak ditentukan' }}</span>
                            </div>

                            <div class="card-description">
                                {{ Str::limit($recipe->description, 100) }}
                            </div>
                        </div>
                    </a>

                    <button class="favorite-btn" onclick="removeFavorite({{ $recipe->id }})"
                        data-recipe-id="{{ $recipe->id }}">
                        <i class="fas fa-heart text-danger"></i>
                    </button>
                </div>
            @empty
                <div class="empty-state">
                    <i class="fas fa-heart"></i>
                    <h3>Belum ada resep favorit</h3>
                    <p>Mulailah simpan resep favorit Anda dan lihat di sini nanti!</p>
                    <a href="{{ route('main-home') }}" class="btn">
                        <i class="fas fa-search"></i> Jelajahi Resep
                    </a>
                </div>
            @endforelse
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function removeFavorite(recipeId) {
            console.log('Klik heart untuk recipe id:', recipeId);
            const button = document.querySelector(`button[data-recipe-id="${recipeId}"]`);
            button.disabled = true;
            button.innerHTML = '<i class="far fa-heart"></i>';

            fetch('{{ route('favorites.destroy') }}', {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        recipe_id: recipeId
                    })
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        setTimeout(() => {
                            button.closest('.card').remove();
                            if (document.querySelectorAll('.card').length === 0) {
                                location.reload();
                            }
                        }, 300);
                    } else {
                        alert('Gagal menghapus favorit.');
                        button.innerHTML = '<i class="fas fa-heart text-danger"></i>';
                        button.disabled = false;
                    }
                })
                .catch(() => {
                    alert('Terjadi kesalahan. Silakan coba lagi.');
                    button.innerHTML = '<i class="fas fa-heart text-danger"></i>';
                    button.disabled = false;
                });
        }
    </script>
@endpush
