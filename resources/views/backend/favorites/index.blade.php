@extends('backend.layouts.app')

@section('contents')
    <h1 class="h3 mb-2 text-gray-800">Data Favorites</h1>
    <p class="mb-4">Halaman ini menampilkan seluruh data favorit resep pengguna.</p>

    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Favorit</h6>
            <a href="{{ route('admin.favorites.create') }}" class="btn btn-sm btn-primary">
                <i class="fas fa-plus"></i> Tambah Favorit
            </a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="favoritesTable" class="table table-bordered text-center" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Pengguna</th>
                            <th>Resep</th>
                            <th>Tanggal Dibuat</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($favorites as $key => $favorite)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        @if ($favorite->user->foto)
                                            <img src="{{ asset('storage/' . $favorite->user->foto) }}" 
                                                class="rounded-circle mr-2" width="40" height="40" 
                                                style="object-fit: cover;">
                                        @else
                                            <img src="https://ui-avatars.com/api/?name={{ urlencode($favorite->user->name) }}&size=40" 
                                                class="rounded-circle mr-2">
                                        @endif
                                        <div>
                                            <div class="font-weight-bold">{{ $favorite->user->name }}</div>
                                            <small class="text-muted">{{ $favorite->user->email }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        @if ($favorite->recipe->foto)
                                            @if (Str::startsWith($favorite->recipe->foto, ['http://', 'https://']))
                                                <img src="{{ $favorite->recipe->foto }}" 
                                                    class="rounded mr-2" width="40" height="40" 
                                                    style="object-fit: cover;">
                                            @else
                                                <img src="{{ asset('storage/' . $favorite->recipe->foto) }}" 
                                                    class="rounded mr-2" width="40" height="40" 
                                                    style="object-fit: cover;">
                                            @endif
                                        @else
                                            <img src="https://ui-avatars.com/api/?name={{ urlencode($favorite->recipe->name) }}&size=40" 
                                                class="rounded mr-2">
                                        @endif
                                        <div>
                                            <div class="font-weight-bold">{{ $favorite->recipe->name }}</div>
                                            <small class="text-muted">{{ $favorite->recipe->province ?? 'Tidak ada daerah' }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>{{ $favorite->created_at->format('d M Y H:i') }}</td>
                                <td>
                                    <a href="{{ route('admin.favorites.show', $favorite->id) }}" class="btn btn-info btn-sm">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.favorites.edit', $favorite->id) }}" class="btn btn-warning btn-sm">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button type="button" class="btn btn-danger btn-sm" data-toggle="modal"
                                        data-target="#deleteModal" data-id="{{ $favorite->id }}"
                                        data-user="{{ $favorite->user->name }}"
                                        data-recipe="{{ $favorite->recipe->name }}">
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
                        <p>Yakin ingin menghapus favorit <strong id="userName"></strong> untuk resep <strong id="recipeName"></strong>?</p>
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
            $('#favoritesTable').DataTable();
        });

        $('#deleteModal').on('show.bs.modal', function(event) {
            const button = $(event.relatedTarget);
            const favoriteId = button.data('id');
            const userName = button.data('user');
            const recipeName = button.data('recipe');
            const action = '/admin-favorites/' + favoriteId;

            $('#deleteForm').attr('action', action);
            $('#userName').text(userName);
            $('#recipeName').text(recipeName);
        });
    </script>
@endpush 