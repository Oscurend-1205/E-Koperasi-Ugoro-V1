<!DOCTYPE html>

<html class="light" lang="id"><head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>e-Koperasi Ugoro - Solusi Digital Koperasi Modern</title>
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&amp;display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
<script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    "colors": {
                        "on-secondary-container": "#331200",
                        "on-primary-container": "#004015",
                        "on-secondary-fixed": "#331200",
                        "tertiary": "#83542d",
                        "surface-container-highest": "#dbe6d6",
                        "surface": "#f6f8f6",
                        "inverse-primary": "#00e556",
                        "tertiary-container": "#ffc091",
                        "tertiary-fixed-dim": "#f8ba8b",
                        "surface-container": "#e6f1e1",
                        "on-surface": "#0f170f",
                        "error-container": "#ffdad6",
                        "surface-container-low": "#f6f8f6",
                        "primary-fixed": "#6cff81",
                        "secondary-fixed": "#ffdbc6",
                        "on-secondary": "#ffffff",
                        "on-primary-fixed-variant": "#00531a",
                        "on-primary-fixed": "#002106",
                        "tertiary-fixed": "#ffdcc4",
                        "primary-container": "#13ec5b",
                        "error": "#ba1a1a",
                        "surface-bright": "#ffffff",
                        "on-background": "#0f170f",
                        "background": "#f6f8f6",
                        "surface-tint": "#006e25",
                        "on-surface-variant": "#3c4b3a",
                        "on-error-container": "#93000a",
                        "on-tertiary-container": "#7a4c27",
                        "surface-container-high": "#e0ebdb",
                        "primary-fixed-dim": "#00e556",
                        "outline-variant": "#bacbb6",
                        "on-tertiary-fixed": "#2f1400",
                        "outline": "#6b7b69",
                        "primary": "#13ec5b",
                        "inverse-on-surface": "#e9f4e4",
                        "secondary": "#f97316",
                        "on-tertiary": "#ffffff",
                        "surface-variant": "#dbe6d6",
                        "on-tertiary-fixed-variant": "#673d18",
                        "secondary-fixed-dim": "#ffb78c",
                        "inverse-surface": "#293328",
                        "on-primary": "#002106",
                        "secondary-container": "#ffdbc6",
                        "surface-dim": "#d2ddcd",
                        "on-secondary-fixed-variant": "#713000",
                        "surface-container-lowest": "#ffffff",
                        "on-error": "#ffffff"
                    },
                    "borderRadius": {
                        "DEFAULT": "0.25rem",
                        "lg": "0.5rem",
                        "xl": "0.75rem",
                        "full": "9999px"
                    },
                    "fontFamily": {
                        "headline": ["Inter"],
                        "body": ["Inter"],
                        "label": ["Inter"]
                    }
                },
            },
        }
    </script>
<style>
        .glass { background: rgba(255, 255, 255, 0.7); backdrop-filter: blur(10px); }
        .material-symbols-outlined { font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24; }
        .hero-gradient { background: linear-gradient(135deg, #f97316 0%, #13ec5b 50%, #ffffff 100%); }
        html { scroll-behavior: smooth; font-size: 88%; /* Further shrunk per request */ }
        
        @keyframes bounce-subtle {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }
        .animate-bounce-subtle { animation: bounce-subtle 3s ease-in-out infinite; }
        
        /* Mobile Menu Transitions */
        #mobileMenu.active { transform: translateX(0); }
    </style>
    
    <script>
        function toggleMobileMenu() {
            const menu = document.getElementById('mobileMenu');
            const l1 = document.getElementById('m-line-1');
            const l2 = document.getElementById('m-line-2');
            const l3 = document.getElementById('m-line-3');
            
            menu.classList.toggle('active');
            
            if(menu.classList.contains('active')) {
                l1.style.transform = 'translateY(7px) rotate(45deg)';
                l2.style.opacity = '0';
                l3.style.transform = 'translateY(-7px) rotate(-45deg)';
                l3.style.width = '24px';
                document.body.style.overflow = 'hidden';
            } else {
                l1.style.transform = 'none';
                l2.style.opacity = '1';
                l3.style.transform = 'none';
                l3.style.width = '16px';
                document.body.style.overflow = 'auto';
            }
        }
    </script>
</head>
<body class="bg-background font-body text-on-surface">
<!-- Top Navigation Bar -->
<!-- Top Navigation Bar -->
<nav class="fixed top-0 left-0 w-full z-[100] bg-white/80 backdrop-blur-xl border-b border-emerald-500/10 shadow-sm transition-all duration-300" id="mainNav">
    <div class="flex justify-between items-center px-5 md:px-12 h-16 max-w-5xl mx-auto">
        <div class="flex items-center gap-3">
            <img src="{{ asset('logo.png') }}" alt="Logo" class="w-8 h-8 md:w-9 md:h-9 object-contain">
            <div class="text-lg md:text-xl font-black text-slate-900 tracking-tighter">E-Koperasi <span class="text-emerald-600">Ugoro</span></div>
        </div>
        
        <div class="hidden lg:flex gap-10 font-inter text-sm font-bold tracking-tight">
            <a class="text-emerald-600 border-b-2 border-emerald-500 pb-1" href="#">Beranda</a>
            <a class="text-slate-500 hover:text-emerald-600 transition-colors" href="#about">Layanan</a>
            <a class="text-slate-500 hover:text-emerald-600 transition-colors" href="#features">Fitur</a>
            <a class="text-slate-500 hover:text-emerald-600 transition-colors" href="#">Tentang</a>
        </div>

        <div class="flex items-center gap-3">
            @auth
                <a href="{{ route('dashboard') }}" class="bg-primary text-on-primary px-6 py-2 rounded-full font-bold text-sm shadow-lg shadow-primary/20 active:scale-95 transition-all">Dashboard</a>
            @else
                <a href="{{ route('login') }}" class="bg-primary text-on-primary px-6 py-2 rounded-full font-bold text-sm shadow-lg shadow-primary/20 active:scale-95 transition-all">Masuk</a>
            @endauth
            
            {{-- Mobile Menu Trigger --}}
            <button class="lg:hidden w-10 h-10 flex flex-col items-center justify-center gap-1.5 focus:outline-none" onclick="toggleMobileMenu()">
                <div class="w-6 h-0.5 bg-slate-900 rounded-full transition-all duration-300" id="m-line-1"></div>
                <div class="w-6 h-0.5 bg-slate-900 rounded-full transition-all duration-300" id="m-line-2"></div>
                <div class="w-4 h-0.5 bg-slate-900 rounded-full ml-auto transition-all duration-300" id="m-line-3"></div>
            </button>
        </div>
    </div>
    
    {{-- Mobile Sidebar Menu --}}
    <div id="mobileMenu" class="fixed inset-0 top-20 bg-white z-[90] lg:hidden translate-x-full transition-transform duration-500 ease-in-out p-6 border-t border-slate-100">
        <div class="flex flex-col gap-6">
            <a onclick="toggleMobileMenu()" href="#" class="text-2xl font-black text-emerald-600">Beranda</a>
            <a onclick="toggleMobileMenu()" href="#about" class="text-2xl font-black text-slate-400 hover:text-slate-900 transition-colors">Layanan</a>
            <a onclick="toggleMobileMenu()" href="#features" class="text-2xl font-black text-slate-400 hover:text-slate-900 transition-colors">Fitur</a>
            <a onclick="toggleMobileMenu()" href="#" class="text-2xl font-black text-slate-400 hover:text-slate-900 transition-colors">Tentang Kami</a>
            
            <div class="h-px bg-slate-100 my-4"></div>
            
            @auth
                <a href="{{ route('dashboard') }}" class="w-full text-center py-4 rounded-2xl bg-emerald-600 font-bold text-white shadow-xl shadow-emerald-200">Dashboard</a>
            @else
                <a href="{{ route('login') }}" class="w-full text-center py-4 rounded-2xl bg-emerald-600 font-bold text-white shadow-xl shadow-emerald-200">Masuk</a>
            @endauth
        </div>
    </div>
</nav>
<!-- Hero Section -->
<!-- Hero Section -->
<header class="relative pt-10 pb-5 md:pt-24 md:pb-20 overflow-hidden">
    <div class="absolute inset-0 -z-10 bg-[radial-gradient(circle_at_top_right,_var(--tw-gradient-stops))] from-emerald-100/50 via-transparent to-transparent"></div>
    <div class="max-w-5xl mx-auto px-4 md:px-12 grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-12 items-center">
        <div class="space-y-8 text-center lg:text-left">
            <div class="inline-flex items-center gap-2 px-4 py-2 bg-emerald-50 rounded-full border border-emerald-100 mx-auto lg:mx-0">
                <span class="relative flex h-2 w-2">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
                </span>
                <span class="text-[10px] font-bold tracking-widest text-emerald-700 uppercase">Dipercaya 500+ Anggota</span>
            </div>
            
            <h1 class="text-3xl sm:text-5xl md:text-7xl font-black text-slate-900 leading-[1.1] tracking-tight">
                Masa Depan <br class="hidden md:block">
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-emerald-600 to-emerald-400">Koperasi Digital</span>
            </h1>
            
            <p class="text-base md:text-xl text-slate-500 max-w-xl mx-auto lg:mx-0 leading-relaxed font-medium">
                Satu platform terintegrasi untuk kelola simpanan, pinjaman modal, dan manajemen anggota yang transparan & barokah.
            </p>
            
            <div class="flex flex-col sm:flex-row gap-3 justify-center lg:justify-start pt-2">
                <a href="{{ route('register') }}" class="bg-emerald-600 text-white px-8 py-4 rounded-2xl font-bold text-base shadow-2xl shadow-emerald-200 hover:-translate-y-1 transition-all text-center">Gabung Sekarang</a>
                <a href="#about" class="bg-white text-slate-900 border border-slate-200 px-8 py-4 rounded-2xl font-bold text-base hover:bg-slate-50 transition-all text-center">Tentang Kami</a>
            </div>
        </div>
        
        <div class="relative mt-8 lg:mt-0">
            <div class="aspect-[4/3] md:aspect-square rounded-[2rem] md:rounded-[3rem] overflow-hidden shadow-2xl relative">
                <img alt="Financial Professional" class="w-full h-full object-cover" src="https://lh3.googleusercontent.com/aida-public/AB6AXuBp3fPcYERlZF5Bw_1BC35icND4aKRNvNR0tzKcm3oMZ42mvu8G-eNra06HtDx-ZQvRSQ3jfQhCXurwLvXbQxH2BomKvTlSMI18qM9rVYzKudYk4b90fQ7zyjiQOGW6W73gdkfRjIZFQqywKPCaZayj0ZKQ5IXzeVhWqqo4bkPYuBNYZcFX30jjfO8KyCggvs-jutPyn9IxVbNyIfvtm5qccyV0nn4InfHi3tP5o20ivIo3yXPqyVqFPG3gjMAj_ESjZdrzR9I-QuA"/>
                <div class="absolute inset-0 bg-gradient-to-t from-emerald-900/40 via-transparent to-transparent"></div>
            </div>
            
            <!-- Floating Data Card -->
            <div class="absolute -bottom-10 -right-2 md:-right-10 bg-white/90 backdrop-blur-xl p-6 md:p-8 rounded-[2rem] shadow-2xl shadow-emerald-900/10 border border-white max-w-[200px] md:max-w-xs animate-bounce-subtle">
                <div class="flex items-center gap-4 mb-4">
                    <div class="w-10 h-10 md:w-12 md:h-12 bg-emerald-600 rounded-2xl flex items-center justify-center text-white shadow-lg shadow-emerald-200">
                        <span class="material-symbols-outlined">analytics</span>
                    </div>
                    <div>
                        <p class="text-[8px] md:text-[10px] font-bold text-slate-400 uppercase tracking-widest">Total Simpanan</p>
                        <p class="text-lg md:text-2xl font-black text-slate-900">Rp 12,8 M</p>
                    </div>
                </div>
                <div class="flex items-center gap-2">
                    <div class="flex -space-x-3">
                        <img class="w-6 h-6 md:w-8 md:h-8 rounded-full border-2 border-white" src="https://ui-avatars.com/api/?name=A&background=random" />
                        <img class="w-6 h-6 md:w-8 md:h-8 rounded-full border-2 border-white" src="https://ui-avatars.com/api/?name=B&background=random" />
                    </div>
                    <span class="text-[10px] font-bold text-emerald-600">+50 Baru</span>
                </div>
            </div>
        </div>
    </div>
</header>
<!-- About Section -->
<!-- About Section -->
<section class="py-8 md:py-14 bg-white" id="about">
    <div class="max-w-5xl mx-auto px-5 md:px-12">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-12 items-center">
            <div class="order-2 lg:order-1 relative scale-90 sm:scale-95">
                <div class="grid grid-cols-2 gap-4">
                    <div class="space-y-4">
                        <img alt="About Ugoro" class="rounded-3xl shadow-lg w-full aspect-[4/5] object-cover" src="https://lh3.googleusercontent.com/aida-public/AB6AXuAg9saVN_eEhzPf5iOOT3HcPjKbzt57y9yXWVMBwugE33x301zY6DkB9gJd-A4vmr4PJkIiAq80XSCCVVZnsenegzN_ZGMbDQkOYTVCeiPAzDMpJkNf7qbw833UoKKiPIvZfAHmfOq6QrzhP4t-hXs15DnDYZJY78MkKeUGcmezrjpDVFfSBaraReCMfvYkt9J1Torni1mLR6Bx2SBdhP_pAyRJ-nMp83LZDxwI-rr2ctUUKwtLsSjIlsGCWCR4fepKJAHwv2ktC5s"/>
                        <div class="bg-emerald-600 p-6 rounded-3xl text-white">
                            <p class="text-3xl font-black italic leading-none">12Th</p>
                            <p class="text-[10px] font-bold uppercase tracking-widest mt-1">Mengabdi untuk Umat</p>
                        </div>
                    </div>
                    <div class="pt-12 space-y-4">
                        <div class="bg-slate-100 aspect-square rounded-3xl flex items-center justify-center">
                             <span class="material-symbols-outlined text-5xl text-emerald-600">volunteer_activism</span>
                        </div>
                        <img alt="About Ugoro" class="rounded-3xl shadow-lg w-full aspect-[4/5] object-cover" src="https://lh3.googleusercontent.com/aida-public/AB6AXuALvssnhaFIA_thM6-w3B1mC0LA5K40IwHphvg9byBJxM3VfHkZFBYaexJbBE4HXNOGLB6Vl0cdAg529h_b0aTy12-RvjBdCbItxnoIEibFmLp4E20nXA4z0oozuNoB_tybvaKK2gkGno8ogOBylnkB8sVmbOAPvhkyELqcbwX9movkI5yih6xxw1u3ZCwrzHIIy5803-GnxpsjX0vclddxS_mr-WqftoRvmRYdWMcfnP9E01urE_79dYkQc7tMubUHIEAtzpDNmpg"/>
                    </div>
                </div>
            </div>
            <div class="order-1 lg:order-2 space-y-5 text-center lg:text-left">
                <div class="space-y-2">
                    <h2 class="text-[9px] font-black tracking-[0.3em] text-emerald-600 uppercase">Mengenal Lebih Dekat</h2>
                    <h3 class="text-xl md:text-3xl font-black text-slate-900 leading-tight">Membangun Masa Depan Ekonomi Bersama</h3>
                    <p class="text-sm md:text-base text-slate-500 leading-relaxed font-medium">
                        e-Koperasi Ugoro hadir sebagai jembatan antara nilai-nilai tradisional gotong royong dengan efisiensi teknologi digital terkini. Kami percaya bahwa setiap anggota berhak atas akses finansial yang transparan.
                    </p>
                </div>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pb-2">
                    <div class="p-4 bg-slate-50 rounded-2xl border border-slate-100 hover:border-emerald-200 transition-colors text-left">
                        <div class="w-8 h-8 bg-emerald-100 rounded-lg flex items-center justify-center text-emerald-600 mb-2.5">
                            <span class="material-symbols-outlined text-lg">verified</span>
                        </div>
                        <h4 class="font-bold text-slate-900 text-sm">Terpercaya</h4>
                        <p class="text-[10px] text-slate-500 font-medium">Sistem manajemen akuntabel.</p>
                    </div>
                    <div class="p-4 bg-slate-50 rounded-2xl border border-slate-100 hover:border-emerald-200 transition-colors text-left">
                        <div class="w-8 h-8 bg-emerald-100 rounded-lg flex items-center justify-center text-emerald-600 mb-2.5">
                            <span class="material-symbols-outlined text-lg">electric_bolt</span>
                        </div>
                        <h4 class="font-bold text-slate-900 text-sm">Cepat & Mudah</h4>
                        <p class="text-[10px] text-slate-500 font-medium">Layanan serba instan.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Statistics Section -->
<!-- Statistics Section -->
<section class="py-16 bg-slate-900 text-white relative overflow-hidden">
    <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/carbon-fibre.png')] opacity-20"></div>
    <div class="max-w-5xl mx-auto px-4 md:px-12 relative z-10 text-center lg:text-left">
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-12 md:gap-8">
            <div class="space-y-1">
                <p class="text-5xl md:text-7xl font-black text-emerald-500 tracking-tighter">1.5K+</p>
                <p class="text-[10px] font-bold uppercase tracking-[0.3em] text-slate-400">Anggota Aktif</p>
            </div>
            <div class="space-y-1">
                <p class="text-5xl md:text-7xl font-black text-white tracking-tighter">Rp 20M+</p>
                <p class="text-[10px] font-bold uppercase tracking-[0.3em] text-slate-400">Putaran Operasional</p>
            </div>
            <div class="space-y-1">
                <p class="text-5xl md:text-7xl font-black text-emerald-500 tracking-tighter">0%</p>
                <p class="text-[10px] font-bold uppercase tracking-[0.3em] text-slate-400">Bunga Tersembunyi</p>
            </div>
        </div>
    </div>
</section>
<!-- Main Features -->
<section class="py-16 bg-surface" id="features">
    <div class="max-w-5xl mx-auto px-6 md:px-12">
        <div class="flex flex-col md:flex-row justify-between items-center lg:items-end mb-12 gap-6 text-center md:text-left">
            <div class="max-w-xl">
                <h2 class="text-[10px] font-black tracking-[0.3em] text-emerald-600 uppercase mb-4">Fitur Unggulan</h2>
                <h3 class="text-2xl md:text-5xl font-black text-slate-900 leading-tight">Kelola Keuangan dengan Mudah & Aman</h3>
            </div>
            <button class="bg-white text-emerald-600 px-6 py-3 rounded-full border border-emerald-100 font-bold flex items-center gap-2 hover:bg-emerald-50 transition-all shadow-sm">
                Lihat Semua Fitur <span class="material-symbols-outlined text-sm">arrow_forward</span>
            </button>
        </div>
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
<!-- Card 1 -->
<div class="bg-surface-container-lowest p-6 rounded-2xl shadow-sm hover:shadow-xl hover:-translate-y-2 transition-all duration-300 group">
<div class="w-12 h-12 bg-emerald-50 rounded-xl flex items-center justify-center text-emerald-600 mb-5 group-hover:bg-primary group-hover:text-on-primary transition-colors">
<span class="material-symbols-outlined text-2xl">savings</span>
</div>
<h4 class="text-lg font-black text-slate-800 mb-3">Simpanan Anggota</h4>
<p class="text-slate-500 text-xs leading-relaxed mb-5">Kelola simpanan wajib, pokok, dan sukarela dengan pelacakan real-time.</p>
<div class="flex items-center gap-2 text-[10px] font-bold text-emerald-600 uppercase">
                        Aktif <span class="w-2 h-2 rounded-full bg-primary animate-pulse"></span>
</div>
</div>
<!-- Card 2 -->
<div class="bg-surface-container-lowest p-6 rounded-2xl shadow-sm hover:shadow-xl hover:-translate-y-2 transition-all duration-300 group">
<div class="w-12 h-12 bg-orange-50 rounded-xl flex items-center justify-center text-orange-600 mb-5 group-hover:bg-secondary group-hover:text-white transition-colors">
<span class="material-symbols-outlined text-2xl">account_balance_wallet</span>
</div>
<h4 class="text-lg font-black text-slate-800 mb-3">Pinjaman Online</h4>
<p class="text-slate-500 text-xs leading-relaxed mb-5">Proses pengajuan pinjaman cepat dengan suku bunga yang kompetitif dan adil.</p>
<div class="flex items-center gap-2 text-[10px] font-bold text-orange-600 uppercase">
                        Instan <span class="material-symbols-outlined text-[10px]">bolt</span>
</div>
</div>
<!-- Card 3 -->
<div class="bg-surface-container-lowest p-6 rounded-2xl shadow-sm hover:shadow-xl hover:-translate-y-2 transition-all duration-300 group">
<div class="w-12 h-12 bg-blue-50 rounded-xl flex items-center justify-center text-blue-600 mb-5 group-hover:bg-blue-600 group-hover:text-white transition-colors">
<span class="material-symbols-outlined text-2xl">groups</span>
</div>
<h4 class="text-lg font-black text-slate-800 mb-3">Manajemen Data</h4>
<p class="text-slate-500 text-xs leading-relaxed mb-5">Database anggota terintegrasi dengan sistem verifikasi identitas yang aman.</p>
<div class="flex items-center gap-2 text-[10px] font-bold text-blue-600 uppercase">
                        Terpusat <span class="material-symbols-outlined text-[10px]">database</span>
</div>
</div>
<!-- Card 4 -->
<div class="bg-surface-container-lowest p-6 rounded-2xl shadow-sm hover:shadow-xl hover:-translate-y-2 transition-all duration-300 group">
<div class="w-12 h-12 bg-purple-50 rounded-xl flex items-center justify-center text-purple-600 mb-5 group-hover:bg-purple-600 group-hover:text-white transition-colors">
<span class="material-symbols-outlined text-2xl">bar_chart</span>
</div>
<h4 class="text-lg font-black text-slate-800 mb-3">Laporan Keuangan</h4>
<p class="text-slate-500 text-xs leading-relaxed mb-5">Laporan otomatis yang transparan dan mudah diunduh kapan saja.</p>
<div class="flex items-center gap-2 text-[10px] font-bold text-purple-600 uppercase">
                        Otomatis <span class="material-symbols-outlined text-[10px]">auto_awesome</span>
</div>
</div>
</div>
</div>
</section>
<!-- Testimonials Section -->
<section class="py-16 bg-white overflow-hidden">
<div class="max-w-5xl mx-auto px-6 md:px-12">
<h2 class="text-center text-3xl md:text-4xl font-bold text-slate-900 mb-12">Apa Kata Anggota Kami</h2>
<div class="grid grid-cols-1 md:grid-cols-3 gap-8">
<div class="bg-slate-50 p-8 rounded-3xl border border-slate-100">
<div class="flex gap-1 text-orange-400 mb-4">
<span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">star</span>
<span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">star</span>
<span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">star</span>
<span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">star</span>
<span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">star</span>
</div>
<p class="text-slate-600 italic mb-8">"Proses simpan pinjam jadi jauh lebih mudah sejak ada e-Koperasi. Semuanya transparan dan bisa dicek lewat HP."</p>
<div class="flex items-center gap-4">
<div class="w-12 h-12 rounded-full overflow-hidden bg-slate-200">
<img alt="Ahmad" class="w-full h-full object-cover" data-alt="Portrait of a smiling Indonesian man in a casual business shirt with a soft office background" src="https://lh3.googleusercontent.com/aida-public/AB6AXuAOUAUb9MWPTZG7SAYCmh9A_VFU0V1AVBiO01gjgL6eNCyR21T6KKAsicH1wVPb84S9M9aPMVJnp45fo7RXYOxnOBnRN9o8Qz2bwkqECCuG3mkwIknLPBJvni83yPhnEnXPQY3LGEEpdvCWZyD4Mk75QCBy6KhhjkM7r1HqgnJVZnp8hJV8FSaluZq_OryCMbFJPI9FvEvnpHHUbgNOJ6NHfyYP65I1qlTruT9qu8OnJaBosPBMld9HZRkoCdlSU36oVRXS3bhBFoY"/>
</div>
<div>
<p class="font-bold text-slate-900">Ahmad Subarjo</p>
<p class="text-xs text-slate-500 uppercase tracking-widest font-bold">Pemilik UMKM</p>
</div>
</div>
</div>
<div class="bg-slate-50 p-8 rounded-3xl border border-slate-100">
<div class="flex gap-1 text-orange-400 mb-4">
<span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">star</span>
<span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">star</span>
<span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">star</span>
<span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">star</span>
<span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">star_half</span>
</div>
<p class="text-slate-600 italic mb-8">"Layanan yang ramah dan aplikasi yang sangat intuitif. Sangat membantu saya dalam mengelola keuangan keluarga."</p>
<div class="flex items-center gap-4">
<div class="w-12 h-12 rounded-full overflow-hidden bg-slate-200">
<img alt="Siti" class="w-full h-full object-cover" data-alt="Portrait of a young professional woman smiling warmly, high-key studio lighting with a neutral background" src="https://lh3.googleusercontent.com/aida-public/AB6AXuDoQITedAETHewhVPUvMS_-pBNmUOv40mm3uLGBgyX5Y8Pua0ELsO5KjukZM5E8Comap9QG2LYn4JDIMFDjou6lVC9uh-JOkY7Z2tZzyep6nSPRFDQ9C6lQ-KtIUgkw76-O_mjsFQJiBjyCgk3Dc2s9EOi--DOANZe71J6RRPiOPG7zsI_kb9lFnXgEQIvrulZjRfVFKnTzNDZSxfQFxtexY4VGKNzlH9cGn8J8xwEOjWu5R4E7emrpmwbhiG0j3zlRR4Zc2byanwY"/>
</div>
<div>
<p class="font-bold text-slate-900">Siti Aminah</p>
<p class="text-xs text-slate-500 uppercase tracking-widest font-bold">Pegawai Negeri</p>
</div>
</div>
</div>
<div class="bg-slate-50 p-8 rounded-3xl border border-slate-100">
<div class="flex gap-1 text-orange-400 mb-4">
<span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">star</span>
<span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">star</span>
<span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">star</span>
<span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">star</span>
<span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">star</span>
</div>
<p class="text-slate-600 italic mb-8">"Saya terkesan dengan kecepatan proses verifikasi pinjaman. Sangat mendukung kebutuhan modal usaha yang mendesak."</p>
<div class="flex items-center gap-4">
<div class="w-12 h-12 rounded-full overflow-hidden bg-slate-200">
<img alt="Budi" class="w-full h-full object-cover" data-alt="Close-up portrait of an older gentleman with a kind expression and silver hair, soft natural lighting" src="https://lh3.googleusercontent.com/aida-public/AB6AXuDzgKackA4YKPENxtiWwmdGZKBHuMj01LiX3AT-vsk8FzhSExG3iNZdsXY5Osk_p8nZyePgb-FhUJcyQJoS4Oz26OTZ2iVLUbr7cgwzSwOMJJaARHLsiFb224xz_5xU6DXFVTgyTdFcnVKjm9z6ZTkcKyasseQ8c3wGn_MRc5uaEg66m6y8hLhyc16wPLlg_0OKJSvX0RlvzLH5u9dlb4_vyIDwlAAcXJgvODb-c3ZLMRtTiGsqUNOqCIY2ptSMz-9qGa3ePp22_NY"/>
</div>
<div>
<p class="font-bold text-slate-900">Budi Hartono</p>
<p class="text-xs text-slate-500 uppercase tracking-widest font-bold">Petani Milenial</p>
</div>
</div>
</div>
</div>
</div>
</section>
<!-- CTA Section -->
<section class="py-8 md:py-10">
    <div class="max-w-5xl mx-auto px-4 md:px-12 w-full">
        <div class="bg-primary rounded-[2rem] md:rounded-[2.5rem] py-8 px-6 md:py-10 md:px-16 text-center relative overflow-hidden shadow-2xl shadow-emerald-900/10">
<div class="absolute top-0 left-0 w-full h-full opacity-10 pointer-events-none">
<div class="absolute top-0 left-0 w-64 h-64 bg-white rounded-full -translate-x-1/2 -translate-y-1/2"></div>
<div class="absolute bottom-0 right-0 w-96 h-96 bg-white rounded-full translate-x-1/3 translate-y-1/3"></div>
</div>
<div class="relative z-10 space-y-5 md:space-y-6 max-w-3xl mx-auto">
<h2 class="text-2xl sm:text-3xl md:text-4xl font-black text-on-primary tracking-tighter leading-tight">Siap Menjadi Bagian dari Perubahan?</h2>
<p class="text-sm md:text-base text-on-primary-container/90 leading-relaxed font-medium">
                        Daftar sekarang dan nikmati kemudahan akses finansial yang modern, aman, dan barokah. Mari tumbuh bersama e-Koperasi Ugoro.
                    </p>
<div class="flex flex-col sm:flex-row gap-3 justify-center pt-2 px-2 sm:px-0">
    <a href="{{ route('register') }}" class="w-full sm:w-auto bg-slate-900 text-white px-8 md:px-10 py-3 md:py-3.5 rounded-xl font-bold text-sm md:text-base hover:scale-105 active:scale-95 transition-all shadow-xl">Daftar Sekarang</a>
    <a href="{{ route('contact.create') }}" class="w-full sm:w-auto bg-white text-emerald-700 border border-emerald-100 px-8 md:px-10 py-3 md:py-3.5 rounded-xl font-bold text-sm md:text-base hover:bg-emerald-50 transition-all">Hubungi Admin</a>
</div>
</div>
</div>
</div>
</section>
<!-- Footer -->
<footer class="bg-slate-50 w-full border-t border-slate-200">
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-10 px-6 md:px-12 py-12 max-w-5xl mx-auto">
<div class="space-y-6">
<div class="flex items-center gap-3">
    <img src="{{ asset('logo.png') }}" alt="Logo" class="w-7 h-7 object-contain">
    <div class="text-lg font-black text-slate-900">E-Koperasi Ugoro</div>
</div>
<p class="text-slate-500 text-sm leading-relaxed">
                    Memberdayakan ekonomi umat melalui sistem digital yang transparan dan inklusif. Terdaftar dan diawasi oleh otoritas terkait.
                </p>
<div class="flex gap-4">
<a class="w-10 h-10 bg-slate-200 rounded-full flex items-center justify-center text-slate-600 hover:bg-primary hover:text-white transition-all" href="#"><span class="material-symbols-outlined">public</span></a>
<a class="w-10 h-10 bg-slate-200 rounded-full flex items-center justify-center text-slate-600 hover:bg-primary hover:text-white transition-all" href="#"><span class="material-symbols-outlined">share</span></a>
<a class="w-10 h-10 bg-slate-200 rounded-full flex items-center justify-center text-slate-600 hover:bg-primary hover:text-white transition-all" href="#"><span class="material-symbols-outlined">alternate_email</span></a>
</div>
</div>
<div>
<h4 class="font-inter text-xs uppercase tracking-widest font-bold text-emerald-500 mb-8">Layanan Kami</h4>
<ul class="space-y-4">
<li><a class="text-slate-500 hover:text-emerald-500 transition-colors text-sm font-medium" href="#">Simpanan Pokok</a></li>
<li><a class="text-slate-500 hover:text-emerald-500 transition-colors text-sm font-medium" href="#">Pinjaman Modal UMKM</a></li>
<li><a class="text-slate-500 hover:text-emerald-500 transition-colors text-sm font-medium" href="#">Simpanan Berjangka</a></li>
<li><a class="text-slate-500 hover:text-emerald-500 transition-colors text-sm font-medium" href="#">Pembiayaan Syariah</a></li>
</ul>
</div>
<div>
<h4 class="font-inter text-xs uppercase tracking-widest font-bold text-emerald-500 mb-8">Informasi</h4>
<ul class="space-y-4">
<li><a class="text-slate-500 hover:text-emerald-500 transition-colors text-sm font-medium" href="#">Syarat &amp; Ketentuan</a></li>
<li><a class="text-slate-500 hover:text-emerald-500 transition-colors text-sm font-medium" href="#">Kebijakan Privasi</a></li>
<li><a class="text-slate-500 hover:text-emerald-500 transition-colors text-sm font-medium" href="#">FAQ</a></li>
<li><a class="text-slate-500 hover:text-emerald-500 transition-colors text-sm font-medium" href="#">Karir</a></li>
</ul>
</div>
<div>
<h4 class="font-inter text-xs uppercase tracking-widest font-bold text-emerald-500 mb-8">Kontak</h4>
<div class="space-y-4 text-sm text-slate-500">
<p class="flex items-start gap-2">
<span class="material-symbols-outlined text-emerald-500">location_on</span>
                        Jl. Ekonomi Sejahtera No. 45<br/>Jakarta Selatan, 12345
                    </p>
<p class="flex items-center gap-2">
<span class="material-symbols-outlined text-emerald-500">phone</span>
                        (021) 8888-7777
                    </p>
<p class="flex items-center gap-2">
<span class="material-symbols-outlined text-emerald-500">mail</span>
                        halo@ugoro.id
                    </p>
</div>
</div>
</div>
<div class="border-t border-slate-200 py-8 px-6 md:px-12 text-center">
<p class="font-inter text-xs uppercase tracking-widest font-bold text-slate-400">© 2025 e-Koperasi Ugoro.</p>
</div>
</footer>
</body></html>