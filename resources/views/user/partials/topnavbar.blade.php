{{-- Top Navbar Partial --}}
{{-- Usage: @include('user.partials.topnavbar', ['activePage' => 'dashboard']) --}}
{{-- activePage options: 'dashboard', 'simpanan', 'pinjaman', 'transaksi', 'profil' --}}

@php
    $navItems = [
        ['key' => 'dashboard',  'label' => 'Dashboard',  'route' => 'dashboard'],
        ['key' => 'simpanan',   'label' => 'Simpanan',   'route' => 'simpanans.index'],
        ['key' => 'pinjaman',   'label' => 'Pinjaman',   'route' => 'pinjamans.index'],
        ['key' => 'transaksi',  'label' => 'Transaksi',  'route' => 'angsurans.index'],
        ['key' => 'profil',     'label' => 'Profil',     'route' => 'profile.edit'],
    ];
    $currentUser = auth()->user();
    $userName = $currentUser->name ?? 'Anggota';
    $userRole = $currentUser->role ?? 'Anggota';
@endphp
@if(session()->has('admin_impersonate'))
<div class="bg-orange-500 text-white px-4 py-2 flex items-center justify-between text-sm font-bold z-50 relative shadow-md">
    <div class="flex items-center gap-2">
        <span class="material-symbols-outlined text-[18px]">admin_panel_settings</span>
        Anda sedang masuk sebagai anggota (Impersonate Mode)
    </div>
    <a href="{{ route('admin.impersonate.leave') }}" class="bg-white text-orange-600 hover:bg-orange-50 px-3 py-1.5 rounded-md text-xs font-extrabold transition-colors shadow-sm">
        Kembali ke Admin
    </a>
</div>
@endif

<header class="sticky top-0 z-30 w-full bg-slate-800 border-b border-slate-700 shadow-sm">
    <div class="w-full flex items-center justify-between h-16">

        {{-- Left: Sidebar Toggle + Logo (No left margin/padding to stick to edge) --}}
        <div class="flex items-center gap-2 flex-shrink-0">
            {{-- Sidebar Toggle Button (hamburger ☰) flush to edge --}}
            <button onclick="toggleSidebar()" class="px-3 py-2 text-slate-300 hover:bg-slate-700 hover:text-white transition-colors" aria-label="Toggle sidebar">
                <span class="material-symbols-outlined text-[24px] leading-none">menu</span>
            </button>

            {{-- Logo --}}
            <div class="flex items-center gap-2 ml-1">
                <img src="{{ asset('logo.png') }}" alt="Logo" class="w-10 h-10 object-contain">
                <h1 class="text-xl lg:text-xl font-bold tracking-tight text-white leading-none hidden sm:block">
                    Koperasi <span class="text-secondary">Ugoro</span> Web
                </h1>
            </div>
        </div>

        {{-- Nav Links (desktop) --}}
        <nav class="hidden md:flex items-center gap-2" aria-label="Menu utama">
            @foreach ($navItems as $item)
                @php $isActive = ($activePage ?? '') === $item['key']; @endphp
                <a href="{{ route($item['route']) }}"
                   class="relative px-3 py-1.5 text-base font-semibold rounded-lg transition-all duration-200
                          {{ $isActive
                              ? 'text-primary bg-primary/10'
                              : 'text-slate-300 hover:text-primary hover:bg-slate-700' }}"
                   @if($isActive) aria-current="page" @endif>
                    {{ $item['label'] }}
                    @if($isActive)
                        <span class="absolute bottom-0 left-1/2 -translate-x-1/2 w-5 h-0.5 bg-primary rounded-full"></span>
                    @endif
                </a>
            @endforeach
        </nav>

        {{-- Right Side --}}
        <div class="flex items-center gap-3 pr-4 lg:pr-8">

            {{-- Notifikasi --}}
            <button type="button"
                    class="relative p-2 text-slate-300 hover:bg-slate-700 hover:text-white rounded-full transition-all duration-200"
                    aria-label="Notifikasi">
                <span class="material-symbols-outlined text-[22px] leading-none">notifications</span>
                <span class="absolute top-1.5 right-1.5 w-2.5 h-2.5 bg-red-500 rounded-full border-2 border-slate-800"></span>
            </button>

            {{-- Divider --}}
            <div class="w-px h-6 bg-slate-700 mx-0.5 hidden sm:block"></div>

            {{-- Profil --}}
            <div class="relative" id="profileDropdownContainer">
                <button type="button"
                        onclick="toggleProfileDropdown()"
                        class="flex items-center gap-3 px-2 py-1.5 rounded-xl hover:bg-slate-700 transition-all duration-200">

                    {{-- Avatar --}}
                    <div class="w-9 h-9 lg:w-10 lg:h-10 rounded-full border-2 border-primary bg-primary/20 flex items-center justify-center flex-shrink-0 overflow-hidden">
                        @if($currentUser && $currentUser->profile_photo)
                            <img src="{{ Storage::url($currentUser->profile_photo) }}" alt="Profile Photo" class="w-full h-full object-cover">
                        @else
                            <span class="text-primary font-bold text-lg leading-none">
                                {{ strtoupper(substr($userName, 0, 1)) }}
                            </span>
                        @endif
                    </div>

                    {{-- Nama & Role --}}
                    <div class="text-left hidden sm:block">
                        <p class="text-base font-bold text-white leading-tight">{{ $userName }}</p>
                        <p class="text-xs text-slate-400 leading-tight mt-0.5">{{ $userRole }}</p>
                    </div>

                    {{-- Chevron --}}
                    <span class="material-symbols-outlined text-[16px] text-slate-400 hidden sm:block transition-transform duration-200"
                          id="profileChevron">expand_more</span>
                </button>

                {{-- Dropdown Menu --}}
                <div id="profileDropdown"
                     class="absolute right-0 mt-2 w-52 bg-white dark:bg-slate-900 rounded-xl shadow-xl border border-slate-100 dark:border-slate-800 overflow-hidden z-50 hidden transition-all duration-150">

                    {{-- Info user --}}
                    <div class="px-4 py-3 border-b border-slate-100 dark:border-slate-800">
                        <p class="text-sm font-bold text-slate-800 dark:text-white">{{ $userName }}</p>
                        <p class="text-sm text-slate-500 dark:text-slate-400 mt-0.5">{{ $userRole }}</p>
                    </div>

                    {{-- Menu Items --}}
                    <div class="py-1.5">
                        <a href="{{ route('profile.edit') }}"
                           class="flex items-center gap-3 px-4 py-2.5 text-sm text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 hover:text-primary transition-colors">
                            <span class="material-symbols-outlined text-[18px]">manage_accounts</span>
                            Edit Profil
                        </a>
                        <a href="{{ route('dashboard') }}"
                           class="flex items-center gap-3 px-4 py-2.5 text-sm text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 hover:text-primary transition-colors">
                            <span class="material-symbols-outlined text-[18px]">help_outline</span>
                            Bantuan
                        </a>
                    </div>

                    {{-- Logout --}}
                    <div class="border-t border-slate-100 dark:border-slate-800 py-1.5">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                    class="w-full flex items-center gap-3 px-4 py-2.5 text-sm text-red-600 hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors">
                                <span class="material-symbols-outlined text-[18px]">logout</span>
                                Keluar
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            {{-- Mobile nav toggle --}}
            <button type="button"
                    onclick="toggleMobileMenu()"
                    class="md:hidden p-2 text-slate-300 hover:bg-slate-700 rounded-lg transition-colors"
                    aria-label="Buka menu navigasi">
                <span class="material-symbols-outlined text-[24px] leading-none">more_vert</span>
            </button>
        </div>
    </div>

    {{-- Mobile Navigation --}}
    <div id="mobileMenu" class="md:hidden border-t border-slate-200 dark:border-slate-800 py-3 px-2 hidden">
        @foreach ($navItems as $item)
            @php $isActive = ($activePage ?? '') === $item['key']; @endphp
            <a href="{{ route($item['route']) }}"
               class="flex items-center gap-2 px-3 py-2 text-base font-medium rounded-xl transition-all duration-200 mb-1
                      {{ $isActive
                          ? 'text-primary bg-primary/10 font-semibold'
                          : 'text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 hover:text-primary' }}"
               @if($isActive) aria-current="page" @endif>
                @if($isActive)
                    <span class="w-1.5 h-1.5 rounded-full bg-primary flex-shrink-0"></span>
                @endif
                {{ $item['label'] }}
            </a>
        @endforeach
    </div>
</header>

<script>
    function toggleProfileDropdown() {
        const dropdown = document.getElementById('profileDropdown');
        const chevron = document.getElementById('profileChevron');
        dropdown.classList.toggle('hidden');
        if (chevron) chevron.style.transform = dropdown.classList.contains('hidden') ? '' : 'rotate(180deg)';
    }

    function toggleMobileMenu() {
        document.getElementById('mobileMenu').classList.toggle('hidden');
    }

    // Close dropdown when clicking outside
    document.addEventListener('click', function(e) {
        const container = document.getElementById('profileDropdownContainer');
        const dropdown = document.getElementById('profileDropdown');
        if (container && dropdown && !container.contains(e.target)) {
            dropdown.classList.add('hidden');
            const chevron = document.getElementById('profileChevron');
            if (chevron) chevron.style.transform = '';
        }
    });
</script>
