<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'BK Dashboard')</title>
    @vite('resources/css/app.css')
    <style>
        body {
            background: radial-gradient(circle at top left, #0f172a, #1e293b);
            color: #f8fafc;
            font-family: 'Poppins', sans-serif;
            min-height: 100vh;
            display: flex;
        }
        .glass {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 16px;
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.3);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        .sidebar {
            width: 240px;
            padding: 1.5rem;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
        .sidebar a {
            color: #cbd5e1;
            text-decoration: none;
            margin: 0.5rem 0;
            display: block;
            padding: 0.75rem 1rem;
            border-radius: 10px;
            transition: 0.3s;
        }
        .sidebar a:hover {
            background: rgba(255, 255, 255, 0.15);
            color: #fff;
        }
        .content {
            flex: 1;
            padding: 2rem;
            overflow-y: auto;
        }
        .btn-primary {
            background: linear-gradient(90deg, #6366f1, #8b5cf6);
            padding: 0.6rem 1.2rem;
            border-radius: 10px;
            color: white;
            font-weight: 600;
            text-decoration: none;
            transition: 0.3s;
        }
        .btn-primary:hover {
            opacity: 0.9;
        }
    </style>
</head>
<body>
    <aside class="sidebar glass">
        <div>
            <h2 class="text-xl font-semibold text-white mb-6">BK System</h2>
            <a href="{{ route('admin.dashboard') }}">🏠 Dashboard</a>
            <a href="{{ route('admin.users.index') }}">👥 Pengguna</a>
            <a href="{{ route('admin.schedules.index') }}">📅 Jadwal</a>
            <a href="{{ route('admin.sessions.index') }}">💬 Sesi Konseling</a>
            <a href="{{ route('admin.violations.index') }}">⚠️ Pelanggaran</a>
            <a href="{{ route('admin.reports.index') }}">📊 Laporan</a>
        </div>
        <div>
            <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit">Logout</button>
        </form>
        </div>
    </aside>

    <main class="content">
        <div class="glass p-6 rounded-2xl">
            @yield('content')
        </div>
    </main>
</body>
</html>
