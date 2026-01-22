<!DOCTYPE html>
<html lang="id">
    <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'BK Dashboard')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        /* Premium SweetAlert2 Design */
        .swal2-popup {
            background: linear-gradient(145deg, rgba(30, 41, 59, 0.98), rgba(15, 23, 42, 0.98)) !important;
            backdrop-filter: blur(20px) !important;
            border: 1px solid rgba(255, 255, 255, 0.08) !important;
            border-radius: 2rem !important;
            padding: 2.5rem 1.5rem !important;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.7) !important;
        }
        .swal2-title {
            color: #f8fafc !important;
            font-size: 1.75rem !important;
            font-weight: 800 !important;
            letter-spacing: -0.025em !important;
            margin-bottom: 0.75rem !important;
        }
        .swal2-html-container {
            color: #94a3b8 !important;
            font-size: 1.05rem !important;
            line-height: 1.6 !important;
            font-weight: 400 !important;
        }
        .swal2-actions {
            margin-top: 2.5rem !important;
            gap: 1rem !important;
        }
        .swal2-confirm {
            background: linear-gradient(135deg, #2dd4bf 0%, #0d9488 100%) !important;
            color: #0f172a !important;
            font-weight: 700 !important;
            border-radius: 1rem !important;
            padding: 0.875rem 2rem !important;
            font-size: 0.95rem !important;
            text-transform: uppercase !important;
            letter-spacing: 0.05em !important;
            box-shadow: 0 10px 15px -3px rgba(45, 212, 191, 0.3) !important;
            border: none !important;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1) !important;
        }
        .swal2-confirm:hover {
            transform: translateY(-2px) !important;
            box-shadow: 0 20px 25px -5px rgba(45, 212, 191, 0.4) !important;
        }
        .swal2-cancel {
            background: rgba(255, 255, 255, 0.03) !important;
            color: #94a3b8 !important;
            font-weight: 600 !important;
            border-radius: 1rem !important;
            padding: 0.875rem 2rem !important;
            font-size: 0.95rem !important;
            text-transform: uppercase !important;
            letter-spacing: 0.05em !important;
            border: 1px solid rgba(255, 255, 255, 0.1) !important;
            transition: all 0.3s ease !important;
        }
        .swal2-cancel:hover {
            background: rgba(255, 255, 255, 0.08) !important;
            color: #f8fafc !important;
        }
        .swal2-icon {
            border: none !important;
            margin-top: 1.5rem !important;
            margin-bottom: 1.5rem !important;
            width: 5rem !important;
            height: 5rem !important;
            display: flex;
            align-items: center !important;
            justify-content: center !important;
            background: rgba(255, 255, 255, 0.03) !important;
            border-radius: 50% !important;
            box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.3) !important;
        }
        
        /* Custom Success Icon */
        .swal2-icon.swal2-success {
            background: linear-gradient(135deg, rgba(45, 212, 191, 0.1) 0%, rgba(45, 212, 191, 0.05) 100%) !important;
            border: 1px solid rgba(45, 212, 191, 0.2) !important;
        }
        .swal2-icon.swal2-success [class^='swal2-success-line'] {
            background-color: #2dd4bf !important;
            height: 5px !important;
            border-radius: 2px !important;
        }
        .swal2-icon.swal2-success .swal2-success-ring {
            border: 4px solid rgba(45, 212, 191, 0.2) !important;
        }
        .swal2-icon.swal2-success .swal2-success-circular-line-left,
        .swal2-icon.swal2-success .swal2-success-circular-line-right,
        .swal2-icon.swal2-success .swal2-success-fix {
            background-color: transparent !important;
        }

        /* Custom Warning Icon */
        .swal2-icon.swal2-warning {
            background: transparent !important;
            border: none !important;
            box-shadow: none !important;
            color: #f59e0b !important;
            font-family: inherit !important;
            font-size: 2.5rem !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            filter: drop-shadow(0 0 10px rgba(245, 158, 11, 0.4)) !important;
        }
        .swal2-icon.swal2-warning .swal2-icon-content {
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
        }
        
        /* Custom Error Icon (Silang) */
        .swal2-icon.swal2-error {
            background: transparent !important;
            border: none !important;
            box-shadow: none !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            filter: drop-shadow(0 0 10px rgba(239, 68, 68, 0.4)) !important;
        }
        .swal2-icon.swal2-error .swal2-x-mark {
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            position: relative !important;
            top: auto !important;
            left: auto !important;
        }
        .swal2-icon.swal2-error [class^='swal2-error-line'] {
            background-color: #ef4444 !important;
            width: 2.5rem !important;
            height: 4px !important;
            border-radius: 4px !important;
        }

        .swal2-timer-progress-bar-container {
            position: absolute !important;
            bottom: 15px !important;
            left: 25px !important;
            right: 25px !important;
            height: 3px !important;
            background: rgba(255, 255, 255, 0.05) !important;
            border-radius: 3px !important;
            overflow: hidden !important;
        }
        .swal2-timer-progress-bar {
            background: #2dd4bf !important;
            height: 100% !important;
            border-radius: 3px !important;
        }

        /* Input & Textarea Premium Styling */
        .swal2-input, .swal2-textarea {
            background: rgba(0, 0, 0, 0.2) !important;
            border: 1px solid rgba(255, 255, 255, 0.1) !important;
            color: #ffffff !important;
            border-radius: 1rem !important;
            font-size: 1rem !important;
            box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.2) !important;
            transition: all 0.3s ease !important;
        }
        .swal2-input:focus, .swal2-textarea:focus {
            border-color: #2dd4bf !important;
            box-shadow: 0 0 0 3px rgba(45, 212, 191, 0.2), inset 0 2px 4px rgba(0, 0, 0, 0.2) !important;
            outline: none !important;
        }
        .swal2-textarea {
            height: 120px !important;
            padding: 1rem !important;
        }
        ::placeholder {
            color: rgba(148, 163, 184, 0.4) !important;
        }

        /* CSS umum (tetap di sini agar Vite tidak menimpanya) */
        html {
            background-color: #0f172a;
        }
        body {
            background: radial-gradient(circle at top left, #0f172a, #1e293b);
            background-attachment: fixed;
            background-color: #0f172a; /* Fallback */
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
            padding: 1.5rem;
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

        /* Hide datalist dropdown arrow */
        input::-webkit-calendar-picker-indicator {
            display: none !important;
        }
    </style>
</head>
<body>
    @php
        $user = Auth::user();
    @endphp

    <aside class="sidebar">
        <div>
            <h2 class="text-2xl font-extrabold text-brand-teal mb-8 tracking-tight">Bimbingan Konseling</h2>
            <a href="{{ route('profile.show') }}" class="group flex items-center gap-3 mb-8 px-4 py-4 bg-white/5 rounded-xl border border-white/10 hover:bg-white/10 hover:border-brand-teal/50 transition-all duration-300 {{ request()->routeIs('profile.show') ? 'ring-2 ring-brand-teal ring-opacity-50 bg-white/10' : '' }}">
                <div class="w-10 h-10 bg-brand-teal/20 rounded-full flex items-center justify-center border border-brand-teal/30 group-hover:border-brand-teal/50 transition-colors shrink-0">
                    <span class="text-lg font-bold text-brand-teal">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                </div>
                <div class="flex-1 min-w-0">
                    @if($user && $user->role === 'parent')
                        @php
                            $selectedChildId = session('selected_child_id');
                            $child = null;
                            if($selectedChildId) {
                                $child = \App\Models\User::find($selectedChildId);
                            } else {
                                $child = \App\Models\ParentStudent::where('parent_id', $user->id)->with('student')->first()->student ?? null;
                            }
                            $childName = $child->name ?? 'Siswa';
                        @endphp
                        <p class="text-sm font-bold text-brand-light truncate">Orang Tua {{ $childName }}</p>
                    @else
                        <p class="text-sm font-bold text-brand-light truncate">{{ $user->name ?? 'User' }}</p>
                    @endif
                    <p class="text-[10px] text-brand-teal font-bold uppercase tracking-wider mt-0.5">{{ $user->role_display_name ?? 'Guest' }}</p>
                </div>
                <svg class="w-4 h-4 text-brand-teal opacity-0 group-hover:opacity-100 transition-all transform group-hover:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </a>

            <nav class="space-y-1 mt-6">
                @if ($user && $user->role === 'student')
                    <a href="{{ route('student.dashboard') }}" class="{{ request()->routeIs('student.dashboard') ? 'active' : '' }}">
                        <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg> Dashboard
                    </a>
                    <a href="{{ route('student.counseling_requests.index') }}" class="{{ request()->routeIs('student.counseling_requests.index') ? 'active' : '' }}">
                        <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg> Permintaan Konseling
                    </a>
                    <a href="{{ route('student.schedules.index') }}" class="{{ request()->routeIs('student.schedules.index') ? 'active' : '' }}">
                        <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg> Jadwal Konseling
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

                    {{-- Menu Khusus Guru BK --}}
                    @if ($user->role === 'guru_bk')
                        <a href="{{ route('admin.counseling_requests.index') }}" class="{{ request()->routeIs('admin.counseling_requests.*') ? 'active' : '' }}">
                            <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg> Permintaan Konseling
                        </a>
                        <a href="{{ route('admin.schedules.index') }}" class="{{ request()->routeIs('admin.schedules.*') ? 'active' : '' }}">
                            <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg> Jadwal Konseling
                        </a>
                        <a href="{{ route('admin.violations.index') }}" class="{{ request()->routeIs('admin.violations.*') ? 'active' : '' }}">
                            <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg> Pelanggaran
                        </a>
                        <a href="{{ route('admin.achievements.index') }}" class="{{ request()->routeIs('admin.achievements.*') ? 'active' : '' }}">
                            <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/></svg> Prestasi
                        </a>
                    @endif

                    {{-- Menu Khusus Admin --}}
                    @if ($user->role === 'admin')
                        <a href="{{ route('admin.users.index') }}" class="{{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                            <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg> Kelola Pengguna
                        </a>
                        <a href="{{ route('admin.classes.index') }}" class="{{ request()->routeIs('admin.classes.*') ? 'active' : '' }}">
                            <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg> Data Kelas
                        </a>
                    @endif
                @elseif ($user && $user->role === 'parent')
                    <a href="{{ route('parent.dashboard') }}" class="{{ request()->routeIs('parent.dashboard') ? 'active' : '' }}">
                        <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg> Dashboard
                    </a>
                    @if($user->is_approved && session('selected_child_id'))
                        <a href="{{ route('parent.counseling.index') }}" class="{{ request()->routeIs('parent.counseling.*') ? 'active' : '' }}">
                            <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg> Sesi Konseling
                        </a>
                        <a href="{{ route('parent.violations.index') }}" class="{{ request()->routeIs('parent.violations.*') ? 'active' : '' }}">
                            <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg> Pelanggaran
                        </a>
                        <a href="{{ route('parent.achievements.index') }}" class="{{ request()->routeIs('parent.achievements.*') ? 'active' : '' }}">
                            <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/></svg> Prestasi
                        </a>
                    @endif
                @elseif ($user && $user->role === 'wali_kelas')
                    <a href="{{ route('wali.dashboard') }}" class="{{ request()->routeIs('wali.dashboard') ? 'active' : '' }}">
                        <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg> Dashboard
                    </a>
                    <a href="{{ route('wali.monitoring') }}" class="{{ request()->routeIs('wali.monitoring') ? 'active' : '' }}">
                        <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg> Monitoring Siswa
                    </a>
                @endif
            </nav>
        </div>

        <div class="mt-8">
            <form action="{{ route('logout') }}" method="POST" id="logout-form">
                @csrf
                <button type="button" onclick="confirmLogout(event)" class="w-full text-left py-2 px-3 rounded-lg text-red-400 hover:bg-gray-700 transition flex items-center gap-3"><svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg> Logout</button>
            </form>
        </div>
    </aside>

    <script>
        function confirmLogout(e) {
            e.preventDefault();
            const userName = "{{ $user->name ?? 'User' }}";
            
            Swal.fire({
                title: 'Konfirmasi Logout',
                html: `Apakah Anda yakin ingin keluar dari akun <strong class="text-brand-teal">${userName}</strong>?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, Logout',
                cancelButtonText: 'Batal',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('logout-form').submit();
                }
            });
        }
    </script>

    <main class="content">
        <div class="flex items-center justify-between mb-6">
            <div>
                {{-- Optional header placeholder: title is per-page --}}
            </div>
            <div class="flex items-center gap-4">
                {{-- Notification dropdown - Only show on dashboard pages --}}
                @auth
                    @if(
                        (request()->routeIs('admin.dashboard') && Auth::user()->role !== 'admin') || 
                        request()->routeIs('student.dashboard') || 
                        request()->routeIs('parent.dashboard') || 
                        request()->routeIs('wali.dashboard')
                    )
                        @include('components.notification_dropdown')
                    @endif
                @endauth
            </div>
        </div>
        @yield('content')
    </main>
    <!-- Global Toast Notification -->
    <div id="global-toast" class="fixed top-4 right-4 z-[9999] transform translate-x-[450px] transition-all duration-500 opacity-0 pointer-events-none">
        <div class="bg-gradient-to-r from-brand-teal to-[#5a8e91] text-brand-dark px-6 py-4 rounded-xl shadow-2xl flex items-center gap-4 min-w-[320px] border border-white/20">
            <div class="w-12 h-12 bg-white/20 rounded-full flex items-center justify-center shrink-0">
                <svg class="w-6 h-6 text-white animate-bounce" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                </svg>
            </div>
            <div class="flex-1">
                <p class="font-bold text-lg leading-tight" id="toast-title">Notifikasi Baru</p>
                <p class="text-sm opacity-90 mt-1" id="toast-message">Ada pesan baru untuk Anda.</p>
            </div>
            <button onclick="closeGlobalToast()" class="text-brand-dark/50 hover:text-brand-dark transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
    </div>
    <script>
        // Global Toast Functions
        function showGlobalToast(title, message) {
            const toast = document.getElementById('global-toast');
            const titleEl = document.getElementById('toast-title');
            const messageEl = document.getElementById('toast-message');
            
            if (!toast) return;
            
            titleEl.textContent = title;
            messageEl.textContent = message;
            
            toast.classList.remove('translate-x-[450px]', 'opacity-0', 'pointer-events-none');
            toast.classList.add('translate-x-0', 'opacity-100', 'pointer-events-auto');
            
            // Reset existing timeout if any
            if (window.toastTimeout) clearTimeout(window.toastTimeout);
            
            // Auto hide after 6 seconds
            window.toastTimeout = setTimeout(closeGlobalToast, 6000);
        }

        function closeGlobalToast() {
            const toast = document.getElementById('global-toast');
            if (toast) {
                toast.classList.add('translate-x-[450px]', 'opacity-0', 'pointer-events-none');
                toast.classList.remove('translate-x-0', 'opacity-100', 'pointer-events-auto');
            }
        }

        function playNotificationSound() {
            try {
                const audioCtx = new (window.AudioContext || window.webkitAudioContext)();
                if (!audioCtx) return;
                const oscillator = audioCtx.createOscillator();
                const gainNode = audioCtx.createGain();
                
                oscillator.connect(gainNode);
                gainNode.connect(audioCtx.destination);
                
                oscillator.type = 'sine';
                oscillator.frequency.setValueAtTime(880, audioCtx.currentTime); // A5
                gainNode.gain.setValueAtTime(0.1, audioCtx.currentTime);
                gainNode.gain.exponentialRampToValueAtTime(0.01, audioCtx.currentTime + 0.5);
                
                oscillator.start();
                oscillator.stop(audioCtx.currentTime + 0.5);
            } catch(e) { console.log('Audio not supported or blocked'); }
        }

        // Global SweetAlert2 Confirm Helper
        function confirmAction(e, title, message, icon = 'warning', confirmText = 'Ya, Lanjutkan', cancelText = 'Batal') {
            e.preventDefault();
            const form = e.target.closest('form');
            const href = e.target.closest('a')?.href;

            Swal.fire({
                title: title,
                text: message,
                icon: icon,
                showCancelButton: true,
                confirmButtonText: confirmText,
                cancelButtonText: cancelText,
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    if (form) {
                        form.submit();
                    } else if (href) {
                        window.location.href = href;
                    }
                }
            });
            return false;
        }

        // Session Alerts (Success/Error)
        function showSessionAlerts() {
            @if(session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: "{{ session('success') }}",
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true
                });
            @endif

            @if(session('error'))
                Swal.fire({
                    icon: 'error',
                    title: 'Kesalahan!',
                    text: "{{ session('error') }}",
                    confirmButtonText: 'OKE'
                });
            @endif
        }

        document.addEventListener('DOMContentLoaded', showSessionAlerts);
        window.addEventListener('pageshow', function(event) {
            // Re-check on page show (handles BFCache)
            // But if it's from cache, we usually don't want to show it again
            if (event.persisted) {
                // Page was loaded from BFCache, don't re-run if we want to avoid ghost alerts
            } else {
                showSessionAlerts();
            }
        });
    </script>
    
    @stack('scripts')
    
    @auth
        <script>
            let lastNotificationId = null;
            let isFirstLoad = true;

            async function checkNotifications() {
                try {
                    const response = await fetch('{{ route('notifications.list') }}');
                    const data = await response.json();
                    
                    const notifications = data.notifications || [];
                    const unreadNotifications = notifications.filter(n => n.status === 'unread');
                    const newestId = notifications.length > 0 ? notifications[0].id : 0;
                    
                    if (isFirstLoad) {
                        isFirstLoad = false;
                        lastNotificationId = newestId;
                        return;
                    }

                    if (newestId > lastNotificationId) {
                        // Find all unread notifications newer than last seen
                        const newones = unreadNotifications.filter(n => n.id > lastNotificationId).reverse();
                        
                        if (newones.length > 0) {
                            newones.forEach(n => {
                                if (window.showGlobalToast) {
                                    let title = 'Notifikasi';
                                    if (n.message.toLowerCase().includes('pelanggaran')) title = '⚠️ Pelanggaran Baru';
                                    if (n.message.toLowerCase().includes('prestasi') || n.message.toLowerCase().includes('selamat')) title = '🏆 Prestasi Baru';
                                    if (n.message.toLowerCase().includes('jadwal')) title = '📅 Jadwal Konseling';
                                    if (n.message.toLowerCase().includes('disetujui')) title = '✅ Permintaan Disetujui';
                                    if (n.message.toLowerCase().includes('ditolak')) title = '❌ Permintaan Ditolak';
                                    
                                    window.showGlobalToast(title, n.message);
                                }
                            });
                            
                            if (window.playNotificationSound) {
                                window.playNotificationSound();
                            }
                        }
                        lastNotificationId = newestId;
                    }
                } catch (error) {
                    console.error('Error checking notifications:', error);
                }
            }

            // Polling notifications for everyone EXCEPT admin (requested)
            @if(Auth::user()->role !== 'admin')
            setInterval(checkNotifications, 15000);
            setTimeout(checkNotifications, 2000);
            @endif

            @if(Auth::user()->role === 'guru_bk')
            let lastRequestCount = null;

            async function checkNewRequests() {
                try {
                    const response = await fetch('{{ route('admin.check_new_requests') }}');
                    const data = await response.json();
                    
                    if (lastRequestCount === null) {
                        lastRequestCount = data.count;
                    } else if (data.count > lastRequestCount) {
                        const newRequestsCount = data.count - lastRequestCount;
                        if (window.showGlobalToast) {
                            window.showGlobalToast('📩 Permintaan Baru', `Ada ${newRequestsCount} permintaan konseling baru dari siswa!`);
                        }
                        if (window.playNotificationSound) window.playNotificationSound();
                    }
                    
                    lastRequestCount = data.count;
                    
                    if (typeof updateRequestsList === 'function') {
                        updateRequestsList(data.requests);
                    }
                    
                    const pendingCardCount = document.getElementById('pending-count');
                    if (pendingCardCount && data.count > (parseInt(pendingCardCount.textContent) || 0)) {
                        const card = pendingCardCount.closest('.bg-brand-gray');
                        if (card) {
                            card.classList.add('animate-pulse', 'border-yellow-500/50');
                            setTimeout(() => {
                                card.classList.remove('animate-pulse', 'border-yellow-500/50');
                            }, 3000);
                        }
                    }
                } catch (error) {
                    console.error('Error checking new requests:', error);
                }
            }
            setInterval(checkNewRequests, 15000);
            @endif
        </script>
    @endauth
    
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // ... existing Alpine/form code ...
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