<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BK System - Dashboard</title>
    
    <!-- Load Tailwind CSS dengan config yang benar -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Load Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    
    <!-- Load Google Fonts untuk font yang lebih baik -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        /* Reset dan base styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body { 
            background-color: #1a202c; 
            color: #e2e8f0; 
            font-family: 'Inter', sans-serif;
            line-height: 1.6;
        }
        
        .card { 
            background-color: #2d3748; 
            border-radius: 0.75rem;
            transition: transform 0.3s, box-shadow 0.3s; 
        }
        .card:hover { 
            transform: translateY(-3px); 
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.2), 0 4px 6px -2px rgba(0, 0, 0, 0.1); 
        }
        
        .text-custom-blue { color: #4c51bf; }
        .badge-sukses { background-color: #38a169; }
        .badge-menunggu { background-color: #d69e2e; }
        .badge-terjadwal { background-color: #4c51bf; }
        
        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 6px;
        }
        ::-webkit-scrollbar-track {
            background: #2d3748;
        }
        ::-webkit-scrollbar-thumb {
            background: #4c51bf;
            border-radius: 3px;
        }
    </style>
</head>
<body class="bg-gray-900 text-gray-100">

<div class="min-h-screen p-6">
    <!-- HEADER -->
    <header class="flex justify-between items-center mb-8 pb-4 border-b border-gray-700">
        <div class="flex items-center space-x-4">
            <h1 class="text-3xl font-bold text-white">BK System</h1>
            <span class="text-sm text-gray-400">Selamat Datang, Admin / Guru BK</span>
        </div>
        
        <div class="flex items-center space-x-4">
            <!-- Notifications -->
            <a href="{{ route('admin.notifications.index') ?? '#' }}" class="relative p-2 text-gray-400 hover:text-white transition duration-200">
                <i class="fas fa-bell fa-lg"></i> 
                <span id="notification-badge" class="absolute top-0 right-0 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-white transform translate-x-1/2 -translate-y-1/2 bg-red-600 rounded-full hidden">
                    0 
                </span>
            </a>
            
            <!-- Logout -->
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="flex items-center text-red-400 hover:text-red-300 transition duration-150">
                    <i class="fas fa-sign-out-alt mr-2"></i> Logout
                </button>
            </form>
        </div>
    </header>

    <!-- WELCOME SECTION -->
    <div class="mb-8">
        <h2 class="text-2xl font-semibold mb-2 text-white">Halo, Admin Sekolah</h2>
        <p class="text-gray-400">Kelola pengguna, jadwal konseling, dan laporan di sini.</p>
    </div>

    <!-- STATS CARDS -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Total Siswa -->
        <a href="{{ route('admin.users.index', ['role' => 'student']) ?? '#' }}" class="card p-6 shadow-lg cursor-pointer">
            <div class="flex flex-col">
                <p class="text-sm font-medium text-gray-400 mb-2">Total Siswa</p>
                <p class="text-4xl font-bold text-blue-500 mb-2">{{ $studentCount ?? 124 }}</p>
                <div class="flex items-center text-xs text-gray-500 mt-2">
                    <span>Lihat Daftar Lengkap</span>
                    <i class="fas fa-arrow-right ml-2"></i>
                </div>
            </div>
        </a>

        <!-- Sesi Konseling -->
        <a href="{{ route('admin.counseling_sessions.index') ?? '#' }}" class="card p-6 shadow-lg cursor-pointer">
            <div class="flex flex-col">
                <p class="text-sm font-medium text-gray-400 mb-2">Sesi Konseling</p>
                <p class="text-4xl font-bold text-blue-500 mb-2">{{ $sessionCount ?? 38 }}</p>
                <div class="flex items-center text-xs text-gray-500 mt-2">
                    <span>Lihat Semua Permintaan</span>
                    <i class="fas fa-arrow-right ml-2"></i>
                </div>
            </div>
        </a>

        <!-- Pelanggaran -->
        <a href="{{ route('admin.violations.index') ?? '#' }}" class="card p-6 shadow-lg cursor-pointer">
            <div class="flex flex-col">
                <p class="text-sm font-medium text-gray-400 mb-2">Pelanggaran</p>
                <p class="text-4xl font-bold text-blue-500 mb-2">{{ $violationCount ?? 12 }}</p>
                <div class="flex items-center text-xs text-gray-500 mt-2">
                    <span>Input Pelanggaran Baru</span>
                    <i class="fas fa-arrow-right ml-2"></i>
                </div>
            </div>
        </a>

        <!-- Laporan Bulanan -->
        <a href="{{ route('admin.monthly_reports.index') ?? '#' }}" class="card p-6 shadow-lg cursor-pointer">
            <div class="flex flex-col">
                <p class="text-sm font-medium text-gray-400 mb-2">Laporan Bulanan</p>
                <p class="text-4xl font-bold text-green-500 mb-2">{{ $reportCount ?? 6 }}</p>
                <div class="flex items-center text-xs text-gray-500 mt-2">
                    <span>Lihat Semua Laporan</span>
                    <i class="fas fa-arrow-right ml-2"></i>
                </div>
            </div>
        </a>
    </div>

    <!-- MAIN CONTENT GRID -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        
        <!-- JADWAL KONSELING TERBARU -->
        <div class="card p-6">
            <div class="flex items-center mb-4">
                <i class="fas fa-calendar-alt mr-3 text-blue-500"></i>
                <h2 class="text-xl font-bold text-white">Jadwal Konseling Terbaru</h2>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-gray-800">
                        <tr>
                            <th class="px-4 py-3 text-left font-medium rounded-tl-lg">TANGGAL</th>
                            <th class="px-4 py-3 text-left font-medium">SISWA</th>
                            <th class="px-4 py-3 text-left font-medium">TOPIK</th>
                            <th class="px-4 py-3 text-left font-medium rounded-tr-lg">STATUS</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-700">
                        <!-- Data Contoh -->
                        <tr class="hover:bg-gray-700/50 transition duration-150">
                            <td class="px-4 py-3">13 Okt 2025</td>
                            <td class="px-4 py-3">Ahmad Rizky</td>
                            <td class="px-4 py-3">Kedisiplinan</td>
                            <td class="px-4 py-3">
                                <span class="badge-sukses text-white px-3 py-1 rounded-full text-xs">Selesai</span>
                            </td>
                        </tr>
                        <tr class="hover:bg-gray-700/50 transition duration-150">
                            <td class="px-4 py-3">15 Okt 2025</td>
                            <td class="px-4 py-3">Rani Putri</td>
                            <td class="px-4 py-3">Motivasi Belajar</td>
                            <td class="px-4 py-3">
                                <span class="badge-menunggu text-white px-3 py-1 rounded-full text-xs">Menunggu</span>
                            </td>
                        </tr>
                        <tr class="hover:bg-gray-700/50 transition duration-150">
                            <td class="px-4 py-3">17 Okt 2025</td>
                            <td class="px-4 py-3">Dewi Lestari</td>
                            <td class="px-4 py-3">Masalah Pertemanan</td>
                            <td class="px-4 py-3">
                                <span class="badge-terjadwal text-white px-3 py-1 rounded-full text-xs">Terjadwal</span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- RINGKASAN LAPORAN -->
        <div class="card p-6">
            <div class="flex items-center mb-4">
                <i class="fas fa-file-alt mr-3 text-blue-500"></i>
                <h2 class="text-xl font-bold text-white">Ringkasan Laporan Bulan Ini</h2>
            </div>
            
            <div class="space-y-4">
                <p class="text-gray-300">
                    Terdapat peningkatan <strong class="text-green-400">26%</strong> dalam jumlah sesi konseling dibandingkan bulan lalu. Mayoritas topik berkaitan dengan <strong>motivasi belajar</strong> dan <strong>kedisiplinan</strong>.
                </p>
                
                <div class="bg-gray-800 p-4 rounded-lg">
                    <h3 class="font-semibold text-white mb-2">Statistik Bulan Ini:</h3>
                    <ul class="text-sm text-gray-300 space-y-1">
                        <li>• 15 sesi konseling dilakukan</li>
                        <li>• 8 pelanggaran ditangani</li>
                        <li>• 5 prestasi dicatat</li>
                        <li>• 3 kunjungan BK dilakukan</li>
                    </ul>
                </div>
                
                <a href="{{ route('admin.monthly_reports.index') ?? '#' }}" class="inline-flex items-center text-blue-400 hover:text-blue-300 transition duration-150 font-semibold">
                    Lihat Detail Laporan
                    <i class="fas fa-chevron-right ml-2 text-sm"></i>
                </a>
            </div>
        </div>
    </div>

</div>

<!-- NOTIFICATION SCRIPT -->
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const notificationBadge = document.getElementById('notification-badge');
        
        axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
        
        function fetchUnreadCount() {
            axios.get('{{ route("admin.notifications.unreadCount") ?? "#" }}')
                .then(function(response) {
                    const count = response.data.count || 0;
                    notificationBadge.textContent = count;
                    
                    if (count > 0) {
                        notificationBadge.classList.remove('hidden');
                    } else {
                        notificationBadge.classList.add('hidden');
                    }
                })
                .catch(function(error) {
                    console.error('Gagal mengambil notifikasi:', error);
                    notificationBadge.classList.add('hidden');
                });
        }

        fetchUnreadCount();
        setInterval(fetchUnreadCount, 30000);
    });
</script>

</body>
</html>