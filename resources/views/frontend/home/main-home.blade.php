v<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rasanesia - Main Menu</title>
    <link rel="stylesheet" href="/assets/css/main-home.css">
</head>
<body>
<div class="container">
    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <button class="toggle" onclick="toggleSidebar()">&#9776;</button>
        <div class="nav">
            <div class="nav-item">
                <span class="icon">
                    <svg width="22" height="22" fill="none" stroke="#a3b48b" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="M3 12L12 3l9 9"/><path d="M9 21V9h6v12"/></svg>
                </span><span class="label">Home</span>
            </div>
            <div class="nav-item">
                <span class="icon">
                    <svg width="22" height="22" fill="none" stroke="#a3b48b" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><circle cx="12" cy="8" r="4"/><path d="M4 20c0-4 8-4 8-4s8 0 8 4"/></svg>
                </span><span class="label">Profile</span>
            </div>
            <div class="nav-item">
                <span class="icon">
                    <svg width="22" height="22" fill="none" stroke="#a3b48b" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><circle cx="11" cy="11" r="7"/><path d="M21 21l-4.35-4.35"/></svg>
                </span><span class="label">Search</span>
            </div>
            <div class="nav-item">
                <span class="icon">
                    <svg width="22" height="22" fill="none" stroke="#a3b48b" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/></svg>
                </span><span class="label">All Recipes</span>
            </div>
            <div class="nav-item">
                <span class="icon">
                    <svg width="22" height="22" fill="none" stroke="#a3b48b" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><rect x="3" y="7" width="18" height="13" rx="2"/><path d="M16 3v4M8 3v4M3 7h18"/></svg>
                </span><span class="label">Archive</span>
            </div>
        </div>
    </div>
    <!-- Main Content -->
    <div class="main-content">
        <div class="title">
            <div class="logo-container">
                <img src="{{ asset('assets/img/chef_hat.png') }}" alt="Logo" class="logo-img">
                <span class="logo-text">Rasanesia</span>
            </div>
        </div>
        <div class="search-bar">
            <input type="text" placeholder="Cari resep, bahan, pengguna">
            <button>Cari</button>
        </div>
        <div class="carousel">
            #Gaskeun2025 #MasakdiRumahAja &nbsp; Inspirasi Masak <br> FOOD AROUND NUSANTARA
        </div>
        <div class="section-title">Pencarian populer resep daerah!</div>
        <div class="card-grid">
            @foreach($randomRecipes as $recipe)
                <div class="card">
                    <img src="{{ $recipe->foto }}" alt="{{ $recipe->name }}" style="height:160px;width:100%;object-fit:cover;">
                    <div class="card-title">{{ $recipe->name }}</div>
                </div>
            @endforeach
        </div>
        <div class="section-title">Resep populer yang dibuat banyak orang saat ini!</div>
        <div class="card-grid">
            @foreach($bestRatedRecipes as $recipe)
                <div class="card">
                    <img src="{{ $recipe->foto }}" alt="{{ $recipe->name }}" style="height:160px;width:100%;object-fit:cover;">
                    <div class="card-title">{{ $recipe->name }}</div>
                    <div style="font-size:0.95em;color:#e0a800;">Rating: {{ number_format($recipe->reviews_avg_rating,1) }}</div>
                </div>
            @endforeach
        </div>
        <div class="section-title">Kategori Masakan Daerah</div>
        <div class="category-grid">
            @foreach($recipesByProvince as $province => $recipes)
                @foreach($recipes as $recipe)
                    <div class="category-card">
                        <img src="{{ $recipe->foto }}" alt="{{ $recipe->name }}" style="height:160px;width:100%;object-fit:cover;">
                        <div class="category-title">{{ $province }}</div>
                        <div style="font-size:0.95em;">{{ $recipe->name }}</div>
                    </div>
                @endforeach
            @endforeach
        </div>
        <div class="footer">
            &copy; 2025 Rasanesia. All rights reserved.
        </div>
    </div>
</div>
<script>
    function toggleSidebar() {
        var sidebar = document.getElementById('sidebar');
        sidebar.classList.toggle('expanded');
    }
</script>
</body>
</html>
