@extends('backend.layouts.app')

@section('contents')
    <h1 class="h3 mb-2 text-gray-800">Detail Review</h1>
    <p class="mb-4">Halaman ini menampilkan detail dari review yang dipilih.</p>

    <div class="card shadow mb-4">
        <div class="card-body">

            <div class="mb-3">
                <label class="form-label fw-bold">Nama Resep</label>
                <p>{{ $review->recipe->name ?? '-' }}</p>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Nama Reviewer</label>
                <p>{{ $review->user->name ?? '-' }}</p>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Rating</label>
                <div>
                    @for ($i = 1; $i <= 5; $i++)
                        <i class="{{ $i <= $review->rating ? 'fas' : 'far' }} fa-star text-warning"></i>
                    @endfor
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Komentar</label>
                <div class="border p-3 rounded bg-light">
                    {{ $review->comment }}
                </div>
            </div>

            <a href="{{ route('admin.reviews.index') }}" class="btn btn-secondary">Kembali</a>
        </div>
    </div>
@endsection
