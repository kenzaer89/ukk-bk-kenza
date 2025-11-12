<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BK System - Selamat Datang</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gradient-to-br from-gray-900 via-gray-800 to-gray-900 text-gray-100">

    <!-- 🌟 Navbar -->
    <nav class="flex items-center justify-between px-8 py-4 bg-gray-800 bg-opacity-70 backdrop-blur-md fixed w-full top-0 z-50 shadow-md">
        <div class="flex items-center space-x-2">
            <span class="text-2xl font-bold text-purple-400">BK System</span>
        </div>
        <div class="space-x-6">
            <a href="#fitur" class="hover:text-purple-400 transition">Fitur</a>
            <a href="#tentang" class="hover:text-purple-400 transition">Tentang</a>
            <a href="#kontak" class="hover:text-purple-400 transition">Kontak</a>
            <a href="{{ route('login') }}" class="bg-purple-500 hover:bg-purple-600 px-4 py-2 rounded-lg text-white font-semibold transition">Masuk</a>
        </div>
    </nav>

    <!-- 🦋 Hero Section -->
    <section class="min-h-screen flex flex-col justify-center items-center text-center px-6">
        <h1 class="text-5xl md:text-6xl font-extrabold mb-4 text-white">Selamat Datang di <span class="text-purple-400">BK System</span></h1>
        <p class="text-gray-300 text-lg mb-8 max-w-2xl">
            Sistem Bimbingan Konseling digital untuk memudahkan guru BK dan siswa dalam menjadwalkan konseling, mencatat pelanggaran, dan memantau perkembangan siswa.
        </p>
        <div class="space-x-4">
    @guest
        <a href="{{ route('login') }}" class="bg-purple-500 hover:bg-purple-600 px-6 py-3 rounded-lg font-semibold transition">Masuk Sekarang</a>
    @else
        <a href="{{ route(auth()->user()->role . '.dashboard') }}" class="bg-purple-500 hover:bg-purple-600 px-6 py-3 rounded-lg font-semibold transition">Ke Dashboard</a>
    @endguest
    <a href="#fitur" class="border border-purple-400 hover:bg-purple-500 hover:text-white px-6 py-3 rounded-lg font-semibold transition">Pelajari Lebih Lanjut</a>
</div>

    </section>

    <!-- ⚙️ Fitur Section -->
    <section id="fitur" class="py-20 bg-gray-800 bg-opacity-40">
        <div class="max-w-6xl mx-auto px-6 text-center">
            <h2 class="text-3xl font-bold text-purple-400 mb-12">Fitur Unggulan</h2>
            <div class="grid md:grid-cols-3 gap-10">
                <div class="bg-gray-800 p-6 rounded-2xl shadow-lg hover:shadow-purple-500/20 transition">
                    <h3 class="text-xl font-semibold mb-2">📅 Jadwal Konseling</h3>
                    <p class="text-gray-400">Atur dan kelola jadwal konseling dengan mudah antara siswa dan guru BK.</p>
                </div>
                <div class="bg-gray-800 p-6 rounded-2xl shadow-lg hover:shadow-purple-500/20 transition">
                    <h3 class="text-xl font-semibold mb-2">💬 Sesi Konseling</h3>
                    <p class="text-gray-400">Catat hasil sesi konseling dan pantau perkembangan siswa secara berkelanjutan.</p>
                </div>
                <div class="bg-gray-800 p-6 rounded-2xl shadow-lg hover:shadow-purple-500/20 transition">
                    <h3 class="text-xl font-semibold mb-2">⚠️ Pelanggaran</h3>
                    <p class="text-gray-400">Simpan dan kelola data pelanggaran siswa dengan sistem poin otomatis.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- 👥 Tentang Section -->
    <section id="tentang" class="py-20 text-center">
        <div class="max-w-4xl mx-auto px-6">
            <h2 class="text-3xl font-bold text-purple-400 mb-6">Tentang BK System</h2>
            <p class="text-gray-300 leading-relaxed">
                BK System adalah aplikasi digital yang dirancang untuk membantu kegiatan bimbingan konseling di sekolah.
                Dengan sistem ini, guru BK dapat lebih efisien dalam mencatat pelanggaran, membuat laporan, dan memantau siswa.
            </p>
        </div>
    </section>

    <!-- 📞 Kontak Section -->
    <section id="kontak" class="py-20 bg-gray-800 bg-opacity-40 text-center">
        <div class="max-w-3xl mx-auto px-6">
            <h2 class="text-3xl font-bold text-purple-400 mb-6">Hubungi Kami</h2>
            <p class="text-gray-300 mb-4">Ada pertanyaan? Hubungi kami melalui email di:</p>
            <p class="text-purple-400 font-semibold">support@bksystem.sch.id</p>
        </div>
    </section>

    <!-- 🧭 Footer -->
    <footer class="bg-gray-900 py-6 text-center border-t border-gray-700">
        <p class="text-gray-400">© {{ date('Y') }} BK System. SMK Antartika 1 Sidoarjo.</p>
    </footer>

</body>
</html>
