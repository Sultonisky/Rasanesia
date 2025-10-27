@extends('frontend.layouts.app')

@section('title', $recipe->name . ' - Rasanesia')

@section('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/detail_resep.css') }}">
@endsection

@section('content')
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle"></i>
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle"></i>
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="recipe-detail-container">
        <!-- Recipe Header with Image -->
        <div class="recipe-header">
            <div class="recipe-image-container">
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
                <img src="{{ $fotoUrl }}" alt="{{ $recipe->name }}" class="recipe-image">
                <div class="recipe-overlay">
                    <h1 class="recipe-title">{{ $recipe->name }}</h1>
                    <div class="recipe-meta">

                        @if ($recipe->province)
                            <div class="recipe-province">
                                <i class="fas fa-map-marker-alt"></i>
                                <span>{{ $recipe->province }}</span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Recipe Actions -->
            <div class="recipe-actions">
                <div class="recipe-rating">
                    <div class="rating-stars">
                        @php
                            $avgRating = $recipe->reviews->avg('rating') ?? 0;
                            $fullStars = floor($avgRating);
                            $hasHalfStar = $avgRating - $fullStars >= 0.5;
                        @endphp

                        @for ($i = 1; $i <= 5; $i++)
                            @if ($i <= $fullStars)
                                <i class="fas fa-star"></i>
                            @elseif($i == $fullStars + 1 && $hasHalfStar)
                                <i class="fas fa-star-half-alt"></i>
                            @else
                                <i class="far fa-star"></i>
                            @endif
                        @endfor
                    </div>
                    <div class="rating-text">
                        <span>{{ number_format($avgRating, 1) }}</span>
                        <span class="rating-count">({{ $recipe->reviews->count() }} ulasan)</span>
                    </div>
                </div>

                <div class="action-buttons">
                    <a href="{{ route('recipes.downloadPdf', $recipe->id) }}" class="btn-download" target="_blank">
                        <i class="fas fa-download"></i>
                        Download PDF
                    </a>
                    
                    @auth
                        <button class="btn-save {{ auth()->user()->favorites->contains($recipe->id) ? 'saved' : '' }}"
                            onclick="toggleFavorite({{ $recipe->id }})" data-recipe-id="{{ $recipe->id }}">
                            <i class="{{ auth()->user()->favorites->contains($recipe->id) ? 'fas' : 'far' }} fa-heart"></i>
                            {{ auth()->user()->favorites->contains($recipe->id) ? 'Tersimpan' : 'Simpan Resep' }}
                        </button>

                        @php
                            $userReview = $recipe->reviews->where('user_id', auth()->id())->first();
                        @endphp

                        @if ($userReview)
                            <button class="btn-review" disabled>
                                <i class="fas fa-star"></i>
                                Sudah Direview
                            </button>
                        @else
                            <a href="#" class="btn-review" onclick="showReviewModal()">
                                <i class="fas fa-star"></i>
                                Beri Review
                            </a>
                        @endif
                    @else
                        <a href="{{ route('login') }}" class="btn-save">
                            <i class="far fa-heart"></i>
                            Simpan Resep
                        </a>

                        <a href="{{ route('login') }}" class="btn-review">
                            <i class="fas fa-star"></i>
                            Beri Review
                        </a>
                    @endauth
                </div>
            </div>
        </div>

        <!-- Recipe Content -->
        <div class="recipe-content">
            <!-- Ingredients Section -->
            <div class="recipe-section">
                <h2 class="section-title">
                    <i class="fas fa-list"></i>
                    Bahan Utama
                </h2>
                <ul class="ingredients-list">
                    @foreach (explode("\n", $recipe->ingredients) as $ingredient)
                        @if (trim($ingredient))
                            <li>{{ trim($ingredient) }}</li>
                        @endif
                    @endforeach
                </ul>
            </div>

            <!-- Cooking Steps Section -->
            <div class="recipe-section">
                <h2 class="section-title">
                    <i class="fas fa-utensils"></i>
                    Cara Memasak
                </h2>
                <ul class="steps-list">
                    @foreach (explode("\n", $recipe->steps) as $index => $step)
                        @if (trim($step))
                            <li>{{ trim($step) }}</li>
                        @endif
                    @endforeach
                </ul>
            </div>
        </div>

        <!-- Recipe Description -->
        @if ($recipe->description)
            <div class="recipe-section">
                <h2 class="section-title">
                    <i class="fas fa-info-circle"></i>
                    Deskripsi
                </h2>
                <p class="recipe-description">{{ $recipe->description }}</p>
            </div>
        @endif

        <!-- Reviews Section -->
        <div class="recipe-reviews">
            <div class="reviews-header">
                <h2 class="reviews-title">
                    <i class="fas fa-comments"></i>
                    Ulasan ({{ $recipe->reviews->count() }})
                </h2>
            </div>

            @if ($recipe->reviews->count() > 0)
                @foreach ($recipe->reviews as $review)
                    <div class="review-item">
                        <div class="review-header">
                            <div>
                                <div class="reviewer-name">{{ $review->user->name }}</div>
                                <div class="review-date">{{ $review->created_at->format('d M Y') }}</div>
                            </div>
                            <div class="review-rating">
                                @for ($i = 1; $i <= 5; $i++)
                                    @if ($i <= $review->rating)
                                        <i class="fas fa-star"></i>
                                    @else
                                        <i class="far fa-star"></i>
                                    @endif
                                @endfor
                            </div>
                        </div>
                        <div class="review-content">
                            {{ $review->comment }}
                        </div>
                    </div>
                @endforeach
            @else
                <div class="no-reviews">
                    <p>Belum ada ulasan untuk resep ini. Jadilah yang pertama memberikan ulasan!</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Review Modal -->
    @auth
        <div id="reviewModal" class="modal" style="display: none;">
            <div class="modal-content">
                <div class="modal-header">
                    <h3>Beri Review untuk {{ $recipe->name }}</h3>
                    <span class="close" onclick="closeReviewModal()">&times;</span>
                </div>
                <div class="modal-body">
                    @php
                        $userReview = $recipe->reviews->where('user_id', auth()->id())->first();
                    @endphp

                    @if ($userReview)
                        <div class="existing-review">
                            <h4>Review Anda:</h4>
                            <div class="review-rating">
                                @for ($i = 1; $i <= 5; $i++)
                                    @if ($i <= $userReview->rating)
                                        <i class="fas fa-star"></i>
                                    @else
                                        <i class="far fa-star"></i>
                                    @endif
                                @endfor
                            </div>
                            <p class="review-comment">{{ $userReview->comment }}</p>
                            <p class="review-date">Diberikan pada: {{ $userReview->created_at->format('d M Y H:i') }}</p>
                        </div>
                    @else
                        <form id="reviewForm" method="POST" action="{{ route('frontend.reviews.store') }}">
                            @csrf
                            <input type="hidden" name="recipe_id" value="{{ $recipe->id }}">

                            <div class="form-group">
                                <label>Rating:</label>
                                <div class="rating-input">
                                    @for ($i = 5; $i >= 1; $i--)
                                        <input type="radio" name="rating" value="{{ $i }}"
                                            id="star{{ $i }}" required>
                                        <label for="star{{ $i }}"><i class="far fa-star"></i></label>
                                    @endfor
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="comment">Komentar:</label>
                                <textarea name="comment" id="comment" rows="4" required
                                    placeholder="Bagikan pengalaman Anda memasak resep ini..."></textarea>
                            </div>

                            <div class="form-actions">
                                <button type="button" class="btn btn-secondary" onclick="closeReviewModal()">Batal</button>
                                <button type="submit" class="btn btn-primary">Kirim Review</button>
                            </div>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    @endauth
@endsection

@section('scripts')
    <script>
        function toggleFavorite(recipeId) {
            const button = document.querySelector(`[data-recipe-id="${recipeId}"]`);
            const icon = button.querySelector('i');

            button.classList.add('favoriting');

            fetch('{{ route('favorites.toggle') }}', {
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
                    if (data.isFavorited) {
                        button.classList.add('saved');
                        button.innerHTML = '<i class="fas fa-heart"></i> Tersimpan';
                    } else {
                        button.classList.remove('saved');
                        button.innerHTML = '<i class="far fa-heart"></i> Simpan Resep';
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                })
                .finally(() => {
                    button.classList.remove('favoriting');
                });
        }

        function showReviewModal() {
            document.getElementById('reviewModal').style.display = 'block';
            document.body.style.overflow = 'hidden'; // Prevent background scrolling
        }

        function closeReviewModal() {
            document.getElementById('reviewModal').style.display = 'none';
            document.body.style.overflow = 'auto'; // Restore scrolling
        }

        // Close modal when clicking outside
        window.onclick = function(event) {
            const modal = document.getElementById('reviewModal');
            if (event.target == modal) {
                closeReviewModal();
            }
        }

        // Close modal with Escape key
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                closeReviewModal();
            }
        });

        // Rating input functionality
        document.addEventListener('DOMContentLoaded', function() {
            const ratingInputs = document.querySelectorAll('.rating-input input');
            const ratingLabels = document.querySelectorAll('.rating-input label i');

            ratingInputs.forEach((input, index) => {
                input.addEventListener('change', function() {
                    const rating = this.value;

                    ratingLabels.forEach((label, labelIndex) => {
                        if (labelIndex < rating) {
                            label.className = 'fas fa-star';
                        } else {
                            label.className = 'far fa-star';
                        }
                    });
                });
            });

            // Auto-hide alerts after 5 seconds
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                setTimeout(() => {
                    if (alert.parentNode) {
                        alert.style.opacity = '0';
                        setTimeout(() => {
                            if (alert.parentNode) {
                                alert.remove();
                            }
                        }, 300);
                    }
                }, 5000);
            });
        });

        // Form submission handling
        document.addEventListener('DOMContentLoaded', function() {
            const reviewForm = document.getElementById('reviewForm');
            if (reviewForm) {
                reviewForm.addEventListener('submit', function(e) {
                    const rating = document.querySelector('input[name="rating"]:checked');
                    const comment = document.getElementById('comment').value.trim();

                    if (!rating) {
                        e.preventDefault();
                        alert('Silakan pilih rating terlebih dahulu.');
                        return;
                    }

                    if (!comment) {
                        e.preventDefault();
                        alert('Silakan isi komentar terlebih dahulu.');
                        return;
                    }
                });
            }
        });
    </script>
@endsection
