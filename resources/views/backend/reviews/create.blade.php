@extends('backend.layouts.app')

@section('contents')
    <h1 class="h3 mb-2 text-gray-800">Tambah Review</h1>
    <p class="mb-4">Isi form untuk menambahkan review pada resep makanan.</p>


    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="{{ route('admin.reviews.store') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label for="recipe_id">Pilih Resep</label>
                    <select name="recipe_id" id="recipe_id" class="form-control @error('recipe_id') is-invalid @enderror">
                        <option value="">-- Pilih Resep --</option>
                        @foreach ($recipes as $recipe)
                            <option value="{{ $recipe->id }}" {{ old('recipe_id') == $recipe->id ? 'selected' : '' }}>
                                {{ $recipe->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('recipe_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="user_id">Pilih Pengguna</label>
                    <select name="user_id" id="user_id" class="form-control @error('user_id') is-invalid @enderror">
                        <option value="">-- Pilih Pengguna --</option>
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                {{ $user->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('user_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Rating Bintang -->
                <div class="form-group">
                    <label for="rating">Rating</label>
                    <div class="star-rating d-flex gap-1" style="font-size: 2rem; color: gold;">
                        @for ($i = 1; $i <= 5; $i++)
                            <i class="far fa-star star" data-value="{{ $i }}"></i>
                        @endfor

                    </div>
                    <input type="hidden" name="rating" id="rating" value="{{ old('rating', 0) }}">
                    @error('rating')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="comment">Komentar</label>
                    <textarea name="comment" id="comment" rows="4" class="form-control @error('comment') is-invalid @enderror">{{ old('comment') }}</textarea>
                    @error('comment')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <a href="{{ route('admin.reviews.index') }}" class="btn btn-secondary">Kembali</a>
                <button type="submit" class="btn btn-primary">Simpan Review</button>
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

            // Set rating awal jika sudah ada (saat reload karena error misalnya)
            const initialRating = parseInt(ratingInput.value);
            if (initialRating > 0) {
                updateStars(initialRating);
            }
        });
    </script>
@endpush
