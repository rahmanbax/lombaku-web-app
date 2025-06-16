    <!-- Navbar -->
    <nav class="minimal-navbar">
        <div class="nav-container">
            <div class="logo-section">
                <div class="logo-icon">
                    <i class="fas fa-trophy"></i>
                </div>
                <span class="logo-text">Lombaku</span>
            </div>

            <button class="hamburger" id="hamburger">
                <i class="fas fa-bars"></i>
            </button>

            <div class="nav-items" id="navItems">
                <a href="#" class="nav-link">Beranda</a>

                <div class="dropdown">
                    <button class="dropdown-toggle">
                        Kategori <i class="fas fa-chevron-down dropdown-icon"></i>
                    </button>
                    <div class="dropdown-menu">
                        <a href="#" class="dropdown-item">Akademik</a>
                        <a href="#" class="dropdown-item">Seni & Desain</a>
                        <a href="#" class="dropdown-item">Teknologi</a>
                        <a href="#" class="dropdown-item">Olahraga</a>
                        <a href="#" class="dropdown-item">Bisnis</a>
                    </div>
                </div>

                <div class="dropdown">
                    <button class="dropdown-toggle">
                        Kegiatan Saya <i class="fas fa-chevron-down dropdown-icon"></i>
                    </button>
                    <div class="dropdown-menu">
                        <a href="#" class="dropdown-item">Lomba Diikuti</a>
                        <a href="#" class="dropdown-item">Lomba Diselenggarakan</a>
                        <a href="#" class="dropdown-item">Favorit</a>
                        <a href="#" class="dropdown-item">Riwayat</a>
                    </div>
                </div>

                <button class="login-btn">Masuk</button>
            </div>
        </div>
    </nav>
  

    <script>
        // Mobile menu toggle
        const hamburger = document.getElementById('hamburger');
        const navItems = document.getElementById('navItems');

        hamburger.addEventListener('click', () => {
            navItems.classList.toggle('active');
        });

        // Dropdown toggle for mobile
        const dropdowns = document.querySelectorAll('.dropdown');

        dropdowns.forEach(dropdown => {
            const toggle = dropdown.querySelector('.dropdown-toggle');

            toggle.addEventListener('click', () => {
                if (window.innerWidth <= 768) {
                    dropdown.classList.toggle('active');
                }
            });
        });

        // Close menu when clicking outside
        document.addEventListener('click', (e) => {
            if (window.innerWidth <= 768) {
                if (!navItems.contains(e.target) && !hamburger.contains(e.target)) {
                    navItems.classList.remove('active');
                }

                dropdowns.forEach(dropdown => {
                    if (!dropdown.contains(e.target)) {
                        dropdown.classList.remove('active');
                    }
                });
            }
        });

        // Search functionality
        const searchButton = document.querySelector('.search-button');
        const searchInput = document.querySelector('.search-input');

        searchButton.addEventListener('click', function() {
            if (searchInput.value.trim() !== '') {
                alert(`Anda mencari: "${searchInput.value}"`);
                // Di aplikasi nyata, ini akan mengirimkan permintaan pencarian
            } else {
                searchInput.focus();
            }
        });

        searchInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                if (searchInput.value.trim() !== '') {
                    alert(`Anda mencari: "${searchInput.value}"`);
                } else {
                    searchInput.focus();
                }
            }
        });

        // Admin button functionality
        const adminButton = document.querySelector('.admin-btn');
        adminButton.addEventListener('click', function() {
            alert('Fitur pendaftaran admin lomba akan segera tersedia!');
            // Di aplikasi nyata, ini akan mengarahkan ke halaman pendaftaran admin
        });
    </script>