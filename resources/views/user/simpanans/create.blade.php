<!DOCTYPE html>
<html class="light" lang="id">
<head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>Tambah Simpanan - Koperasi Ugoro</title>
@include('user.partials.theme_loader')
@include('user.partials.scroll')
</head>
<body class="bg-background-light text-slate-900 min-h-screen">

@include('user.partials.sidebar', ['activePage' => 'simpanan'])

<div class="min-h-screen transition-all bg-background-light dark:bg-background-dark" id="content-wrapper">

@include('user.partials.topnavbar', ['activePage' => 'simpanan'])

<!-- Page Content -->
<main class="max-w-[1440px] mx-auto w-full p-4 lg:p-8 space-y-6 pb-12">

    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-6">
        <div>
            <h2 class="text-3xl lg:text-3xl font-extrabold text-slate-900 dark:text-white tracking-tight">Tambah Simpanan</h2>
            <p class="text-slate-500 text-sm mt-1">Silakan isi detail simpanan baru.</p>
        </div>
    </div>

    <div class="max-w-2xl mx-auto space-y-6">
        <div class="p-6 sm:p-8 bg-white dark:bg-slate-900 shadow sm:rounded-2xl border border-slate-200 dark:border-slate-800 border-t-4 border-t-primary">
            
            <form method="POST" action="{{ route('simpanans.store') }}" class="space-y-6">
                @csrf

                <!-- Jenis Simpanan -->
                <div>
                    <x-input-label for="jenis_simpanan" :value="__('Jenis Simpanan')" class="font-bold text-slate-700 dark:text-slate-200" />
                    <div class="mt-2 relative">
                        <select id="jenis_simpanan" name="jenis_simpanan" class="block w-full rounded-lg border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 dark:text-white shadow-sm focus:border-primary focus:ring-primary transition duration-200" required>
                            <option value="Pokok">Simpanan Pokok</option>
                            <option value="Wajib">Simpanan Wajib</option>
                            <option value="Sukarela">Simpanan Sukarela</option>
                        </select>
                    </div>
                    <x-input-error :messages="$errors->get('jenis_simpanan')" class="mt-2" />
                </div>

                <!-- Jumlah -->
                <div>
                    <x-input-label for="jumlah" :value="__('Jumlah Setoran')" class="font-bold text-slate-700 dark:text-slate-200" />
                    <div class="mt-2 relative rounded-md shadow-sm">
                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                            <span class="text-slate-500 sm:text-sm">Rp</span>
                        </div>
                        <x-text-input id="jumlah" class="block w-full pl-10 border-slate-300 dark:border-slate-700 dark:bg-slate-800 dark:text-white focus:border-primary focus:ring-primary rounded-lg" type="number" name="jumlah" :value="old('jumlah')" required min="1000" placeholder="0" />
                    </div>
                    <p class="mt-1 text-sm text-slate-500">Minimal setoran Rp 1.000</p>
                    <x-input-error :messages="$errors->get('jumlah')" class="mt-2" />
                </div>

                <!-- Keterangan -->
                <div>
                    <x-input-label for="keterangan" :value="__('Keterangan (Opsional)')" class="font-bold text-slate-700 dark:text-slate-200" />
                    <textarea id="keterangan" name="keterangan" class="block mt-2 w-full rounded-lg border-slate-300 dark:border-slate-700 dark:bg-slate-800 dark:text-white shadow-sm focus:border-primary focus:ring-primary transition duration-200" rows="3" placeholder="Contoh: Setoran bulan Desember">{{ old('keterangan') }}</textarea>
                    <x-input-error :messages="$errors->get('keterangan')" class="mt-2" />
                </div>

                <div class="flex items-center justify-end pt-4 border-t border-slate-100 dark:border-slate-800">
                    <a href="{{ route('simpanans.index') }}" class="px-4 py-2 text-sm font-medium text-slate-600 dark:text-slate-300 bg-white dark:bg-slate-800 border border-slate-300 dark:border-slate-700 rounded-lg hover:bg-slate-50 dark:hover:bg-slate-700 mr-3 transition-colors">
                        Batal
                    </a>
                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-primary border border-transparent rounded-lg font-semibold text-sm text-white uppercase tracking-widest hover:bg-green-500 focus:bg-green-500 active:bg-green-600 focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2 transition ease-in-out duration-150">
                        {{ __('Simpan Transaksi') }}
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
