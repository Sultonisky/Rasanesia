@extends('backend.layouts.app')

@section('contents')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Review Terhapus</h1>
    <a href="{{ route('admin.reviews.index') }}" class="btn btn-secondary mb-3">Kembali ke Daftar Review</a>
    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Resep</th>
                            <th>User</th>
                            <th>Rating</th>
                            <th>Dihapus Pada</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($reviews as $review)
                        <tr>
                            <td>{{ $review->id }}</td>
                            <td>{{ $review->recipe->name ?? '-' }}</td>
                            <td>{{ $review->user->name ?? '-' }}</td>
                            <td>{{ $review->rating }}</td>
                            <td>{{ $review->deleted_at }}</td>
                            <td>
                                <form action="{{ route('admin.reviews.restore', $review->id) }}" method="POST" style="display:inline-block;">
                                    @csrf
                                    <button type="submit" class="btn btn-success btn-sm">Restore</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center">Tidak ada review terhapus.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection 