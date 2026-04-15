<!DOCTYPE html>
<html lang="id" data-theme="light">
<head>
  <meta charset="utf-8"/>
  <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Edit Tabel — Koperasi Ugoro</title>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet"/>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200"/>
  @include('admin.partials.layout_styles')
  @include('admin.partials.theme')

  <style>
    /* ══════════════════════════════════════════
       Page Layout
    ══════════════════════════════════════════ */
    .canvas { padding: 18px 26px; max-width: 1540px; margin: 0 auto; }
    .page-header { display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 18px; flex-wrap: wrap; gap: 13px; }
    .page-header h2 { font-size: var(--fs-h2); font-weight: 800; color: var(--text-primary); letter-spacing: -0.4px; }
    .page-header p { font-size: var(--fs-md); color: var(--text-muted); margin-top: 2px; }
    .breadcrumb { display: flex; align-items: center; gap: 6px; font-size: var(--fs-sm); margin-bottom: 4px; color: var(--text-muted); }
    .breadcrumb a { color: var(--green); text-decoration: none; font-weight: 600; }
    .breadcrumb a:hover { text-decoration: underline; }

    /* ══════════════════════════════════════════
       Spreadsheet Editor
    ══════════════════════════════════════════ */
    .ss-card { background: var(--surface); border: 1px solid var(--border); border-radius: 14px; box-shadow: var(--shadow); overflow: hidden; }
    .ss-toolbar {
      padding: 14px 18px; border-bottom: 1px solid var(--border); display: flex;
      align-items: center; justify-content: space-between; gap: 10px; flex-wrap: wrap; background: var(--bg);
    }
    .ss-toolbar-left { display: flex; align-items: center; gap: 12px; }
    .ss-toolbar-right { display: flex; align-items: center; gap: 8px; flex-wrap: wrap; }
    .ss-stat { font-size: var(--fs-sm); color: var(--text-muted); }
    .ss-stat strong { color: var(--text-primary); font-weight: 700; }

    .ss-wrap { overflow: auto; max-height: 65vh; position: relative; }
    .ss-table { width: 100%; border-collapse: collapse; font-size: var(--fs-sm); }
    .ss-table thead th {
      position: sticky; top: 0; z-index: 10; padding: 10px 12px;
      font-size: 11px; font-weight: 700; text-transform: uppercase;
      letter-spacing: 0.5px; color: var(--text-muted); background: var(--surface);
      border-bottom: 2px solid var(--border); white-space: nowrap; text-align: left;
    }
    .ss-table thead th.num { text-align: right; }
    .ss-table tbody td { padding: 6px 8px; border-bottom: 1px solid var(--border); vertical-align: middle; }
    .ss-table tbody tr:hover td { background: var(--bg); }

    .ss-table .row-num {
      width: 45px; text-align: center; font-size: 11px; color: var(--text-muted);
      background: var(--bg); border-right: 1px solid var(--border); font-weight: 600; padding: 6px 4px;
    }

    .ss-input {
      width: 100%; border: 1.5px solid transparent; background: transparent;
      padding: 6px 8px; border-radius: 5px; font-size: 13px; color: var(--text-primary);
      font-family: inherit; transition: all .15s; outline: none;
    }
    .ss-input:focus { border-color: var(--green); background: var(--surface); box-shadow: 0 0 0 3px rgba(22,163,74,.12); }
    .ss-input.num { text-align: right; font-variant-numeric: tabular-nums; }
    .ss-input.error { border-color: var(--red); background: var(--red-light); }

    .ss-cell-action { text-align: center; width: 45px; }
    .btn-del-row {
      padding: 4px 6px; border-radius: 4px; border: none; background: none;
      color: var(--text-muted); cursor: pointer; transition: all .15s; display: inline-flex;
    }
    .btn-del-row:hover { background: var(--red-light); color: var(--red); }

    .ss-footer {
      padding: 14px 18px; border-top: 1px solid var(--border); background: var(--bg);
      display: flex; align-items: center; justify-content: space-between; gap: 10px; flex-wrap: wrap;
    }

    /* ── Error tooltip ── */
    .ss-error-tip {
      font-size: 9px; color: var(--red); font-weight: 600; margin-top: 1px;
      display: none; padding: 0 8px;
    }
    .ss-input.error + .ss-error-tip { display: block; }

    /* ══════════════════════════════════════════
       Buttons
    ══════════════════════════════════════════ */
    .btn { display: inline-flex; align-items: center; gap: 6px; padding: 9px 15px; border-radius: 9px; border: 1px solid var(--border); background: var(--surface); font-size: var(--fs-md); font-weight: 600; color: var(--text-primary); cursor: pointer; font-family: inherit; transition: all .15s; text-decoration: none; }
    .btn:hover { background: var(--bg); }
    .btn .material-symbols-rounded { font-size: 18px; }
    .btn-sm { padding: 7px 11px; font-size: var(--fs-sm); }
    .btn-primary { background: var(--green); border-color: var(--green); color: #fff; }
    .btn-primary:hover { background: #15803d; border-color: #15803d; }
    .btn-primary:disabled { opacity: 0.5; cursor: not-allowed; }
    .btn-danger { background: transparent; border-color: #fca5a5; color: var(--red); }
    .btn-danger:hover { background: #fef2f2; }

    .button-group { display: flex; gap: 8px; flex-wrap: wrap; }

    /* ══════════════════════════════════════════
       Flash & Toast
    ══════════════════════════════════════════ */
    .flash { display: flex; align-items: flex-start; gap: 10px; padding: 12px 14px; border-radius: 8px; margin-bottom: 0.75rem; font-size: 12px; }
    .flash-success { background: var(--green-light); color: var(--green); border: 1px solid var(--green); }
    .flash-error { background: var(--red-light); color: var(--red); border: 1px solid var(--red); }
    #toast { position: fixed; bottom: 20px; right: 20px; background: var(--text-primary); color: var(--surface); border-radius: 8px; padding: 10px 14px; font-size: var(--fs-md); font-weight: 500; display: flex; align-items: center; gap: 6px; opacity: 0; transform: translateY(10px); transition: all .3s ease; z-index: 9998; max-width: 360px; box-shadow: var(--shadow); }
    #toast.visible { opacity: 1; transform: translateY(0); }

    @media (max-width: 768px) {
      .canvas { padding: 14px; }
      .ss-wrap { max-height: 50vh; }
      .ss-toolbar, .ss-footer { flex-direction: column; align-items: stretch; }
      .ss-toolbar-left, .ss-toolbar-right { justify-content: space-between; }
    }
  </style>
</head>
<body>

@include('admin.partials.sidebar')

<main>
  <header>
    <span class="topbar-title">Edit Tabel Data</span>
    <div class="topbar-right">
      <button class="icon-btn" title="Toggle Tema" onclick="toggleTheme()">
        <span class="material-symbols-rounded">contrast</span>
      </button>
      <div class="divider-v"></div>
      <div class="user-chip">
        <div>
          <div class="name">{{ auth()->user()->name ?? 'Admin' }}</div>
          <div class="role">Super Admin</div>
        </div>
        <img alt="Admin" src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name ?? 'Admin') }}&background=dcfce7&color=16a34a&bold=true&size=64"/>
      </div>
    </div>
  </header>

  <div class="canvas">
    <!-- ══════════════ PAGE HEADER ══════════════ -->
    <div class="page-header">
      <div>
        <div class="breadcrumb">
          <a href="{{ route('admin.dashboard') }}">Dashboard</a>
          <span class="material-symbols-rounded" style="font-size:11px;">chevron_right</span>
          <a href="{{ route('admin.import') }}">Import Data</a>
          <span class="material-symbols-rounded" style="font-size:11px;">chevron_right</span>
          <span>Edit Tabel</span>
        </div>
        <h2>Edit Tabel Data Anggota</h2>
        <p>Tambah, hapus, atau edit data secara langsung seperti spreadsheet</p>
      </div>
    </div>

    <!-- ══════════════ FLASH MESSAGES ══════════════ -->
    @if(session('success'))
    <div class="flash flash-success">
      <span class="material-symbols-rounded">check_circle</span>
      <div><div style="font-weight:700;">Berhasil!</div><div style="margin-top:2px;">{{ session('success') }}</div></div>
    </div>
    @endif
    @if(session('error'))
    <div class="flash flash-error">
      <span class="material-symbols-rounded">error</span>
      <div><div style="font-weight:700;">Gagal</div><div style="margin-top:2px;">{{ session('error') }}</div></div>
    </div>
    @endif

    <!-- ══════════════ SPREADSHEET EDITOR ══════════════ -->
    <div class="ss-card">
      <!-- TOOLBAR -->
      <div class="ss-toolbar">
        <div class="ss-toolbar-left">
          <span class="material-symbols-rounded" style="color:var(--green);font-size:20px;">grid_on</span>
          <span style="font-weight:800; font-size:var(--fs-base); color:var(--text-primary);">Spreadsheet Editor</span>
          <span class="ss-stat">Baris: <strong id="ssRowCount">0</strong></span>
          <span class="ss-stat" id="ssErrorStat" style="display:none;">Error: <strong style="color:var(--red);" id="ssErrorCount">0</strong></span>
        </div>
        <div class="ss-toolbar-right">
          <button class="btn btn-sm" onclick="ssAddRow()" title="Tambah baris baru">
            <span class="material-symbols-rounded">add</span> Tambah Baris
          </button>
          <button class="btn btn-sm btn-danger" onclick="ssClearAll()" title="Hapus semua baris">
            <span class="material-symbols-rounded">delete_sweep</span> Hapus Semua
          </button>
        </div>
      </div>

      <!-- TABLE -->
      <div class="ss-wrap">
        <table class="ss-table" id="ssTable">
          <thead>
            <tr>
              <th style="width:45px; text-align:center;">#</th>
              <th style="min-width:120px;">NIA (No Anggota)</th>
              <th style="min-width:180px;">Nama Anggota</th>
              <th class="num" style="min-width:110px;">S. Pokok</th>
              <th class="num" style="min-width:110px;">S. Wajib</th>
              <th class="num" style="min-width:110px;">Monosuko</th>
              <th class="num" style="min-width:110px;">DPU</th>
              <th style="width:45px; text-align:center;">×</th>
            </tr>
          </thead>
          <tbody id="ssBody"></tbody>
        </table>
      </div>

      <!-- FOOTER -->
      <div class="ss-footer">
        <div class="button-group">
          <button class="btn btn-sm" onclick="ssAddRow()"><span class="material-symbols-rounded">add</span> Tambah Baris</button>
          <button class="btn btn-sm" onclick="ssAdd5Rows()"><span class="material-symbols-rounded">playlist_add</span> +5 Baris</button>
        </div>
        <div class="button-group">
          <a href="{{ route('admin.import') }}" class="btn btn-sm">
            <span class="material-symbols-rounded">arrow_back</span> Kembali
          </a>
          <button class="btn btn-sm btn-primary" id="btnSaveDraft" onclick="ssSaveDraft()" disabled>
            <span class="material-symbols-rounded">save</span>
            <span id="btnSaveDraftLabel">Simpan ke Draft</span>
          </button>
        </div>
      </div>
    </div>
  </div>
</main>

<!-- TOAST NOTIFICATION -->
<div id="toast">
  <span class="material-symbols-rounded" id="toastIcon">check_circle</span>
  <span id="toastMsg">Berhasil!</span>
</div>

<script>
/* ════════════════════════════════════════════════════════════
   SPREADSHEET EDITOR — Core Logic
════════════════════════════════════════════════════════════ */
let ssRowId = 0;

// Load data dari sessionStorage jika ada (dari import.blade.php)
window.addEventListener('load', function() {
  const importedData = sessionStorage.getItem('importData');
  if (importedData) {
    const rows = JSON.parse(importedData);
    rows.forEach(row => ssAddRow(row));
    sessionStorage.removeItem('importData');
  }
});

function ssCreateRowHTML(data = {}) {
  const id = ssRowId++;
  const nia = data.nia || '';
  const name = data.name || '';
  const pokok = data.pokok || '';
  const wajib = data.wajib || '';
  const monosuko = data.monosuko || '';
  const dpu = data.dpu || '';

  return `<tr id="ssr-${id}" data-id="${id}">
    <td class="row-num">${id + 1}</td>
    <td><input class="ss-input" data-field="nia" value="${escHtml(nia)}" placeholder="UG-001" oninput="ssValidateRow(this)"><div class="ss-error-tip"></div></td>
    <td><input class="ss-input" data-field="name" value="${escHtml(name)}" placeholder="Nama Lengkap" oninput="ssValidateRow(this)"><div class="ss-error-tip"></div></td>
    <td><input class="ss-input num" data-field="pokok" value="${pokok}" placeholder="0"></td>
    <td><input class="ss-input num" data-field="wajib" value="${wajib}" placeholder="0"></td>
    <td><input class="ss-input num" data-field="monosuko" value="${monosuko}" placeholder="0"></td>
    <td><input class="ss-input num" data-field="dpu" value="${dpu}" placeholder="0"></td>
    <td class="ss-cell-action"><button class="btn-del-row" onclick="ssDeleteRow(${id})" title="Hapus baris"><span class="material-symbols-rounded" style="font-size:16px;">close</span></button></td>
  </tr>`;
}

function escHtml(s) {
  const d = document.createElement('div');
  d.textContent = s;
  return d.innerHTML;
}

function ssAddRow(data = {}) {
  document.getElementById('ssBody').insertAdjacentHTML('beforeend', ssCreateRowHTML(data));
  ssUpdateStats();
  
  // Focus the first input of the new row
  const rows = document.querySelectorAll('#ssBody tr');
  const lastRow = rows[rows.length - 1];
  if (lastRow) lastRow.querySelector('.ss-input')?.focus();
}

function ssAdd5Rows() {
  for (let i = 0; i < 5; i++) ssAddRow();
}

function ssDeleteRow(id) {
  const row = document.getElementById('ssr-' + id);
  if (row) {
    row.style.opacity = '0';
    row.style.transform = 'translateX(-20px)';
    row.style.transition = 'all .2s';
    setTimeout(() => {
      row.remove();
      ssReindex();
      ssUpdateStats();
    }, 200);
  }
}

function ssClearAll() {
  if (!confirm('Hapus semua baris dari spreadsheet?')) return;
  document.getElementById('ssBody').innerHTML = '';
  ssRowId = 0;
  ssUpdateStats();
}

function ssReindex() {
  document.querySelectorAll('#ssBody tr').forEach((tr, i) => {
    tr.querySelector('.row-num').textContent = i + 1;
  });
}

function ssUpdateStats() {
  const rows = document.querySelectorAll('#ssBody tr');
  document.getElementById('ssRowCount').textContent = rows.length;
  let errors = 0;
  rows.forEach(tr => {
    tr.querySelectorAll('.ss-input.error').forEach(() => errors++);
  });
  const errStat = document.getElementById('ssErrorStat');
  if (errors > 0) {
    errStat.style.display = 'inline';
    document.getElementById('ssErrorCount').textContent = errors;
  } else {
    errStat.style.display = 'none';
  }
  document.getElementById('btnSaveDraft').disabled = rows.length === 0;
}

function ssValidateRow(input) {
  const field = input.dataset.field;
  const val = input.value.trim();
  const tip = input.nextElementSibling;
  
  if ((field === 'nia' || field === 'name') && val === '') {
    input.classList.add('error');
    if (tip) {
      tip.textContent = field === 'nia' ? 'NIA wajib diisi' : 'Nama wajib diisi';
      tip.style.display = 'block';
    }
  } else {
    input.classList.remove('error');
    if (tip) {
      tip.textContent = '';
      tip.style.display = 'none';
    }
  }
  ssUpdateStats();
}

function ssGetAllRows() {
  const rows = [];
  document.querySelectorAll('#ssBody tr').forEach(tr => {
    const inputs = tr.querySelectorAll('.ss-input');
    const nia = inputs[0]?.value.trim();
    const name = inputs[1]?.value.trim();
    
    // Hanya push jika NIA dan Nama tidak kosong
    if (!nia || !name) return;
    
    rows.push({
      nia, name,
      pokok: parseInt(inputs[2]?.value) || 0,
      wajib: parseInt(inputs[3]?.value) || 0,
      monosuko: parseInt(inputs[4]?.value) || 0,
      dpu: parseInt(inputs[5]?.value) || 0,
    });
  });
  return rows;
}

/* ════════════════════════════════════════════════════════════
   SAVE DRAFT VIA AJAX
════════════════════════════════════════════════════════════ */
function ssSaveDraft() {
  const rows = ssGetAllRows();
  if (rows.length === 0) {
    showToast('Tidak ada data valid untuk disimpan.', true);
    return;
  }
  
  const btn = document.getElementById('btnSaveDraft');
  btn.disabled = true;
  document.getElementById('btnSaveDraftLabel').textContent = 'Menyimpan...';

  fetch('{{ route("admin.drafts.storeManual") }}', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
      'Accept': 'application/json',
      'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content
    },
    body: JSON.stringify({ rows })
  }).then(r => r.json()).then(res => {
    if (res.success) {
      showToast('Draft berhasil disimpan! (' + rows.length + ' baris)');
      setTimeout(() => window.location.href = '{{ route("admin.import") }}', 1200);
    } else {
      showToast('Gagal menyimpan draft.', true);
    }
  }).catch(err => {
    console.error(err);
    showToast('Terjadi kesalahan jaringan.', true);
  }).finally(() => {
    btn.disabled = false;
    document.getElementById('btnSaveDraftLabel').textContent = 'Simpan ke Draft';
  });
}

/* ════════════════════════════════════════════════════════════
   UTILITIES
════════════════════════════════════════════════════════════ */
function showToast(msg, isError = false) {
  const toast = document.getElementById('toast');
  const icon = document.getElementById('toastIcon');
  const msgEl = document.getElementById('toastMsg');
  
  icon.textContent = isError ? 'error' : 'check_circle';
  msgEl.textContent = msg;
  toast.classList.add('visible');
  
  setTimeout(() => toast.classList.remove('visible'), 3000);
}

// Initialize with at least one empty row
window.addEventListener('load', function() {
  if (document.querySelectorAll('#ssBody tr').length === 0) {
    ssAddRow();
  }
});
</script>

</body>
</html>
