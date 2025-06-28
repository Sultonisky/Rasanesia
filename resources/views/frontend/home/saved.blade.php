@extends('frontend.layouts.app')

@section('content')
<div class="main-content">
        <div class="back-button">
            <a href="{{ route('main-home') }}" style="text-decoration: none; color: inherit;">
                <svg 
                    xmlns="http://www.w3.org/2000/svg" 
                    width="32" 
                    height="32" 
                    viewBox="0 0 24 24" 
                    fill="none"
                    stroke="#202020" 
                    stroke-width="2" 
                    stroke-linecap="round" 
                    stroke-linejoin="round">
                    <line x1="20" y1="12" x2="4" y2="12" />
                    <polyline points="10 18 4 12 10 6" />
                </svg>
            </a>
            <h2>Disimpan</h2>
        </div>

        <!-- Looping Data disini -->
        <div class="card-container">
            @if($favorites->count() > 0)
                @foreach($favorites as $recipe)
                    <div class="card">
                        @if($recipe->foto)
                            @if(Str::startsWith($recipe->foto, ['http://', 'https://']))
                                <img src="{{ $recipe->foto }}" alt="{{ $recipe->name }}">
                            @else
                                <img src="{{ asset('storage/' . $recipe->foto) }}" alt="{{ $recipe->name }}">
                            @endif
                        @else
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($recipe->name) }}&size=200&background=random" alt="{{ $recipe->name }}">
                        @endif
                        <h3 class="title">{{ $recipe->name }}</h3>
                        <button class="btn btn-danger btn-sm remove-favorite" data-recipe-id="{{ $recipe->id }}" style="margin-top: 10px;">
                            <i class="fas fa-heart-broken"></i> Hapus dari Favorit
                        </button>
                    </div>
                @endforeach
            @else
                <div style="text-align: center; padding: 50px; color: #666;">
                    <i class="fas fa-heart" style="font-size: 48px; margin-bottom: 20px; color: #ddd;"></i>
                    <h3>Belum ada resep favorit</h3>
                    <p>Anda belum menyimpan resep apapun ke dalam favorit.</p>
                    <a href="{{ route('main-home') }}" class="btn btn-primary">Jelajahi Resep</a>
                </div>
            @endif
        </div>
    </div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    $('.remove-favorite').click(function() {
        const recipeId = $(this).data('recipe-id');
        const card = $(this).closest('.card');
        
        $.ajax({
            url: '{{ route("favorites.destroy") }}',
            method: 'DELETE',
            data: {
                recipe_id: recipeId,
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                if (response.success) {
                    card.fadeOut(300, function() {
                        $(this).remove();
                        // Check if no more cards
                        if ($('.card-container .card').length === 0) {
                            location.reload(); // Reload to show empty state
                        }
                    });
                }
            },
            error: function() {
                alert('Terjadi kesalahan saat menghapus dari favorit');
            }
        });
    });
});
</script>
@endpush