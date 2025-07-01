@extends('frontend.layouts.app')

@section('title', 'Rasanesia - Main Menu')

@section('content')
    <div class="title">
        <div class="logo-container">
            <img src="{{ asset('assets/img/chef_hat.png') }}" alt="Logo" class="logo-img">
            <span class="logo-text">Rasanesia</span>
        </div>
    </div>
    <div class="search-bar">
        <input type="text" id="searchInput" placeholder="Cari resep, bahan, pengguna" onkeyup="searchRecipes()">
        <button onclick="searchRecipes()">Cari</button>
    </div>
    <div class="carousel-container">
        <div class="carousel">
            <div class="carousel-slide active">
                <img src="{{ asset('assets/img/carousel/carousel-1.jpg') }}" alt="Carousel 1">
                <div class="carousel-caption">
                    <h2>#Gaskeun2025 #MasakdiRumahAja</h2>
                    <p>Inspirasi Masak FOOD AROUND NUSANTARA</p>
                </div>
            </div>
            <div class="carousel-slide">
                <img src="{{ asset('assets/img/carousel/carousel-2.jpg') }}" alt="Carousel 2">
                <div class="carousel-caption">
                    <h2>Resep Tradisional Indonesia</h2>
                    <p>Nikmati Kelezatan Masakan Nusantara</p>
                </div>
            </div>
            <div class="carousel-slide">
                <img src="{{ asset('assets/img/carousel/carousel-3.jpg') }}" alt="Carousel 3">
                <div class="carousel-caption">
                    <h2>Kuliner Daerah Terbaik</h2>
                    <p>Jelajahi Cita Rasa dari Seluruh Indonesia</p>
                </div>
            </div>
        </div>
        <div class="carousel-indicators">
            <span class="indicator active" onclick="currentSlide(1)"></span>
            <span class="indicator" onclick="currentSlide(2)"></span>
            <span class="indicator" onclick="currentSlide(3)"></span>
        </div>
        <button class="carousel-btn prev" onclick="changeSlide(-1)">&#10094;</button>
        <button class="carousel-btn next" onclick="changeSlide(1)">&#10095;</button>
    </div>
    <div class="section-title">Resep Terbaru!</div>
    <div class="card-grid">
        @foreach ($latestRecipes as $recipe)
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
                    <img src="{{ $fotoUrl }}" alt="{{ $recipe->name }}"
                        style="height:160px;width:100%;object-fit:cover;">
                    <div class="card-content">
                        <div class="card-title">{{ $recipe->name }}</div>
                        <div class="card-region">
                            <i class="fas fa-map-marker-alt"></i>
                            <span>{{ $recipe->province }}</span>
                        </div>
                        <div class="card-description">
                            {{ Str::limit($recipe->description, 80) }}
                        </div>
                    </div>
                </a>
                @auth
                    <button class="favorite-btn" data-recipe-id="{{ $recipe->id }}" data-is-favorited="false">
                        <i class="far fa-heart"></i>
                    </button>
                @else
                    <button class="favorite-btn guest-favorite" onclick="showLoginAlert()">
                        <i class="far fa-heart"></i>
                    </button>
                @endauth
            </div>
        @endforeach
    </div>
    <div class="section-title">Resep populer yang dibuat banyak orang saat ini!</div>
    <div class="card-grid">
        @foreach ($bestRatedRecipes as $recipe)
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
                    <img src="{{ $fotoUrl }}" alt="{{ $recipe->name }}"
                        style="height:160px;width:100%;object-fit:cover;">
                    <div class="card-content">
                        <div class="card-title">{{ $recipe->name }}</div>
                        <div class="card-region">
                            <i class="fas fa-map-marker-alt"></i>
                            <span>{{ $recipe->province }}</span>
                        </div>
                        <div class="card-description">
                            {{ Str::limit($recipe->description, 80) }}
                        </div>
                        <div class="rating-container">
                            @php
                                $rating = round($recipe->reviews_avg_rating);
                                $fullStars = floor($rating);
                                $hasHalfStar = $rating - $fullStars >= 0.5;
                            @endphp
                            <div class="stars">
                                @for ($i = 1; $i <= 5; $i++)
                                    @if ($i <= $fullStars)
                                        <i class="fas fa-star star-filled"></i>
                                    @elseif($i == $fullStars + 1 && $hasHalfStar)
                                        <i class="fas fa-star-half-alt star-half"></i>
                                    @else
                                        <i class="far fa-star star-empty"></i>
                                    @endif
                                @endfor
                            </div>
                            <span class="rating-text">{{ number_format($recipe->reviews_avg_rating, 1) }}</span>
                        </div>
                    </div>
                </a>
                @auth
                    <button class="favorite-btn" data-recipe-id="{{ $recipe->id }}" data-is-favorited="false">
                        <i class="far fa-heart"></i>
                    </button>
                @else
                    <button class="favorite-btn guest-favorite" onclick="showLoginAlert()">
                        <i class="far fa-heart"></i>
                    </button>
                @endauth
            </div>
        @endforeach
    </div>
    <div class="section-title">Kategori Masakan Daerah</div>
    <div class="category-grid">
        @foreach ($recipesByProvince as $province => $recipe)
            <div class="category-card">
                <a href="{{ route('recipe.show', $recipe->id) }}" class="category-link">
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
                    <img src="{{ $fotoUrl }}" alt="{{ $recipe->name }}"
                        style="height:160px;width:100%;object-fit:cover;">
                    <div class="category-title">{{ $province }}</div>
                    <div class="category-recipe-name">{{ $recipe->name }}</div>
                </a>
            </div>
        @endforeach
    </div>

    <!-- Alert Modal untuk Guest -->
    <div class="modal fade" id="loginAlert" tabindex="-1" aria-labelledby="loginAlertLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="loginAlertLabel">Login Diperlukan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Untuk menambahkan resep ke favorit, Anda harus login terlebih dahulu.</p>
                </div>
                <div class="modal-footer">
                    <a href="{{ route('login') }}" class="btn btn-primary">Login</a>
                    <a href="{{ route('register') }}" class="btn btn-secondary">Register</a>
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        let slideIndex = 0;
        let slideInterval;

        function showSlides() {
            const slides = document.querySelectorAll('.carousel-slide');
            const indicators = document.querySelectorAll('.indicator');

            // Hide all slides
            slides.forEach(slide => slide.classList.remove('active'));
            indicators.forEach(indicator => indicator.classList.remove('active'));

            // Show current slide
            slides[slideIndex].classList.add('active');
            indicators[slideIndex].classList.add('active');
        }

        function changeSlide(direction) {
            const slides = document.querySelectorAll('.carousel-slide');
            slideIndex += direction;

            if (slideIndex >= slides.length) {
                slideIndex = 0;
            } else if (slideIndex < 0) {
                slideIndex = slides.length - 1;
            }

            showSlides();
            resetInterval();
        }

        function currentSlide(n) {
            slideIndex = n - 1;
            showSlides();
            resetInterval();
        }

        function resetInterval() {
            clearInterval(slideInterval);
            slideInterval = setInterval(() => {
                changeSlide(1);
            }, 5000); // Change slide every 5 seconds
        }

        // Initialize carousel
        document.addEventListener('DOMContentLoaded', function() {
            showSlides();
            slideInterval = setInterval(() => {
                changeSlide(1);
            }, 5000);

            // Initialize favorite buttons only for authenticated users
            @auth
            initializeFavoriteButtons();
        @endauth
        });

        // Alert functions for guest users
        function showLoginAlert() {
            const modal = new bootstrap.Modal(document.getElementById('loginAlert'));
            modal.show();
        }

        @auth
        // Favorite functionality for authenticated users
        function initializeFavoriteButtons() {
            const favoriteButtons = document.querySelectorAll('.favorite-btn:not(.guest-favorite)');

            favoriteButtons.forEach(button => {
                const recipeId = button.dataset.recipeId;

                // Check if recipe is already favorited
                checkFavoriteStatus(recipeId, button);

                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation(); // Prevent card link from being triggered
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
        @endauth

        // Search functionality
        function searchRecipes() {
            const searchTerm = document.getElementById('searchInput').value.toLowerCase().trim();
            const allCards = document.querySelectorAll('.card');
            const allCategoryCards = document.querySelectorAll('.category-card');

            // Search in regular recipe cards
            allCards.forEach(card => {
                const title = card.querySelector('.card-title')?.textContent.toLowerCase() || '';
                const region = card.querySelector('.card-region span')?.textContent.toLowerCase() || '';
                const description = card.querySelector('.card-description')?.textContent.toLowerCase() || '';

                const isMatch = title.includes(searchTerm) ||
                    region.includes(searchTerm) ||
                    description.includes(searchTerm);

                if (searchTerm === '' || isMatch) {
                    card.style.display = 'flex';
                    card.style.opacity = '1';
                } else {
                    card.style.opacity = '0.3';
                    card.style.transform = 'scale(0.95)';
                }
            });

            // Search in category cards
            allCategoryCards.forEach(card => {
                const title = card.querySelector('.category-title')?.textContent.toLowerCase() || '';
                const recipeName = card.querySelector('.category-recipe-name')?.textContent
                    .toLowerCase() || '';

                const isMatch = title.includes(searchTerm) ||
                    recipeName.includes(searchTerm);

                if (searchTerm === '' || isMatch) {
                    card.style.display = 'flex';
                    card.style.opacity = '1';
                } else {
                    card.style.opacity = '0.3';
                    card.style.transform = 'scale(0.95)';
                }
            });

            // Show/hide section titles based on search results
            const sections = document.querySelectorAll('.section-title');
            sections.forEach(section => {
                const nextGrid = section.nextElementSibling;
                if (nextGrid && (nextGrid.classList.contains('card-grid') || nextGrid.classList.contains(
                        'category-grid'))) {
                    const visibleCards = Array.from(nextGrid.children).filter(card =>
                        card.style.opacity !== '0.3'
                    );

                    if (searchTerm === '' || visibleCards.length > 0) {
                        section.style.display = 'block';
                        nextGrid.style.display = 'grid';
                    } else {
                        section.style.display = 'none';
                        nextGrid.style.display = 'none';
                    }
                }
            });

            // Show no results message if needed
            showNoResultsMessage(searchTerm);
        }

        function showNoResultsMessage(searchTerm) {
            // Remove existing no results message
            const existingMessage = document.querySelector('.no-results-message');
            if (existingMessage) {
                existingMessage.remove();
            }

            if (searchTerm !== '') {
                const allCards = document.querySelectorAll('.card, .category-card');
                const visibleCards = Array.from(allCards).filter(card =>
                    card.style.opacity !== '0.3'
                );

                if (visibleCards.length === 0) {
                    const noResultsDiv = document.createElement('div');
                    noResultsDiv.className = 'no-results-message';
                    noResultsDiv.innerHTML = `
                <div style="text-align: center; padding: 40px 20px; background: white; border-radius: 15px; box-shadow: 0 2px 8px rgba(163,180,139,0.06); border: 1px solid #c7d3b0; margin: 20px 0;">
                    <i class="fas fa-search" style="font-size: 3em; color: #c7d3b0; margin-bottom: 15px;"></i>
                    <h3 style="color: #2e3a32; margin-bottom: 10px; font-size: 1.3em;">Tidak ada hasil ditemukan</h3>
                    <p style="color: #6c757d; margin: 0;">Coba kata kunci lain atau periksa ejaan Anda.</p>
                </div>
            `;

                    // Insert after the search bar
                    const searchBar = document.querySelector('.search-bar');
                    searchBar.parentNode.insertBefore(noResultsDiv, searchBar.nextSibling);
                }
            }
        }

        // Clear search when input is cleared
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('searchInput');
            searchInput.addEventListener('input', function() {
                if (this.value === '') {
                    // Reset all cards to normal state
                    const allCards = document.querySelectorAll('.card, .category-card');
                    allCards.forEach(card => {
                        card.style.opacity = '1';
                        card.style.transform = 'scale(1)';
                    });

                    // Show all sections
                    const sections = document.querySelectorAll('.section-title');
                    sections.forEach(section => {
                        section.style.display = 'block';
                        const nextGrid = section.nextElementSibling;
                        if (nextGrid && (nextGrid.classList.contains('card-grid') || nextGrid
                                .classList.contains('category-grid'))) {
                            nextGrid.style.display = 'grid';
                        }
                    });

                    // Remove no results message
                    const noResultsMessage = document.querySelector('.no-results-message');
                    if (noResultsMessage) {
                        noResultsMessage.remove();
                    }
                }
            });
        });
    </script>
@endsection
