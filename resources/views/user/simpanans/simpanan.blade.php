<!DOCTYPE html>
<html class="light" lang="id">
<head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<link rel="icon" type="image/png" href="{{ asset('logo.png') }}">
<title>Simpanan Anggota - Koperasi Ugoro</title>
@include('user.partials.theme_loader')
  <style>
  .bar-item { height: 0%; transition: height 0.8s cubic-bezier(0.4,0,0.2,1); }
  .bar-hover { transition: background 0.2s, transform 0.2s; }
  .bar-hover:hover { transform: scaleX(1.05); filter: brightness(1.1); }

  .card-animate { opacity: 0; transform: translateY(12px); transition: opacity 0.45s ease, transform 0.45s ease; }
  .card-animate.visible { opacity: 1; transform: translateY(0); }

  .ripple-btn { position: relative; overflow: hidden; }
  .ripple-btn::after {
    content: ''; position: absolute; inset: 0;
    background: radial-gradient(circle, rgba(255,255,255,0.35) 0%, transparent 70%);
    opacity: 0; transition: opacity 0.4s;
  }
  .ripple-btn:active::after { opacity: 1; transition: opacity 0s; }

  .progress-bar { width: 0%; transition: width 1.1s cubic-bezier(0.4,0,0.2,1); }

  @keyframes ping-custom {
    0% { transform: scale(1); opacity: 0.75; }
    75%, 100% { transform: scale(2); opacity: 0; }
  }
  .ping-dot::before {
    content: ''; position: absolute; inset: 0; border-radius: 9999px;
    background: #16a34a; animation: ping-custom 1.5s cubic-bezier(0,0,0.2,1) infinite;
  }

  @keyframes fadeSlideIn {
    from { opacity: 0; transform: translateY(8px); }
    to   { opacity: 1; transform: translateY(0); }
  }
  @keyframes rippleAnim { to { transform: scale(2.5); opacity: 0; } }

  .hover-lift { transition: box-shadow 0.2s, transform 0.2s; }
  .hover-lift:hover { box-shadow: 0 6px 20px -4px rgba(19,236,91,0.18); transform: translateY(-1px); }

  .bar-tooltip { opacity: 0; transform: translateY(4px); transition: all 0.2s ease; pointer-events: none; }
  .group\/bar:hover .bar-tooltip { opacity: 1; transform: translateY(0); }

  /* Redundant material styles removed as they are now in theme_loader */
</style>
  @include('user.partials.scroll')
</head>
<body class="bg-background-light text-slate-900 min-h-screen">

@include('user.partials.sidebar', ['activePage' => 'simpanan'])

<div class="min-h-screen transition-all bg-background-light" id="content-wrapper">
    @include('user.partials.topnavbar', ['activePage' => 'simpanan'])

    <!-- Main Content -->
    <main class="max-w-[1600px] mx-auto w-full px-6 lg:px-10 pt-3 pb-10 space-y-8">

    <!-- ── Page Header ── -->
    <div class="card-animate flex flex-col sm:flex-row sm:items-center justify-between gap-2">
      <div>
        <p></p>
        <h2 class="text-2xl font-extrabold text-slate-900 dark:text-white tracking-tight">Data Simpanan</h2>
        <p class="text-xs text-slate-400 mt-1">Ringkasan dan riwayat simpanan Anda</p>
      </div>
      <div class="flex items-center gap-2 flex-wrap">
        <div class="flex items-center gap-2 text-xs font-semibold text-slate-600 bg-white border border-slate-200 rounded-lg px-2.5 py-1 shadow-sm">
          <span class="material-symbols-outlined text-emerald-500" style="font-size:16px">badge</span>
          KOP-12345
          <span class="text-slate-300">·</span>
          <span class="relative inline-flex items-center gap-1.5">
            <span class="ping-dot relative h-1.5 w-1.5 rounded-full bg-green-600 inline-block"></span>
            <span class="text-green-600 font-bold">Aktif</span>
          </span>
        </div>
        <div class="hidden sm:flex items-center gap-1.5 text-[10px] font-semibold text-slate-400 bg-white border border-slate-100 rounded-lg px-2.5 py-1 shadow-sm">
          <span class="material-symbols-outlined text-slate-400" style="font-size:14px">update</span>
          Update: Hari Ini
        </div>
      </div>
    </div>

    <!-- ── Info Banner ── -->
    <div class="card-animate flex items-start gap-2 bg-emerald-50 border border-primary/20 rounded-xl px-3 py-2.5" style="transition-delay:0.05s">
      <span class="material-symbols-outlined text-emerald-500 shrink-0 mt-0.5" style="font-size:20px">info</span>
      <p class="text-[11px] sm:text-xs text-emerald-900 leading-relaxed">
        Halaman ini menampilkan seluruh jenis simpanan yang Anda miliki di Koperasi Ugoro, meliputi simpanan
        <strong>Pokok, Wajib, Monosuko, DPU,</strong> dan <strong>Sukarela</strong>.
        Jika ada pertanyaan mengenai saldo, hubungi petugas koperasi.
      </p>
    </div>

    <!-- ── Summary Cards ── -->
    <div class="grid grid-cols-2 sm:grid-cols-3 xl:grid-cols-6 gap-3">

      <!-- Total Simpanan -->
      <div class="card-animate col-span-2 sm:col-span-3 xl:col-span-2 relative overflow-hidden rounded-xl bg-gradient-to-br from-primary to-emerald-400 p-3 shadow-md shadow-primary/20 text-white flex flex-col justify-between min-h-[96px]" style="transition-delay:0.1s">
        <div class="absolute -top-4 -right-4 h-20 w-20 rounded-full bg-white/10"></div>
        <div class="absolute -bottom-5 -left-2 h-16 w-16 rounded-full bg-black/10"></div>
        <div class="relative z-10 flex items-center gap-2 mb-2">
          <div class="h-8 w-8 bg-white/25 rounded-lg flex items-center justify-center border border-white/20">
            <span class="material-symbols-outlined fill-icon text-white" style="font-size:20px">account_balance_wallet</span>
          </div>
          <span class="text-xs font-bold bg-white/20 px-2 py-0.5 rounded border border-white/10 uppercase tracking-wider">Total Simpanan</span>
        </div>
        <div class="relative z-10">
          <p class="text-xl sm:text-2xl font-extrabold tracking-tight leading-none">Rp {{ number_format($totalSimpanan ?? 0, 0, ',', '.') }}</p>
          <p class="text-sm mt-1 text-white/70 font-semibold">{{ isset($simpanans) ? $simpanans->unique('jenis_simpanan')->count() : 0 }} jenis simpanan aktif</p>
        </div>
      </div>

      <!-- Pokok -->
      <div class="card-animate bg-white rounded-xl p-3 border border-slate-100 shadow-sm hover-lift group" style="transition-delay:0.13s">
        <div class="flex items-center gap-2 mb-2">
          <div class="h-8 w-8 bg-emerald-50 text-emerald-600 rounded-lg flex items-center justify-center shrink-0 group-hover:scale-105 transition-transform">
            <span class="material-symbols-outlined" style="font-size:18px">database</span>
          </div>
          <p class="text-xs font-bold uppercase tracking-wider text-slate-400 leading-tight">Pokok</p>
        </div>
        <p class="text-base font-extrabold text-slate-900 leading-none">Rp {{ number_format($totalPokok ?? 0, 0, ',', '.') }}</p>
        <div class="mt-2 h-1 bg-slate-100 rounded-full overflow-hidden">
          <div class="progress-bar h-full bg-primary rounded-full" data-width="{{ $persenPokok }}"></div>
        </div>
        <p class="text-[10px] text-slate-400 mt-1 font-semibold">{{ $persenPokok }}% tersimpan</p>
      </div>

      <!-- Wajib -->
      <div class="card-animate bg-white rounded-xl p-3 border border-slate-100 shadow-sm hover-lift group" style="transition-delay:0.16s">
        <div class="flex items-center gap-2 mb-2">
          <div class="h-8 w-8 bg-emerald-50 text-emerald-600 rounded-lg flex items-center justify-center shrink-0 group-hover:scale-105 transition-transform">
            <span class="material-symbols-outlined" style="font-size:18px">event_repeat</span>
          </div>
          <p class="text-xs font-bold uppercase tracking-wider text-slate-400 leading-tight">Wajib</p>
        </div>
        <p class="text-base font-extrabold text-slate-900 leading-none">Rp {{ number_format($totalWajib ?? 0, 0, ',', '.') }}</p>
        <div class="mt-2 h-1 bg-slate-100 rounded-full overflow-hidden">
          <div class="progress-bar h-full bg-primary rounded-full" data-width="{{ $persenWajib }}"></div>
        </div>
        <p class="text-[10px] text-slate-400 mt-1 font-semibold">{{ $persenWajib }}% dari target rutin</p>
      </div>

      <!-- Monosuko -->
      <div class="card-animate bg-white rounded-xl p-3 border border-slate-100 shadow-sm hover-lift group" style="transition-delay:0.19s">
        <div class="flex items-center gap-2 mb-2">
          <div class="h-8 w-8 bg-orange-50 text-secondary rounded-lg flex items-center justify-center shrink-0 group-hover:scale-105 transition-transform">
            <span class="material-symbols-outlined" style="font-size:18px">volunteer_activism</span>
          </div>
          <p class="text-xs font-bold uppercase tracking-wider text-slate-400 leading-tight">Monosuko</p>
        </div>
        <p class="text-base font-extrabold text-slate-900 leading-none">Rp {{ number_format($totalMonosuko ?? 0, 0, ',', '.') }}</p>
        <div class="mt-2 h-1 bg-slate-100 rounded-full overflow-hidden">
          <div class="progress-bar h-full bg-secondary rounded-full" data-width="{{ $persenMonosuko }}"></div>
        </div>
        <p class="text-[10px] text-slate-400 mt-1 font-semibold">{{ $persenMonosuko }}% dari target</p>
      </div>

      <!-- DPU -->
      <div class="card-animate bg-white rounded-xl p-3 border border-slate-100 shadow-sm hover-lift group" style="transition-delay:0.22s">
        <div class="flex items-center gap-2 mb-2">
          <div class="h-8 w-8 bg-orange-50 text-secondary rounded-lg flex items-center justify-center shrink-0 group-hover:scale-105 transition-transform">
            <span class="material-symbols-outlined" style="font-size:18px">shield</span>
          </div>
          <p class="text-xs font-bold uppercase tracking-wider text-slate-400 leading-tight">DPU</p>
        </div>
        <p class="text-base font-extrabold text-slate-900 leading-none">Rp {{ number_format($totalDPU ?? 0, 0, ',', '.') }}</p>
        <div class="mt-2 h-1 bg-slate-100 rounded-full overflow-hidden">
          <div class="progress-bar h-full bg-secondary rounded-full" data-width="{{ $persenDPU }}"></div>
        </div>
        <p class="text-[10px] text-slate-400 mt-1 font-semibold">{{ $persenDPU }}% dana perlindungan</p>
      </div>

      <!-- Sukarela -->
      <div class="card-animate col-span-2 sm:col-span-3 xl:col-span-2 bg-white rounded-xl p-3 border border-slate-100 shadow-sm hover-lift group flex items-center justify-between gap-2" style="transition-delay:0.25s">
        <div class="flex items-center gap-2">
          <div class="h-10 w-10 bg-emerald-50 text-emerald-600 rounded-lg flex items-center justify-center shrink-0 group-hover:scale-105 transition-transform">
            <span class="material-symbols-outlined" style="font-size:20px">hand_gesture</span>
          </div>
          <div>
            <p class="text-xs font-bold uppercase tracking-wider text-slate-400">Sukarela</p>
            <p class="text-base font-extrabold text-slate-900 leading-tight mt-0.5">Rp {{ number_format($totalSukarela ?? 0, 0, ',', '.') }}</p>
          </div>
        </div>
        <div class="flex items-center gap-2 shrink-0">
          <div class="hidden sm:block w-28">
            <div class="flex justify-between text-[10px] font-bold text-slate-400 mb-1">
              <span>Progress</span><span>{{ $persenSukarela }}%</span>
            </div>
            <div class="h-1 bg-slate-100 rounded-full overflow-hidden">
              <div class="progress-bar h-full bg-primary rounded-full" data-width="{{ $persenSukarela }}"></div>
            </div>
            <p class="text-[10px] text-slate-400 mt-1 font-semibold">Target: Rp {{ number_format(1000000, 0, ',', '.') }}</p>
          </div>
          <span class="px-1.5 py-0.5 bg-emerald-50 text-emerald-700 text-[10px] font-black uppercase rounded-full tracking-wider">Aktif</span>
        </div>
      </div>

    </div>

    <!-- ── Table + Chart ── -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 card-animate" style="transition-delay:0.28s">

      <!-- Transaction Table -->
      <div class="lg:col-span-2 bg-white rounded-xl border border-slate-100 shadow-sm overflow-hidden flex flex-col">
        <div class="px-3 py-2 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-2">
          <div class="flex items-center gap-2">
            <div class="h-4 w-1 bg-primary rounded-full"></div>
            <div>
              <h3 class="text-xs font-bold text-slate-900 leading-none">Riwayat Simpanan</h3>
              <p class="text-[11px] text-slate-400 mt-0.5">5 transaksi terakhir</p>
            </div>
          </div>
          <div class="flex items-center gap-2 flex-wrap">
            <div class="flex items-center gap-1 flex-wrap">
              <button data-filter="semua"    class="filter-pill text-[10px] font-bold px-2 py-0.5 rounded flex bg-primary/10 text-emerald-700 border border-primary/20 transition-colors">Semua</button>
              <button data-filter="pokok"    class="filter-pill text-[10px] font-bold px-2 py-0.5 rounded flex bg-white text-slate-500 border border-slate-200 hover:bg-slate-50 transition-colors">Pokok</button>
              <button data-filter="wajib"    class="filter-pill text-[10px] font-bold px-2 py-0.5 rounded flex bg-white text-slate-500 border border-slate-200 hover:bg-slate-50 transition-colors">Wajib</button>
              <button data-filter="monosuko" class="filter-pill text-[10px] font-bold px-2 py-0.5 rounded flex bg-white text-slate-500 border border-slate-200 hover:bg-slate-50 transition-colors hidden sm:inline-flex">Monosuko</button>
              <button data-filter="dpu"      class="filter-pill text-[10px] font-bold px-2 py-0.5 rounded flex bg-white text-slate-500 border border-slate-200 hover:bg-slate-50 transition-colors hidden sm:inline-flex">DPU</button>
              <button data-filter="sukarela" class="filter-pill text-[10px] font-bold px-2 py-0.5 rounded flex bg-white text-slate-500 border border-slate-200 hover:bg-slate-50 transition-colors hidden sm:inline-flex">Sukarela</button>
            </div>
            <a href="#" class="text-xs font-bold text-emerald-600 flex items-center gap-0.5 hover:underline whitespace-nowrap">
              Semua <span class="material-symbols-outlined" style="font-size:14px">arrow_forward</span>
            </a>
          </div>
        </div>

        <div class="overflow-x-auto flex-1">
          <table class="w-full text-left">
            <thead class="bg-slate-50/80 dark:bg-slate-800/50">
              <tr class="text-slate-400 text-[10px] sm:text-xs uppercase tracking-widest">
                <th class="px-3 py-2 font-black">Tanggal</th>
                <th class="px-3 py-2 font-black">Jenis Simpanan</th>
                <th class="px-3 py-2 font-black">Nominal</th>
                <th class="px-3 py-2 font-black hidden sm:table-cell">Keterangan</th>
                <th class="px-3 py-2 font-black">Status</th>
              </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
              @forelse ($simpanans as $index => $tx)
              @php
                $ikons = [
                  'Pokok' => ['icon' => 'database', 'color' => 'emerald'],
                  'Wajib' => ['icon' => 'event_repeat', 'color' => 'emerald'],
                  'Sukarela' => ['icon' => 'hand_gesture', 'color' => 'secondary'],
                  'Monosuko' => ['icon' => 'volunteer_activism', 'color' => 'secondary'],
                  'DPU' => ['icon' => 'shield', 'color' => 'secondary'],
                ];
                $jenis = $tx->jenis_simpanan;
                $icon = $ikons[$jenis]['icon'] ?? 'account_balance_wallet';
                $color = $ikons[$jenis]['color'] ?? 'emerald';
                $bgClass = $color === 'emerald' ? 'bg-emerald-50 text-emerald-600' : 'bg-orange-50 text-secondary';
              @endphp
              <tr class="hover:bg-emerald-50/30 transition-colors group/row" data-jenis="{{ strtolower($jenis) }}" 
                  style="--tx-delay: {{ $index * 0.07 }}s; animation: fadeSlideIn 0.4s ease var(--tx-delay) both;">
                <td class="px-3 py-2 whitespace-nowrap">
                  <p class="text-[11px] sm:text-xs font-semibold text-slate-800 leading-none">{{ \Carbon\Carbon::parse($tx->tanggal_transaksi)->format('d M Y') }}</p>
                  <p class="text-[10px] text-slate-400 mt-0.5">{{ \Carbon\Carbon::parse($tx->created_at)->format('H:i') }} WIB</p>
                </td>
                <td class="px-3 py-2">
                  <div class="flex items-center gap-1.5">
                    <div class="h-6 w-6 rounded-md {{ $bgClass }} flex items-center justify-center shrink-0 group-hover/row:scale-105 transition-transform">
                      <span class="material-symbols-outlined {{ $color === 'secondary' ? 'text-secondary' : 'text-emerald-600' }}" style="font-size:14px">{{ $icon }}</span>
                    </div>
                    <span class="text-[11px] sm:text-xs font-semibold text-slate-700 whitespace-nowrap">{{ $jenis }}</span>
                  </div>
                </td>
                <td class="px-3 py-2 whitespace-nowrap"><span class="text-[11px] sm:text-xs font-bold text-emerald-600">+ Rp {{ number_format($tx->jumlah, 0, ',', '.') }}</span></td>
                <td class="px-3 py-2 text-[11px] sm:text-xs text-slate-500 hidden sm:table-cell max-w-[120px] truncate">{{ $tx->keterangan ?? '-' }}</td>
                <td class="px-3 py-2"><span class="px-1.5 py-0.5 bg-emerald-50 text-emerald-700 text-[10px] font-black uppercase rounded-full tracking-wide">Selesai</span></td>
              </tr>
              @empty
              <tr>
                <td colspan="5" class="px-4 py-8 text-center text-slate-500">Belum ada data simpanan.</td>
              </tr>
              @endforelse
            </tbody>
          </table>
        </div>

        <!-- Pagination -->
        <div class="px-3 py-2 border-t border-slate-100 flex items-center justify-between text-[11px] sm:text-xs text-slate-400">
          <span>Menampilkan total {{ $simpanans->count() }} transaksi terakhir</span>
        </div>
      </div>

      <!-- Chart Panel -->
      <div class="bg-white rounded-xl border border-slate-100 shadow-sm p-4 flex flex-col">
        <div class="flex items-start justify-between mb-3">
          <div>
            <h4 class="font-bold text-xs sm:text-sm text-slate-900 leading-none">Pertumbuhan Simpanan</h4>
            <p class="text-[10px] sm:text-xs text-slate-400 mt-1">6 Bulan Terakhir</p>
          </div>
          <span class="flex items-center gap-0.5 text-[10px] font-bold {{ $growthDir === 'up' ? 'text-green-500 bg-green-50' : 'text-red-500 bg-red-50' }} px-1.5 py-0.5 rounded-lg">
            <span class="material-symbols-outlined" style="font-size:14px">trending_{{ $growthDir }}</span>
            {{ $growthText }}
          </span>
        </div>

        <div class="flex-grow flex items-end gap-2 h-28">
          @foreach($chartMonths as $m)
          <div class="bar-wrap flex-1 flex flex-col items-center gap-1 relative group/bar cursor-pointer">
            <div class="bar-tooltip absolute -top-8 left-1/2 -translate-x-1/2 bg-slate-800 text-white text-sm font-bold px-1.5 py-0.5 rounded-lg whitespace-nowrap z-10 shadow-lg">
              {{ $m['formatted'] }}<div class="absolute -bottom-1 left-1/2 -translate-x-1/2 w-1.5 h-1.5 bg-slate-800 rotate-45"></div>
            </div>
            <div class="w-full flex items-end h-24">
              <div class="bar-item bar-hover w-full rounded-t-sm {{ $m['is_current'] ? 'bg-primary' : 'bg-primary/20 group-hover/bar:bg-primary/60' }}" 
                   data-height="{{ $m['height'] }}" style="height:0%"></div>
            </div>
            <span class="text-[11px] font-extrabold {{ $m['is_current'] ? 'text-primary' : 'text-slate-400 group-hover/bar:text-primary transition-colors' }} uppercase tracking-tighter">{{ $m['label'] }}</span>
          </div>
          @endforeach
        </div>

        <div class="mt-3 pt-3 border-t border-slate-100 flex flex-wrap justify-between items-end gap-2">
          <div class="min-w-fit">
            <p class="text-xs text-slate-500 uppercase font-bold tracking-wider">Total Akumulasi</p>
            <p class="text-lg font-extrabold text-emerald-500 mt-0.5">Rp {{ number_format($totalSimpanan ?? 0, 0, ',', '.') }}</p>
          </div>
          <div class="text-right min-w-fit">
            <p class="text-xs text-slate-500 uppercase font-bold tracking-wider">Yield 6 Bulan</p>
            <p class="text-xs font-bold {{ $growthDir === 'up' ? 'text-green-500' : 'text-red-500' }} mt-0.5">{{ $growthText }}</p>
          </div>
        </div>
      </div>

    </div>

    <!-- ── Quick Actions ── -->
    <div class="card-animate" style="transition-delay:0.32s">
        @include('user.partials.quick_action')
    </div>
    </div>

  </main>

  {{-- Footer --}}
  @include('user.partials.footer')
</div>

<!-- Mobile FAB -->
<div class="fixed bottom-5 right-5 z-50 lg:hidden">
  <button class="bg-secondary text-white rounded-full shadow-2xl flex items-center justify-center active:scale-95 transition-all shadow-secondary/30 hover:opacity-90" style="height:50px;width:50px">
    <span class="material-symbols-outlined">add</span>
  </button>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
  // 1. Card entrance
  const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) { entry.target.classList.add('visible'); observer.unobserve(entry.target); }
    });
  }, { threshold: 0.05 });
  document.querySelectorAll('.card-animate').forEach(el => observer.observe(el));

  // 2. Progress bars
  const progressObserver = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        entry.target.querySelectorAll('.progress-bar').forEach(bar => {
          const t = bar.dataset.width || 0;
          setTimeout(() => { bar.style.width = t + '%'; }, 200);
        });
        progressObserver.unobserve(entry.target);
      }
    });
  }, { threshold: 0.1 });
  document.querySelectorAll('.card-animate').forEach(el => progressObserver.observe(el));

  // 3. Bar chart
  const chartObserver = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        entry.target.querySelectorAll('.bar-item').forEach((bar, i) => {
          setTimeout(() => { bar.style.height = bar.dataset.height + '%'; }, i * 90);
        });
        chartObserver.unobserve(entry.target);
      }
    });
  }, { threshold: 0.1 });
  document.querySelectorAll('.bar-wrap').forEach(el => chartObserver.observe(el));

  // 4. Filter pills
  document.querySelectorAll('.filter-pill').forEach(btn => {
    btn.addEventListener('click', function () {
      document.querySelectorAll('.filter-pill').forEach(b => {
        b.classList.remove('bg-primary/10','text-emerald-700','border-primary/20');
        b.classList.add('bg-white','text-slate-500','border-slate-200');
      });
      this.classList.remove('bg-white','text-slate-500','border-slate-200');
      this.classList.add('bg-primary/10','text-emerald-700','border-primary/20');
      const filter = this.dataset.filter;
      document.querySelectorAll('tbody tr[data-jenis]').forEach(row => {
        row.style.display = (filter === 'semua' || row.dataset.jenis.includes(filter)) ? '' : 'none';
      });
    });
  });

  // 5. Ripple
  document.querySelectorAll('.ripple-btn').forEach(btn => {
    btn.addEventListener('click', function (e) {
      const rect = this.getBoundingClientRect();
      const ripple = document.createElement('span');
      const size = Math.max(rect.width, rect.height);
      ripple.style.cssText = `position:absolute;width:${size}px;height:${size}px;border-radius:50%;background:rgba(255,255,255,0.3);top:${e.clientY-rect.top-size/2}px;left:${e.clientX-rect.left-size/2}px;transform:scale(0);animation:rippleAnim 0.5s ease-out forwards;pointer-events:none;`;
      this.appendChild(ripple);
      setTimeout(() => ripple.remove(), 500);
    });
  });

});
</script>
</body>
</html>
