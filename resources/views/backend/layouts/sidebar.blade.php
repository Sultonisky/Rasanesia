<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('dashboard') }}">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-fw fa-utensils"></i> {{-- ikon makanan khas --}}
        </div>
        <div class="sidebar-brand-text mx-3">Rasanesia</div>
    </a>

    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item">
        <a class="nav-link" href="{{ route('dashboard') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
    </li>

    <!-- Nav Item - Users -->
    <li class="nav-item">
        <a class="nav-link" href="{{ route('users.index') }}">
            <i class="fas fa-fw fa-users"></i>
            <span>Users</span>
        </a>
    </li>

    <!-- Nav Item - Recipes -->
    <li class="nav-item">
        <a class="nav-link" href="{{ route('admin.recipes.index') }}">
            <i class="fas fa-fw fa-utensils"></i>
            <span>Recipes</span>
        </a>
    </li>

    <!-- Nav Item - Reviews -->
    <li class="nav-item">
        <a class="nav-link" href="{{ route('reviews.index') }}">
            <i class="fas fa-fw fa-star"></i>
            <span>Reviews</span>
        </a>
    </li>

    <!-- Nav Item - Favorites -->
    <li class="nav-item">
        <a class="nav-link" href="{{ route('admin.favorites.index') }}">
            <i class="fas fa-fw fa-heart"></i>
            <span>Favorites</span>
        </a>
    </li>

    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
