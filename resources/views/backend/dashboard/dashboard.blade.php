@extends('backend.layouts.app')


@section('contents')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
        <span class="text-muted">Selamat datang kembali, {{ Auth::user()->name }}</span>
    </div>

    <!-- Row Card Statistik -->
    <div class="row">
        <!-- Total Resep -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Resep</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $recipesCount }}</div>
                    </div>
                    <i class="fas fa-utensils fa-2x text-gray-300"></i>
                </div>
            </div>
        </div>

        <!-- Total Review -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Total Review</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $reviewsCount }}</div>
                    </div>
                    <i class="fas fa-star fa-2x text-gray-300"></i>
                </div>
            </div>
        </div>

        <!-- Jumlah Pengguna -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Jumlah Pengguna</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $usersCount }}</div>
                    </div>
                    <i class="fas fa-users fa-2x text-gray-300"></i>
                </div>
            </div>
        </div>

        <!-- Total Provinsi Asal Resep -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Asal Provinsi</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $provinceCount }}</div>
                    </div>
                    <i class="fas fa-map-marked-alt fa-2x text-gray-300"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Review Terbaru</h6>
            <a href="{{ route('admin.reviews.index') }}" class="btn btn-sm btn-secondary">Lihat Semua</a>
        </div>
        <div class="card-body p-0">
            <ul class="list-group list-group-flush">
                @forelse ($latestReviews as $review)
                    <li class="list-group-item">
                        <strong>{{ $review->user->name }}</strong> beri rating
                        <span class="text-warning">
                            @for ($i = 1; $i <= 5; $i++)
                                <i class="{{ $i <= $review->rating ? 'fas' : 'far' }} fa-star"></i>
                            @endfor
                        </span>
                        <br>
                        <small class="text-muted">{{ $review->recipe->name }} —
                            {{ Str::limit($review->comment, 60) }}</small>
                    </li>
                @empty
                    <li class="list-group-item text-center text-muted">Belum ada review.</li>
                @endforelse
            </ul>
        </div>
    </div>


    <div class="card shadow mb-4">
        <div class="card-header">
            <h6 class="m-0 font-weight-bold text-primary">Sebaran Resep per Provinsi</h6>
        </div>
        <div class="card-body">
            <canvas id="provinceChart" height="100"></canvas>
        </div>
    </div>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            const ctx = document.getElementById('provinceChart').getContext('2d');
            const provinceChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: {!! json_encode($provinceNames) !!},
                    datasets: [{
                        label: 'Jumlah Resep per Provinsi',
                        data: {!! json_encode($provinceCounts) !!},
                        backgroundColor: 'rgba(54, 162, 235, 0.7)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1,
                        borderRadius: 6,
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                precision: 0
                            }
                        }
                    }
                }
            });
        </script>
    @endpush
@endsection
