@extends('frontend.layouts.app')

@section('title', 'Resep Saya - Rasanesia')

@section('content')
<div class="title">
    <div class="logo-container">
        <img src="{{ asset('assets/img/chef_hat.png') }}" alt="Logo" class="logo-img">
        <span class="logo-text">Resep Saya</span>
    </div>
</div>

<div class="my-recipes-container">
    @if($recipes->count() > 0)
        <div class="recipes-header">
            <h2>Resep yang Telah Anda Buat</h2>
            <p>Total {{ $recipes->total() }} resep</p>
        </div>
        
        <div class="card-grid">
            @foreach($recipes as $recipe)
                <div class="card">
                    <img src="{{ $recipe->foto ? asset('storage/' . $recipe->foto) : asset('assets/img/default-recipe.jpg') }}" 
                         alt="{{ $recipe->name }}" 
                         style="height:160px;width:100%;object-fit:cover;">
                    <div class="card-content">
                        <div class="card-title">{{ $recipe->name }}</div>
                        <div class="card-region">
                            <i class="fas fa-map-marker-alt"></i>
                            <span>{{ $recipe->province ?: 'Tidak ditentukan' }}</span>
                        </div>
                        <div class="card-description">
                            {{ Str::limit($recipe->description, 80) }}
                        </div>
                        <div class="card-meta">
                            <span class="created-date">
                                <i class="fas fa-calendar"></i>
                                {{ $recipe->created_at->format('d M Y') }}
                            </span>
                        </div>
                    </div>
                    <div class="card-actions">
                        <a href="{{ route('recipes.edit', $recipe->id) }}" class="action-btn edit-btn" title="Edit Resep">
                            <i class="fas fa-edit"></i>
                        </a>
                        <button class="action-btn delete-btn" onclick="deleteRecipe({{ $recipe->id }})" title="Hapus Resep">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
            @endforeach
        </div>
        
        <div class="pagination-container">
            {{ $recipes->links() }}
        </div>
    @else
        <div class="empty-state">
            <div class="empty-icon">
                <i class="fas fa-utensils"></i>
            </div>
            <h3>Belum Ada Resep</h3>
            <p>Anda belum membuat resep apapun. Mulai buat resep pertama Anda!</p>
            <a href="{{ route('recipes.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i>
                Buat Resep Pertama
            </a>
        </div>
    @endif
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteModal" class="modal" style="display: none;">
    <div class="modal-content">
        <div class="modal-header">
            <h3>Konfirmasi Hapus</h3>
            <span class="close" onclick="closeDeleteModal()">&times;</span>
        </div>
        <div class="modal-body">
            <p>Apakah Anda yakin ingin menghapus resep ini? Tindakan ini tidak dapat dibatalkan.</p>
            <div class="modal-buttons">
                <button onclick="confirmDelete()" class="btn btn-danger">Hapus</button>
                <button onclick="closeDeleteModal()" class="btn btn-light">Batal</button>
            </div>
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
let recipeToDelete = null;

function deleteRecipe(recipeId) {
    recipeToDelete = recipeId;
    document.getElementById('deleteModal').style.display = 'block';
}

function closeDeleteModal() {
    document.getElementById('deleteModal').style.display = 'none';
    recipeToDelete = null;
}

function confirmDelete() {
    if (recipeToDelete) {
        const form = document.getElementById('deleteForm');
        form.action = `/recipes/${recipeToDelete}`;
        form.submit();
    }
}

// Close modal when clicking outside
window.onclick = function(event) {
    const modal = document.getElementById('deleteModal');
    if (event.target == modal) {
        closeDeleteModal();
    }
}
</script>
@endsection 