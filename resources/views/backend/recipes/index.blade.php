@extends('backend.layouts.app')


@section('contents')
    <h1 class="h3 mb-2 text-gray-800">Data Recipes</h1>
    <p class="mb-4">Halaman ini menampilkan seluruh data resep.</p>

    @include('components.alert')

    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Resep</h6>
            <a href="{{ route('recipes.create') }}" class="btn btn-sm btn-primary">
                <i class="fas fa-plus"></i> Tambah Resep
            </a>
        </div>
        <div class="card-body">
            <div class="table-responsive ">
                <table id="recipeTable" class="table table-bordered text-center" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Foto</th>
                            <th>Nama Resep</th>
                            <th>Pembuat</th>
                            {{-- <th>Bahan</th>
                            <th>Step</th> --}}
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($recipes as $key => $recipe)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td class="text-center">
                                    @if ($recipe->foto)
                                        <img src="{{ asset('storage/' . $recipe->foto) }}" width="60" height="60"
                                            style="object-fit: cover; border-radius: 8px;">
                                    @else
                                        <img src="https://ui-avatars.com/api/?name={{ urlencode($recipe->name) }}"
                                            width="60" height="60" style="border-radius: 8px;">
                                    @endif
                                </td>
                                <td>{{ $recipe->name }}</td>
                                <td>{{ $recipe->user->name ?? '-' }}</td>
                                {{-- <td>{{ $recipe->ingredients ?? '-' }}</td>
                                <td>{{ $recipe->steps ?? '-' }}</td> --}}
                                <td>
                                    <a href="{{ route('recipes.show', $recipe->id) }}" class="btn btn-info btn-sm">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('recipes.edit', $recipe->id) }}" class="btn btn-warning btn-sm">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button type="button" class="btn btn-danger btn-sm" data-toggle="modal"
                                        data-target="#deleteModal" data-id="{{ $recipe->id }}"
                                        data-name="{{ $recipe->name }}">
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

    <!-- Modal Hapus -->
    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form method="POST" id="deleteForm">
                @csrf
                @method('DELETE')
                <div class="modal-content">
                    <div class="modal-header bg-danger text-white">
                        <h5 class="modal-title" id="deleteModalLabel">Konfirmasi Hapus</h5>
                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Yakin ingin menghapus resep <strong id="recipeName"></strong>?</p>
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
            $('#recipeTable').DataTable();
        });

        $('#deleteModal').on('show.bs.modal', function(event) {
            const button = $(event.relatedTarget);
            const recipeId = button.data('id');
            const recipeName = button.data('name');
            const action = '/recipes/' + recipeId;

            $('#deleteForm').attr('action', action);
            $('#recipeName').text(recipeName);
        });
    </script>
@endpush
