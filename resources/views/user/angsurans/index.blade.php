<!DOCTYPE html>
<html class="light" lang="id">
<head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<link rel="icon" type="image/png" href="{{ asset('logo.png') }}">
<title>Transaksi - Koperasi Ugoro</title>
@include('user.partials.theme_loader')
@include('user.partials.scroll')
</head>
<body class="bg-background-light text-slate-900 min-h-screen">

@include('user.partials.sidebar', ['activePage' => 'transaksi'])

<div class="min-h-screen transition-all bg-background-light dark:bg-background-dark" id="content-wrapper">

@include('user.partials.topnavbar', ['activePage' => 'transaksi'])

<!-- Page Content -->
<main class="max-w-[1600px] mx-auto w-full p-6 lg:px-10 pt-3 pb-10 space-y-8">

    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
        <div>
            <h2 class="text-2xl lg:text-2xl font-extrabold text-slate-900 dark:text-white tracking-tight">Riwayat Angsuran</h2>
            <p class="text-slate-500 text-sm mt-1">Pantau riwayat pembayaran angsuran Anda.</p>
        </div>
        <a href="{{ route('angsurans.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-secondary text-white font-bold rounded-xl shadow-lg shadow-secondary/20 hover:shadow-xl hover:-translate-y-0.5 transition-all duration-200">
            <span class="material-symbols-outlined text-[18px]">payments</span>
            Bayar Angsuran
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-50 border-l-4 border-primary text-green-700 p-4 rounded-r shadow-sm flex items-center" role="alert">
            <span class="material-symbols-outlined mr-3 text-primary">check_circle</span>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <!-- Table Card -->
    <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200 dark:divide-slate-800">
                <thead class="bg-slate-50/80 dark:bg-slate-800/50">
                    <tr class="text-slate-400 text-[10px] sm:text-xs uppercase tracking-widest">
                        <th class="px-5 py-3 text-left font-black">Tanggal Bayar</th>
                        <th class="px-5 py-3 text-left font-black">Pinjaman (ID)</th>
                        <th class="px-5 py-3 text-left font-black">Angsuran Ke-</th>
                        <th class="px-5 py-3 text-left font-black">Jumlah Bayar</th>
                        <th class="px-5 py-3 text-left font-black">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                    @forelse ($angsurans as $angsuran)
                        <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/30 transition-colors">
                            <td class="px-5 py-3 whitespace-nowrap text-sm text-slate-600 font-medium">
                                {{ \Carbon\Carbon::parse($angsuran->tanggal_bayar)->format('d M Y') }}
                            </td>
                            <td class="px-5 py-3 whitespace-nowrap text-sm text-slate-900">
                                <span class="font-mono text-xs bg-slate-100 dark:bg-slate-800 px-2 py-1 rounded">#{{ $angsuran->pinjaman_id }}</span>
                                <span class="text-slate-500 text-xs ml-1">({{ \Illuminate\Support\Str::limit($angsuran->pinjaman->keterangan ?? 'Utama', 15) }})</span>
                            </td>
                            <td class="px-5 py-3 whitespace-nowrap text-sm text-slate-900 font-semibold">
                                {{ $angsuran->angsuran_ke }}
                            </td>
                            <td class="px-5 py-3 whitespace-nowrap text-sm font-bold text-slate-800 dark:text-white">
                                Rp {{ number_format($angsuran->jumlah_bayar, 0, ',', '.') }}
                            </td>
                            <td class="px-5 py-3 whitespace-nowrap text-sm">
                                <span class="px-2.5 py-1 inline-flex text-xs leading-5 font-bold rounded-full bg-green-100 text-green-700">
                                    {{ ucfirst($angsuran->status) }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-16 text-center">
                                <div class="flex flex-col items-center justify-center text-slate-400">
                                    <span class="material-symbols-outlined text-[48px] mb-3">receipt_long</span>
                                    <p class="font-semibold text-slate-600">Belum ada data angsuran.</p>
                                    <p class="text-sm mt-1">Lakukan pembayaran tepat waktu.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
        <!-- Informasi & Pengumuman -->
        <div class="fade-up" style="transition-delay: 0.1s">
            @include('user.partials.quick_action')
        </div>

    </main>
{{-- Footer --}}
@include('user.partials.footer')



<script>
</script>
</body>
</html>
