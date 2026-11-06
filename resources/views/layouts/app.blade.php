<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'SI SPT & SPPD') - DISKOMINFOSANTIK Kab. Kapuas</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    @stack('styles')
</head>
<body class="bg-gray-100 min-h-screen">
    <div class="flex min-h-screen">
        <aside class="w-64 bg-blue-900 text-white flex-shrink-0 fixed inset-y-0 left-0 z-30 transform transition-transform duration-200 ease-in-out md:translate-x-0 -translate-x-full" id="sidebar">
            <div class="p-4 border-b border-blue-800">
                <h1 class="text-lg font-bold leading-tight">SI SPT & SPPD</h1>
                <p class="text-blue-300 text-xs mt-1">DISKOMINFOSANTIK Kab. Kapuas</p>
            </div>
            <nav class="mt-4 px-2 space-y-1">
                <a href="{{ route('dashboard') }}" class="flex items-center px-3 py-2.5 rounded-lg text-sm {{ request()->routeIs('dashboard') ? 'bg-blue-700 text-white' : 'text-blue-200 hover:bg-blue-800' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-4 0a1 1 0 01-1-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 01-1 1h-2z"/></svg>
                    Dashboard
                </a>
                @if(auth()->user()->isAdmin())
                <a href="{{ route('users.index') }}" class="flex items-center px-3 py-2.5 rounded-lg text-sm {{ request()->routeIs('users.*') ? 'bg-blue-700 text-white' : 'text-blue-200 hover:bg-blue-800' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197"/></svg>
                    Manajemen User
                </a>
                <a href="{{ route('pegawai.index') }}" class="flex items-center px-3 py-2.5 rounded-lg text-sm {{ request()->routeIs('pegawai.*') ? 'bg-blue-700 text-white' : 'text-blue-200 hover:bg-blue-800' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    Data Pegawai
                </a>
                <a href="{{ route('tujuan-tugas.index') }}" class="flex items-center px-3 py-2.5 rounded-lg text-sm {{ request()->routeIs('tujuan-tugas.*') ? 'bg-blue-700 text-white' : 'text-blue-200 hover:bg-blue-800' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    Tujuan Tugas
                </a>
                @endif
                @if(in_array(auth()->user()->role, ['admin', 'pejabat']))
                <a href="{{ route('spt.index') }}" class="flex items-center px-3 py-2.5 rounded-lg text-sm {{ request()->routeIs('spt.*') ? 'bg-blue-700 text-white' : 'text-blue-200 hover:bg-blue-800' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    Surat Perintah Tugas
                </a>
                @endif
                @if(in_array(auth()->user()->role, ['admin', 'pejabat', 'pegawai']))
                <a href="{{ route('sppd.index') }}" class="flex items-center px-3 py-2.5 rounded-lg text-sm {{ request()->routeIs('sppd.*') ? 'bg-blue-700 text-white' : 'text-blue-200 hover:bg-blue-800' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/></svg>
                    SPPD
                </a>
                @endif
                @if(in_array(auth()->user()->role, ['admin', 'verifikator']))
                <a href="{{ route('verifikasi.index') }}" class="flex items-center px-3 py-2.5 rounded-lg text-sm {{ request()->routeIs('verifikasi.*') ? 'bg-blue-700 text-white' : 'text-blue-200 hover:bg-blue-800' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    Verifikasi SPPD
                </a>
                @endif
            </nav>
        </aside>
        <div class="flex-1 md:ml-64">
            <header class="bg-white shadow-sm border-b border-gray-200 sticky top-0 z-20">
                <div class="flex items-center justify-between px-4 py-3">
                    <button onclick="document.getElementById('sidebar').classList.toggle('-translate-x-full')" class="md:hidden text-gray-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                    </button>
                    <div class="flex-1"></div>
                    <div class="flex items-center space-x-4">
                        <span class="text-sm text-gray-600">{{ auth()->user()->username }} <span class="text-xs bg-blue-100 text-blue-800 px-2 py-0.5 rounded-full">{{ ucfirst(auth()->user()->role) }}</span></span>
                        <form method="POST" action="{{ route('logout') }}" class="inline">@csrf
                            <button type="submit" class="text-sm text-red-600 hover:text-red-800">Logout</button>
                        </form>
                    </div>
                </div>
            </header>
            <main class="p-6">
                @if(session('success'))
                <div class="mb-4 p-4 bg-green-50 border border-green-200 text-green-700 rounded-lg" id="alert-success">{{ session('success') }}</div>
                @endif
                @if(session('error'))
                <div class="mb-4 p-4 bg-red-50 border border-red-200 text-red-700 rounded-lg">{{ session('error') }}</div>
                @endif
                @yield('content')
            </main>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>setTimeout(() => { const a = document.getElementById('alert-success'); if (a) a.style.display = 'none'; }, 4000);</script>
    @stack('scripts')
</body>
</html>
