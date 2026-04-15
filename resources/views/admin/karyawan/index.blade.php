<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>Admin - Manajemen Struktur — Koperasi Ugoro</title>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet"/>
@include('admin.partials.layout_styles')
@include('admin.partials.theme')

<style>
  *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

  :root {
    --green: #16a34a;
    --green-light: #dcfce7;
    --green-mid: #86efac;
    --red: #dc2626;
    --red-light: #fee2e2;
    --red-mid: #fca5a5;
    --bg: #f5f5f3;
    --surface: #ffffff;
    --surface-2: #f9f9f8;
    --border: rgba(0,0,0,.08);
    --text-primary: #111;
    --text-secondary: #6b7280;
    --text-muted: #9ca3af;
  }

  /* ── Main layout ── */

  header {
    height: 44px;
    background: var(--surface);
    border-bottom: 1px solid var(--border);
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 0 20px;
    position: sticky;
    top: 0;
    z-index: 40;
  }

  .topbar-right { display: flex; align-items: center; gap: 4px; }
  .icon-btn {
    width: 32px; height: 32px; display: flex; align-items: center; justify-content: center;
    border-radius: 8px; border: none; background: none;
    color: var(--text-secondary); cursor: pointer; transition: background .15s;
  }
  .icon-btn:hover { background: var(--bg); color: var(--text-primary); }
  .divider-v { width: 1px; height: 20px; background: var(--border); margin: 0 4px; }
  .user-chip {
    display: flex; align-items: center; gap: 8px;
    padding: 4px 4px 4px 10px;
    border: 1px solid var(--border);
    border-radius: 40px;
    cursor: pointer;
    transition: background .15s;
    background: var(--bg);
  }
  .user-chip:hover { border-color: var(--green-mid); }
  .user-chip .name { font-size: 11px; font-weight: 700; color: var(--text-primary); line-height: 1.1; }
  .user-chip .role { font-size: 9px; font-weight: 600; color: var(--green); text-transform: uppercase; letter-spacing: .4px; }
  .user-chip img {
    width: 26px; height: 26px;
    border-radius: 50%;
    object-fit: cover;
    border: 1px solid var(--border);
  }

  /* ── Canvas ── */
  .canvas {
    padding: 24px;
    display: flex;
    flex-direction: column;
    gap: 20px;
    max-width: 1400px;
    width: 100%;
    margin: 0 auto;
  }

  /* ── Alert ── */
  .alert {
    display: flex; align-items: center; gap: 8px;
    padding: 10px 14px; border-radius: 10px;
    font-weight: 600; font-size: 12px;
  }
  .alert-success {
    background: var(--green-light);
    border: 1px solid var(--green-mid);
    color: var(--green);
  }

  /* ── Page header ── */
  .page-top {
    display: flex; align-items: center; justify-content: space-between;
    gap: 16px; margin-bottom: 4px;
  }
  .page-title { font-size: 22px; font-weight: 800; color: var(--text-primary); letter-spacing: -.5px; }
  .page-sub { font-size: 12px; color: var(--text-muted); font-weight: 500; margin-top: 2px; }

  /* ── Buttons ── */
  .btn {
    display: inline-flex; align-items: center; gap: 8px;
    padding: 8px 16px; border-radius: 10px;
    font-size: 13px; font-weight: 700;
    cursor: pointer; border: none; transition: all .2s;
    font-family: inherit; text-decoration: none; white-space: nowrap;
  }
  .btn-primary { background: var(--green); color: #fff; box-shadow: 0 4px 12px rgba(22,163,74,.2); }
  .btn-primary:hover { background: #15803d; transform: translateY(-1px); }

  /* ── Card ── */
  .card {
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: 16px;
    box-shadow: var(--shadow);
    overflow: hidden;
  }

  /* ── Toolbar ── */
  .toolbar {
    padding: 16px 20px;
    border-bottom: 1px solid var(--border);
    display: flex; align-items: center; justify-content: space-between;
    gap: 12px; flex-wrap: wrap;
  }
  .toolbar-title { font-size: 14px; font-weight: 700; color: var(--text-primary); }

  .search-wrap {
    display: flex; align-items: center; gap: 8px;
    background: var(--bg); border: 1px solid var(--border);
    border-radius: 8px; padding: 6px 12px;
  }
  .search-wrap input {
    border: none; background: transparent;
    font-size: 13px; outline: none; color: var(--text-primary);
    font-family: inherit; width: 200px;
  }
  .search-wrap input::placeholder { color: var(--text-muted); }

  /* ── Table ── */
  .tbl-wrap { overflow-x: auto; }
  table { width: 100%; border-collapse: collapse; min-width: 620px; }
  thead tr { background: var(--bg); }
  th {
    padding: 12px 20px;
    font-size: 11px; font-weight: 800;
    text-transform: uppercase; color: var(--text-primary);
    background: #f8fafc;
    letter-spacing: .8px; text-align: left;
    border-bottom: 2px solid var(--border);
  }
  td {
    padding: 14px 20px;
    border-bottom: 1px solid var(--border);
    font-size: 13px; vertical-align: middle; color: var(--text-primary);
    font-weight: 500;
  }
  tbody tr:last-child td { border-bottom: none; }
  tbody tr:hover { background: var(--bg); }

  /* ── Avatar ── */
  .avatar {
    width: 36px; height: 36px; border-radius: 8px;
    object-fit: cover; display: block; border: 1px solid var(--border);
  }
  .avatar-fallback {
    width: 36px; height: 36px; border-radius: 8px;
    display: flex; align-items: center; justify-content: center;
    font-size: 12px; font-weight: 800; background: var(--bg);
    color: var(--text-secondary); border: 1px solid var(--border);
  }

  /* ── Name cell ── */
  .name-cell { font-weight: 700; font-size: 13px; color: var(--text-primary); }
  .pos-cell { font-size: 11px; color: var(--text-muted); margin-top: 1px; }

  /* ── Type pill ── */
  .type-pill {
    display: inline-block; font-size: 9px; font-weight: 700;
    padding: 3px 8px; border-radius: 6px;
    background: var(--bg); color: var(--text-secondary);
    border: 1px solid var(--border); white-space: nowrap;
  }

  /* ── Status badge ── */
  .badge {
    display: inline-flex; align-items: center; gap: 4px;
    font-size: 10px; font-weight: 800; text-transform: uppercase;
    padding: 4px 10px; border-radius: 99px;
    letter-spacing: .3px; white-space: nowrap;
  }
  .badge-aktif { background: var(--green-light); color: var(--green); border: 1px solid var(--green-mid); }
  .badge-nonaktif { background: var(--red-light); color: var(--red); border: 1px solid var(--red-mid); }

  /* ── Mono / order ── */
  .mono { font-family: monospace; font-size: 11px; color: var(--text-muted); }
  .order-num { font-weight: 700; font-size: 11px; color: var(--text-muted); }

  /* ── Action buttons ── */
  .actions { display: flex; gap: 4px; }
  .act {
    width: 30px; height: 30px;
    display: flex; align-items: center; justify-content: center;
    border-radius: 7px; border: none; background: transparent;
    cursor: pointer; color: var(--text-muted); transition: all .15s;
  }
  .act:hover.edit { background: var(--bg); color: var(--text-primary); }
  .act:hover.del  { background: var(--red-light); color: var(--red); }

  /* ── Table footer ── */
  .tbl-footer {
    padding: 12px 20px;
    border-top: 1px solid var(--border);
    display: flex; align-items: center; justify-content: space-between;
    flex-wrap: wrap; gap: 8px; background: var(--bg);
  }
  [data-theme="dark"] .tbl-footer { background: #1e293b; }
  .tbl-info { font-size: 11px; color: var(--text-muted); font-weight: 500; }

  .pgn { display: flex; gap: 4px; }
  .pg-btn {
    padding: 5px 12px; border-radius: 6px;
    border: 1px solid var(--border); background: var(--surface);
    cursor: pointer; font-size: 12px; font-weight: 600;
    color: var(--text-secondary); transition: all .15s;
    font-family: inherit; display: flex; align-items: center; justify-content: center;
  }
  .pg-btn:hover:not(:disabled) { background: var(--bg); }
  .pg-btn.active { background: var(--green); color: #fff; border-color: var(--green); }
  .pg-btn:disabled { opacity: .45; cursor: not-allowed; }
</style>
@include('admin.partials.theme')
</head>
<body>

@include('admin.partials.sidebar')

<main>
  <header>
    <div class="header-logo">MANAJEMEN STRUKTUR</div>
    <div class="topbar-right">
      <button class="icon-btn" title="Toggle Tema" onclick="toggleTheme()">
        <span class="material-symbols-rounded">contrast</span>
      </button>
      <button class="icon-btn"><span class="material-symbols-rounded">notifications</span></button>
      <div class="divider-v"></div>
      <div class="user-chip">
        <div>
          <div class="name">{{ auth()->user()->name ?? 'Admin Ugoro' }}</div>
          <div class="role">Super Admin</div>
        </div>
        <img alt="Admin" src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name ?? 'Admin+Ugoro') }}&background=dcfce7&color=16a34a&bold=true&size=64"/>
      </div>
    </div>
  </header>

  <div class="canvas">

    {{-- ── Flash message ── --}}
    @if(session('success'))
      <div class="alert alert-success">
        <span class="ms-rounded">check_circle</span>
        {{ session('success') }}
      </div>
    @endif

    {{-- ── Page header ── --}}
    <div class="page-top">
      <div>
        <div class="page-title">Manajemen Struktur Pegawai</div>
        <div class="page-sub">Kelola data pengurus, pengawas, dan karyawan koperasi</div>
      </div>
      <a href="{{ route('karyawans.create') }}" class="btn btn-primary">
        <span class="ms-rounded">person_add</span>
        Tambah Anggota
      </a>
    </div>

    {{-- ── Table card ── --}}
    <div class="card" style="background: #ffffff !important;">

      {{-- Toolbar --}}
      <div class="toolbar">
        <span class="toolbar-title">Daftar Struktur</span>
        <div class="search-wrap">
          <span class="ms-rounded" style="color:var(--text-muted);">search</span>
          <input type="text" id="searchInput" placeholder="Cari nama atau jabatan…" oninput="filterTable()" />
        </div>
      </div>

      {{-- Table --}}
      <div class="tbl-wrap">
        <table id="strukturTable">
          <thead>
            <tr>
              <th>Foto</th>
              <th>Nama &amp; Jabatan</th>
              <th>Tipe</th>
              <th>NIP / ID</th>
              <th>Status</th>
              <th>Urutan</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            @foreach($karyawans as $k)
            <tr>
              {{-- Foto --}}
              <td>
                @if($k->photo)
                  <img class="avatar" src="{{ asset('storage/' . $k->photo) }}" alt="Foto {{ $k->name }}">
                @else
                  <div class="avatar-fallback">
                    {{ strtoupper(substr($k->name, 0, 1)) }}{{ strtoupper(substr(strstr($k->name, ' ') ?: ' ', 1, 1)) }}
                  </div>
                @endif
              </td>

              {{-- Nama & Jabatan --}}
              <td>
                <div class="name-cell">{{ $k->name }}</div>
                <div class="pos-cell">{{ $k->position }}</div>
              </td>

              {{-- Tipe --}}
              <td>
                <span class="type-pill">{{ $k->type }}</span>
              </td>

              {{-- NIP --}}
              <td>
                <span class="mono">{{ $k->nip ?? '—' }}</span>
              </td>

              {{-- Status --}}
              <td>
                @php $s = strtolower($k->status); @endphp
                <span class="badge {{ $s === 'aktif' ? 'badge-aktif' : 'badge-nonaktif' }}">
                  {{ strtoupper($k->status) }}
                </span>
              </td>

              {{-- Urutan --}}
              <td>
                <span class="order-num">#{{ $k->order_num }}</span>
              </td>

              {{-- Aksi --}}
              <td>
                <div class="actions">
                  <a href="{{ route('karyawans.edit', $k->id) }}" class="act edit" title="Edit">
                    <span class="ms-rounded">edit</span>
                  </a>
                  <button type="button" class="act del js-univ-confirm" title="Hapus"
                    data-title="Hapus Data Pegawai?"
                    data-desc="Apakah Anda yakin ingin menghapus data <strong>{{ addslashes($k->name) }}</strong>? Tindakan ini tidak dapat dibatalkan."
                    data-action="{{ route('karyawans.destroy', $k->id) }}">
                    <span class="ms-rounded">delete</span>
                  </button>
                </div>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>

      {{-- Footer --}}
      <div class="tbl-footer">
        <span class="tbl-info" id="tableInfo">
          Menampilkan {{ $karyawans->count() }} data
        </span>
        @if(method_exists($karyawans, 'links'))
        <div class="pgn">
          {{ $karyawans->links() }}
        </div>
        @endif
      </div>

    </div>{{-- /.card --}}

  </div>{{-- /.canvas --}}
</main>

<script>
  function filterTable() {
    const q = document.getElementById('searchInput').value.toLowerCase();
    const rows = document.querySelectorAll('#strukturTable tbody tr');
    let visible = 0;
    rows.forEach(row => {
      const text = row.innerText.toLowerCase();
      const show = text.includes(q);
      row.style.display = show ? '' : 'none';
      if (show) visible++;
    });
    document.getElementById('tableInfo').textContent =
      'Menampilkan ' + visible + ' data' + (q ? ' (filter aktif)' : '');
  }
</script>

@include('admin.partials.confirm_modal')
@include('admin.partials.layout_scripts')
</body>
</html>
