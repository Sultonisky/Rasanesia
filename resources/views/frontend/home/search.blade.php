@extends('frontend.layouts.app')

@section('title', 'Rasanesia - Search')

@section('content')
    <div class="main-content">
        <div class="back-button">
            <a href="{{ route('main-home') }}" style="text-decoration: none; color: inherit;">
                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none"
                    stroke="#202020" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="20" y1="12" x2="4" y2="12" />
                    <polyline points="10 18 4 12 10 6" />
                </svg>
            </a>
            <h2>Search</h2>
        </div>

        <div class="search-container">
            <form action="{{ route('search') }}" method="GET" class="search-form">
                <div class="search-input-group">
                    <input type="text" name="q" value="{{ $query }}"
                        placeholder="Cari resep, bahan, atau daerah..." class="search-input">
                    <button type="submit" class="search-btn">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </form>
        </div>

        @if ($query)
            <div class="search-results">
                <h3>Hasil Pencarian untuk "{{ $query }}"</h3>
                @if ($recipes->count() > 0)
                    <div class="card-container">
                        @foreach ($recipes as $recipe)
                            <div class="card">
                            @php
                            $foto = $recipe->foto;
                            if ($foto && !Str::startsWith($foto, ['http://', 'https://'])) {
                                $foto = 'https://' . ltrim($foto, '/');
                            }
                            @endphp
                            <a href="{{ route('recipe.show', $recipe->id) }}">
                                <img src="{{ $foto }}" alt="{{ $recipe->name }}">
                            </a>
                                <button class="favorite-btn" data-recipe-id="{{ $recipe->id }}" data-is-favorited="false">
                                    <i class="far fa-heart"></i>
                                </button>
                            </div>
                        @endforeach
                    </div>
            </div>
                @else
                    <div class="no-results">
                        <i class="fas fa-search" style="font-size: 48px; margin-bottom: 20px; color: #ddd;"></i>
                        <h3>Tidak ada hasil ditemukan</h3>
                        <p>Tidak ada resep yang cocok dengan pencarian "{{ $query }}"</p>
                        <p>Coba kata kunci lain atau jelajahi resep lainnya.</p>
                    </div>
                @endif
            </div>
        @else
            <div class="search-suggestions">
                <h3>Jelajahi Resep</h3>
                <div class="suggestions-grid">
                    <div class="suggestion-card">
                        <i class="fas fa-fire"></i>
                        <h4>Resep Populer</h4>
                        <p>Temukan resep yang paling banyak disukai</p>
                    </div>
                    <div class="suggestion-card">
                        <i class="fas fa-clock"></i>
                        <h4>Resep Terbaru</h4>
                        <p>Resep yang baru ditambahkan</p>
                    </div>
                    <div class="suggestion-card">
                        <i class="fas fa-map-marker-alt"></i>
                        <h4>Resep Daerah</h4>
                        <p>Resep dari berbagai daerah Indonesia</p>
                    </div>
                    <div class="suggestion-card">
                        <i class="fas fa-star"></i>
                        <h4>Resep Favorit</h4>
                        <p>Resep yang telah Anda simpan</p>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            // Initialize favorite buttons
            initializeFavoriteButtons();
        });

        // Favorite functionality
        function initializeFavoriteButtons() {
            const favoriteButtons = document.querySelectorAll('.favorite-btn');

            favoriteButtons.forEach(button => {
                const recipeId = button.dataset.recipeId;

                // Check if recipe is already favorited
                checkFavoriteStatus(recipeId, button);

                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    toggleFavorite(recipeId, button);
                });
            });
        }

        function checkFavoriteStatus(recipeId, button) {
            fetch(`/favorites/check?recipe_id=${recipeId}`)
                .then(response => response.json())
                .then(data => {
                    if (data.is_favorited) {
                        button.querySelector('i').classList.remove('far');
                        button.querySelector('i').classList.add('fas', 'text-danger');
                        button.dataset.isFavorited = 'true';
                    }
                })
                .catch(error => console.error('Error checking favorite status:', error));
        }

        function toggleFavorite(recipeId, button) {
            const icon = button.querySelector('i');
            const isFavorited = button.dataset.isFavorited === 'true';

            fetch('/favorites/toggle', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        recipe_id: recipeId
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        if (data.is_favorited) {
                            icon.classList.remove('far');
                            icon.classList.add('fas', 'text-danger');
                            button.dataset.isFavorited = 'true';
                        } else {
                            icon.classList.remove('fas', 'text-danger');
                            icon.classList.add('far');
                            button.dataset.isFavorited = 'false';
                        }
                    }
                })
                .catch(error => {
                    console.error('Error toggling favorite:', error);
                    alert('Terjadi kesalahan saat mengubah status favorit');
                });
        }
    </script>
@endpush

@push('styles')
    <style>
        .search-container {
            margin-bottom: 30px;
        }

        .search-form {
            max-width: 600px;
            margin: 0 auto;
        }

        .search-input-group {
            display: flex;
            background: white;
            border-radius: 25px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .search-input {
            flex: 1;
            padding: 15px 20px;
            border: none;
            outline: none;
            font-size: 16px;
        }

        .search-btn {
            padding: 15px 25px;
            background: #a3b48b;
            border: none;
            color: white;
            cursor: pointer;
            transition: background 0.3s;
        }

        .search-btn:hover {
            background: #8b9c6e;
        }

        .search-results h3 {
            margin-bottom: 20px;
            color: #2e3a32;
        }

        .no-results {
            text-align: center;
            padding: 50px;
            color: #666;
        }

        .suggestions-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }

        .suggestion-card {
            background: white;
            padding: 30px;
            border-radius: 15px;
            text-align: center;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s;
        }

        .suggestion-card:hover {
            transform: translateY(-5px);
        }

        .suggestion-card i {
            font-size: 48px;
            color: #a3b48b;
            margin-bottom: 15px;
        }

        .suggestion-card h4 {
            margin-bottom: 10px;
            color: #2e3a32;
        }

        .suggestion-card p {
            color: #666;
            font-size: 14px;
        }

        .card {
            position: relative;
        }

        .card .description {
            font-size: 14px;
            color: #666;
            margin: 10px 0;
        }

        .card .province {
            font-size: 12px;
            color: #a3b48b;
            font-weight: 500;
        }
    </style>
@endpush
