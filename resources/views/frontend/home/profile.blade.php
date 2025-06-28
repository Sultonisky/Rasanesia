@extends('frontend.layouts.app')

@section('title', 'Profile - Rasanesia')

@section('styles')
<link rel="stylesheet" href="{{ asset('assets/css/profile.css') }}">
@endsection

@section('content')
<div class="profile-container">
    <!-- Title -->
    <div class="title">
        <i class="fas fa-user"></i>
        <span>Profile</span>
    </div>

    <!-- Success Message -->
    @if(session('success'))
        <div class="alert alert-success">
            <i class="fas fa-check-circle"></i>
            {{ session('success') }}
        </div>
    @endif

    <!-- Error Messages -->
    @if($errors->any())
        <div class="alert alert-danger">
            <i class="fas fa-exclamation-circle"></i>
            <ul style="margin: 0; padding-left: 20px;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Profile Card -->
    <div class="profile-card">
        <div class="profile-content">
            <!-- Left Side - Profile Photo -->
            <div class="profile-photo-section">
                <div class="profile-photo-container">
                    @if(auth()->user()->foto)
                        <img src="{{ asset('storage/' . auth()->user()->foto) }}" alt="Profile Photo" class="profile-photo" id="profile-photo-preview">
                    @else
                        <div class="profile-photo-placeholder" id="profile-photo-preview">
                            <i class="fas fa-user"></i>
                        </div>
                    @endif
                </div>
                
                <div class="photo-upload-section">
                    <input type="file" id="profile-photo-input" accept="image/*" style="display: none;">
                    <button type="button" class="btn btn-secondary photo-upload-btn" onclick="document.getElementById('profile-photo-input').click()">
                        <i class="fas fa-camera"></i>
                        <span>Ubah Foto Profile</span>
                    </button>
                    <p class="photo-hint">Format: JPG, PNG, GIF (Max: 2MB)</p>
                </div>
            </div>

            <!-- Right Side - Profile Form -->
            <div class="profile-form-section">
                <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" id="profile-form">
                    @csrf
                    @method('PUT')
                    
                    <!-- Hidden file input for photo upload -->
                    <input type="file" name="foto" id="hidden-foto-input" accept="image/*" style="display: none;">
                    
                    <div class="form-group">
                        <label for="name">Nama</label>
                        <input type="text" 
                               id="name" 
                               name="name" 
                               class="form-control @error('name') is-invalid @enderror" 
                               value="{{ old('name', auth()->user()->name) }}" 
                               required>
                        @error('name')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" 
                               id="email" 
                               name="email" 
                               class="form-control @error('email') is-invalid @enderror" 
                               value="{{ old('email', auth()->user()->email) }}" 
                               required>
                        @error('email')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary" id="submit-btn">
                            <i class="fas fa-save"></i>
                            <span>Save Changes</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const photoInput = document.getElementById('profile-photo-input');
    const photoPreview = document.getElementById('profile-photo-preview');
    const hiddenFileInput = document.getElementById('hidden-foto-input');
    const submitBtn = document.getElementById('submit-btn');
    
    photoInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            // Validate file size (2MB)
            if (file.size > 2 * 1024 * 1024) {
                alert('File terlalu besar. Maksimal 2MB.');
                return;
            }
            
            // Validate file type
            if (!file.type.startsWith('image/')) {
                alert('File harus berupa gambar.');
                return;
            }
            
            // Update hidden file input for form submission
            const dataTransfer = new DataTransfer();
            dataTransfer.items.add(file);
            hiddenFileInput.files = dataTransfer.files;
            
            const reader = new FileReader();
            reader.onload = function(e) {
                // Create new image element
                const img = document.createElement('img');
                img.src = e.target.result;
                img.className = 'profile-photo';
                img.alt = 'Profile Photo';
                
                // Clear container and add new image
                photoPreview.parentElement.innerHTML = '';
                photoPreview.parentElement.appendChild(img);
            };
            reader.readAsDataURL(file);
        }
    });

    // Form submission handling
    document.getElementById('profile-form').addEventListener('submit', function(e) {
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i><span>Menyimpan...</span>';
    });
});
</script>
@endsection