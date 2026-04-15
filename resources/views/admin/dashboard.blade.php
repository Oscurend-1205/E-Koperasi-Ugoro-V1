@extends('layouts.admin')

@section('title', 'Koperasi Ugoro — Dashboard')

@push('styles')
<style>
/* ── Local Style Overrides ── */
.canvas { padding: 24px; display: flex; flex-direction: column; gap: 16px; max-width: 1400px; width: 100%; margin: 0 auto; }

/* ===== CANVAS ===== */
.canvas {
  padding: 24px;
  display: flex;
  flex-direction: column;
  gap: 16px;
  max-width: 1400px;
  width: 100%;
  margin: 0 auto;
}

/* ===== PAGE HEADER ===== */
.page-header {
  display: flex;
  justify-content: space-between;
  align-items: flex-start;
  flex-wrap: wrap;
  gap: 12px;
}
.page-header h2 {
  font-size: var(--fs-h2);
  font-weight: 800;
  color: var(--text-primary);
  letter-spacing: -.5px;
}
.page-header > div > p {
  font-size: var(--fs-md);
  color: var(--text-muted);
  font-weight: 500;
  margin-top: 2px;
}
.header-actions {
  display: flex;
  gap: 8px;
  align-items: center;
}

/* ===== BUTTONS ===== */
.btn {
  display: inline-flex;
  align-items: center;
  gap: 6px;
  padding: 8px 16px;
  border-radius: 8px;
  font-size: var(--fs-base);
  font-weight: 600;
  cursor: pointer;
  border: none;
  line-height: var(--fs-base);
  font-family: inherit;
  transition: opacity .15s, transform .1s;
}
.btn:active { transform: scale(.98); }
.btn-outline {
  background: var(--surface);
  border: 1px solid var(--border);
  color: var(--text-primary);
}
.btn-outline:hover { background: var(--bg); border-color: var(--text-muted); }
.btn-primary {
  background: var(--green);
  color: #fff;
}
.btn-primary:hover { opacity: .9; }
.btn-dark {
  background: #111b11;
  color: #fff;
}
.btn-dark:hover { opacity: .88; }

/* ===== BENTO GRID ===== */
.bento {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 20px;
}
@media (max-width: 860px) {
  .bento { grid-template-columns: 1fr; }
}

/* ===== CARD ===== */
.card {
  background: var(--surface);
  border: 1px solid var(--border);
  border-radius: 16px;
  box-shadow: var(--shadow);
  overflow: hidden;
}
.card-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 12px 16px;
  border-bottom: 1px solid var(--border);
}
.card-title {
  display: flex;
  align-items: center;
  gap: 8px;
  font-weight: 700;
  font-size: var(--fs-base);
  color: var(--text-primary);
}
.card-title .material-symbols-rounded {
  font-size: 20px;
}
.badge {
  background: var(--surface);
  color: var(--text-muted);
  font-size: var(--fs-xs);
  font-weight: 700;
  padding: 3px 9px;
  border-radius: 6px;
  border: 0.5px solid var(--border);
  letter-spacing: .03em;
}

/* ===== IMPORT CARD ===== */
.import-body {
  display: grid;
  grid-template-columns: 1fr 1fr;
}
.drop-zone {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  gap: 8px;
  padding: 20px 16px;
  background: var(--surface);
  border-right: 1px solid var(--border);
  cursor: pointer;
  transition: all .15s;
}
.drop-zone:hover { background: var(--border-light, #f0fdf4); }
.drop-zone .material-symbols-rounded {
  font-size: 36px;
  color: var(--green);
  opacity: .7;
}
.drop-zone p {
  font-size: var(--fs-md);
  color: var(--text-muted);
  text-align: center;
  line-height: 1.5;
}
.btn-upload {
  background: #dcfce7;
  color: #14532d;
  font-size: var(--fs-xs);
  font-weight: 700;
  padding: 6px 14px;
  border-radius: 7px;
  border: none;
  cursor: pointer;
  font-family: inherit;
  transition: opacity .15s;
}
.btn-upload:hover { opacity: .85; }

.preview-wrap { padding: 12px 16px; }
.preview-label {
  font-size: var(--fs-xxs);
  font-weight: 700;
  color: var(--text-muted);
  text-transform: uppercase;
  letter-spacing: .07em;
  margin-bottom: 8px;
}
.mini-table {
  width: 100%;
  border-collapse: collapse;
  font-size: var(--fs-md);
}
.mini-table th {
  color: var(--text-muted);
  font-weight: 600;
  padding: 4px 6px;
  text-align: left;
  border-bottom: 0.5px solid var(--border);
  white-space: nowrap;
}
.mini-table td {
  padding: 6px 6px;
  color: var(--text);
  border-bottom: 0.5px solid var(--border);
}
.mini-table tr:last-child td { border-bottom: none; }
.mini-table .name { font-weight: 600; }

.import-footer {
  padding: 12px 18px;
  border-top: 0.5px solid var(--border);
  background: var(--surface);
}

/* ===== FORM CARD ===== */
.form-body { padding: 18px 18px 16px; }
.form-body label {
  display: block;
  font-size: var(--fs-xs);
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: .5px;
  color: var(--text-secondary);
  margin-bottom: 6px;
  margin-top: 12px;
}

.form-body > div:first-child label { margin-top: 0; }

.form-input {
  width: 100%;
  padding: 8px 12px;
  border: 1px solid var(--border);
  border-radius: 8px;
  background: var(--surface);
  color: var(--text-primary);
  font-size: var(--fs-base);
  font-weight: 500;
  font-family: inherit;
  outline: none;
  transition: all .15s;
}
.form-input:focus {
  border-color: var(--green);
  box-shadow: 0 0 0 3px rgba(22, 163, 74, .1);
}
.form-input::placeholder { color: var(--text-muted); opacity: .8; }
textarea.form-input {
  resize: vertical;
  min-height: 60px;
}

.form-row {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 12px;
}
.form-row > div { display: flex; flex-direction: column; }
.form-row label { margin-top: 14px; }

.alert {
  padding: 10px 13px;
  border-radius: 8px;
  font-size: var(--fs-base);
  font-weight: 600;
  margin-bottom: 14px;
}
.alert-success { background: #f0fdf4; border: 1px solid #bbf7d0; color: #15803d; }
.alert-error   { background: #fef2f2; border: 1px solid #fecaca; color: #dc2626; }

.btn-register {
  width: 100%;
  padding: 8px;
  background: var(--orange);
  color: #fff;
  border: none;
  border-radius: 8px;
  font-size: var(--fs-base);
  font-weight: 700;
  font-family: inherit;
  cursor: pointer;
  transition: opacity .15s, transform .1s;
}
.btn-register:hover { opacity: .9; }
.btn-register:active { transform: scale(.99); }

/* ===== DATA TABLE CARD ===== */

.table-toolbar {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 12px 16px;
  flex-wrap: wrap;
  gap: 10px;
}
.table-toolbar-left h3 {
  font-size: var(--fs-lg);
  font-weight: 700;
  color: var(--text-primary);
}
.table-toolbar-left p {
  font-size: 11px;
  color: var(--text-muted);
  margin-top: 1px;
}
.table-toolbar-right {
  display: flex;
  gap: 8px;
  align-items: center;
}
.filter-select {
  padding: 5px 10px;
  border: 1px solid var(--border);
  border-radius: 7px;
  background: var(--surface);
  color: var(--text-primary);
  font-size: 11px;
  font-weight: 500;
  font-family: inherit;
  cursor: pointer;
  outline: none;
}
.icon-btn-sm {
  background: var(--surface);
  border: 1px solid var(--border);
  border-radius: 7px;
  width: 28px;
  height: 28px;
  display: flex;
  align-items: center;
  justify-content: center;
  cursor: pointer;
  color: var(--text-muted);
  transition: background .15s;
}
.icon-btn-sm:hover { background: var(--surface); }
.icon-btn-sm .material-symbols-rounded { font-size: 16px; }

.data-table {
  width: 100%;
  border-collapse: collapse;
  font-size: 13px;
}
.data-table thead th {
  padding: 12px 16px;
  font-size: 11px;
  font-weight: 800;
  text-transform: uppercase;
  letter-spacing: .8px;
  color: var(--text-primary);
  background: #f8fafc;
  border-bottom: 2px solid var(--border);
  text-align: left;
  white-space: nowrap;
}
.data-table td {
  padding: 12px 16px;
  border-bottom: 1px solid var(--border);
  vertical-align: middle;
  color: var(--text-primary);
  font-weight: 500;
  font-size: 13px;
}
.data-table tbody tr:last-child td { border-bottom: none; }
.data-table tbody tr { transition: background .12s; }
.data-table tbody tr:hover { background: var(--surface); }

/* ===== MEMBER CELL ===== */
.member-cell {
  display: flex;
  align-items: center;
  gap: 10px;
}
.avatar {
  width: 32px;
  height: 32px;
  border-radius: 8px;
  display: flex;
  align-items: center;
  justify-content: center;
  font-weight: 800;
  font-size: 11px;
  flex-shrink: 0;
  letter-spacing: .03em;
}
.av-green { background: #dcfce7; color: #14532d; }
.member-name { font-weight: 600; font-size: 13px; }
.member-id {
  color: var(--text-muted);
  font-size: 12px;
  font-family: 'Courier New', monospace;
}

/* ===== AMOUNTS & PILLS ===== */
.amount-green { color: var(--green); font-weight: 600; }
.amount-orange { color: #ea580c; font-weight: 600; }
.amount-muted { color: var(--text-muted); font-weight: 500; }

.pill {
  display: inline-block;
  padding: 3px 10px;
  border-radius: 99px;
  font-size: 11px;
  font-weight: 700;
  letter-spacing: .02em;
}
.pill-green { background: #dcfce7; color: #14532d; }

/* ===== ACTION BUTTONS ===== */
.action-cell { display: flex; gap: 6px; }
.act-btn {
  width: 30px;
  height: 30px;
  border-radius: 7px;
  border: 1px solid var(--border);
  background: var(--surface);
  cursor: pointer;
  display: flex;
  align-items: center;
  justify-content: center;
  transition: all .15s;
  color: var(--text-muted);
}
.act-btn .material-symbols-rounded { font-size: 16px; }
.act-btn.edit:hover { background: var(--green-light); color: var(--green); border-color: var(--green-mid); }
.act-btn.del:hover  { background: var(--red-light); color: var(--red); border-color: #fecaca; }

/* ===== TABLE FOOTER ===== */
.table-footer {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 12px 18px;
  border-top: 0.5px solid var(--border);
  background: var(--surface);
  flex-wrap: wrap;
  gap: 8px;
}
.table-footer > p {
  font-size: 11px;
  color: var(--text-muted);
}
.pagination { display: flex; gap: 4px; }
.pg-btn {
  width: 30px;
  height: 30px;
  border-radius: 7px;
  border: 1px solid var(--border);
  background: var(--surface);
  cursor: pointer;
  font-size: 12px;
  font-weight: 600;
  color: var(--text-muted);
  font-family: inherit;
  transition: all .15s;
}
.pg-btn:hover { background: var(--bg); }
.pg-btn.active {
  background: var(--green);
  color: #fff;
  border-color: var(--green);
}

/* ===== STATS ROW ===== */
.stats-row {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 12px;
  margin-bottom: 4px;
}
@media (max-width: 1024px) {
  .stats-row { grid-template-columns: repeat(2, 1fr); }
}
@media (max-width: 640px) {
  .stats-row { grid-template-columns: 1fr; }
}
.stat-card {
  background: var(--surface);
  border: 1px solid var(--border);
  border-radius: 16px;
  padding: 12px 16px;
  display: flex;
  align-items: center;
  gap: 12px;
  box-shadow: var(--shadow);
}
.stat-icon {
  width: 40px;
  height: 40px;
  border-radius: 10px;
  display: flex;
  align-items: center;
  justify-content: center;
}
.stat-info {
  display: flex;
  flex-direction: column;
}
.stat-label {
  font-size: 11px;
  font-weight: 700;
  color: var(--text-muted);
  text-transform: uppercase;
  letter-spacing: .05em;
  margin-bottom: 2px;
}
.stat-value {
  font-size: 20px;
  font-weight: 800;
  color: var(--text-primary);
  line-height: 1.1;
}
.stat-trend {
  font-size: 11px;
  font-weight: 600;
  margin-top: 4px;
  display: flex;
  align-items: center;
  gap: 4px;
}
.trend-up { color: var(--green); }
</style>
@endpush

@section('content')

    <!-- Page Header -->
    <div class="page-header">
      <div>
        <h2>Dashboard Admin</h2>
        <p>Ringkasan manajemen data dan performa koperasi</p>
      </div>
      <div class="header-actions">
        <button class="btn btn-outline">
          <span class="material-symbols-rounded" style="font-size:15px;">download</span>
          Export PDF
        </button>
        <button class="btn btn-primary" onclick="location.reload()">
          <span class="material-symbols-rounded" style="font-size:15px;">refresh</span>
          Refresh Data
        </button>
      </div>
    </div>

    <!-- Stats Row -->
    <div class="stats-row">
      <div class="stat-card">
        <div class="stat-icon" style="background:rgba(22,163,74,.1); color:var(--green);">
          <span class="material-symbols-rounded">group</span>
        </div>
        <div class="stat-info">
          <span class="stat-label">Total Anggota</span>
          <span class="stat-value">{{ number_format($totalAnggota, 0, ',', '.') }}</span>
          <span class="stat-trend trend-up">
            <span class="material-symbols-rounded" style="font-size:14px;">trending_up</span>
            Aktif & Terverifikasi
          </span>
        </div>
      </div>
      <div class="stat-card">
        <div class="stat-icon" style="background:rgba(22,163,74,.1); color:var(--green);">
          <span class="material-symbols-rounded">account_balance_wallet</span>
        </div>
        <div class="stat-info">
          <span class="stat-label">Total Simpanan</span>
          <span class="stat-value">Rp {{ number_format($totalSimpanan, 0, ',', '.') }}</span>
          <span class="stat-trend" style="color:var(--text-muted);">
            Saldo Keseluruhan
          </span>
        </div>
      </div>
      <div class="stat-card">
        <div class="stat-icon" style="background:rgba(234,88,12,.1); color:#ea580c;">
          <span class="material-symbols-rounded">payments</span>
        </div>
        <div class="stat-info">
          <span class="stat-label">Pinjaman Disetujui</span>
          <span class="stat-value">Rp {{ number_format($totalPinjaman, 0, ',', '.') }}</span>
          <span class="stat-trend" style="color:var(--text-muted);">
            Total Kredit Aktif
          </span>
        </div>
      </div>
    </div>

    <!-- Bento: Import + Form -->
    <div class="bento">

      <!-- Import Card -->
      <div class="card">
        <div class="card-header">
          <div class="card-title">
            <span class="material-symbols-rounded" style="color:var(--green)">upload_file</span>
            Import Data Anggota
          </div>
          <span class="badge">XLSX / CSV</span>
        </div>
        <form action="{{ route('admin.import.process') }}" method="POST" enctype="multipart/form-data">
          @csrf
          <input type="hidden" name="type" value="anggota">
          <input type="file" id="importFile" name="file" class="hidden" accept=".xlsx,.xls,.csv" onchange="this.form.submit()">
          
          <div class="import-body">
            <div class="drop-zone" onclick="document.getElementById('importFile').click()">
              <span class="material-symbols-rounded">cloud_upload</span>
              <p>Seret file atau klik untuk upload</p>
              <button type="button" class="btn-upload">Upload Excel</button>
            </div>
            <div class="preview-wrap">
              <p class="preview-label">Preview Data</p>
              <table class="mini-table">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>No Anggota</th>
                    <th>Status</th>
                  </tr>
                </thead>
                <tbody>
                  @php $previewUsers = $users->take(3); @endphp
                  @forelse ($previewUsers as $previewUser)
                  <tr>
                    <td>{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</td>
                    <td class="name">{{ $previewUser->name }}</td>
                    <td>{{ $previewUser->no_anggota }}</td>
                    <td><span class="pill pill-green">Aktif</span></td>
                  </tr>
                  @empty
                  <tr>
                    <td colspan="4" style="text-align:center;color:var(--text-muted);padding:12px 0;">Belum ada data</td>
                  </tr>
                  @endforelse
                </tbody>
              </table>
            </div>
          </div>
          <div class="import-footer">
            <button type="submit" class="btn btn-dark">
              <span class="material-symbols-rounded" style="font-size:15px;">database</span>
              Simpan ke Database
            </button>
          </div>
        </form>
      </div>

      <!-- Form Card -->
      <div class="card">
        <div class="card-header">
          <div class="card-title">
            <span class="material-symbols-rounded" style="color:#ea580c">person_add</span>
            Daftarkan Anggota Baru
          </div>
        </div>
        <div class="form-body">

          @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
          @endif
          @if(session('error'))
            <div class="alert alert-error">{{ session('error') }}</div>
          @endif

          <form action="{{ route('admin.members.store') }}" method="POST">
            @csrf

            <div>
              <label>Nama Lengkap</label>
              <input name="name" class="form-input" placeholder="Ahmad Subardjo" type="text" required
                     oninput="if(!document.getElementById('emailInput').dataset.modified){document.getElementById('emailInput').value=this.value.toLowerCase().replace(/[^a-z0-9]/g,'')+'@example.com';}"/>
            </div>

            <div class="form-row">
              <div>
                <label>Email</label>
                <input name="email" id="emailInput" class="form-input" placeholder="ahmad@example.com" type="email" required
                       oninput="this.dataset.modified=true;"
                       onblur="if(this.value&&!this.value.includes('@')){this.value+='@example.com';}"/>
              </div>
              <div>
                <label>Password</label>
                <input name="password" class="form-input" placeholder="Minimal 8 karakter" type="password" required/>
              </div>
            </div>

            <div class="form-row">
              <div>
                <label>No Anggota</label>
                <input name="no_anggota" class="form-input" placeholder="UG-XXXX" type="text" required/>
              </div>
              <div>
                <label>No HP</label>
                <input name="no_hp" class="form-input" placeholder="0812..." type="text" required/>
              </div>
            </div>

            <div>
              <label>Alamat</label>
              <textarea name="alamat" class="form-input" placeholder="Jl. Raya Koperasi No. 1..." rows="2" required></textarea>
            </div>

            <button class="btn-register" type="submit">Daftarkan Anggota</button>
          </form>
        </div>
      </div>

    </div><!-- /bento -->

    <!-- Data Table -->
    <div class="card table-card" style="background: var(--surface) !important;">
      <div class="table-toolbar">
        <div class="table-toolbar-left">
          <h3>Daftar Anggota Aktif</h3>
          <p>Total {{ $totalAnggota }} anggota terdaftar</p>
        </div>
        <div class="table-toolbar-right">
          <select class="filter-select">
            <option>Semua Status</option>
            <option>Aktif</option>
            <option>Tidak Aktif</option>
          </select>
          <button class="icon-btn-sm">
            <span class="material-symbols-rounded">more_vert</span>
          </button>
        </div>
      </div>

      <div style="overflow-x:auto;">
        <table class="data-table">
          <thead>
            <tr>
              <th>Anggota</th>
              <th>No Anggota</th>
              <th>Simpanan</th>
              <th>Pinjaman</th>
              <th>Status</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            @php $topUsers = $users->take(10); @endphp
            @forelse ($topUsers as $usr)
            <tr>
              <td>
                <div class="member-cell">
                  @php
                    $initials = collect(explode(' ', $usr->name))
                      ->map(fn($w) => strtoupper(substr($w, 0, 1)))
                      ->take(2)->implode('');
                  @endphp
                  <div class="avatar av-green">{{ $initials }}</div>
                  <div class="member-name">{{ $usr->name }}</div>
                </div>
              </td>
              <td class="member-id">{{ $usr->no_anggota }}</td>
              <td>
                <span class="amount-green">
                  Rp {{ number_format($usr->simpanans->sum('jumlah'), 0, ',', '.') }}
                </span>
              </td>
              <td>
                <span class="{{ $usr->pinjamans->sum('jumlah_pinjaman') > 0 ? 'amount-orange' : 'amount-muted' }}">
                  Rp {{ number_format($usr->pinjamans->sum('jumlah_pinjaman'), 0, ',', '.') }}
                </span>
              </td>
              <td><span class="pill pill-green">Aktif</span></td>
              <td>
                <div class="action-cell">
                  <button class="act-btn edit" title="Edit">
                    <span class="material-symbols-rounded">edit</span>
                  </button>
                  <form action="{{ route('admin.members.destroy', $usr->id) }}" method="POST"
                        onsubmit="return confirm('Yakin ingin menghapus anggota ini? Semua data terkait (simpanan, pinjaman) juga akan dihapus.')"
                        style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="act-btn del" title="Hapus">
                      <span class="material-symbols-rounded">delete</span>
                    </button>
                  </form>
                </div>
              </td>
            </tr>
            @empty
            <tr>
              <td colspan="6" style="text-align:center;padding:28px;color:var(--text-muted);">
                Belum ada anggota yang terdaftar
              </td>
            </tr>
            @endforelse
          </tbody>
        </table>
      </div>

      <div class="table-footer">
        <p>Menampilkan {{ min(10, $totalAnggota) }} dari {{ $totalAnggota }} anggota</p>
        <div class="pagination">
          @if($totalAnggota > 10)
            <a href="{{ route('admin.dataAnggota') }}" class="btn btn-outline" style="padding: 4px 12px; font-size: 11px;">
              Lihat Semua <span class="material-symbols-rounded" style="font-size:14px;">arrow_forward</span>
            </a>
          @else
            <button class="pg-btn active">1</button>
          @endif
        </div>
      </div>
    </div>

@endsection