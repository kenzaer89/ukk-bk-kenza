<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'BK Dashboard')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        /* CSS umum (tetap di sini agar Vite tidak menimpanya) */
        body {
            background: radial-gradient(circle at top left, #0f172a, #1e293b);
            color: #f8fafc;
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            display: flex; /* Menggunakan flex untuk membagi sidebar dan konten */
            min-height: 100vh;
        }

        /* Gaya Sidebar */
        .sidebar {
            width: 256px; /* w-64 */
            flex-shrink: 0; /* Mencegah sidebar menyusut */
            min-height: 100vh;
            padding: 1.5rem; /* p-6 */
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            border-right: 1px solid #334155; /* border-gray-700 */
        }

        /* Gaya Konten Utama */
        .content {
            flex-grow: 1; /* Mengisi sisa ruang */
            padding: 1.5rem; /* p-6 */
        }
        
        .sidebar a {
            display: block;
            padding: 0.75rem 0.5rem;
            margin-bottom: 0.5rem;
            border-radius: 0.5rem;
            color: #9ca3af; /* gray-400 */
            transition: background-color 0.2s, color 0.2s;
        }

        .sidebar a:hover {
            background-color: rgba(255, 255, 255, 0.1);
            color: white;
        }

        .glass {
            background: rgba(255, 255, 255, 0.05);
            border-radius: 16px;
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.4);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
    </style>
</head>
<body>
    @php
        $user = Auth::user();
    @endphp

    <aside class="sidebar bg-gray-900">
        <div>
            <h2 class="text-2xl font-extrabold text-indigo-400 mb-8">BK System</h2>
            <p class="text-sm font-semibold text-gray-300 mb-6">👋 Halo, {{ $user->name ?? 'User' }}</p>

            <nav class="space-y-2">
                @if ($user && $user->role === 'student')
                    <a href="{{ route('student.dashboard') }}" class="{{ request()->routeIs('student.dashboard') ? 'bg-indigo-600 text-white font-bold' : 'hover:bg-gray-700' }}">🏠 Dashboard</a>
                    <a href="{{ route('student.requests.index') }}" class="{{ request()->routeIs('student.requests.index') ? 'bg-indigo-600 text-white font-bold' : 'hover:bg-gray-700' }}">📝 Permintaan Konseling</a>
                @elseif ($user && $user->role === 'admin')
                    {{-- Tambahkan navigasi Admin di sini --}}
                @endif
            </nav>
        </div>

        <div class="mt-8">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="w-full text-left py-2 px-3 rounded-lg text-red-400 hover:bg-gray-700 transition">🚪 Logout</button>
            </form>
        </div>
    </aside>

    <main class="content">
        @yield('content')
    </main>
</body>
</html>