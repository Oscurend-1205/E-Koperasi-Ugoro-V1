<!DOCTYPE html>

<html class="light" lang="id"><head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<link href="{{ asset('logo.png') }}" rel="icon" type="image/png"/>
<title>Data Karyawan - Portal Ugoro</title>
@include('user.partials.theme_loader')
@include('user.partials.scroll')
</head>
<body class="bg-background-light text-slate-900 min-h-screen antialiased">

@include('user.partials.sidebar', ['activePage' => 'karyawan'])

<div class="min-h-screen transition-all bg-background-light dark:bg-background-dark" id="content-wrapper">
@include('user.partials.topnavbar', ['activePage' => 'dashboard'])
<!-- Content Area -->
<div class="p-6 max-w-7xl mx-auto w-full">
<!-- Hero Section -->
<div class="mb-6 flex flex-col md:flex-row md:items-center justify-between gap-4">
<div>
<h1 class="text-2xl font-extrabold text-slate-900 dark:text-white mb-2">Struktur Organisasi</h1>
<p class="text-muted text-sm max-w-2xl leading-relaxed">Daftar pengurus dan staf operasional Koperasi Ugoro yang bertugas dalam pengelolaan harian dan pelayanan anggota.</p>
</div>
@if(auth()->check() && auth()->user()->isAdmin())
<a href="{{ route('karyawans.index') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-sm font-bold shadow-md transition-all self-start">
    <span class="material-symbols-outlined text-sm">settings_suggest</span>
    Kelola Struktur
</a>
@endif
</div>
<!-- Search Section -->
<div class="mb-8">
<div class="relative max-w-md">
<span class="material-symbols-outlined absolute left-3.5 top-1/2 -translate-y-1/2 text-muted text-sm">search</span>
<input class="w-full pl-10 pr-3 py-2 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-xl focus:ring-2 focus:ring-primary/50 focus:border-primary transition-all outline-none text-sm" placeholder="Cari nama karyawan atau jabatan..." readonly="" type="text" value=""/>
</div>
</div>
<!-- Pengurus Inti Section -->
<section class="mb-10">
<div class="flex items-center gap-2 mb-4">
<span class="material-symbols-outlined text-primary font-bold">verified_user</span>
<h3 class="text-xl font-bold text-slate-900 dark:text-white">Pengurus</h3>
</div>
<div class="grid grid-cols-1 md:grid-cols-3 gap-5">
@foreach($pengurus as $p)
<div class="bg-white dark:bg-slate-900 p-5 rounded-xl border border-slate-100 dark:border-slate-800 shadow-sm hover:shadow-md transition-shadow">
<div class="flex flex-col items-center text-center">
<div class="relative mb-3">
@if($p->photo)
<img class="w-20 h-20 rounded-full border-4 border-primary/20 object-cover" src="{{ asset('storage/' . $p->photo) }}"/>
@else
<img class="w-20 h-20 rounded-full border-4 border-primary/20 object-cover" src="https://ui-avatars.com/api/?name={{ urlencode($p->name) }}&background=f1f5f9&color=64748b&bold=true&size=128"/>
@endif
<span class="absolute bottom-0 right-0 bg-primary text-white text-[10px] font-bold px-1.5 py-0.5 rounded-full border-2 border-white dark:border-slate-900">{{ strtoupper($p->status) }}</span>
</div>
<h4 class="text-lg font-bold text-slate-900 dark:text-white mb-0.5">{{ $p->name }}</h4>
<p class="text-primary font-semibold text-sm mb-1">{{ $p->position }}</p>
<p class="text-xs text-muted mb-3">NIP: {{ $p->nip ?? '-' }}</p>
<button onclick='showProfileModal(@json($p))' class="w-full py-1.5 border border-primary text-primary hover:bg-primary/5 rounded-lg text-xs font-semibold transition-colors">
                                    Lihat Profil
                                </button>
</div>
</div>
@endforeach
</div>
</section>

<!-- Pengawas Section -->
<section class="mb-10">
<div class="flex items-center gap-2 mb-4">
<span class="material-symbols-outlined text-primary font-bold">supervisor_account</span>
<h3 class="text-xl font-bold text-slate-900 dark:text-white">Pengawas</h3>
</div>
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
@foreach($pengawas as $pw)
<div class="bg-white dark:bg-slate-900 p-5 rounded-xl border border-slate-100 dark:border-slate-800 shadow-sm hover:shadow-md transition-shadow">
<div class="flex flex-col items-center text-center">
<div class="relative mb-3">
@if($pw->photo)
<img class="w-20 h-20 rounded-full border-4 border-primary/20 object-cover" src="{{ asset('storage/' . $pw->photo) }}"/>
@else
<img class="w-20 h-20 rounded-full border-4 border-primary/20 object-cover" src="https://ui-avatars.com/api/?name={{ urlencode($pw->name) }}&background=f1f5f9&color=64748b&bold=true&size=128"/>
@endif
<span class="absolute bottom-0 right-0 bg-primary text-white text-[10px] font-bold px-1.5 py-0.5 rounded-full border-2 border-white dark:border-slate-900">{{ strtoupper($pw->status) }}</span>
</div>
<h4 class="text-lg font-bold text-slate-900 dark:text-white mb-0.5">{{ $pw->name }}</h4>
<p class="text-primary font-semibold text-sm mb-1">{{ $pw->position }}</p>
<p class="text-xs text-muted mb-3">NIP: {{ $pw->nip ?? '-' }}</p>
<button onclick='showProfileModal(@json($pw))' class="w-full py-1.5 border border-primary text-primary hover:bg-primary/5 rounded-lg text-xs font-semibold transition-colors">
                                    Lihat Profil
                                </button>
</div>
</div>
@endforeach
</div>
</section>

<!-- Staf Operasional Section -->
<section>
<div class="flex items-center gap-2 mb-4">
<span class="material-symbols-outlined text-primary font-bold">badge</span>
<h3 class="text-xl font-bold text-slate-900 dark:text-white">Karyawan</h3>
</div>
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
@foreach($karyawans as $k)
<div class="bg-white dark:bg-slate-900 p-4 rounded-xl border border-slate-100 dark:border-slate-800 shadow-sm">
<div class="flex items-center gap-3 mb-3">
@if($k->photo)
<img class="w-12 h-12 rounded-full object-cover border border-slate-200" src="{{ asset('storage/' . $k->photo) }}"/>
@else
<img class="w-12 h-12 rounded-full object-cover border border-slate-200" src="https://ui-avatars.com/api/?name={{ urlencode($k->name) }}&background=f1f5f9&color=64748b&bold=true&size=128"/>
@endif
<div class="overflow-hidden">
<p class="font-bold text-slate-900 dark:text-white text-xs truncate">{{ $k->name }}</p>
<p class="text-xs text-muted truncate">{{ $k->position }}</p>
<div class="flex items-center gap-1 mt-0.5">
<span class="w-1.5 h-1.5 rounded-full bg-primary"></span>
<span class="text-[10px] text-primary font-medium uppercase tracking-wider">{{ $k->status }}</span>
</div>
</div>
</div>
<p class="text-xs text-muted mb-2">ID: {{ $k->nip ?? '-' }}</p>
<button onclick='showProfileModal(@json($k))' class="w-full py-1 border border-primary/40 text-primary hover:bg-primary/5 rounded-lg text-xs font-semibold transition-colors">
                                Lihat Profil
                            </button>
</div>
@endforeach
</div>
</section>
</div>
{{-- Footer --}}
@include('user.partials.footer')
</div>
<!-- Profile Modal -->
<div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-50 flex items-center justify-center p-4 hidden" id="profileModal">
<div class="bg-white dark:bg-slate-900 w-full max-w-lg rounded-2xl overflow-hidden shadow-2xl scale-95 opacity-0 transition-all duration-300" id="modalContent">
<div class="h-24 bg-gradient-to-r from-primary/20 to-primary/40 relative">
<button onclick="closeProfileModal()" class="absolute top-4 right-4 w-10 h-10 flex items-center justify-center bg-white/20 hover:bg-white/40 rounded-full text-white">
<span class="material-symbols-outlined">close</span>
</button>
</div>
<div class="px-8 pb-8 -mt-12 relative">
<img class="w-24 h-24 rounded-full border-4 border-white dark:border-slate-900 object-cover shadow-lg mb-4" id="modalPhoto" src=""/>
<div class="flex justify-between items-start mb-6">
<div>
<h3 class="text-3xl font-bold text-slate-900 dark:text-white" id="modalName"></h3>
<p class="text-primary font-medium" id="modalPosition"></p>
</div>
<span class="bg-primary/10 text-primary px-3 py-1 rounded-full text-sm font-bold border border-primary/20" id="modalStatus"></span>
</div>
<div class="space-y-4">
<div class="grid grid-cols-2 gap-4 text-base">
<div>
<p class="text-muted mb-1 uppercase text-sm font-bold tracking-widest">Nomor Induk</p>
<p class="font-medium" id="modalNip"></p>
</div>
<div>
<p class="text-muted mb-1 uppercase text-sm font-bold tracking-widest">Tipe Struktur</p>
<p class="font-medium" id="modalType"></p>
</div>
</div>
<div>
<p class="text-muted mb-1 uppercase text-sm font-bold tracking-widest">Bio Singkat</p>
<p class="text-slate-600 dark:text-slate-400 leading-relaxed italic" id="modalBio"></p>
</div>
</div>
<div class="mt-8 pt-6 border-t border-slate-100 dark:border-slate-800 flex justify-end">
<button onclick="closeProfileModal()" class="px-6 py-2 bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-400 rounded-lg text-base font-bold">Tutup</button>
</div>
</div>
</div>
</div>
<script>
function showProfileModal(data) {
    const modal = document.getElementById('profileModal');
    const content = document.getElementById('modalContent');
    
    document.getElementById('modalName').textContent = data.name;
    document.getElementById('modalPosition').textContent = data.position;
    document.getElementById('modalStatus').textContent = data.status;
    document.getElementById('modalNip').textContent = data.nip || '-';
    document.getElementById('modalType').textContent = data.type;
    document.getElementById('modalBio').textContent = data.bio || 'Belum ada bio singkat.';
    
    if(data.photo) {
        document.getElementById('modalPhoto').src = '/storage/' + data.photo;
    } else {
        document.getElementById('modalPhoto').src = 'https://ui-avatars.com/api/?name=' + encodeURIComponent(data.name) + '&background=f1f5f9&color=64748b&bold=true&size=128';
    }
    
    modal.classList.remove('hidden');
    setTimeout(() => {
        content.classList.remove('scale-95', 'opacity-0');
        content.classList.add('scale-100', 'opacity-100');
    }, 10);
}

function closeProfileModal() {
    const modal = document.getElementById('profileModal');
    const content = document.getElementById('modalContent');
    
    content.classList.remove('scale-100', 'opacity-100');
    content.classList.add('scale-95', 'opacity-0');
    
    setTimeout(() => {
        modal.classList.add('hidden');
    }, 300);
}
</script>
</body></html>
