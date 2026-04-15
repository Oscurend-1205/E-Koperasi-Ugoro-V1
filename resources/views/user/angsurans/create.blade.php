<!DOCTYPE html>
<html class="light" lang="id">
<head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>Bayar Angsuran - Koperasi Ugoro</title>
@include('user.partials.theme_loader')
@include('user.partials.scroll')
</head>
<body class="bg-background-light text-slate-900 min-h-screen">

@include('user.partials.sidebar', ['activePage' => 'transaksi'])

<div class="min-h-screen transition-all bg-background-light dark:bg-background-dark" id="content-wrapper">

@include('user.partials.topnavbar', ['activePage' => 'transaksi'])

<!-- Page Content -->
<main class="max-w-[1440px] mx-auto w-full p-4 lg:p-8 space-y-6 pb-12">

    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-6">
        <div>
            <h2 class="text-3xl lg:text-3xl font-extrabold text-slate-900 dark:text-white tracking-tight">Bayar Angsuran</h2>
            <p class="text-slate-500 text-sm mt-1">Pilih pinjaman dan masukkan jumlah pembayaran.</p>
        </div>
    </div>

    <div class="max-w-2xl mx-auto space-y-6">
        <div class="p-6 sm:p-8 bg-white dark:bg-slate-900 shadow sm:rounded-2xl border border-slate-200 dark:border-slate-800 border-t-4 border-t-secondary">
            
            <form method="POST" action="{{ route('angsurans.store') }}" class="space-y-6">
                @csrf

                <!-- Pilih Pinjaman -->
                <div>
                    <x-input-label for="pinjaman_id" :value="__('Pilih Pinjaman')" class="font-bold text-slate-700 dark:text-slate-200" />
                    <div class="mt-2 relative">
                        <select id="pinjaman_id" name="pinjaman_id" class="block w-full rounded-lg border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 dark:text-white shadow-sm focus:border-secondary focus:ring-secondary transition duration-200" required>
                            <option value="">-- Pilih Pinjaman --</option>
                            @foreach($pinjamans as $loan)
                                <option value="{{ $loan->id }}" {{ (isset($selectedPinjamanId) && $selectedPinjamanId == $loan->id) ? 'selected' : '' }}>
                                    Pinjaman #{{ $loan->id }} - Sisa: Rp {{ number_format($loan->jumlah_pinjaman, 0, ',', '.') }} ({{ $loan->tenor }} Bln)
                                </option>
                            @endforeach
                        </select>
                        @if($pinjamans->isEmpty())
                            <p class="text-sm text-red-500 mt-2 flex items-center">
                                <span class="material-symbols-outlined text-[16px] mr-1">warning</span>
                                Anda tidak memiliki pinjaman aktif yang disetujui.
                            </p>
                        @endif
                    </div>
                    <x-input-error :messages="$errors->get('pinjaman_id')" class="mt-2" />
                </div>

                <!-- Angsuran Ke -->
                <div>
                    <x-input-label for="angsuran_ke" :value="__('Angsuran Ke-')" class="font-bold text-slate-700 dark:text-slate-200" />
                    <div class="mt-2 relative rounded-md shadow-sm w-1/3">
                        <x-text-input id="angsuran_ke" class="block w-full border-slate-300 dark:border-slate-700 dark:bg-slate-800 dark:text-white focus:border-secondary focus:ring-secondary rounded-lg" type="number" name="angsuran_ke" :value="old('angsuran_ke')" required min="1" placeholder="1" />
                    </div>
                    <x-input-error :messages="$errors->get('angsuran_ke')" class="mt-2" />
                </div>

                <!-- Jumlah Bayar -->
                <div>
                    <x-input-label for="jumlah_bayar" :value="__('Jumlah Pembayaran (Rp)')" class="font-bold text-slate-700 dark:text-slate-200" />
                    <div class="mt-2 relative rounded-md shadow-sm">
                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                            <span class="text-slate-500 sm:text-sm">Rp</span>
                        </div>
                        <x-text-input id="jumlah_bayar" class="block w-full pl-10 border-slate-300 dark:border-slate-700 dark:bg-slate-800 dark:text-white focus:border-secondary focus:ring-secondary rounded-lg" type="number" name="jumlah_bayar" :value="old('jumlah_bayar')" required min="1000" placeholder="0" />
                    </div>
                    <x-input-error :messages="$errors->get('jumlah_bayar')" class="mt-2" />
                </div>

                <div class="flex items-center justify-end pt-4 border-t border-slate-100 dark:border-slate-800">
                    <a href="{{ route('angsurans.index') }}" class="px-4 py-2 text-sm font-medium text-slate-600 dark:text-slate-300 bg-white dark:bg-slate-800 border border-slate-300 dark:border-slate-700 rounded-lg hover:bg-slate-50 dark:hover:bg-slate-700 mr-3 transition-colors">
                        Batal
                    </a>
                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-secondary border border-transparent rounded-lg font-semibold text-sm text-white uppercase tracking-widest hover:bg-orange-600 focus:bg-orange-600 active:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-secondary focus:ring-offset-2 transition ease-in-out duration-150">
                        {{ __('Bayar Sekarang') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</main>

</div>
<script>
    function toggleSidebar() {
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebarOverlay');
        sidebar.classList.toggle('-translate-x-full');
        overlay.classList.toggle('hidden');
    }
</script>
</body>
</html>
