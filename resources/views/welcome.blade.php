<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lombaku - Platform Lomba Terbaik</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .card-lomba:hover .lomba-image {
            transform: scale(1.05);
        }
        /* Animasi sederhana untuk elemen yang masuk */
        .fade-in-up {
            opacity: 0;
            transform: translateY(20px);
            transition: opacity 0.6s ease-out, transform 0.6s ease-out;
        }
        .fade-in-up.visible {
            opacity: 1;
            transform: translateY(0);
        }
        .hero-bg {
            background-color: #f0f4ff;
            background-image:
                radial-gradient(at 0% 0%, hsla(253, 100%, 75%, 0.15) 0px, transparent 50%),
                radial-gradient(at 98% 1%, hsla(220, 100%, 75%, 0.15) 0px, transparent 50%);
        }
    </style>
</head>

<body class="bg-gray-50 font-sans">

    <x-public-header-nav />

    <!-- Hero Section -->
    <section class="hero-bg">
        <div class="container mx-auto px-4 py-16 md:py-24 text-center">
            <h1 class="text-4xl md:text-5xl font-extrabold text-gray-900 mb-4 leading-tight fade-in-up">
                Temukan Peluang, Raih Kemenanganmu
            </h1>
            <p class="text-gray-600 text-lg max-w-2xl mx-auto mb-8 fade-in-up" style="transition-delay: 150ms;">
                Platform terpusat untuk semua informasi kompetisi. Dari tingkat kampus hingga internasional, mulailah perjalanan prestasimu di sini.
            </p>

            <div class="max-w-xl mx-auto fade-in-up" style="transition-delay: 300ms;">
                <div class="relative">
                    <i class="fas fa-search absolute left-6 top-1/2 -translate-y-1/2 text-gray-400"></i>
                    <input
                        id="search-input-welcome"
                        type="text"
                        class="w-full pl-14 pr-6 py-4 text-lg bg-white rounded-full shadow-lg border-2 border-transparent focus:border-blue-500 focus:ring-blue-500 transition"
                        placeholder="Ketik nama lomba...">
                </div>
            </div>
        </div>
    </section>
    
    <!-- Lomba Terbaru Section -->
    <section id="lomba-terbaru" class="container mx-auto px-4 py-16">
        <h2 class="text-3xl font-bold text-center text-gray-800 mb-12 fade-in-up">Lomba Terbaru Untukmu</h2>

        <div id="lomba-container" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 min-h-[400px]">
            <!-- Loading state -->
            <div id="loading-state" class="col-span-full flex justify-center items-center">
                <i class="fas fa-spinner fa-spin fa-3x text-blue-500"></i>
            </div>
        </div>
        
        <div class="mt-16 text-center fade-in-up">
            <a href="{{ route('lombaterkini') }}" class="inline-block bg-blue-600 text-white font-semibold py-3 px-8 rounded-lg hover:bg-blue-700 transition-colors shadow-md hover:shadow-lg">
                Lihat Semua Lomba <i class="fas fa-arrow-right ml-2"></i>
            </a>
        </div>
    </section>

    <!-- Template untuk kartu lomba -->
    <template id="lomba-card-template">
        <div class="card-lomba bg-white rounded-2xl shadow-lg overflow-hidden transform transition-all duration-300 hover:shadow-2xl hover:-translate-y-2">
            <div class="relative overflow-hidden">
                <a class="lomba-link-img" href="#">
                    <img class="lomba-image w-full h-52 object-cover transition-transform duration-300" src="" alt="">
                </a>
                <div class="absolute top-3 left-3 flex flex-wrap gap-2">
                    <!-- Tags akan diisi di sini -->
                </div>
            </div>
            <div class="p-6">
                <p class="lomba-penyelenggara text-sm text-gray-500 mb-2 capitalize"></p>
                <h3 class="lomba-nama text-xl font-bold text-gray-800 mb-4 h-14" title=""></h3>
                
                <div class="flex items-center text-gray-600 text-sm">
                    <i class="fas fa-calendar-alt mr-2 text-red-500"></i>
                    <span class="lomba-tanggal"></span>
                </div>

                <a class="lomba-link-detail mt-6 block w-full bg-blue-600 text-white text-center font-semibold py-2.5 rounded-lg hover:bg-blue-700 transition-colors">
                    Lihat Detail
                </a>
            </div>
        </div>
    </template>

 <footer class="bg-gray-800 text-white mt-20">
        <div class="container mx-auto px-4 py-12">
            <div class="max-w-3xl mx-auto text-center mb-8">
                <p class="text-xl md:text-2xl font-medium mb-6">Butuh mahasiswa potensial untuk mengikuti lomba anda?</p>
                <button class="bg-yellow-500 hover:bg-yellow-600 text-gray-900 font-bold py-3 px-8 rounded-full text-lg transition-colors">
                    Daftar sebagai Admin Lomba
                </button>
            </div>
        </div>
        <div class="bg-gray-900 py-6">
            <div class="container mx-auto px-4 text-center">
                <p class="text-gray-400">&copy; lombaku@2025. All rights reserved.</p>
            </div>
        </div>
    </footer>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const container = document.getElementById('lomba-container');
    const loadingState = document.getElementById('loading-state');
    const template = document.getElementById('lomba-card-template');
    const baseUrl = window.location.origin;

    const formatDate = (dateString) => new Date(dateString).toLocaleDateString('id-ID', { day: 'numeric', month: 'short', year: 'numeric' });

    // Fungsi untuk mengambil data lomba dari API
    async function fetchLatestLombas() {
        loadingState.style.display = 'flex';
        container.innerHTML = '';
        container.appendChild(loadingState);

        try {
            const response = await axios.get('/api/lomba', { params: { limit: 6 } });
            const lombas = response.data.data.data;
            
            loadingState.style.display = 'none';
            
            if (lombas.length === 0) {
                container.innerHTML = `<div class="col-span-full text-center py-12"><p class="text-gray-500 text-lg">Saat ini belum ada lomba yang tersedia.</p></div>`;
                return;
            }

            lombas.forEach((lomba, index) => {
                const card = template.content.cloneNode(true);
                const cardElement = card.querySelector('.card-lomba');
                
                // Tambahkan animasi fade-in-up
                cardElement.classList.add('fade-in-up');
                cardElement.style.transitionDelay = `${index * 100}ms`;

                const link = `${baseUrl}/lomba/${lomba.id_lomba}`;
                
                card.querySelector('.lomba-image').src = `${baseUrl}/${lomba.foto_lomba}`;
                card.querySelector('.lomba-image').alt = lomba.nama_lomba;
                card.querySelector('.lomba-link-img').href = link;
                
                const tagsContainer = card.querySelector('.absolute.top-3');
                tagsContainer.innerHTML = '';
                lomba.tags.slice(0, 2).forEach(tag => {
                    const tagEl = document.createElement('span');
                    tagEl.className = 'bg-white/90 text-blue-800 text-xs font-semibold px-2.5 py-1 rounded-full shadow-sm';
                    tagEl.textContent = tag.nama_tag;
                    tagsContainer.appendChild(tagEl);
                });

                card.querySelector('.lomba-nama').textContent = lomba.nama_lomba;
                card.querySelector('.lomba-nama').title = lomba.nama_lomba;
                card.querySelector('.lomba-penyelenggara').textContent = lomba.penyelenggara || 'Komunitas Mahasiswa';
                card.querySelector('.lomba-tanggal').textContent = `Batas Daftar: ${formatDate(lomba.tanggal_akhir_registrasi)}`;
                card.querySelector('.lomba-link-detail').href = link;
                
                container.appendChild(card);
            });
            
            // Pemicu animasi setelah elemen ditambahkan ke DOM
            setTimeout(() => {
                document.querySelectorAll('.fade-in-up').forEach(el => {
                    el.classList.add('visible');
                });
            }, 100);

        } catch (error) {
            console.error('Gagal mengambil data lomba:', error);
            loadingState.style.display = 'none';
            container.innerHTML = `<div class="col-span-full text-center py-12"><p class="text-red-500 text-lg">Gagal memuat data lomba. Silakan coba lagi nanti.</p></div>`;
        }
    }

    // Fungsi untuk pencarian
    const searchInput = document.getElementById('search-input-welcome');
    function handleSearch() {
        const query = searchInput.value.trim();
        if (query) {
            window.location.href = `${baseUrl}/lombaterkini?search=${encodeURIComponent(query)}`;
        }
    }

    // Event listener untuk search bar
    searchInput.addEventListener('keypress', (e) => {
        if (e.key === 'Enter') {
            e.preventDefault(); // Mencegah submit form jika ada
            handleSearch();
        }
    });
    
    // Trigger animasi untuk elemen statis
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('visible');
            }
        });
    }, { threshold: 0.1 });

    document.querySelectorAll('.fade-in-up').forEach(el => {
        observer.observe(el);
    });

    // Panggil fungsi untuk memuat data saat halaman dimuat
    fetchLatestLombas();
});
</script>

</body>
</html>