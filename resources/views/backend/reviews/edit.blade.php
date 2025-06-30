@extends('backend.layouts.app')

@section('contents')
    <h1 class="h3 mb-2 text-gray-800">Edit Review</h1>
    <p class="mb-4">Halaman ini digunakan untuk mengubah review terhadap resep.</p>


    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="{{ route('reviews.update', $review->id) }}" method="POST">
                @csrf
                @method('PUT')

                <!-- Kirim recipe_id dan user_id agar validasi controller tidak gagal -->
                <input type="hidden" name="recipe_id" value="{{ $review->recipe_id }}">
                <input type="hidden" name="user_id" value="{{ $review->user_id }}">

                <div class="mb-3">
                    <label class="form-label">Nama Resep</label>
                    <input type="text" class="form-control" value="{{ $review->recipe->name }}" disabled>
                </div>

                <div class="mb-3">
                    <label class="form-label">Rating</label>
                    <div class="star-rating">
                        @for ($i = 1; $i <= 5; $i++)
                            <i class="{{ $i <= $review->rating ? 'fas' : 'far' }} fa-star star text-warning"
                                data-value="{{ $i }}"></i>
                        @endfor
                    </div>
                    <input type="hidden" name="rating" id="rating" value="{{ $review->rating }}">
                </div>

                <div class="mb-3">
                    <label for="comment" class="form-label">Komentar</label>
                    <textarea name="comment" id="comment" class="form-control" rows="4" required>{{ old('comment', $review->comment) }}</textarea>
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('reviews.index') }}" class="btn btn-secondary">Batal</a>
                    <button type="submit" class="btn btn-primary">Update Review</button>
                </div>
            </form>

        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const stars = document.querySelectorAll('.star-rating .star');
            const ratingInput = document.getElementById('rating');

            function updateStars(rating) {
                stars.forEach((star, index) => {
                    if (index < rating) {
                        star.classList.remove('far');
                        star.classList.add('fas', 'text-warning');
                    } else {
                        star.classList.remove('fas', 'text-warning');
                        star.classList.add('far');
                    }
                });
            }

            stars.forEach((star) => {
                star.addEventListener('click', () => {
                    const rating = parseInt(star.getAttribute('data-value'));
                    ratingInput.value = rating;
                    updateStars(rating);
                });
            });

            updateStars(parseInt(ratingInput.value)); // Untuk initial state
        });
    </script>
@endpush
