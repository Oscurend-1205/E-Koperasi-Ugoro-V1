<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Dashboard Koperasi Ugoro">
    <link rel="icon" type="image/png" href="{{ asset('logo.png') }}">
    <title>Dashboard - Koperasi Ugoro</title>
    @include('user.partials.theme_loader')
    @include('user.partials.scroll')
</head>
<body class="bg-background-light text-slate-900 min-h-screen">

@include('user.partials.sidebar', ['activePage' => 'dashboard'])

<div class="min-h-screen transition-all bg-background-light" id="content-wrapper">
    @include('user.partials.topnavbar', ['activePage' => 'dashboard'])

    <!-- Main Content -->
    <main class="max-w-[1600px] mx-auto w-full px-5 lg:px-10 pt-3 pb-10 space-y-8">
        <!-- Greeting -->
        <div class="mb-5 fade-in-up">
            <h2 class="text-xl lg:text-xl font-black text-slate-800 tracking-tight">
                <span id="greeting">Selamat Datang</span>, <span class="text-primary">{{ $user->name ?? 'Suparmin' }}</span>!
            </h2>
            <p class="text-slate-600 mt-1 text-base lg:text-base">Berikut ringkasan keuangan koperasi Anda</p>
        </div>

        <!-- Member Card -->
        <div class="bg-gradient-to-r from-primary via-green-600 to-green-700 rounded-2xl p-4 lg:p-5 text-white mb-5 fade-in-up delay-1 relative overflow-hidden shadow-xl shadow-primary/20">
            <div class="absolute top-0 right-0 w-40 h-40 bg-white/10 rounded-full -translate-y-1/2 translate-x-1/2"></div>
            <div class="absolute bottom-0 left-0 w-32 h-32 bg-white/5 rounded-full translate-y-1/2 -translate-x-1/2"></div>
            
            <div class="relative flex flex-col sm:flex-row sm:items-center gap-4">
                <div class="w-14 h-14 lg:w-16 lg:h-16 rounded-2xl bg-white/20 backdrop-blur flex items-center justify-center text-xl lg:text-xl font-bold border-2 border-white/30 overflow-hidden">
                    @if($user->profile_photo)
                        <img src="{{ Storage::url($user->profile_photo) }}" alt="Profile" class="w-full h-full object-cover">
                    @else
                        {{ substr($user->name ?? 'S', 0, 1) }}
                    @endif
                </div>
                <div class="flex-1">
                    <div class="flex flex-wrap items-center gap-2 mb-1">
                        <h3 class="text-xl lg:text-xl font-bold">{{ $user->name ?? 'Suparmin' }}</h3>
                        <span class="px-2 py-0.5 bg-white/20 backdrop-blur text-xs font-bold rounded-full">{{ $user->role ?? 'Anggota' }}</span>
                    </div>
                    <p class="text-white/80 text-xs lg:text-xs">No. Anggota: <span class="font-bold text-white">{{ $user->no_anggota ?? '-' }}</span></p>
                </div>
                <div class="flex items-center gap-1.5 bg-white/10 backdrop-blur px-3 py-1.5 rounded-xl">
                    <svg class="w-5 h-5 text-green-300" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    <span class="text-sm font-medium">Aktif</span>
                </div>
            </div>
            
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 mt-5 pt-5 border-t border-white/20">
                <div class="flex items-center gap-2">
                    <div class="p-2 bg-white/10 rounded-lg">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <div class="min-w-0">
                        <p class="text-xs text-white/60">Email</p>
                        <p class="text-xs font-medium truncate">{{ $user->email ?? 'user@email.com' }}</p>
                    </div>
                </div>
                <div class="flex items-center gap-2">
                    <div class="p-2 bg-white/10 rounded-lg">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                        </svg>
                    </div>
                    <div class="min-w-0">
                        <p class="text-xs text-white/60">Telepon</p>
                        <p class="text-xs font-medium truncate">{{ $user->no_hp ?? '-' }}</p>
                    </div>
                </div>
                <div class="flex items-center gap-2">
                    <div class="p-2 bg-white/10 rounded-lg">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                    </div>
                    <div class="min-w-0">
                        <p class="text-xs text-white/60">Alamat</p>
                        <p class="text-xs font-medium truncate">{{ $user->alamat ?? '-' }}</p>
                    </div>
                </div>
                <div class="flex items-center gap-2">
                    <div class="p-2 bg-white/10 rounded-lg">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <div class="min-w-0">
                        <p class="text-xs text-white/60">Bergabung</p>
                        <p class="text-xs font-medium">{{ $user->created_at ? $user->created_at->translatedFormat('M Y') : '-' }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 mb-4">
            <!-- Total Simpanan -->
            <div class="bg-white rounded-2xl p-5 border border-slate-200 card-hover fade-in-up delay-2 flex flex-col justify-between">
                <div class="flex items-center justify-between mb-1">
                    <p class="text-xs text-slate-500 font-extrabold">Total Simpanan</p>
                    <span class="text-[10px] font-extrabold text-emerald-600 bg-emerald-50 px-1.5 py-0.5 rounded-md">+12.5%</span>
                </div>
                <h3 class="text-lg font-black text-slate-800 counter tracking-tight" data-target="{{ $totalSimpanan ?? 0 }}">Rp 0</h3>
                <div class="mt-2.5 flex items-center gap-2">
                    <div class="flex-1 bg-slate-100 h-1.5 rounded-full overflow-hidden">
                        <div class="h-full bg-primary rounded-full progress-bar" style="--p: {{ $persenSimpanan }}%; width: var(--p);"></div>
                    </div>
                    <p class="text-[10px] text-slate-400 font-medium whitespace-nowrap">{{ $persenSimpanan }}% dari target tahunan</p>
                </div>
            </div>

            <!-- Total Pinjaman -->
            <div class="bg-white rounded-2xl p-5 border border-slate-200 card-hover fade-in-up delay-3 flex flex-col justify-between">
                <div class="flex items-center justify-between mb-1">
                    <p class="text-xs text-slate-500 font-extrabold">Total Pinjaman</p>
                    <span class="text-[10px] font-extrabold text-blue-600 bg-blue-50 px-1.5 py-0.5 rounded-md">+5.2%</span>
                </div>
                <h3 class="text-lg font-black text-slate-800 counter tracking-tight" data-target="{{ $totalPinjaman ?? 0 }}">Rp 0</h3>
                <div class="mt-2.5 flex items-center gap-2">
                    <div class="flex-1 bg-slate-100 h-1.5 rounded-full overflow-hidden">
                        <div class="h-full bg-secondary rounded-full progress-bar" style="--progress-width: {{ $persenTerbayar ?? 0 }}%; width: var(--progress-width);"></div>
                    </div>
                    <p class="text-[10px] text-slate-400 font-medium whitespace-nowrap">{{ $persenTerbayar ?? 0 }}% sudah terbayar</p>
                </div>
            </div>

            <!-- Sisa Angsuran -->
            <div class="bg-white rounded-2xl p-5 border border-slate-200 card-hover fade-in-up delay-4 flex flex-col justify-between">
                <div class="flex items-center justify-between mb-1">
                    <p class="text-xs text-slate-500 font-extrabold">Sisa Angsuran</p>
                    <span class="text-[10px] font-extrabold text-red-600 bg-red-50 px-1.5 py-0.5 rounded-md">-8.3%</span>
                </div>
                <h3 class="text-lg font-black text-slate-800 counter tracking-tight" data-target="{{ $sisaAngsuran ?? 0 }}">Rp 0</h3>
                <div class="mt-2.5 flex items-center gap-2">
                    <div class="flex-1 bg-slate-100 h-1.5 rounded-full overflow-hidden">
                        <div class="h-full bg-red-500 rounded-full progress-bar" style="--progress-width: {{ $persenSisa ?? 0 }}%; width: var(--progress-width);"></div>
                    </div>
                    <p class="text-[10px] text-slate-400 font-medium whitespace-nowrap">{{ $bulanTersisa ?? 0 }} bulan tersisa (estimasi)</p>
                </div>
            </div>
        </div>


        <!-- ── Table + Chart ── -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 mt-5 card-hover fade-in-up delay-5" style="transition-delay:0.6s">

            <!-- Transaction Table -->
            <div class="lg:col-span-2 bg-white rounded-xl border border-slate-100 shadow-sm overflow-hidden flex flex-col">
                <div class="px-4 py-3 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-2">
                    <div class="flex items-center gap-2">
                        <div class="h-5 w-1 bg-primary rounded-full"></div>
                        <div>
                            <h3 class="text-xs font-black text-slate-900 leading-none">Aktivitas Terbaru</h3>
                            <p class="text-[10px] text-slate-400 mt-0.5">Transaksi simpanan & pinjaman</p>
                        </div>
                    </div>
                </div>
                <div class="overflow-x-auto flex-1">
                    <table class="w-full text-left">
                        <thead class="bg-slate-50/80">
                            <tr class="text-slate-400 text-[10px] sm:text-xs uppercase tracking-widest">
                                <th class="px-3 py-2 font-black">Tanggal</th>
                                <th class="px-3 py-2 font-black">Aktivitas</th>
                                <th class="px-3 py-2 font-black">Nominal</th>
                                <th class="px-3 py-2 font-black">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            @forelse ($transactions ?? [] as $tx)
                                <tr class="hover:bg-slate-50 transition-colors">
                                    <td class="px-3 py-2 whitespace-nowrap">
                                        <p class="text-[11px] sm:text-xs font-semibold text-slate-800 leading-none">{{ $tx['date'] }}</p>
                                    </td>
                                    <td class="px-3 py-2">
                                        <div class="flex items-center gap-2">
                                            @if($tx['type'] == 'in')
                                                <div class="h-6 w-6 rounded bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0">
                                                    <span class="material-symbols-outlined text-[14px]">arrow_downward</span>
                                                </div>
                                            @else
                                                <div class="h-6 w-6 rounded bg-red-50 text-red-500 flex items-center justify-center shrink-0">
                                                    <span class="material-symbols-outlined text-[14px]">arrow_upward</span>
                                                </div>
                                            @endif
                                            <span class="text-[11px] sm:text-xs font-semibold text-slate-700 whitespace-nowrap">{{ $tx['title'] }}</span>
                                        </div>
                                    </td>
                                    <td class="px-3 py-2 whitespace-nowrap">
                                        <span class="text-[11px] sm:text-xs font-bold {{ $tx['type'] == 'in' ? 'text-emerald-600' : 'text-slate-800' }}">
                                            {{ $tx['type'] == 'in' ? '+' : '' }} Rp {{ number_format($tx['amount'], 0, ',', '.') }}
                                        </span>
                                    </td>
                                    <td class="px-3 py-2">
                                        <span class="px-1.5 py-0.5 {{ $tx['status'] == 'selesai' || $tx['status'] == 'disetujui' ? 'bg-emerald-50 text-emerald-700' : 'bg-slate-100 text-slate-600' }} text-[10px] font-black uppercase rounded-full tracking-wide">
                                            {{ $tx['status'] }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-3 py-8 text-center text-xs text-slate-500">Belum ada aktivitas terbaru.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Chart Panel -->
            <div class="bg-white rounded-xl border border-slate-100 shadow-sm p-4 flex flex-col" id="chart">
                <div class="flex items-start justify-between mb-4">
                    <div>
                        <h4 class="font-black text-xs sm:text-sm text-slate-900 leading-none">Pertumbuhan Simpanan</h4>
                        <p class="text-[10px] sm:text-xs text-slate-400 mt-1">6 Bulan Terakhir</p>
                    </div>
                </div>

                @php
                    $maxVal = collect($chartData ?? [])->max('value');
                    $maxVal = $maxVal > 0 ? $maxVal : 1;
                @endphp

                <div class="flex-grow flex items-end gap-2 h-36">
                    @foreach($chartData ?? [] as $data)
                        @php
                            $height = round(($data['value'] / $maxVal) * 100);
                        @endphp
                        <div class="flex-1 flex flex-col items-center gap-1 relative group cursor-pointer">
                            <div class="opacity-0 group-hover:opacity-100 absolute -top-8 left-1/2 -translate-x-1/2 bg-slate-800 text-white text-[10px] sm:text-xs font-bold px-1.5 py-0.5 rounded-lg whitespace-nowrap z-10 shadow-lg transition-opacity">
                                Rp {{ number_format($data['value'] / 1000, 1) }}k<div class="absolute -bottom-1 left-1/2 -translate-x-1/2 w-1.5 h-1.5 bg-slate-800 rotate-45"></div>
                            </div>
                            <div class="w-full flex items-end h-28">
                                <div class="chart-bar w-full rounded-t-sm bg-primary/20 group-hover:bg-primary transition-all duration-500" data-height="{{ $height }}" style="height:0%"></div>
                            </div>
                            <span class="text-[10px] font-extrabold text-slate-400 uppercase tracking-tighter group-hover:text-primary transition-colors">{{ $data['month'] }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="card-animate mt-5" style="transition-delay:0.7s">
            @include('user.partials.quick_action')
        </div>

    </main>

    {{-- Footer --}}
    @include('user.partials.footer')

    <script src="{{ asset('js/user-dashboard.js') }}"></script>
</div>
</body>
</html>
