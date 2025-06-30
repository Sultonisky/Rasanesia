@extends('backend.layouts.app')

@php
    use Illuminate\Support\Str;
@endphp

@section('contents')
    <h1 class="h3 mb-2 text-gray-800">Data Review</h1>
    <p class="mb-4">Halaman ini menampilkan seluruh ulasan pengguna terhadap resep.</p>

    <a href="{{ route('admin.reviews.trashed') }}" class="btn btn-warning mb-3">Lihat Review Terhapus</a>

    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Review</h6>
            <a href="{{ route('admin.reviews.create') }}" class="btn btn-sm btn-primary">
                <i class="fas fa-plus"></i> Tambah Review
            </a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="reviewTable" class="table table-bordered text-center" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Nama User</th>
                            <th>Nama Resep</th>
                            <th>Rating</th>
                            <th>Komentar</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($reviews as $review)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $review->user->name ?? '-' }}</td>
                                <td>{{ $review->recipe->name ?? '-' }}</td>
                                <td>
                                    @for ($i = 1; $i <= 5; $i++)
                                        <i
                                            class="fas fa-star {{ $i <= $review->rating ? 'text-warning' : 'text-muted' }}"></i>
                                    @endfor
                                </td>
                                <td>{{ Str::limit($review->comment, 60) }}</td>
                                <td>
                                    <a href="{{ route('admin.reviews.show', $review->id) }}" class="btn btn-info btn-sm">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.reviews.edit', $review->id) }}" class="btn btn-warning btn-sm">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button type="button" class="btn btn-danger btn-sm" data-toggle="modal"
                                        data-target="#deleteModal" data-id="{{ $review->id }}"
                                        data-name="Review oleh {{ $review->user->name }}">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal Konfirmasi Hapus -->
    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form method="POST" id="deleteForm">
                @csrf
                @method('DELETE')
                <div class="modal-content">
                    <div class="modal-header bg-danger text-white">
                        <h5 class="modal-title" id="deleteModalLabel">Konfirmasi Hapus</h5>
                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <p>Yakin ingin menghapus <strong id="reviewName"></strong>?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-danger">Hapus</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('#reviewTable').DataTable();
        });

        $('#deleteModal').on('show.bs.modal', function(event) {
            const button = $(event.relatedTarget);
            const reviewId = button.data('id');
            const reviewName = button.data('name');
            const action = '/reviews/' + reviewId;

            $('#deleteForm').attr('action', action);
            $('#reviewName').text(reviewName);
        });
    </script>
@endpush
