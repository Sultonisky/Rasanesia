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
    <input type="text" placeholder="Cari resep, bahan, pengguna">
    <button>Cari</button>
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
    @foreach($latestRecipes as $recipe)
        <div class="card">
            <img src="{{ $recipe->foto }}" alt="{{ $recipe->name }}" style="height:160px;width:100%;object-fit:cover;">
            <div class="card-content">
                <div class="card-title">{{ $recipe->name }}</div>
                <div class="card-region">
                    <i class="fas fa-map-marker-alt"></i>
                    <span>{{ $recipe->province }}</span>
                </div>
                <div class="card-description">
                    {{ Str::limit($recipe->description, 80) }}
                </div>
                <div class="card-meta">
                    <span class="cooking-time">
                        <i class="fas fa-clock"></i>
                        {{ $recipe->cooking_time ?? '30' }} menit
                    </span>
                    <span class="difficulty">
                        <i class="fas fa-signal"></i>
                        {{ $recipe->difficulty ?? 'Sedang' }}
                    </span>
                </div>
            </div>
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
    @foreach($bestRatedRecipes as $recipe)
        <div class="card">
            <img src="{{ $recipe->foto }}" alt="{{ $recipe->name }}" style="height:160px;width:100%;object-fit:cover;">
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
                    @for($i = 1; $i <= 5; $i++)
                        @if($i <= $fullStars)
                            <i class="fas fa-star text-warning"></i>
                        @elseif($i == $fullStars + 1 && $hasHalfStar)
                            <i class="fas fa-star-half-alt text-warning"></i>
                        @else
                            <i class="far fa-star text-warning"></i>
                        @endif
                    @endfor
                    <span class="rating-text">({{ number_format($recipe->reviews_avg_rating, 1) }})</span>
                </div>
                <div class="card-meta">
                    <span class="cooking-time">
                        <i class="fas fa-clock"></i>
                        {{ $recipe->cooking_time ?? '30' }} menit
                    </span>
                    <span class="difficulty">
                        <i class="fas fa-signal"></i>
                        {{ $recipe->difficulty ?? 'Sedang' }}
                    </span>
                </div>
            </div>
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
    @foreach($recipesByProvince as $province => $recipes)
        @foreach($recipes as $recipe)
            <div class="category-card">
                <img src="{{ $recipe->foto }}" alt="{{ $recipe->name }}" style="height:160px;width:100%;object-fit:cover;">
                <div class="category-title">{{ $province }}</div>
                <div style="font-size:0.95em;">{{ $recipe->name }}</div>
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
    @endforeach
</div>

<!-- Alert Modal untuk Guest -->
<div id="loginAlert" class="modal" style="display: none;">
    <div class="modal-content">
        <div class="modal-header">
            <h3>Login Diperlukan</h3>
            <span class="close" onclick="closeLoginAlert()">&times;</span>
        </div>
        <div class="modal-body">
            <p>Untuk menambahkan resep ke favorit, Anda harus login terlebih dahulu.</p>
            <div class="modal-buttons">
                <a href="{{ route('login') }}" class="btn btn-primary">Login</a>
                <a href="{{ route('register') }}" class="btn btn-secondary">Register</a>
                <button onclick="closeLoginAlert()" class="btn btn-light">Batal</button>
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
    document.getElementById('loginAlert').style.display = 'block';
}

function closeLoginAlert() {
    document.getElementById('loginAlert').style.display = 'none';
}

// Close modal when clicking outside
window.onclick = function(event) {
    const modal = document.getElementById('loginAlert');
    if (event.target == modal) {
        modal.style.display = 'none';
    }
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
</script>
@endsection
