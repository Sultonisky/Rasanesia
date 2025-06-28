@extends('frontend.layouts.app')

@section('title', 'Pencarian Resep - Rasanesia')

@section('content')
<div class="title">
    <div class="logo-container">
        <img src="{{ asset('assets/img/chef_hat.png') }}" alt="Logo" class="logo-img">
        <span class="logo-text">Pencarian Resep</span>
    </div>
</div>

<div class="search-bar">
    <form action="{{ route('search') }}" method="GET" style="display: flex; width: 100%;">
        <input type="text" name="q" placeholder="Cari resep berdasarkan nama, bahan, atau provinsi..." value="{{ $query }}" style="flex: 1;">
        <button type="submit">
            <i class="fas fa-search"></i>
        </button>
    </form>
</div>

@if($query)
    @if($recipes->count() > 0)
        <div class="section-title">
            <i class="fas fa-search"></i>
            Hasil Pencarian untuk "{{ $query }}" ({{ $recipes->count() }} resep ditemukan)
        </div>
        
        <div class="card-grid">
            @foreach($recipes as $recipe)
                <div class="card">
                    <img src="{{ asset('storage/' . $recipe->foto) }}" alt="{{ $recipe->name }}">
                    
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
                    
                    @auth
                        <button class="favorite-btn" onclick="toggleFavorite({{ $recipe->id }})" data-recipe-id="{{ $recipe->id }}">
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
    @else
        <div class="empty-state">
            <div class="empty-state-icon">
                <i class="fas fa-search"></i>
            </div>
            <h3 class="empty-state-title">Tidak Ada Hasil</h3>
            <p class="empty-state-text">Tidak ada resep yang ditemukan untuk pencarian "{{ $query }}".</p>
            <p class="empty-state-text">Coba kata kunci lain atau lihat <a href="{{ route('all-recipes') }}" style="color: #4CAF50; text-decoration: none;">semua resep</a>.</p>
        </div>
    @endif
@else
    <div class="empty-state">
        <div class="empty-state-icon">
            <i class="fas fa-search"></i>
        </div>
        <h3 class="empty-state-title">Mulai Pencarian</h3>
        <p class="empty-state-text">Masukkan kata kunci untuk mencari resep berdasarkan nama, bahan, atau provinsi.</p>
        <div style="margin-top: 20px;">
            <h4 style="color: #666; margin-bottom: 10px;">Contoh pencarian:</h4>
            <div style="display: flex; flex-wrap: wrap; gap: 10px;">
                <a href="{{ route('search', ['q' => 'nasi']) }}" class="btn btn-secondary" style="font-size: 12px; padding: 8px 16px;">Nasi</a>
                <a href="{{ route('search', ['q' => 'ayam']) }}" class="btn btn-secondary" style="font-size: 12px; padding: 8px 16px;">Ayam</a>
                <a href="{{ route('search', ['q' => 'Jawa']) }}" class="btn btn-secondary" style="font-size: 12px; padding: 8px 16px;">Jawa</a>
                <a href="{{ route('search', ['q' => 'pedas']) }}" class="btn btn-secondary" style="font-size: 12px; padding: 8px 16px;">Pedas</a>
            </div>
        </div>
    </div>
@endif

<!-- Login Alert Modal -->
<div class="modal fade" id="loginAlert" tabindex="-1" aria-labelledby="loginAlertLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="loginAlertLabel">Login Diperlukan</h5>
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
    const modal = new bootstrap.Modal(document.getElementById('loginAlert'));
    modal.show();
}

@auth
function toggleFavorite(recipeId) {
    fetch('/favorites/toggle', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({ recipe_id: recipeId })
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