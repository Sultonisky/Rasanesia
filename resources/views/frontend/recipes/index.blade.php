@extends('frontend.layouts.app')

@section('title', 'Semua Resep - Rasanesia')

@section('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/pagination.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/all-recipes.css') }}">
@endsection

@section('content')
    <div class="title">
        <div class="logo-container">
            <img src="{{ asset('assets/img/chef_hat.png') }}" alt="Logo" class="logo-img">
            <span class="logo-text">Semua Resep</span>
        </div>
    </div>

    <div class="search-bar">
        <form action="{{ route('search') }}" method="GET" style="display: flex; width: 100%;">
            <input type="text" name="q" placeholder="Cari resep..." value="{{ request('q') }}" style="flex: 1;">
            <button type="submit">
                <i class="fas fa-search"></i>
            </button>
        </form>
    </div>

    @if ($recipes->count() > 0)
        <div class="section-title">
            <i class="fas fa-utensils"></i>
            Daftar Semua Resep ({{ $recipes->total() }} resep)
        </div>

        <div class="card-grid">
            @foreach ($recipes as $recipe)
                <div class="card">
                    <a href="{{ route('recipe.show', $recipe->id) }}" class="card-link">
                        @php
                            $foto = $recipe->foto;
                            if (
                                $foto &&
                                (\Illuminate\Support\Str::startsWith($foto, 'http://') ||
                                    \Illuminate\Support\Str::startsWith($foto, 'https://'))
                            ) {
                                $fotoUrl = $foto;
                            } elseif ($foto) {
                                $fotoUrl = asset('storage/' . $foto);
                            } else {
                                $fotoUrl = asset('assets/img/chef_hat.png');
                            }
                        @endphp
                        <img src="{{ $fotoUrl }}" alt="{{ $recipe->name }}">

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

                    @auth
                        <button class="favorite-btn" onclick="toggleFavorite({{ $recipe->id }})"
                            data-recipe-id="{{ $recipe->id }}">
                            <i class="far fa-heart"></i>
                        </button>
                    @else
                        <button class="favorite-btn" onclick="showLoginAlert('menyimpan resep')">
                            <i class="far fa-heart"></i>
                        </button>
                    @endauth
                </div>
            @endforeach
        </div>

        @if ($recipes->hasPages())
            <div class="pagination-container">
                <nav aria-label="Page navigation">
                    <ul class="pagination justify-content-center">
                        {{-- Previous Page Link --}}
                        @if ($recipes->onFirstPage())
                            <li class="page-item disabled"><span class="page-link">&laquo;</span></li>
                        @else
                            <li class="page-item"><a class="page-link" href="{{ $recipes->previousPageUrl() }}"
                                    rel="prev">&laquo;</a></li>
                        @endif

                        {{-- Pagination Elements --}}
                        @foreach ($recipes->getUrlRange(1, $recipes->lastPage()) as $page => $url)
                            @if ($page == $recipes->currentPage())
                                <li class="page-item active"><span class="page-link">{{ $page }}</span></li>
                            @elseif (
                                $page == 1 ||
                                    $page == $recipes->lastPage() ||
                                    ($page >= $recipes->currentPage() - 2 && $page <= $recipes->currentPage() + 2))
                                <li class="page-item"><a class="page-link"
                                        href="{{ $url }}">{{ $page }}</a></li>
                            @elseif ($page == $recipes->currentPage() - 3 || $page == $recipes->currentPage() + 3)
                                <li class="page-item disabled"><span class="page-link">...</span></li>
                            @endif
                        @endforeach

                        {{-- Next Page Link --}}
                        @if ($recipes->hasMorePages())
                            <li class="page-item"><a class="page-link" href="{{ $recipes->nextPageUrl() }}"
                                    rel="next">&raquo;</a></li>
                        @else
                            <li class="page-item disabled"><span class="page-link">&raquo;</span></li>
                        @endif
                    </ul>
                </nav>
            </div>
        @endif
    @else
        <div class="empty-state">
            <div class="empty-state-icon">
                <i class="fas fa-utensils"></i>
            </div>
            <h3 class="empty-state-title">Tidak Ada Resep</h3>
            <p class="empty-state-text">Belum ada resep yang tersedia saat ini.</p>
        </div>
    @endif

    <!-- Login Alert Modal -->
    <div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="loginModalLabel">Login Diperlukan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Anda harus login terlebih dahulu untuk <span id="featureName"></span>.</p>
                </div>
                <div class="modal-footer">
                    <a href="{{ route('login') }}" class="btn btn-primary">Login</a>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function showLoginAlert(feature) {
            document.getElementById('featureName').textContent = feature;
            const modal = new bootstrap.Modal(document.getElementById('loginModal'));
            modal.show();
        }

        @auth

        function toggleFavorite(recipeId) {
            event.preventDefault();
            event.stopPropagation(); // Prevent card link from being triggered

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
                    const btn = document.querySelector(`[data-recipe-id="${recipeId}"]`);
                    const icon = btn.querySelector('i');

                    if (data.is_favorited) {
                        icon.className = 'fas fa-heart text-danger';
                        btn.classList.add('favorited');
                    } else {
                        icon.className = 'far fa-heart';
                        btn.classList.remove('favorited');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        }

        // Check favorite status on page load
        document.addEventListener('DOMContentLoaded', function() {
            const favoriteButtons = document.querySelectorAll('.favorite-btn[data-recipe-id]');
            favoriteButtons.forEach(btn => {
                const recipeId = btn.getAttribute('data-recipe-id');
                fetch(`/favorites/check?recipe_id=${recipeId}`)
                    .then(response => response.json())
                    .then(data => {
                        const icon = btn.querySelector('i');
                        if (data.is_favorited) {
                            icon.className = 'fas fa-heart text-danger';
                            btn.classList.add('favorited');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
            });
        });
        @endauth
    </script>
@endsection
