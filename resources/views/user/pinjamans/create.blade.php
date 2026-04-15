<!DOCTYPE html>
<html class="light" lang="id">
<head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>Ajukan Pinjaman - Koperasi Ugoro</title>
@include('user.partials.theme_loader')
@include('user.partials.scroll')
</head>
<body class="bg-background-light text-slate-900 min-h-screen">

@include('user.partials.sidebar', ['activePage' => 'pinjaman'])

<div class="min-h-screen transition-all bg-background-light dark:bg-background-dark" id="content-wrapper">

@include('user.partials.topnavbar', ['activePage' => 'pinjaman'])

<!-- Page Content -->
<main class="max-w-[1440px] mx-auto w-full p-4 lg:p-8 space-y-6 pb-12">

    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-6">
        <div>
            <h2 class="text-3xl lg:text-3xl font-extrabold text-slate-900 dark:text-white tracking-tight">Ajukan Pinjaman</h2>
            <p class="text-slate-500 text-sm mt-1">Isi data dengan benar untuk mempercepat proses persetujuan.</p>
        </div>
    </div>

    <div class="max-w-2xl mx-auto space-y-6">
        <div class="p-6 sm:p-8 bg-white dark:bg-slate-900 shadow sm:rounded-2xl border border-slate-200 dark:border-slate-800 border-t-4 border-t-primary">
            
            <form method="POST" action="{{ route('pinjamans.store') }}" class="space-y-6">
                @csrf

                <!-- Jumlah Pinjaman -->
                <div>
                    <x-input-label for="jumlah_pinjaman" :value="__('Jumlah Pinjaman (Rp)')" class="font-bold text-slate-700 dark:text-slate-200" />
                    <div class="mt-2 relative rounded-md shadow-sm">
                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                            <span class="text-slate-500 sm:text-sm">Rp</span>
                        </div>
                        <x-text-input id="jumlah_pinjaman" class="block w-full pl-10 border-slate-300 dark:border-slate-700 dark:bg-slate-800 dark:text-white focus:border-primary focus:ring-primary rounded-lg" type="number" name="jumlah_pinjaman" :value="old('jumlah_pinjaman')" required min="50000" oninput="calculateInstallment()" placeholder="0" />
                    </div>
                    <p class="mt-1 text-sm text-slate-500">Minimal pinjaman Rp 50.000</p>
                    <x-input-error :messages="$errors->get('jumlah_pinjaman')" class="mt-2" />
                </div>

                <!-- Tenor -->
                <div>
                    <x-input-label for="tenor" :value="__('Jangka Waktu (Bulan)')" class="font-bold text-slate-700 dark:text-slate-200" />
                    <div class="mt-2 text-sm text-slate-900 dark:text-white grid grid-cols-2 md:grid-cols-4 gap-4">
                        <!-- Custom Radio Buttons for Tenor -->
                        <label class="cursor-pointer">
                            <input type="radio" name="tenor" value="3" class="peer sr-only" onchange="calculateInstallment()" required>
                            <div class="rounded-lg border border-slate-200 dark:border-slate-700 p-4 hover:bg-slate-50 dark:hover:bg-slate-800 peer-checked:border-primary peer-checked:bg-primary/10 peer-checked:text-primary transition-all text-center">
                                <div class="font-bold">3 Bulan</div>
                            </div>
                        </label>
                        <label class="cursor-pointer">
                            <input type="radio" name="tenor" value="6" class="peer sr-only" onchange="calculateInstallment()">
                            <div class="rounded-lg border border-slate-200 dark:border-slate-700 p-4 hover:bg-slate-50 dark:hover:bg-slate-800 peer-checked:border-primary peer-checked:bg-primary/10 peer-checked:text-primary transition-all text-center">
                                <div class="font-bold">6 Bulan</div>
                            </div>
                        </label>
                        <label class="cursor-pointer">
                            <input type="radio" name="tenor" value="12" class="peer sr-only" onchange="calculateInstallment()">
                            <div class="rounded-lg border border-slate-200 dark:border-slate-700 p-4 hover:bg-slate-50 dark:hover:bg-slate-800 peer-checked:border-primary peer-checked:bg-primary/10 peer-checked:text-primary transition-all text-center">
                                <div class="font-bold">12 Bulan</div>
                            </div>
                        </label>
                        <label class="cursor-pointer">
                            <input type="radio" name="tenor" value="24" class="peer sr-only" onchange="calculateInstallment()">
                            <div class="rounded-lg border border-slate-200 dark:border-slate-700 p-4 hover:bg-slate-50 dark:hover:bg-slate-800 peer-checked:border-primary peer-checked:bg-primary/10 peer-checked:text-primary transition-all text-center">
                                <div class="font-bold">24 Bulan</div>
                            </div>
                        </label>
                    </div>
                    <x-input-error :messages="$errors->get('tenor')" class="mt-2" />
                </div>

                <!-- Estimasi Cicilan -->
                <div class="bg-gradient-to-r from-slate-50 to-slate-100 dark:from-slate-800 dark:to-slate-900 p-6 rounded-xl border border-slate-200 dark:border-slate-700 shadow-inner">
                    <p class="text-sm font-medium text-slate-500 uppercase tracking-wide">Estimasi Cicilan per Bulan</p>
                    <p class="text-3xl font-extrabold text-primary mt-2" id="estimasi_cicilan">Rp 0</p>
                    <p class="text-sm text-slate-400 mt-1">*Belum termasuk biaya administrasi jika ada</p>
                </div>

                <!-- Keterangan -->
                <div>
                    <x-input-label for="keterangan" :value="__('Keterangan Keperluan (Opsional)')" class="font-bold text-slate-700 dark:text-slate-200" />
                    <textarea id="keterangan" name="keterangan" class="block mt-2 w-full rounded-lg border-slate-300 dark:border-slate-700 dark:bg-slate-800 dark:text-white shadow-sm focus:border-primary focus:ring-primary transition duration-200" rows="3" placeholder="Contoh: Renovasi rumah, biaya pendidikan">{{ old('keterangan') }}</textarea>
                    <x-input-error :messages="$errors->get('keterangan')" class="mt-2" />
                </div>

                <div class="flex items-center justify-end pt-4 border-t border-slate-100 dark:border-slate-800">
                    <a href="{{ route('pinjamans.index') }}" class="px-4 py-2 text-sm font-medium text-slate-600 dark:text-slate-300 bg-white dark:bg-slate-800 border border-slate-300 dark:border-slate-700 rounded-lg hover:bg-slate-50 dark:hover:bg-slate-700 mr-3 transition-colors">
                        Batal
                    </a>
                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-primary border border-transparent rounded-lg font-semibold text-sm text-white uppercase tracking-widest hover:bg-green-500 focus:bg-green-500 active:bg-green-600 focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2 transition ease-in-out duration-150">
                        {{ __('Ajukan Sekarang') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</main>

<script>
    function calculateInstallment() {
        let amount = document.getElementById('jumlah_pinjaman').value;
        // Get selected radio button value
        let tenorElement = document.querySelector('input[name="tenor"]:checked');
        let tenor = tenorElement ? tenorElement.value : null;
        
        if (amount && tenor) {
            // Simple calculation: Amount / Tenor
            let installment = Math.ceil(amount / tenor);
            // Valid formatter
            let formatted = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(installment);
            document.getElementById('estimasi_cicilan').innerText = formatted;
        } else {
            document.getElementById('estimasi_cicilan').innerText = 'Rp 0';
        }
    }
</script>

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
