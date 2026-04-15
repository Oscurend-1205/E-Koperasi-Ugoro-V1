<!DOCTYPE html>
<html class="light" lang="id">
<head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<link rel="icon" type="image/png" href="{{ asset('logo.png') }}">
<title>Pinjaman - Koperasi Ugoro</title>
@include('user.partials.theme_loader')
<style>
    .fade-up.visible {
        opacity: 1;
        transform: translateY(0);
    }

    /* Info card hover */
    .info-card {
        transition: box-shadow 0.2s ease, transform 0.2s ease;
    }
    .info-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 12px 32px -8px rgba(19, 236, 91, 0.15), 0 4px 16px -4px rgba(0,0,0,0.08);
    }

    /* Loan summary card accent bar */
    .accent-bar::before {
        content: '';
        position: absolute;
        left: 0;
        top: 0;
        bottom: 0;
        width: 4px;
        border-radius: 4px 0 0 4px;
        background: linear-gradient(180deg, #13ec5b, #0ec44c);
    }

    /* Subtle animated gradient for summary header */
    .summary-gradient {
        background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 60%, #f0fdf4 100%);
        background-size: 200% 200%;
        animation: gradientShift 6s ease infinite;
    }
    @keyframes gradientShift {
        0%   { background-position: 0% 50%; }
        50%  { background-position: 100% 50%; }
        100% { background-position: 0% 50%; }
    }

    /* Dark mode variants */
    .dark .summary-gradient {
        background: linear-gradient(135deg, #14352014 0%, #1a4a2620 60%, #14352014 100%);
    }
    .dark .info-card:hover {
        box-shadow: 0 12px 32px -8px rgba(19, 236, 91, 0.10), 0 4px 16px -4px rgba(0,0,0,0.3);
    }
</style>
@include('user.partials.scroll')
</head>
<body class="bg-slate-100 dark:bg-background-dark text-slate-900 dark:text-white min-h-screen">

@include('user.partials.sidebar', ['activePage' => 'pinjaman'])

<div class="min-h-screen transition-all bg-background-light dark:bg-background-dark" id="content-wrapper">

    @include('user.partials.topnavbar', ['activePage' => 'pinjaman'])

    <!-- Page Content -->
    <main class="max-w-[1600px] mx-auto w-full p-5 lg:px-10 pt-3 pb-10 space-y-8">

        <!-- Page Header -->
        <div class="fade-up flex flex-col sm:flex-row sm:items-center justify-between gap-3" style="transition-delay: 0s">
            <div>
                <h2 class="text-2xl font-extrabold text-slate-900 dark:text-white tracking-tight">Data Pinjaman</h2>
                <p class="text-slate-500 dark:text-slate-400 text-sm mt-1">Informasi detail pinjaman aktif Anda.</p>
            </div>
            <a href="{{ route('pinjamans.create') }}"
               class="inline-flex items-center gap-2 px-4 py-2 bg-primary text-white font-bold rounded-xl shadow-lg shadow-primary/20 hover:bg-primary-dark hover:shadow-xl hover:-translate-y-0.5 transition-all duration-200 text-sm">
                <span class="material-symbols-outlined text-[16px]">add</span>
                Ajukan Pinjaman
            </a>
        </div>

        {{-- Flash Message --}}
        @if(session('success'))
            <div class="fade-up bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 text-green-700 dark:text-green-400 p-4 rounded-2xl flex items-center gap-3 shadow-sm" role="alert" style="transition-delay:0.05s">
                <span class="material-symbols-outlined text-primary text-[22px]">check_circle</span>
                <span class="text-sm font-medium">{{ session('success') }}</span>
            </div>
        @endif


        {{-- ─── MAIN CONTENT ─── --}}
        @if(isset($pinjaman) && $pinjaman)

            {{-- ── Summary Card (full-width hero) ── --}}
            <div class="fade-up relative bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-sm overflow-hidden accent-bar" style="transition-delay:0.12s">

                {{-- Top accent header --}}
                <div class="summary-gradient dark:bg-slate-800/30 px-5 py-4 flex flex-col sm:flex-row sm:items-center justify-between gap-3 border-b border-slate-100 dark:border-slate-800">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-xl bg-primary/10 flex items-center justify-center">
                            <span class="material-symbols-outlined text-primary text-[18px]">account_balance</span>
                        </div>
                        <div>
                            <p class="text-[10px] text-slate-500 dark:text-slate-400 font-medium uppercase tracking-wider">Status Pinjaman</p>
                            <p class="text-sm font-bold text-slate-800 dark:text-white">
                                @php
                                    $statusLabel = match($pinjaman->status ?? 'aktif') {
                                        'aktif'     => 'Aktif',
                                        'lunas'     => 'Lunas',
                                        'pending'   => 'Menunggu',
                                        'ditolak'   => 'Ditolak',
                                        default     => ucfirst($pinjaman->status ?? 'Aktif'),
                                    };
                                    $statusClass = match($pinjaman->status ?? 'aktif') {
                                        'aktif'   => 'bg-green-100 text-green-700 dark:bg-green-900/40 dark:text-green-400',
                                        'lunas'   => 'bg-blue-100 text-blue-700 dark:bg-blue-900/40 dark:text-blue-400',
                                        'pending' => 'bg-yellow-100 text-yellow-700 dark:bg-yellow-900/40 dark:text-yellow-400',
                                        'ditolak' => 'bg-red-100 text-red-700 dark:bg-red-900/40 dark:text-red-400',
                                        default   => 'bg-slate-100 text-slate-700',
                                    };
                                @endphp
                                <span class="px-2.5 py-0.5 rounded-full text-xs font-bold {{ $statusClass }}">{{ $statusLabel }}</span>
                            </p>
                        </div>
                    </div>
                    <div class="text-right hidden sm:block">
                        <p class="text-xs text-slate-500 dark:text-slate-400">Tanggal Pengajuan</p>
                        <p class="text-sm font-semibold text-slate-700 dark:text-slate-300">
                            {{ isset($pinjaman->tanggal_pengajuan) ? \Carbon\Carbon::parse($pinjaman->tanggal_pengajuan)->format('d M Y') : '-' }}
                        </p>
                    </div>
                </div>

                {{-- Grid Info Cards --}}
                <div class="p-5">
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3">

                        {{-- 1. Nilai Pinjaman --}}
                        <div class="info-card bg-slate-50 dark:bg-slate-800/50 rounded-xl p-4 border border-slate-100 dark:border-slate-700/60 cursor-default">
                            <div class="flex items-center gap-2 mb-2">
                                <div class="w-7 h-7 rounded-lg bg-primary/10 flex items-center justify-center flex-shrink-0">
                                    <span class="material-symbols-outlined text-primary text-[15px]">payments</span>
                                </div>
                                <p class="text-[10px] font-semibold text-slate-400 uppercase tracking-wider">Nilai Pinjaman</p>
                            </div>
                            <p class="text-xl font-extrabold text-slate-900 dark:text-white leading-none">
                                Rp {{ number_format($pinjaman->jumlah ?? $pinjaman->jumlah_pinjaman ?? 0, 0, ',', '.') }}
                            </p>
                        </div>

                        {{-- 2. Jangka Waktu --}}
                        <div class="info-card bg-slate-50 dark:bg-slate-800/50 rounded-xl p-4 border border-slate-100 dark:border-slate-700/60 cursor-default">
                            <div class="flex items-center gap-2 mb-2">
                                <div class="w-7 h-7 rounded-lg bg-blue-50 dark:bg-blue-900/30 flex items-center justify-center flex-shrink-0">
                                    <span class="material-symbols-outlined text-blue-500 text-[15px]">calendar_month</span>
                                </div>
                                <p class="text-[10px] font-semibold text-slate-400 uppercase tracking-wider">Jangka Waktu</p>
                            </div>
                            <p class="text-xl font-extrabold text-slate-900 dark:text-white leading-none">
                                {{ $pinjaman->tenor ?? '-' }}
                                <span class="text-sm font-semibold text-slate-500">Bulan</span>
                            </p>
                        </div>

                        {{-- 3. Angsuran per Bulan --}}
                        <div class="info-card bg-slate-50 dark:bg-slate-800/50 rounded-xl p-4 border border-slate-100 dark:border-slate-700/60 cursor-default">
                            <div class="flex items-center gap-2 mb-2">
                                <div class="w-7 h-7 rounded-lg bg-orange-50 dark:bg-orange-900/30 flex items-center justify-center flex-shrink-0">
                                    <span class="material-symbols-outlined text-orange-500 text-[15px]">event_repeat</span>
                                </div>
                                <p class="text-[10px] font-semibold text-slate-400 uppercase tracking-wider">Angsuran / Bulan</p>
                            </div>
                            <p class="text-xl font-extrabold text-slate-900 dark:text-white leading-none">
                                Rp {{ number_format($pinjaman->angsuran ?? 0, 0, ',', '.') }}
                            </p>
                        </div>

                        {{-- 4. Sisa Pokok Pinjaman --}}
                        <div class="info-card relative bg-gradient-to-br from-primary/10 to-primary/5 dark:from-primary/10 dark:to-transparent rounded-xl p-4 border border-primary/20 dark:border-primary/20 cursor-default">
                            <div class="flex items-center gap-2 mb-2">
                                <div class="w-7 h-7 rounded-lg bg-primary/15 flex items-center justify-center flex-shrink-0">
                                    <span class="material-symbols-outlined text-primary text-[15px]">account_balance_wallet</span>
                                </div>
                                <p class="text-[10px] font-semibold text-slate-400 uppercase tracking-wider">Sisa Pokok</p>
                            </div>
                            <p class="text-xl font-extrabold text-primary leading-none">
                                Rp {{ number_format($pinjaman->sisa_pokok ?? 0, 0, ',', '.') }}
                            </p>
                        </div>

                    </div>
                </div>

                {{-- Progress bar (sisa vs total) --}}
                @php
                    $total = $pinjaman->jumlah ?? $pinjaman->jumlah_pinjaman ?? 1;
                    $sisa  = $pinjaman->sisa_pokok ?? 0;
                    $lunas = max(0, $total - $sisa);
                    $pct   = $total > 0 ? round(($lunas / $total) * 100) : 0;
                @endphp
                <div class="px-5 pb-5">
                    <div class="bg-slate-50 dark:bg-slate-800/40 rounded-xl p-3 border border-slate-100 dark:border-slate-700/50">
                        <div class="flex items-center justify-between mb-2">
                            <p class="text-xs font-semibold text-slate-500 dark:text-slate-400">Progres Pelunasan</p>
                            <p class="text-xs font-bold text-primary">{{ $pct }}% Terlunasi</p>
                        </div>
                        <div class="w-full bg-slate-200 dark:bg-slate-700 rounded-full h-2.5 overflow-hidden">
                            <div class="h-2.5 rounded-full bg-gradient-to-r from-primary to-primary-dark transition-all duration-700"
                                 style="width: <?php echo $pct; ?>%;"></div>
                        </div>
                        <div class="flex justify-between mt-2">
                            <p class="text-xs text-slate-400">
                                Terlunasi: <span class="font-semibold text-slate-600 dark:text-slate-300">Rp {{ number_format($lunas, 0, ',', '.') }}</span>
                            </p>
                            <p class="text-xs text-slate-400">
                                Sisa: <span class="font-semibold text-primary">Rp {{ number_format($sisa, 0, ',', '.') }}</span>
                            </p>
                        </div>
                    </div>
                </div>

            </div>

        @else

            {{-- ── Empty State ── --}}
            <div class="fade-up bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-sm" style="transition-delay:0.12s">
                <div class="flex flex-col items-center justify-center py-16 px-6 text-center">
                    <div class="w-16 h-16 rounded-2xl bg-slate-100 dark:bg-slate-800 flex items-center justify-center mb-4">
                        <span class="material-symbols-outlined text-[32px] text-slate-300 dark:text-slate-600">account_balance_wallet</span>
                    </div>
                    <h3 class="text-base font-bold text-slate-700 dark:text-slate-300 mb-1">Belum ada data pinjaman</h3>
                    <p class="text-[11px] sm:text-xs text-slate-400 max-w-xs">
                        Anda belum memiliki pinjaman aktif. Ajukan pinjaman untuk memulai.
                    </p>
                    <a href="{{ route('pinjamans.create') }}"
                       class="mt-5 inline-flex items-center gap-2 px-4 py-2 bg-primary text-white font-bold rounded-xl shadow-lg shadow-primary/20 hover:bg-primary-dark hover:-translate-y-0.5 transition-all duration-200 text-xs">
                        <span class="material-symbols-outlined text-[16px]">add</span>
                        Ajukan Sekarang
                    </a>
                </div>
            </div>

        @endif

        {{-- ── Riwayat Pinjaman (bonus section) ── --}}
        @if(isset($pinjamans) && $pinjamans->count() > 0)
        <div class="fade-up" style="transition-delay:0.18s">
            <h3 class="text-xs font-bold text-slate-700 dark:text-slate-300 mb-3 flex items-center gap-2">
                <span class="material-symbols-outlined text-[18px] text-slate-400">history</span>
                Riwayat Pengajuan
            </h3>
            <div class="fade-up bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-sm overflow-hidden" style="transition-delay:0.18s">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-100 dark:divide-slate-800">
                        <thead class="bg-slate-50/80 dark:bg-slate-800/50">
                            <tr class="text-slate-400 text-[10px] sm:text-xs uppercase tracking-widest">
                                <th class="px-5 py-3 text-left font-black">Tanggal</th>
                                <th class="px-5 py-3 text-left font-black">Nilai Pinjaman</th>
                                <th class="px-5 py-3 text-left font-black">Bunga</th>
                                <th class="px-5 py-3 text-left font-black">Tenor</th>
                                <th class="px-5 py-3 text-left font-black">Status</th>
                                <th class="px-5 py-3 text-left font-black">Keterangan</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                            @foreach ($pinjamans as $item)
                                <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/30 transition-colors">
                                    <td class="px-5 py-3 whitespace-nowrap text-xs text-slate-500 dark:text-slate-400 font-medium">
                                        {{ \Carbon\Carbon::parse($item->tanggal_pengajuan)->format('d M Y') }}
                                    </td>
                                    <td class="px-5 py-3 whitespace-nowrap text-sm font-bold text-slate-800 dark:text-white">
                                        Rp {{ number_format($item->jumlah_pinjaman, 0, ',', '.') }}
                                    </td>
                                    <td class="px-5 py-3 whitespace-nowrap text-xs text-slate-600 dark:text-slate-300">
                                        {{ floatval($item->bunga ?? 0) }}%
                                    </td>
                                    <td class="px-5 py-3 whitespace-nowrap text-xs text-slate-600 dark:text-slate-300">
                                        {{ $item->tenor }} Bulan
                                    </td>
                                    <td class="px-5 py-3 whitespace-nowrap">
                                        @php
                                            $sCls = match($item->status) {
                                                'pending'   => 'bg-yellow-100 text-yellow-700 dark:bg-yellow-900/30 dark:text-yellow-400',
                                                'disetujui' => 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400',
                                                'ditolak'   => 'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400',
                                                default     => 'bg-slate-100 text-slate-600',
                                            };
                                        @endphp
                                        <span class="px-2 py-0.5 inline-flex text-[10px] sm:text-xs font-bold rounded-full {{ $sCls }}">
                                            {{ ucfirst($item->status) }}
                                        </span>
                                    </td>
                                    <td class="px-5 py-3 whitespace-nowrap text-xs text-slate-400 dark:text-slate-500">
                                        {{ \Illuminate\Support\Str::limit($item->keterangan ?? '-', 30) }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @endif

        <!-- Informasi & Pengumuman (di bawah) -->
        <div class="fade-up" style="transition-delay: 0.24s">
            @include('user.partials.quick_action')
        </div>

    </main>

    {{-- Footer --}}
    @include('user.partials.footer')

</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.08 });
        document.querySelectorAll('.fade-up').forEach(el => observer.observe(el));
    });
</script>
</body>
</html>
