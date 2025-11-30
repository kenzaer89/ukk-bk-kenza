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
            display: flex;
            min-height: 100vh;
        }

        /* Gaya Sidebar */
        .sidebar {
            width: 260px;
            flex-shrink: 0;
            height: 100vh; /* Full height viewport */
            position: sticky; /* Sticky positioning */
            top: 0;
            padding: 1.5rem;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            border-right: 1px solid rgba(255, 255, 255, 0.1);
            background: rgba(15, 23, 42, 0.6); /* Semi-transparent dark background */
            backdrop-filter: blur(12px); /* Glass effect */
            overflow-y: auto; /* Scrollable if content is too long */
        }

        /* Gaya Konten Utama */
        .content {
            flex-grow: 1;
            padding: 2rem;
            width: calc(100% - 260px); /* Prevent overflow issues */
        }
        
        .sidebar a {
            display: block;
            padding: 0.75rem 1rem;
            margin-bottom: 0.5rem;
            border-radius: 0.75rem;
            color: #94a3b8;
            font-weight: 500;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .sidebar a:hover {
            background-color: rgba(255, 255, 255, 0.05);
            color: #f8fafc;
            transform: translateX(4px);
        }
        
        .sidebar a.active {
            background: linear-gradient(to right, rgba(45, 212, 191, 0.1), rgba(45, 212, 191, 0));
            color: #2dd4bf; /* brand-teal */
            border-left: 3px solid #2dd4bf;
        }

        .glass {
            background: rgba(255, 255, 255, 0.05);
            border-radius: 16px;
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.4);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }
        ::-webkit-scrollbar-track {
            background: rgba(15, 23, 42, 0.5); 
        }
        ::-webkit-scrollbar-thumb {
            background: rgba(148, 163, 184, 0.2); 
            border-radius: 4px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: rgba(148, 163, 184, 0.4); 
        }
    </style>
</head>
<body>
    @php
        $user = Auth::user();
    @endphp

    <aside class="sidebar">
        <div>
            <h2 class="text-2xl font-extrabold text-brand-teal mb-8 tracking-tight">BK System</h2>
            <div class="mb-8 px-4 py-3 bg-white/5 rounded-xl border border-white/10">
                <p class="text-xs text-brand-light/60 mb-1">Selamat Datang,</p>
                <p class="text-sm font-bold text-brand-light truncate">{{ $user->name ?? 'User' }}</p>
                <p class="text-xs text-brand-teal mt-1 capitalize">{{ str_replace('_', ' ', $user->role ?? 'Guest') }}</p>
            </div>

            <nav class="space-y-1">
                @if ($user && $user->role === 'student')
                    <a href="{{ route('student.dashboard') }}" class="{{ request()->routeIs('student.dashboard') ? 'active' : '' }}">
                        <span>🏠</span> Dashboard
                    </a>
                    <a href="{{ route('student.counseling_requests.index') }}" class="{{ request()->routeIs('student.counseling_requests.index') ? 'active' : '' }}">
                        <span>📝</span> Permintaan Konseling
                    </a>
                    <a href="{{ route('student.violations.index') }}" class="{{ request()->routeIs('student.violations.index') ? 'active' : '' }}">
                        <span>⚠️</span> Riwayat Pelanggaran
                    </a>
                    <a href="{{ route('student.achievements.index') }}" class="{{ request()->routeIs('student.achievements.index') ? 'active' : '' }}">
                        <span>🏆</span> Riwayat Prestasi
                    </a>
                @elseif ($user && in_array($user->role, ['admin', 'guru_bk']))
                    <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <span>🏠</span> Dashboard
                    </a>
                    <a href="{{ route('admin.counseling_requests.index') }}" class="{{ request()->routeIs('admin.counseling_requests.*') ? 'active' : '' }}">
                        <span>📋</span> Permintaan Konseling
                    </a>
                    <a href="{{ route('admin.schedules.index') }}" class="{{ request()->routeIs('admin.schedules.*') ? 'active' : '' }}">
                        <span>📅</span> Jadwal Konseling
                    </a>
                    <a href="{{ route('admin.users.index') }}" class="{{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                        <span>👥</span> Kelola Pengguna
                    </a>
                    <a href="{{ route('admin.violations.index') }}" class="{{ request()->routeIs('admin.violations.*') ? 'active' : '' }}">
                        <span>⚠️</span> Pelanggaran
                    </a>
                    <a href="{{ route('admin.achievements.index') }}" class="{{ request()->routeIs('admin.achievements.*') ? 'active' : '' }}">
                        <span>🏆</span> Prestasi
                    </a>
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
    
    @stack('scripts')
</body>
</html>