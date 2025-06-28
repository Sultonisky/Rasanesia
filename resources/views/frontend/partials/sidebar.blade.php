<div class="sidebar" id="sidebar">
    <button class="toggle" onclick="toggleSidebar()">
        <i class="fas fa-bars"></i>
    </button>
    <div class="nav">
        <div class="nav-item">
            <a href="{{ route('main-home') }}" style="text-decoration: none; color: inherit;">
                <span class="icon">
                    <i class="fas fa-home"></i>
                </span><span class="label">Home</span>
            </a>
        </div>
        
        <div class="nav-item">
            <a href="{{ route('all-recipes') }}" style="text-decoration: none; color: inherit;">
                <span class="icon">
                    <i class="fas fa-utensils"></i>
                </span><span class="label">All Recipes</span>
            </a>
        </div>
        
        <div class="nav-item">
            <a href="{{ route('search') }}" style="text-decoration: none; color: inherit;">
                <span class="icon">
                    <i class="fas fa-search"></i>
                </span><span class="label">Search</span>
            </a>
        </div>
        
        @auth
            <div class="nav-item">
                <a href="{{ route('profile') }}" style="text-decoration: none; color: inherit;">
                    <span class="icon">
                        <i class="fas fa-user"></i>
                    </span><span class="label">Profile</span>
                </a>
            </div>
        @else
            <div class="nav-item">
                <a href="#" onclick="showLoginAlert('profile')" style="text-decoration: none; color: inherit;">
                    <span class="icon">
                        <i class="fas fa-user"></i>
                    </span><span class="label">Profile</span>
                </a>
            </div>
        @endauth
        
        @auth
            <div class="nav-item">
                <a href="{{ route('recipes.create') }}" style="text-decoration: none; color: inherit;">
                    <span class="icon">
                        <i class="fas fa-plus"></i>
                    </span><span class="label">Tambah Resep</span>
                </a>
            </div>
        @else
            <div class="nav-item">
                <a href="#" onclick="showLoginAlert('tambah resep')" style="text-decoration: none; color: inherit;">
                    <span class="icon">
                        <i class="fas fa-plus"></i>
                    </span><span class="label">Tambah Resep</span>
                </a>
            </div>
        @endauth
        
        @auth
            <div class="nav-item dropdown">
                <div onclick="toggleDropdown(this)" style="display: flex; align-items: center; justify-content: space-between; width: 100%; cursor: pointer;">
                    <div style="display: flex; align-items: center; gap: 10px;">
                        <span class="icon">
                            <i class="fas fa-archive"></i>
                        </span><span class="label">Archive</span>
                    </div>
                    <div class="dropdown-arrow">
                        <i class="fas fa-chevron-down"></i>
                    </div>
                </div>
                <div class="dropdown-menu">
                    <a href="{{ route('my-recipes') }}" class="dropdown-item">
                        <i class="fas fa-book-open"></i>
                        Resep Saya
                    </a>
                    <a href="{{ route('saved') }}" class="dropdown-item">
                        <i class="fas fa-heart"></i>
                        Favorite
                    </a>
                </div>
            </div>
        @else
            <div class="nav-item">
                <a href="#" onclick="showLoginAlert('archive')" style="text-decoration: none; color: inherit;">
                    <span class="icon">
                        <i class="fas fa-archive"></i>
                    </span><span class="label">Archive</span>
                </a>
            </div>
        @endauth
        
        @guest
            <div class="nav-item">
                <a href="{{ route('login') }}" style="text-decoration: none; color: inherit;">
                    <span class="icon">
                        <i class="fas fa-sign-in-alt"></i>
                    </span><span class="label">Login</span>
                </a>
            </div>
        @endguest
        
        @auth
            <div class="nav-item mobile-logout">
                <button type="button" onclick="confirmLogout()" style="background: none; border: none; color: inherit; cursor: pointer; display: flex; flex-direction: column; align-items: center; gap: 5px; width: 100%; padding: 8px 12px; border-radius: 8px; transition: background 0.2s, color 0.2s; font-size: 0.9em;">
                    <span class="icon">
                        <i class="fas fa-sign-out-alt"></i>
                    </span><span class="label">Logout</span>
                </button>
            </div>
        @endauth
    </div>
    
    @auth
        <div class="nav-footer">
            <div class="nav-item logout-item">
                <button type="button" onclick="confirmLogout()" style="background: none; border: none; color: inherit; cursor: pointer; display: flex; align-items: center; gap: 10px; width: 100%; padding: 10px 15px; border-radius: 8px; transition: background 0.2s, color 0.2s; font-size: 1.1em;">
                    <span class="icon">
                        <i class="fas fa-sign-out-alt"></i>
                    </span><span class="label">Logout</span>
                </button>
            </div>
        </div>
    @endauth
</div>

<!-- Login Alert Modal -->
<div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="loginModalLabel">Login Diperlukan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Anda harus login terlebih dahulu untuk mengakses fitur <span id="featureName"></span>.</p>
            </div>
            <div class="modal-footer">
                <a href="{{ route('login') }}" class="btn btn-primary">Login</a>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
            </div>
        </div>
    </div>
</div>

<!-- Logout Confirmation Modal -->
<div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="logoutModalLabel">
                    <i class="fas fa-exclamation-triangle text-warning"></i>
                    Konfirmasi Logout
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Apakah Anda yakin ingin keluar dari akun ini?</p>
                <p class="text-muted small">Anda akan perlu login kembali untuk mengakses fitur-fitur yang memerlukan autentikasi.</p>
            </div>
            <div class="modal-footer">
                <form action="{{ route('frontend.logout') }}" method="POST" id="logoutForm">
                    @csrf
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-sign-out-alt"></i>
                        Ya, Logout
                    </button>
                </form>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times"></i>
                    Batal
                </button>
            </div>
        </div>
    </div>
</div>

<script>
function toggleSidebar() {
    const sidebar = document.getElementById('sidebar');
    sidebar.classList.toggle('expanded');
}

function toggleDropdown(element) {
    const dropdownMenu = element.parentElement.querySelector('.dropdown-menu');
    const arrow = element.querySelector('.dropdown-arrow i');
    
    // Close all other dropdowns
    document.querySelectorAll('.dropdown-menu').forEach(menu => {
        if (menu !== dropdownMenu) {
            menu.classList.remove('show');
        }
    });
    
    document.querySelectorAll('.dropdown-arrow i').forEach(arrowIcon => {
        if (arrowIcon !== arrow) {
            arrowIcon.classList.remove('rotated');
        }
    });
    
    // Toggle current dropdown
    dropdownMenu.classList.toggle('show');
    arrow.classList.toggle('rotated');
}

// Close dropdowns when clicking outside
document.addEventListener('click', function(event) {
    if (!event.target.closest('.dropdown')) {
        document.querySelectorAll('.dropdown-menu').forEach(menu => {
            menu.classList.remove('show');
        });
        document.querySelectorAll('.dropdown-arrow i').forEach(arrow => {
            arrow.classList.remove('rotated');
        });
    }
});

function showLoginAlert(feature) {
    document.getElementById('featureName').textContent = feature;
    const modal = new bootstrap.Modal(document.getElementById('loginModal'));
    modal.show();
}

function confirmLogout() {
    const modal = new bootstrap.Modal(document.getElementById('logoutModal'));
    modal.show();
}
</script> 