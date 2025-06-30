@extends('backend.layouts.app')

@section('contents')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Favorite Terhapus</h1>
    <a href="{{ route('admin.favorites.index') }}" class="btn btn-secondary mb-3">Kembali ke Daftar Favorite</a>
    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>User</th>
                            <th>Resep</th>
                            <th>Dihapus Pada</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($favorites as $favorite)
                        <tr>
                            <td>{{ $favorite->id }}</td>
                            <td>{{ $favorite->user->name ?? '-' }}</td>
                            <td>{{ $favorite->recipe->name ?? '-' }}</td>
                            <td>{{ $favorite->deleted_at }}</td>
                            <td>
                                <form action="{{ route('admin.favorites.restore', $favorite->id) }}" method="POST" style="display:inline-block;">
                                    @csrf
                                    <button type="submit" class="btn btn-success btn-sm">Restore</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center">Tidak ada favorite terhapus.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection 