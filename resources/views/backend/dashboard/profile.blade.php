@extends('backend.layouts.app')

@section('contents')
    <h4 class="mb-4">Profile Settings</h4>

    <form method="POST" enctype="multipart/form-data" action="{{ route('admin.profile.update') }}">
        @csrf
        @method('PUT')

        <div class="row">
            <!-- Foto Preview -->
            <div class="col-md-4 mb-4">
                <div class="card shadow">
                    <div class="card-body text-center">
                        <h5 class="mb-3">Foto Profil</h5>
                        <img src="{{ auth()->user()->foto ? asset('storage/' . auth()->user()->foto) : 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name) }}"
                            class="img-thumbnail foto-preview" id="preview-image"
                            style="width: 100%; max-height: 300px; object-fit: cover;" alt="Preview Foto">

                        <input type="file" name="foto" class="form-control mt-3" onchange="previewFoto()">
                        <small class="text-muted">Kosongkan jika tidak ingin mengubah foto.</small>
                    </div>
                </div>
            </div>

            <!-- Form Input -->
            <div class="col-md-8">
                <div class="card shadow">
                    <div class="card-body">
                        <!-- Name -->
                        <div class="form-group">
                            <label for="name">Nama</label>
                            <input type="text" name="name" class="form-control" value="{{ auth()->user()->name }}">
                        </div>

                        <!-- Email -->
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" name="email" class="form-control" value="{{ auth()->user()->email }}"
                                disabled>
                        </div>

                        <!-- Tombol -->
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Simpan Perubahan
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection

@push('scripts')
    <script>
        function previewFoto() {
            const foto = document.querySelector('input[name="foto"]');
            const fotoPreview = document.querySelector('.foto-preview');

            if (foto && foto.files && foto.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    fotoPreview.src = e.target.result;
                    fotoPreview.style.display = 'block';
                };
                reader.readAsDataURL(foto.files[0]);
            }
        }
    </script>
@endpush
