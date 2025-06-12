<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Mahasiswa</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#3b82f6',
                        secondary: '#60a5fa',
                        dark: '#1e293b',
                        light: '#f8fafc'
                    },
                    fontFamily: {
                        poppins: ['Poppins', 'sans-serif']
                    },
                    boxShadow: {
                        'profile': '0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.1)',
                        'card': '0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -2px rgba(0, 0, 0, 0.05)'
                    },
                    animation: {
                        'fade-in': 'fadeIn 0.5s ease-in-out',
                        'float': 'float 3s ease-in-out infinite'
                    },
                    keyframes: {
                        fadeIn: {
                            '0%': { opacity: 0, transform: 'translateY(10px)' },
                            '100%': { opacity: 1, transform: 'translateY(0)' }
                        },
                        float: {
                            '0%, 100%': { transform: 'translateY(0)' },
                            '50%': { transform: 'translateY(-10px)' }
                        }
                    }
                }
            }
        }
    </script>
    <style>
        body {
            background: linear-gradient(135deg, #e0f2fe, #dbeafe);
            min-height: 100vh;
            font-family: 'Poppins', sans-serif;
        }

        .profile-container {
            margin-top: 6rem; /* Adjust to create space for the header */
        }

        .profile-card {
            transition: all 0.3s ease;
            border-radius: 20px;
            overflow: hidden;
            background: linear-gradient(to bottom right, #ffffff, #f8fafc);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.5);
        }

        .profile-img {
            border: 4px solid white;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        .profile-img:hover {
            transform: scale(1.05);
        }

        .info-item {
            transition: all 0.3s ease;
            border-bottom: 1px solid #e2e8f0;
        }

        .info-item:hover {
            background-color: #f1f5f9;
            transform: translateX(5px);
        }

        .social-icon {
            transition: all 0.3s ease;
            color: #3b82f6;
            background: rgba(59, 130, 246, 0.1);
        }

        .social-icon:hover {
            transform: translateY(-3px);
            background: #3b82f6;
            color: white;
        }

        .edit-btn {
            transition: all 0.3s ease;
            background: linear-gradient(to right, #3b82f6, #60a5fa);
            box-shadow: 0 4px 6px rgba(59, 130, 246, 0.3);
        }

        .edit-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 8px rgba(59, 130, 246, 0.4);
        }

        .progress-bar {
            height: 8px;
            border-radius: 4px;
            background-color: #e2e8f0;
            overflow: hidden;
        }

        .progress-fill {
            height: 100%;
            border-radius: 4px;
            background: linear-gradient(to right, #3b82f6, #60a5fa);
        }

        .floating {
            animation: float 6s ease-in-out infinite;
        }

        .fade-in {
            animation: fadeIn 0.8s ease-out;
        }

        .card-hover {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }

        @media (max-width: 768px) {
            .profile-card {
                margin: 20px;
            }

            .profile-container {
                margin-top: 5rem;
            }
        }
    </style>
</head>

<body class="flex items-center justify-center min-h-screen p-4">
    <!-- Public Header Nav -->
    <x-public-header-nav />

    <!-- Profile Container -->
    <div class="profile-container profile-card w-full max-w-4xl shadow-profile">
        <!-- Header with gradient background -->
        <div class="h-32 bg-gradient-to-r from-primary to-secondary relative">
            <div class="absolute -bottom-16 left-8">
                <div class="relative">
                    <div class="absolute -inset-2 bg-white rounded-full opacity-50"></div>
                    <img src="https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=500&q=80" 
                         alt="Foto Profil" 
                         class="w-32 h-32 rounded-full object-cover border-4 border-white profile-img floating">
                </div>
            </div>
        </div>

        <div class="p-8 pt-20">
            <div class="flex flex-col md:flex-row gap-8">
                <!-- Left Side: Main Information -->
                <div class="md:w-1/2 fade-in">
                    <div class="flex flex-col gap-1 mb-6">
                        <h1 class="text-3xl font-bold text-dark">John Doe</h1>
                        <div class="flex items-center gap-2 text-gray-600">
                            <i class="fas fa-user-graduate"></i>
                            <span class="font-medium">Mahasiswa</span>
                        </div>
                    </div>

                    <!-- Profile Info -->
                    <div class="space-y-4">
                        <h2 class="text-xl font-semibold text-dark flex items-center gap-2">
                            <i class="fas fa-info-circle text-primary"></i>
                            <span>Informasi Profil</span>
                        </h2>

                        <div class="space-y-3">
                            <div class="info-item p-3 rounded-lg">
                                <div class="flex justify-between">
                                    <span class="text-gray-700 font-medium flex items-center gap-2">
                                        <i class="fas fa-user text-blue-500"></i>
                                        Nama:
                                    </span>
                                    <span class="text-gray-600 font-medium">John Doe</span>
                                </div>
                            </div>

                            <div class="info-item p-3 rounded-lg">
                                <div class="flex justify-between">
                                    <span class="text-gray-700 font-medium flex items-center gap-2">
                                        <i class="fas fa-id-card text-blue-500"></i>
                                        NIM:
                                    </span>
                                    <span class="text-gray-600 font-medium">123456789</span>
                                </div>
                            </div>

                            <div class="info-item p-3 rounded-lg">
                                <div class="flex justify-between">
                                    <span class="text-gray-700 font-medium flex items-center gap-2">
                                        <i class="fas fa-envelope text-blue-500"></i>
                                        Email:
                                    </span>
                                    <span class="text-gray-600 font-medium">john.doe@example.com</span>
                                </div>
                            </div>

                            <div class="info-item p-3 rounded-lg">
                                <div class="flex justify-between">
                                    <span class="text-gray-700 font-medium flex items-center gap-2">
                                        <i class="fas fa-graduation-cap text-blue-500"></i>
                                        Jurusan:
                                    </span>
                                    <span class="text-gray-600 font-medium">D3 Sistem Informasi</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="mt-8 flex flex-wrap gap-3">
                        <button class="edit-btn px-6 py-3 text-white rounded-lg font-medium flex items-center gap-2">
                            <i class="fas fa-edit"></i>
                            Edit Profil
                        </button>
                        <button class="px-6 py-3 bg-white border border-gray-300 text-gray-700 rounded-lg font-medium hover:bg-gray-50 transition flex items-center gap-2">
                            <i class="fas fa-download"></i>
                            Download CV
                        </button>
                    </div>
                </div>

                <!-- Right Side: Additional Information -->
                <div class="md:w-1/2 space-y-6 fade-in">
                    <!-- Stats Section -->
                    <div class="bg-white rounded-xl p-5 shadow-card card-hover">
                        <h2 class="text-xl font-semibold text-dark mb-4 flex items-center gap-2">
                            <i class="fas fa-chart-line text-primary"></i>
                            <span>Statistik Akademik</span>
                        </h2>

                        <div class="space-y-4">
                            <div>
                                <div class="flex justify-between mb-1">
                                    <span class="text-gray-700">IPK Semester Ini</span>
                                    <span class="text-gray-700 font-medium">3.75</span>
                                </div>
                                <div class="progress-bar">
                                    <div class="progress-fill w-3/4"></div>
                                </div>
                            </div>

                            <div>
                                <div class="flex justify-between mb-1">
                                    <span class="text-gray-700">Kehadiran</span>
                                    <span class="text-gray-700 font-medium">92%</span>
                                </div>
                                <div class="progress-bar">
                                    <div class="progress-fill w-[92%]"></div>
                                </div>
                            </div>

                            <div>
                                <div class="flex justify-between mb-1">
                                    <span class="text-gray-700">SKS Diambil</span>
                                    <span class="text-gray-700 font-medium">144/144</span>
                                </div>
                                <div class="progress-bar">
                                    <div class="progress-fill w-full"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Social Media Section -->
                    <div class="bg-white rounded-xl p-5 shadow-card card-hover">
                        <h2 class="text-xl font-semibold text-dark mb-4 flex items-center gap-2">
                            <i class="fas fa-hashtag text-primary"></i>
                            <span>Media Sosial</span>
                        </h2>

                        <div class="flex gap-3">
                            <a href="#" class="social-icon w-10 h-10 rounded-full flex items-center justify-center">
                                <i class="fab fa-instagram"></i>
                            </a>
                            <a href="#" class="social-icon w-10 h-10 rounded-full flex items-center justify-center">
                                <i class="fab fa-linkedin-in"></i>
                            </a>
                            <a href="#" class="social-icon w-10 h-10 rounded-full flex items-center justify-center">
                                <i class="fab fa-github"></i>
                            </a>
                            <a href="#" class="social-icon w-10 h-10 rounded-full flex items-center justify-center">
                                <i class="fab fa-twitter"></i>
                            </a>
                        </div>
                    </div>

                    <!-- Favorite Subjects -->
                    <div class="bg-white rounded-xl p-5 shadow-card card-hover">
                        <h2 class="text-xl font-semibold text-dark mb-4 flex items-center gap-2">
                            <i class="fas fa-book text-primary"></i>
                            <span>Mata Kuliah Favorit</span>
                        </h2>

                        <div class="flex flex-wrap gap-2">
                            <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm">Basis Data</span>
                            <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm">Pemrograman Web</span>
                            <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm">UI/UX Design</span>
                            <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm">Jaringan Komputer</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="bg-gray-50 px-8 py-4 text-center text-gray-500 text-sm">
            © 2023 Profil Mahasiswa | D3 Sistem Informasi
        </div>
    </div>
</body>

</html>
