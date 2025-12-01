<!DOCTYPE html>
<html lang="id">
    <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="csrf-token" content="{{ csrf_token() }}">
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
                @if($user && $user->role === 'parent')
                    @php
                        $childName = \App\Models\ParentStudent::where('parent_id', $user->id)->with('student')->first()->student->name ?? 'Siswa';
                    @endphp
                    <p class="text-sm font-bold text-brand-light truncate">Orang Tua {{ $childName }}</p>
                @else
                    <p class="text-sm font-bold text-brand-light truncate">{{ $user->name ?? 'User' }}</p>
                @endif
                <p class="text-xs text-brand-teal mt-1 capitalize">{{ str_replace('_', ' ', $user->role ?? 'Guest') }}</p>
            </div>

            <nav class="space-y-1">
                @if ($user && $user->role === 'student')
                    <a href="{{ route('student.dashboard') }}" class="{{ request()->routeIs('student.dashboard') ? 'active' : '' }}">
                        <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg> Dashboard
                    </a>
                    <a href="{{ route('student.counseling_requests.index') }}" class="{{ request()->routeIs('student.counseling_requests.index') ? 'active' : '' }}">
                        <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg> Permintaan Konseling
                    </a>
                    <a href="{{ route('student.violations.index') }}" class="{{ request()->routeIs('student.violations.index') ? 'active' : '' }}">
                        <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg> Riwayat Pelanggaran
                    </a>
                    <a href="{{ route('student.achievements.index') }}" class="{{ request()->routeIs('student.achievements.index') ? 'active' : '' }}">
                        <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/></svg> Riwayat Prestasi
                    </a>
                @elseif ($user && in_array($user->role, ['admin', 'guru_bk']))
                    <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg> Dashboard
                    </a>
                    <a href="{{ route('admin.counseling_requests.index') }}" class="{{ request()->routeIs('admin.counseling_requests.*') ? 'active' : '' }}">
                        <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg> Permintaan Konseling
                    </a>
                    <a href="{{ route('admin.schedules.index') }}" class="{{ request()->routeIs('admin.schedules.*') ? 'active' : '' }}">
                        <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg> Jadwal Konseling
                    </a>
                    <a href="{{ route('admin.users.index') }}" class="{{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                        <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg> Kelola Pengguna
                    </a>
                    <a href="{{ route('admin.violations.index') }}" class="{{ request()->routeIs('admin.violations.*') ? 'active' : '' }}">
                        <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg> Pelanggaran
                    </a>
                    <a href="{{ route('admin.achievements.index') }}" class="{{ request()->routeIs('admin.achievements.*') ? 'active' : '' }}">
                        <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/></svg> Prestasi
                    </a>
                @elseif ($user && $user->role === 'parent')
                    <a href="{{ route('parent.dashboard') }}" class="{{ request()->routeIs('parent.dashboard') ? 'active' : '' }}">
                        <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg> Dashboard
                    </a>
                @endif
            </nav>
        </div>

        <div class="mt-8">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="w-full text-left py-2 px-3 rounded-lg text-red-400 hover:bg-gray-700 transition flex items-center gap-3"><svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg> Logout</button>
            </form>
        </div>
    </aside>

    <main class="content">
        <div class="flex items-center justify-between mb-6">
            <div>
                {{-- Optional header placeholder: title is per-page --}}
            </div>
            <div class="flex items-center gap-4">
                {{-- Notification dropdown --}}
                @auth
                    @include('components.notification_dropdown')
                @endauth
            </div>
        </div>
        @yield('content')
    </main>
    
    @stack('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Attach behavior to all forms that have start_time and end_time inputs
            document.querySelectorAll('form').forEach(function (form) {
                const startInput = form.querySelector('input[name="start_time"]');
                const endInput = form.querySelector('input[name="end_time"]');
                if (!startInput || !endInput) return;

                // Add id if not present to reference
                if (!startInput.id) startInput.id = 'start_time_' + Math.random().toString(36).substr(2, 9);
                if (!endInput.id) endInput.id = 'end_time_' + Math.random().toString(36).substr(2, 9);

                // Create a helper message element for the end time
                let helpEl = document.createElement('p');
                helpEl.className = 'mt-1 text-xs text-red-400 hidden';
                helpEl.textContent = 'Isi waktu mulai terlebih dahulu.';
                endInput.parentNode.appendChild(helpEl);

                function updateEndState() {
                    if (!startInput.value) {
                        endInput.disabled = true;
                        endInput.classList.add('opacity-60', 'cursor-not-allowed');
                        helpEl.classList.remove('hidden');
                    } else {
                        endInput.disabled = false;
                        endInput.classList.remove('opacity-60', 'cursor-not-allowed');
                        helpEl.classList.add('hidden');
                        // Set minimum selectable time to start time
                        try { endInput.min = startInput.value; } catch(e) {}
                        // If an end time is already present and <= start time, clear it
                        if (endInput.value && endInput.value <= startInput.value) {
                            endInput.value = '';
                        }
                    }
                }

                // Initialize state on page load
                updateEndState();

                // When start changes, update end
                startInput.addEventListener('change', updateEndState);
                startInput.addEventListener('input', updateEndState);

                // When focusing end_time, if disabled, focus start and show a temporary tooltip
                endInput.addEventListener('focus', function (e) {
                    if (endInput.disabled) {
                        e.preventDefault();
                        // small UX: focus start field and scroll into view
                        startInput.focus();
                        startInput.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    }
                });
            });
        });
    </script>
</body>
</html>