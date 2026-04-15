{{-- Sidebar Navigation Partial --}}
{{-- Usage: @include('user.partials.sidebar', ['activePage' => 'dashboard']) --}}

<aside id="sidebar" class="flex flex-col w-64 h-screen shrink-0 fixed top-0 left-0 bg-white border-r border-slate-200 p-6 z-50 transition-transform duration-300 ease-in-out transform -translate-x-full overflow-y-auto shadow-sm">
    <div class="mb-8 flex items-center justify-between gap-2 px-1">
        <div class="flex items-center gap-2">
            <div class="bg-gradient-to-br from-green-400 to-green-600 p-2.5 rounded-xl text-white shadow-md shadow-green-200">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                </svg>
            </div>
            <span class="text-xl font-extrabold text-slate-900 tracking-tight">Ugoro <span class="text-green-500 font-black">Portal</span></span>
        </div>
        <button onclick="toggleSidebar()" class="p-1.5 rounded-xl text-slate-400 hover:bg-slate-50 transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>

    <nav class="space-y-1.5 flex-grow">
        {{-- Dashboard --}}
        <a href="{{ route('dashboard') }}" 
           class="flex items-center gap-3 px-4 py-2.5 w-full transition-all duration-300 
           {{ Route::is('dashboard') ? 'bg-green-50 text-green-600 font-bold rounded-full' : 'text-slate-500 hover:text-slate-900 hover:bg-slate-50 font-medium rounded-full' }}">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
            </svg>
            <span class="text-base tracking-wide">Dashboard</span>
        </a>

        {{-- Data Struktur --}}
        <a href="{{ route('karyawan') }}" 
           class="flex items-center gap-3 px-4 py-2.5 w-full transition-all duration-300 
           {{ Route::is('karyawan') ? 'bg-green-50 text-green-600 font-bold rounded-full' : 'text-slate-500 hover:text-slate-900 hover:bg-slate-50 font-medium rounded-full' }}">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
            </svg>
            <span class="text-base tracking-wide">Data Struktur</span>
        </a>

        {{-- Simpanan & Pinjaman --}}
        <a href="{{ route('simpanans.index') }}" 
           class="flex items-center gap-3 px-4 py-2.5 w-full transition-all duration-300 
           {{ Route::is('simpanans.index') || Route::is('pinjamans.index') ? 'bg-green-50 text-green-600 font-bold rounded-full' : 'text-slate-500 hover:text-slate-900 hover:bg-slate-50 font-medium rounded-full' }}">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span class="text-base tracking-wide">Simpanan & Pinjaman</span>
        </a>

        {{-- Laporan Tahunan --}}
        <a href="{{ route('angsurans.index') }}" 
           class="flex items-center gap-3 px-4 py-2.5 w-full transition-all duration-300 
           {{ Route::is('angsurans.index') ? 'bg-green-50 text-green-600 font-bold rounded-full' : 'text-slate-500 hover:text-slate-900 hover:bg-slate-50 font-medium rounded-full' }}">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 17v-2m3 2v-4m3 2v-6m-9 9h12a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
            </svg>
            <span class="text-base tracking-wide">Laporan Tahunan</span>
        </a>

        {{-- Informasi Pengurus --}}
        <a href="#" 
           class="flex items-center gap-3 px-4 py-2.5 w-full transition-all duration-300 text-slate-500 hover:text-slate-900 hover:bg-slate-50 font-medium rounded-full">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
            </svg>
            <span class="text-base tracking-wide">Informasi Pengurus</span>
        </a>

        {{-- Hubungi Admin --}}
        <a href="{{ route('contact.create') }}" 
           class="flex items-center gap-3 px-4 py-2.5 w-full transition-all duration-300 
           {{ Route::is('contact.*') ? 'bg-green-50 text-green-600 font-bold rounded-full' : 'text-slate-500 hover:text-slate-900 hover:bg-slate-50 font-medium rounded-full' }}">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
            </svg>
            <span class="text-base tracking-wide">Hubungi Admin</span>
        </a>

        {{-- Profil --}}
        <a href="{{ route('profile.edit') }}" 
           class="flex items-center gap-3 px-4 py-2.5 w-full transition-all duration-300 
           {{ Route::is('profile.edit') ? 'bg-green-50 text-green-600 font-bold rounded-full' : 'text-slate-500 hover:text-slate-900 hover:bg-slate-50 font-medium rounded-full' }}">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
            </svg>
            <span class="text-base tracking-wide">Profil</span>
        </a>
    </nav>

    <div class="pt-6 border-t border-slate-100 mb-2">
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="flex items-center gap-3 px-4 py-2.5 w-full transition-all duration-300 text-red-500 hover:bg-red-50 font-bold rounded-full group">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                </svg>
                <span class="text-base tracking-wide">Keluar</span>
            </button>
        </form>
    </div>
</aside>

<div id="sidebarOverlay" 
     class="fixed inset-0 bg-slate-900/40 z-40 hidden backdrop-blur-sm transition-all duration-300" 
     onclick="toggleSidebar()">
</div>

<script>
    function toggleSidebar() {
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebarOverlay');
        if (sidebar && overlay) {
            sidebar.classList.toggle('-translate-x-full');
            overlay.classList.toggle('hidden');
        }
    }
</script>
