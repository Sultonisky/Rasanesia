@extends('frontend.layouts.app')

@section('title', 'Resep Saya - Rasanesia')

@section('content')
<div class="my-recipes-page">
    <!-- Title & Search Bar -->
    <div class="recipes-header-bar">
        <div class="recipes-title" style="text-align:center; width:100%;">
            <h1>Resep Saya</h1>
        </div>
        <form class="recipes-search" method="GET" action="">
            <input type="text" name="q" placeholder="Cari resep yang telah Anda buat..." value="{{ request('q') }}" autocomplete="off" />
            <button type="submit"><i class="fas fa-search"></i></button>
        </form>
    </div>

    <!-- Recipes List -->
    <div class="recipes-list-area">
        @if($recipes->count() > 0)
            <div class="recipes-list">
                @foreach($recipes as $recipe)
                    <div class="recipe-card">
                        <div class="recipe-card-img">
                            <img src="{{ $recipe->foto ? asset('storage/' . $recipe->foto) : asset('assets/img/default-recipe.jpg') }}" alt="{{ $recipe->name }}" loading="lazy">
                        </div>
                        <div class="recipe-card-content">
                            <div class="recipe-card-header">
                                <h2 class="recipe-card-title">{{ $recipe->name }}</h2>
                                <div class="recipe-card-actions">
                                    <a href="{{ route('recipes.edit', $recipe->id) }}" class="edit-btn" title="Edit Resep"><i class="fas fa-edit"></i></a>
                                    <button class="delete-btn" onclick="deleteRecipe({{ $recipe->id }})" title="Hapus Resep"><i class="fas fa-trash"></i></button>
                                </div>
                            </div>
                            <div class="recipe-card-meta">
                                <span class="meta-item"><i class="fas fa-calendar-alt"></i> {{ $recipe->created_at->format('d M Y, H:i') }}</span>
                                <span class="meta-item"><i class="fas fa-map-marker-alt"></i> {{ $recipe->province ?: 'Tidak ditentukan' }}</span>
                            </div>
                            <div class="recipe-card-desc">
                                {{ Str::limit($recipe->description, 100) }}
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="pagination-wrapper">
                {{ $recipes->links() }}
            </div>
        @else
            <div class="empty-state">
                <div class="empty-illustration">
                    <i class="fas fa-book-open"></i>
                </div>
                <div class="empty-content">
                    <h2>Belum Ada Resep</h2>
                    <p>Anda belum membuat resep apapun. Mulai perjalanan kuliner Anda dengan membuat resep pertama!</p>
                    <div class="empty-actions">
                        <a href="{{ route('recipes.create') }}" class="btn-primary">
                            <i class="fas fa-plus"></i>
                            Buat Resep Pertama
                        </a>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>

<!-- Delete Modal -->
<div id="deleteModal" class="modal-overlay">
    <div class="modal-container">
        <div class="modal-header">
            <div class="modal-icon">
                <i class="fas fa-exclamation-triangle"></i>
            </div>
            <h3>Konfirmasi Hapus</h3>
            <button class="modal-close" onclick="closeDeleteModal()">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="modal-body">
            <p>Apakah Anda yakin ingin menghapus resep ini? Tindakan ini tidak dapat dibatalkan.</p>
        </div>
        <div class="modal-footer">
            <button class="btn-cancel" onclick="closeDeleteModal()">
                <i class="fas fa-times"></i>
                Batal
            </button>
            <button class="btn-delete" onclick="confirmDelete()">
                <i class="fas fa-trash"></i>
                Hapus Resep
            </button>
        </div>
    </div>
</div>
<form id="deleteForm" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>
@endsection

@section('scripts')
<script>
function deleteRecipe(recipeId) {
    window.recipeToDelete = recipeId;
    document.getElementById('deleteModal').classList.add('active');
    document.body.style.overflow = 'hidden';
}
function closeDeleteModal() {
    document.getElementById('deleteModal').classList.remove('active');
    document.body.style.overflow = 'auto';
    window.recipeToDelete = null;
}
function confirmDelete() {
    if (window.recipeToDelete) {
        const form = document.getElementById('deleteForm');
        form.action = /recipes/${window.recipeToDelete};
        form.submit();
    }
}
document.getElementById('deleteModal').addEventListener('click', function(event) {
    if (event.target === this) {
        closeDeleteModal();
    }
});
</script>
@endsection

@section('styles')
<link rel="stylesheet" href="{{ asset('assets/css/my-recipes.css') }}">
@endsection