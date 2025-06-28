<div class="sidebar" id="sidebar">
    <button class="toggle" onclick="toggleSidebar()">&#9776;</button>
    <div class="nav">
        <div class="nav-item">
            <a href="{{ route('main-home') }}" style="text-decoration: none; color: inherit;">
                <span class="icon">
                    <i class="fas fa-home"></i>
                </span><span class="label">Home</span>
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
                <a href="{{ route('search') }}" style="text-decoration: none; color: inherit;">
                    <span class="icon">
                        <i class="fas fa-search"></i>
                    </span><span class="label">Search</span>
                </a>
            </div>
        @else
            <div class="nav-item">
                <a href="#" onclick="showLoginAlert('search')" style="text-decoration: none; color: inherit;">
                    <span class="icon">
                        <i class="fas fa-search"></i>
                    </span><span class="label">Search</span>
                </a>
            </div>
        @endauth
        @auth
            <div class="nav-item">
                <a href="{{ route('all-recipes') }}" style="text-decoration: none; color: inherit;">
                    <span class="icon">
                        <i class="fas fa-utensils"></i>
                    </span><span class="label">All Recipes</span>
                </a>
            </div>
        @else
            <div class="nav-item">
                <a href="#" onclick="showLoginAlert('all-recipes')" style="text-decoration: none; color: inherit;">
                    <span class="icon">
                        <i class="fas fa-utensils"></i>
                    </span><span class="label">All Recipes</span>
                </a>
            </div>
        @endauth
        @auth
            <div class="nav-item">
                <a href="{{ route('recipes.create') }}" style="text-decoration: none; color: inherit;">
                    <span class="icon">
                        <i class="fas fa-plus-circle"></i>
                    </span><span class="label">Tambah Resep</span>
                </a>
            </div>
        @else
            <div class="nav-item">
                <a href="#" onclick="showLoginAlert('add-recipe')" style="text-decoration: none; color: inherit;">
                    <span class="icon">
                        <i class="fas fa-plus-circle"></i>
                    </span><span class="label">Tambah Resep</span>
                </a>
            </div>
        @endauth
        @auth
            <div class="nav-item dropdown">
                <a href="#" onclick="toggleDropdown('archive-dropdown')" style="text-decoration: none; color: inherit;">
                    <span class="icon">
                        <i class="fas fa-archive"></i>
                    </span><span class="label">Archive</span>
                    <span class="dropdown-arrow">
                        <i class="fas fa-chevron-down"></i>
                    </span>
                </a>
                <div class="dropdown-menu" id="archive-dropdown">
                    <a href="{{ route('saved') }}" class="dropdown-item">
                        <i class="fas fa-heart"></i>
                        <span>Favorites</span>
                    </a>
                    <a href="{{ route('my-recipes') }}" class="dropdown-item">
                        <i class="fas fa-utensils"></i>
                        <span>Resep Saya</span>
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
        
        @auth
            <div class="nav-item">
                <form method="POST" action="{{ route('frontend.logout') }}" style="display: inline;">
                    @csrf
                    <button type="submit" style="background: none; border: none; color: inherit; cursor: pointer; display: flex; align-items: center; width: 100%;">
                        <span class="icon">
                            <i class="fas fa-sign-out-alt"></i>
                        </span><span class="label">Logout</span>
                    </button>
                </form>
            </div>
        @else
            <div class="nav-item">
                <a href="{{ route('login') }}" style="text-decoration: none; color: inherit;">
                    <span class="icon">
                        <i class="fas fa-sign-in-alt"></i>
                    </span><span class="label">Login</span>
                </a>
            </div>
            <div class="nav-item">
                <a href="{{ route('register') }}" style="text-decoration: none; color: inherit;">
                    <span class="icon">
                        <i class="fas fa-user-plus"></i>
                    </span><span class="label">Register</span>
                </a>
            </div>
        @endauth
    </div>
</div>

<!-- Alert Modal untuk Guest -->
<div id="loginAlert" class="modal" style="display: none;">
    <div class="modal-content">
        <div class="modal-header">
            <h3>Login Diperlukan</h3>
            <span class="close" onclick="closeLoginAlert()">&times;</span>
        </div>
        <div class="modal-body">
            <p id="alertMessage">Untuk mengakses fitur ini, Anda harus login terlebih dahulu.</p>
            <div class="modal-buttons">
                <a href="{{ route('login') }}" class="btn btn-primary">Login</a>
                <a href="{{ route('register') }}" class="btn btn-secondary">Register</a>
                <button onclick="closeLoginAlert()" class="btn btn-light">Batal</button>
            </div>
        </div>
    </div>
</div>

<script>
function showLoginAlert(feature) {
    const messages = {
        'profile': 'Untuk mengakses profil, Anda harus login terlebih dahulu.',
        'search': 'Untuk menggunakan fitur pencarian, Anda harus login terlebih dahulu.',
        'all-recipes': 'Untuk melihat semua resep, Anda harus login terlebih dahulu.',
        'add-recipe': 'Untuk menambahkan resep baru, Anda harus login terlebih dahulu.',
        'archive': 'Untuk mengakses arsip, Anda harus login terlebih dahulu.',
        'saved': 'Untuk melihat resep yang disimpan, Anda harus login terlebih dahulu.'
    };
    
    document.getElementById('alertMessage').textContent = messages[feature] || 'Untuk mengakses fitur ini, Anda harus login terlebih dahulu.';
    document.getElementById('loginAlert').style.display = 'block';
}

function closeLoginAlert() {
    document.getElementById('loginAlert').style.display = 'none';
}

function toggleDropdown(dropdownId) {
    const dropdown = document.getElementById(dropdownId);
    const arrow = dropdown.previousElementSibling.querySelector('.dropdown-arrow i');
    
    // Tutup semua dropdown lain
    const allDropdowns = document.querySelectorAll('.dropdown-menu');
    const allArrows = document.querySelectorAll('.dropdown-arrow i');
    
    allDropdowns.forEach(d => {
        if (d.id !== dropdownId) {
            d.classList.remove('show');
        }
    });
    
    allArrows.forEach(a => {
        if (a !== arrow) {
            a.classList.remove('rotated');
        }
    });
    
    // Toggle dropdown yang diklik
    dropdown.classList.toggle('show');
    arrow.classList.toggle('rotated');
}

// Close modal when clicking outside
window.onclick = function(event) {
    const modal = document.getElementById('loginAlert');
    if (event.target == modal) {
        modal.style.display = 'none';
    }
}

// Tutup dropdown ketika klik di luar
document.addEventListener('click', function(event) {
    const dropdowns = document.querySelectorAll('.dropdown-menu');
    dropdowns.forEach(dropdown => {
        if (!dropdown.contains(event.target) && !event.target.closest('.dropdown')) {
            dropdown.classList.remove('show');
            const arrow = dropdown.previousElementSibling.querySelector('.dropdown-arrow i');
            if (arrow) {
                arrow.classList.remove('rotated');
            }
        }
    });
});
</script> 