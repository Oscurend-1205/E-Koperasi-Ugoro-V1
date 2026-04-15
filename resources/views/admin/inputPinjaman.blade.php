@extends('layouts.admin')

@section('title', 'Koperasi Ugoro — Input Pinjaman')

@push('styles')
<style>
/* ── Local Style Overrides ── */
.canvas { padding: 24px; display: flex; flex-direction: column; gap: 16px; max-width: 1400px; width: 100%; margin: 0 auto; }

.user-chip .name { font-size: var(--fs-sm); font-weight: 700; color: var(--text-primary); line-height: 1.1; }
.user-chip .role { font-size: var(--fs-xxs); font-weight: 600; color: var(--green); text-transform: uppercase; letter-spacing: .4px; }


/* ── Canvas ── */
  .canvas { padding: 24px; display: flex; flex-direction: column; gap: 16px; max-width: 1400px; width: 100%; margin: 0 auto; }
  .page-header h2 { font-size: var(--fs-h2); font-weight: 800; color: var(--text-primary); letter-spacing: -.5px; }
  .page-header p { font-size: var(--fs-md); color: var(--text-muted); font-weight: 500; margin-top: 2px; }

/* ── Buttons ── */
.btn {
  display: inline-flex; align-items: center; gap: 8px;
  padding: 8px 16px; border-radius: 10px; font-size: 13px;
  font-weight: 700; font-family: inherit; cursor: pointer; border: none;
  transition: all .2s; text-decoration: none;
}
.btn-primary { background: var(--green); color: #fff; box-shadow: 0 4px 12px rgba(22,163,74,.2); }
.btn-primary:hover { background: #15803d; transform: translateY(-1px); }
.btn-outline { background: var(--surface); border: 1px solid var(--border); color: var(--text-primary); }
.btn-outline:hover { background: var(--bg); border-color: var(--text-muted); }
.btn-dark { background: #1a1f1a; color: #fff; }
.btn-dark:hover { background: #111; }
.btn-ghost {
  display: inline-flex; align-items: center; gap: 5px;
  padding: 6px 11px; border-radius: 7px;
  border: 1px solid var(--border); background: var(--surface);
  font-size: var(--fs-sm); font-weight: 700; font-family: inherit;
  color: var(--text-secondary); cursor: pointer;
}
.btn-ghost:hover { background: var(--bg); }

/* ── Card ── */
.card {
  background: var(--surface);
  border: 1px solid var(--border);
  border-radius: 16px;
  box-shadow: var(--shadow);
  overflow: hidden;
}
.card-header {
  padding: 16px 20px;
  border-bottom: 1px solid var(--border);
  display: flex; align-items: center; justify-content: space-between;
}
.card-title {
  display: flex; align-items: center; gap: 8px;
  font-size: 14px; font-weight: 700; color: var(--text-primary);
}
.card-title .material-symbols-rounded { font-size: 18px; }

/* ── Member search bar ── */
.member-search-bar {
  background: var(--surface);
  border: 1px solid var(--border);
  border-radius: 16px;
  box-shadow: var(--shadow);
  padding: 16px 20px;
  display: flex;
  align-items: center;
  gap: 12px;
}
.member-search-bar .search-wrap { position: relative; flex: 1; max-width: 320px; }
.member-search-bar .search-wrap .material-symbols-rounded { position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: var(--text-muted); font-size: 16px; }
.member-search-bar input {
  width: 100%; padding: 8px 12px 8px 36px;
  border: 1px solid var(--border); border-radius: 8px;
  background: var(--surface); font-size: var(--fs-base); font-family: inherit;
  color: var(--text-primary); outline: none; transition: border-color .15s;
}
.member-search-bar input:focus { border-color: var(--green); }
.member-search-bar input::placeholder { color: var(--text-muted); }

/* ── Member info chip (shown after search) ── */
.member-found {
  display: flex; align-items: center; gap: 12px;
  padding: 12px 16px;
  background: var(--green-light);
  border: 1px solid var(--green-mid);
  border-radius: 10px;
  margin-bottom: 0;
}
.member-found .av {
  width: 36px; height: 34px; border-radius: 8px;
  background: var(--green); display: flex; align-items: center; justify-content: center;
  font-size: 12px; font-weight: 800; color: #fff; flex-shrink: 0;
}
.member-found .mname { font-size: var(--fs-lg); font-weight: 700; color: var(--text-primary); }
.member-found .mmeta { font-size: var(--fs-sm); color: var(--text-secondary); }
.member-found .badge {
  margin-left: auto; font-size: var(--fs-xs); font-weight: 800;
  padding: 3px 10px; border-radius: 99px;
  background: var(--green); color: #fff;
}

/* ── Loan history mini box ── */
.loan-history-mini {
  display: grid; grid-template-columns: repeat(3, 1fr);
  gap: 10px; margin-top: 14px;
}
.lhm-card {
  background: var(--surface); border: 1px solid var(--border);
  border-radius: 10px; padding: 12px 14px;
}
.lhm-card .lhm-label { font-size: var(--fs-xs); font-weight: 700; text-transform: uppercase; letter-spacing: .5px; color: var(--text-muted); margin-bottom: 4px; }
.lhm-card .lhm-val { font-size: var(--fs-lg); font-weight: 800; color: var(--text-primary); font-variant-numeric: tabular-nums; }
.lhm-card .lhm-val.orange { color: var(--orange); }
.lhm-card .lhm-val.green  { color: var(--green); }

/* ── Form ── */
.form-body { padding: 20px; }
.form-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 14px; }
.form-grid .span2 { grid-column: span 2; }
.form-grid .full  { grid-column: 1 / -1; }

.form-field { display: flex; flex-direction: column; gap: 5px; }
label.flabel {
  font-size: var(--fs-xs); font-weight: 700;
  text-transform: uppercase; letter-spacing: .5px;
  color: var(--text-muted);
}
.form-input {
  width: 100%; padding: 8px 12px;
  border: 1px solid var(--border); border-radius: 8px;
  background: var(--surface); font-size: var(--fs-base); font-family: inherit;
  color: var(--text-primary); outline: none; transition: all .15s;
}
.form-input:focus { border-color: var(--green); box-shadow: 0 0 0 3px rgba(22,163,74,.1); }
.form-input::placeholder { color: var(--text-muted); }
.form-input:read-only { background: var(--bg); opacity: 0.8; cursor: not-allowed; }
select.form-input {
  appearance: none;
  background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%239aaa98' stroke-width='2'%3E%3Cpath d='M6 9l6 6 6-6'/%3E%3C/svg%3E");
  background-repeat: no-repeat; background-position: right 10px center;
  padding-right: 30px;
}

.input-prefix-wrap { position: relative; }
.input-prefix-wrap .pfx {
  position: absolute; left: 12px; top: 50%; transform: translateY(-50%);
  font-size: var(--fs-md); font-weight: 700; color: var(--text-secondary); pointer-events: none;
}
.input-prefix-wrap .form-input { padding-left: 32px; }

.form-divider {
  grid-column: 1 / -1;
  border: none; border-top: 1px dashed var(--border);
  margin: 4px 0;
}

/* auto-calc readonly field highlight */
.calc-field .form-input {
  background: var(--green-light);
  color: var(--green);
  font-weight: 700;
  font-variant-numeric: tabular-nums;
}

/* ── Simulasi angsuran table ── */
.sim-wrap { margin-top: 16px; padding-top: 16px; border-top: 1px solid var(--border); }
.sim-title { font-size: var(--fs-md); font-weight: 700; color: var(--text-secondary); margin-bottom: 10px; display: flex; align-items: center; gap: 6px; }
.sim-title .material-symbols-rounded { font-size: var(--fs-xl); color: var(--orange); }

table.sim-table { width: 100%; border-collapse: collapse; }
.sim-table thead th {
  padding: 8px 12px; font-size: var(--fs-xs); font-weight: 700;
  text-transform: uppercase; letter-spacing: .6px;
  color: var(--text-muted); background: var(--surface);
  border-bottom: 1px solid var(--border); text-align: left;
}
.sim-table tbody tr { border-bottom: 1px solid var(--border); }
.sim-table tbody tr:last-child { border-bottom: none; }
.sim-table td { padding: 8px 12px; font-size: 12px; color: var(--text-secondary); font-variant-numeric: tabular-nums; }
.sim-table td.bold { font-weight: 700; color: var(--text-primary); }
.sim-table td.green { color: var(--green); font-weight: 600; }

/* ── Form actions ── */
.form-actions {
  padding: 16px 20px;
  border-top: 1px solid var(--border);
  background: var(--bg);
  display: flex; justify-content: flex-end; gap: 10px;
}
[data-theme="dark"] .form-actions { background: #1e293b; }

/* ── Data table ── */
table.data-table { width: 100%; border-collapse: collapse; }
.data-table thead th {
  padding: 12px 20px; font-size: 11px; font-weight: 800;
  text-transform: uppercase; letter-spacing: .8px;
  color: var(--text-primary); background: #f8fafc;
  border-bottom: 2px solid var(--border); text-align: left; white-space: nowrap;
}
.data-table thead th.center { text-align: center; }
.data-table tbody tr { border-bottom: 1px solid var(--border); transition: background .1s; }
.data-table tbody tr:last-child { border-bottom: none; }
.data-table tbody tr:hover { background: var(--bg); }
.data-table td { padding: 14px 20px; font-size: 13px; color: var(--text-primary); font-weight: 500; }
.data-table td.mono-val { font-size: 13px; font-weight: 600; font-variant-numeric: tabular-nums; }
.data-table td.bold { font-weight: 700; color: var(--text-primary); }
.data-table td.green  { color: var(--green);  font-weight: 600; }
.data-table td.orange { color: var(--orange); font-weight: 600; }
.data-table td.center { text-align: center; }

.pill { display: inline-flex; align-items: center; gap: 4px; font-size: 10px; font-weight: 800; text-transform: uppercase; padding: 4px 10px; border-radius: 99px; letter-spacing: .3px; }
.pill-green  { background: var(--green-light);  color: var(--green); border: 1px solid var(--green-mid); }
.pill-orange { background: var(--orange-light); color: var(--orange); border: 1px solid var(--orange-dim); }
.pill-gray   { background: var(--bg); color: var(--text-muted); border: 1px solid var(--border); }

.act-btn {
  width: 30px; height: 30px; display: flex; align-items: center; justify-content: center;
  border-radius: 7px; border: none; background: none; cursor: pointer; color: var(--text-muted);
  transition: all .15s;
}
.act-btn:hover.edit { background: var(--green-light); color: var(--green); }
.act-btn:hover.del  { background: var(--red-light);   color: var(--red); }
.act-btn .material-symbols-rounded { font-size: 16px; }
.act-cell { display: flex; justify-content: center; gap: 4px; }

.table-footer {
  padding: 12px 20px; border-top: 1px solid var(--border);
  background: var(--bg);
  display: flex; align-items: center; justify-content: space-between;
}
.table-footer p { font-size: 11px; color: var(--text-muted); font-weight: 500; }

.pagination { display: flex; gap: 4px; }
.pg-btn {
  padding: 5px 12px;
  border-radius: 6px; border: 1px solid var(--border);
  background: var(--surface); font-size: 12px; font-weight: 600;
  font-family: inherit; color: var(--text-secondary); cursor: pointer;
  display: flex; align-items: center; justify-content: center;
  transition: all .15s;
}
.pg-btn:hover:not(:disabled) { background: var(--bg); }
.pg-btn.active { background: var(--green); color: #fff; border-color: var(--green); }
.pg-btn:disabled { opacity: .45; cursor: not-allowed; }

.search-container { position: relative; width: 300px; }
.search-results {
  position: absolute; top: 100%; left: 0; right: 0;
  background: var(--surface); border: 1px solid var(--border);
  border-radius: 10px; margin-top: 5px; box-shadow: 0 10px 25px -5px rgba(0,0,0,0.1);
  max-height: 250px; overflow-y: auto; z-index: 1000;
  display: none;
}
.search-results.show { display: block; }
.search-item {
  padding: 10px 14px; font-size: 13px; color: var(--text-primary);
  cursor: pointer; border-bottom: 1px solid var(--border);
  transition: background .15s;
  line-height: 1.3;
}
.search-item:last-child { border-bottom: none; }
.search-item:hover { background: var(--bg); }
.search-item strong { display: block; font-size: 13px; color: var(--text-primary); }
.search-item span { font-size: 10px; color: var(--text-muted); font-weight: 600; text-transform: uppercase; }
.clear-btn {
  position: absolute; right: 8px; top: 50%; transform: translateY(-50%);
  width: 20px; height: 20px; border-radius: 50%;
  display: flex; align-items: center; justify-content: center;
  color: var(--text-muted); text-decoration: none;
  transition: all .15s;
  z-index: 10;
}
.clear-btn:hover { background: var(--bg); color: var(--red); }

.empty-state {
  grid-column: 1 / -1;
  display: flex; flex-direction: column; align-items: center; justify-content: center;
  padding: 80px 20px; text-align: center;
  background: var(--surface); border: 1px dashed var(--border);
  border-radius: 16px; margin-top: 20px;
}
.empty-icon {
  width: 64px; height: 64px; background: var(--bg); border-radius: 50%;
  display: flex; align-items: center; justify-content: center;
  margin-bottom: 20px;
}
.empty-icon .material-symbols-rounded { font-size: 32px; color: var(--text-muted); }
.empty-state h3 { font-size: 18px; font-weight: 800; color: var(--text-primary); margin-bottom: 8px; }
.empty-state p { font-size: 13px; color: var(--text-muted); max-width: 320px; line-height: 1.5; }
</style>
@endpush

@section('content')

    <!-- Page Title & SEARCH BAR -->
    <div class="page-header">
      <div>
        <h2>Input Pinjaman</h2>
        <p>Pilih anggota untuk pengajuan pinjaman</p>
      </div>

      @if($users->isNotEmpty())
      <div class="search-container" style="width: 320px; margin-top: 0;">
        <div class="input-wrap" style="position:relative;">
          <span class="material-symbols-rounded" style="position:absolute; left:12px; top:50%; transform:translateY(-50%); font-size:18px; color:var(--text-muted); z-index:5;">search</span>
          <input type="text" id="memberSearch" class="form-input" style="padding-left:38px; padding-right:32px;" 
                 placeholder="Cari Nama atau No. Anggota..." 
                 value="{{ $selectedUser ? $selectedUser->name : '' }}" autocomplete="off">
          @if($selectedUser)
            <a href="{{ route('admin.inputPinjaman') }}" class="clear-btn" title="Hapus Pilihan">
              <span class="material-symbols-rounded" style="font-size:16px;">close</span>
            </a>
          @endif
        </div>
        <div id="searchResults" class="search-results"></div>
        
        <form id="selectionForm" action="{{ route('admin.inputPinjaman') }}" method="GET">
          <input type="hidden" name="user_id" id="selectedUserId" value="{{ $selectedUser ? $selectedUser->id : '' }}">
        </form>
      </div>
      @endif
    </div>

    @if(session('success'))
      <div style="background:#e6ffe6; border:1px solid #00cc00; color:#006600; padding:12px; border-radius:8px; font-weight:bold; margin-bottom: 20px;">
        {{ session('success') }}
      </div>
    @endif
    
    @if($errors->any())
      <div style="background:#ffe6e6; border:1px solid #cc0000; color:#cc0000; padding:12px; border-radius:8px; font-weight:bold; margin-bottom: 20px;">
        <ul>
          @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    @if($selectedUser)
      <div style="display:grid;grid-template-columns:300px 1fr;gap:14px;align-items:start;">

        <!-- Left: Cari Anggota -->
        <div class="card">
          <div class="card-header">
            <div class="card-title">
              <span class="material-symbols-rounded" style="color:var(--green)">person_search</span>
              Cari Anggota
            </div>
            <div style="display:flex; align-items:center; gap:8px;">
              <span class="pill pill-green">Aktif</span>
              <a href="{{ route('admin.inputPinjaman') }}" class="pill pill-gray" style="text-decoration:none; padding:4px 8px; font-size:10px; display:flex; align-items:center; gap:2px;">
                <span class="material-symbols-rounded" style="font-size:14px;">close</span> Tutup
              </a>
            </div>
          </div>
          <div style="padding:14px;">
            <div class="member-found" style="display:flex;">
              @php
                $initials = collect(explode(' ', $selectedUser->name))->map(fn($w) => strtoupper(substr($w, 0, 1)))->take(2)->implode('');
              @endphp
              <div class="av">{{ $initials }}</div>
              <div>
                <div class="mname" style="color: #000;">{{ $selectedUser->name }}</div>
                <div class="mmeta">{{ $selectedUser->no_anggota }}</div>
              </div>
            </div>

            <div>
              <p style="font-size:9px;font-weight:700;text-transform:uppercase;letter-spacing:.5px;color:var(--text-3);margin:12px 0 6px;">Riwayat Pinjaman</p>
              <div class="loan-history-mini">
                <div class="lhm-card">
                  <div class="lhm-label">Pinjaman Aktif</div>
                  <div class="lhm-val orange">{{ $pinjamans->where('status', 'disetujui')->count() }}x</div>
                </div>
                <div class="lhm-card">
                  <div class="lhm-label">Sisa Pokok</div>
                  <div class="lhm-val orange">
                    @php
                      $sisaPokok = 0;
                      foreach($pinjamans->where('status', 'disetujui') as $p) {
                        $sisaPokok += max(0, $p->jumlah_pinjaman - $p->angsurans->sum('jumlah_bayar'));
                      }
                    @endphp
                    Rp {{ number_format($sisaPokok, 0, ',', '.') }}
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Right: Form Input Pinjaman -->
        <div class="card">
          <div class="card-header">
            <div class="card-title">
              <span class="material-symbols-rounded" style="color:var(--orange)">edit_note</span>
              Detail Pinjaman Baru
            </div>
          </div>
          <div class="form-body">
            <form action="{{ route('admin.storePinjaman') }}" method="POST">
              @csrf
              <input type="hidden" name="user_id" value="{{ $selectedUser->id }}">
              <div class="form-grid">
                <div class="form-field">
                  <label class="flabel">No Anggota</label>
                  <input class="form-input" type="text" value="{{ $selectedUser->no_anggota }}" readonly/>
                </div>
                <div class="form-field span2">
                  <label class="flabel">Nama Anggota</label>
                  <input class="form-input" type="text" value="{{ $selectedUser->name }}" readonly/>
                </div>
                <hr class="form-divider"/>
                <div class="form-field">
                  <label class="flabel">Jumlah Pinjaman</label>
                  <div class="input-prefix-wrap">
                    <span class="pfx">Rp</span>
                    <input name="jumlah_pinjaman" class="form-input format-rupiah" id="inputJumlah" type="text" placeholder="2.000.000" oninput="calcAngsuran()" required/>
                  </div>
                </div>
                <div class="form-field">
                  <label class="flabel">Jangka Waktu</label>
                  <select name="tenor" class="form-input" id="inputJangka" onchange="calcAngsuran()" required>
                    <option value="6">6 Bulan</option>
                    <option value="12">12 Bulan</option>
                    <option value="18">18 Bulan</option>
                    <option value="24" selected>24 Bulan</option>
                    <option value="36">36 Bulan</option>
                  </select>
                </div>
                <div class="form-field">
                  <label class="flabel">Bunga (%) / Bln</label>
                  <input name="bunga" class="form-input" id="inputBunga" type="number" step="0.01" placeholder="0" value="0" oninput="calcAngsuran()" required/>
                </div>
                <div class="form-field">
                  <label class="flabel">Tanggal Pengajuan</label>
                  <input name="tanggal_pengajuan" class="form-input" type="date" value="{{ date('Y-m-d') }}" required/>
                </div>
                <div class="form-field span2">
                  <label class="flabel">Keterangan Tambahan</label>
                  <input name="keterangan" class="form-input" type="text" placeholder="Catatan opsional"/>
                </div>
              </div>
              <div class="form-grid" style="margin-top: 15px;">
                <div class="form-field calc-field">
                  <label class="flabel">Angsuran/Bulan (Otomatis)</label>
                  <div class="input-prefix-wrap">
                    <span class="pfx" style="color:var(--green);">Rp</span>
                    <input class="form-input" id="outputAngsuran" type="text" value="—" readonly/>
                  </div>
                </div>
              </div>
              <div class="form-actions" style="margin-top: 20px;">
                <button class="btn btn-outline" type="button" onclick="resetForm()">Reset</button>
                <button class="btn btn-dark" type="submit">
                  <span class="material-symbols-rounded" style="font-size:14px;">save</span>
                  Simpan Pinjaman
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>

      <!-- Data Table: Daftar Pinjaman -->
      <div class="card" style="background: var(--surface) !important; margin-top: 20px;">
        <div class="card-header" style="border-bottom: 1px solid var(--border);">
          <div class="card-title">
            <span class="material-symbols-rounded" style="color:var(--orange)">history</span>
            Daftar Pinjaman Anggota
          </div>
          <p style="font-size:11px;color:var(--text-3);margin:0;">Semua aktif & selesai</p>
        </div>
        <div style="overflow-x:auto;">
          <table class="data-table">
            <thead>
              <tr>
                <th>Anggota</th>
                <th>Tanggal</th>
                <th>Pinjaman</th>
                <th>Sisa Tagihan</th>
                <th class="center">Status</th>
                <th class="center">Aksi</th>
              </tr>
            </thead>
            <tbody>
              @forelse ($pinjamans as $p)
              <tr>
                <td>{{ $p->user->name }}</td>
                <td>{{ \Carbon\Carbon::parse($p->tanggal_pengajuan)->translatedFormat('d M Y') }}</td>
                <td class="bold">Rp {{ number_format($p->jumlah_pinjaman, 0, ',', '.') }}</td>
                <td class="orange">
                  @php
                    $sisa = $p->jumlah_pinjaman - $p->angsurans->sum('jumlah_bayar');
                  @endphp
                  Rp {{ number_format($sisa, 0, ',', '.') }}
                </td>
                <td class="center">
                  <span class="pill {{ $p->status == 'lunas' ? 'pill-green' : 'pill-orange' }}">{{ ucfirst($p->status) }}</span>
                </td>
                <td>
                  <div class="act-cell">
                    <button class="act-btn" title="Lihat"><span class="material-symbols-rounded">visibility</span></button>
                    <button type="button" class="act-btn del js-univ-confirm" title="Hapus"
                      data-title="Hapus Pinjaman?"
                      data-desc="Anda akan menghapus data pinjaman <strong>{{ $p->user->name }}</strong> sebesar <strong>Rp {{ number_format($p->jumlah_pinjaman, 0, ',', '.') }}</strong>. Tindakan ini tidak dapat dibatalkan."
                      data-action="{{ route('admin.destroyPinjaman', $p->id) }}">
                      <span class="material-symbols-rounded">delete</span>
                    </button>
                  </div>
                </td>
              </tr>
              @empty
              <tr>
                <td colspan="6" style="text-align: center; padding: 20px;">Belum ada riwayat pinjaman untuk anggota ini.</td>
              </tr>
              @endforelse
            </tbody>
          </table>
        </div>
        <div class="table-footer">
          <p>Menampilkan <strong>{{ $allPinjamans->count() }}</strong> pinjaman</p>
          <div class="pagination">
            <button class="pg-btn active">1</button>
          </div>
        </div>
      </div>
    @else
      <div class="empty-state">
        <div class="empty-icon"><span class="material-symbols-rounded">payments</span></div>
        <h3>Tidak ada data yang ditampilkan</h3>
        <p>Gunakan fitur pencarian di atas untuk memilih anggota koperasi.</p>
      </div>
    @endif
@endsection

@push('scripts')
<!-- Toast -->
<div id="toast" style="position:fixed;bottom:20px;right:20px;background:#1a1f1a;color:#fff;padding:11px 16px;border-radius:9px;font-size:13px;font-weight:600;display:flex;align-items:center;gap:7px;box-shadow:0 8px 24px rgba(0,0,0,.2);transform:translateY(20px);opacity:0;transition:all .25s;z-index:999;">
  <span class="material-symbols-rounded" style="color:#4ade80;font-size:15px;">check_circle</span>
  Data pinjaman berhasil disimpan!
</div>

<script>
  const members = <?php echo json_encode($users->map(function($u) { 
    return ['id' => $u->id, 'name' => $u->name, 'no' => $u->no_anggota]; 
  })->toArray()); ?>;

  const searchInput = document.getElementById('memberSearch');
  const resultsDiv = document.getElementById('searchResults');
  const hiddenInput = document.getElementById('selectedUserId');
  const selectionForm = document.getElementById('selectionForm');

  if (searchInput) {
    searchInput.addEventListener('input', function() {
      const val = this.value.toLowerCase();
      resultsDiv.innerHTML = '';
      
      if (val.length < 1) {
        resultsDiv.classList.remove('show');
        return;
      }

      const filtered = members.filter(m => 
        m.name.toLowerCase().includes(val) || 
        m.no.toLowerCase().includes(val)
      );

      if (filtered.length > 0) {
        filtered.forEach(m => {
          const item = document.createElement('div');
          item.className = 'search-item';
          item.innerHTML = `<strong>${m.name}</strong><span>${m.no}</span>`;
          item.onclick = function() {
            searchInput.value = m.name;
            hiddenInput.value = m.id;
            resultsDiv.classList.remove('show');
            selectionForm.submit();
          };
          resultsDiv.appendChild(item);
        });
        resultsDiv.classList.add('show');
      } else {
        resultsDiv.classList.remove('show');
      }
    });

    document.addEventListener('click', function(e) {
      if (!searchInput.contains(e.target) && !resultsDiv.contains(e.target)) {
        resultsDiv.classList.remove('show');
      }
    });
  }

  function fmt(n) {
    return new Intl.NumberFormat('id-ID').format(Math.round(n));
  }

  function calcAngsuran() {
    const jumlahEl = document.getElementById('inputJumlah');
    const jangkaEl = document.getElementById('inputJangka');
    const bungaEl = document.getElementById('inputBunga');
    const outputEl = document.getElementById('outputAngsuran');
    if (!jumlahEl || !jangkaEl || !outputEl) return;

    const jumlah = parseFloat(jumlahEl.value.replace(/\./g, '')) || 0;
    const jangka = parseInt(jangkaEl.value) || 0;
    const bunga = bungaEl && bungaEl.value ? parseFloat(bungaEl.value) : 0;

    if (!jumlah || !jangka) {
      outputEl.value = '—';
      return;
    }

    const pokokPerBulan = jumlah / jangka;
    const bungaNominal = jumlah * (bunga / 100);
    const totalAngsuran = pokokPerBulan + bungaNominal;
    outputEl.value = fmt(totalAngsuran);
  }

  function resetForm() {
    const jumlahEl = document.getElementById('inputJumlah');
    const jangkaEl = document.getElementById('inputJangka');
    const bungaEl = document.getElementById('inputBunga');
    const outputEl = document.getElementById('outputAngsuran');
    if (jumlahEl) jumlahEl.value = '';
    if (jangkaEl) jangkaEl.value = '24';
    if (bungaEl) bungaEl.value = '0';
    if (outputEl) outputEl.value = '—';
  }

</script>
@endpush
