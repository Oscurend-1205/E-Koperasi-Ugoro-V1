@extends('layouts.admin')

@section('title', 'Koperasi Ugoro — Spreadsheet Editor')

@push('styles')

  <style>
    /* ══════════════════════════════════════════
       Page Layout
    ══════════════════════════════════════════ */
    .canvas { padding: 24px 28px; max-width: 1540px; margin: 0 auto; }
    .page-header { display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 20px; flex-wrap: wrap; gap: 12px; }
    .page-header h2 { font-size: var(--fs-h2); font-weight: 800; color: var(--text-primary); letter-spacing: -0.5px; }
    .page-header p { font-size: var(--fs-md); color: var(--text-muted); margin-top: 2px; }
    .breadcrumb { display: flex; align-items: center; gap: 6px; font-size: var(--fs-sm); margin-bottom: 4px; color: var(--text-muted); }
    .breadcrumb a { color: var(--green); text-decoration: none; font-weight: 600; }
    .breadcrumb a:hover { text-decoration: underline; }

    /* ══════════════════════════════════════════
       Spreadsheet Editor Card
    ══════════════════════════════════════════ */
    .ss-card {
      background: var(--surface); border: 1px solid var(--border);
      border-radius: 16px; box-shadow: 0 4px 24px rgba(0,0,0,.06); overflow: hidden;
    }
    .ss-toolbar {
      padding: 14px 20px; border-bottom: 1px solid var(--border);
      display: flex; align-items: center; justify-content: space-between;
      gap: 10px; flex-wrap: wrap; background: var(--bg);
    }
    .ss-toolbar-left { display: flex; align-items: center; gap: 12px; }
    .ss-toolbar-right { display: flex; align-items: center; gap: 8px; }
    .ss-stat { font-size: var(--fs-sm); color: var(--text-muted); }
    .ss-stat strong { color: var(--text-primary); }

    .ss-wrap { overflow: auto; max-height: calc(100vh - 320px); position: relative; }
    .ss-table { width: 100%; border-collapse: collapse; font-size: var(--fs-sm); }
    .ss-table thead th {
      position: sticky; top: 0; z-index: 10; padding: 10px 14px;
      font-size: 10px; font-weight: 700; text-transform: uppercase;
      letter-spacing: .5px; color: var(--text-muted); background: var(--surface);
      border-bottom: 2px solid var(--border); white-space: nowrap; text-align: left;
    }
    .ss-table thead th.num { text-align: right; }
    .ss-table tbody td {
      padding: 3px 5px; border-bottom: 1px solid var(--border); vertical-align: middle;
    }
    .ss-table tbody tr:hover td { background: var(--bg); }
    .ss-table tbody tr.deleting { opacity: 0; transform: translateX(-20px); transition: all .25s ease; }

    .ss-table .row-num {
      width: 44px; text-align: center; font-size: 10px; color: var(--text-muted);
      background: var(--bg); border-right: 1px solid var(--border); font-weight: 700; padding: 8px 4px;
    }

    .ss-input {
      width: 100%; border: 1.5px solid transparent; background: transparent;
      padding: 8px 10px; border-radius: 6px; font-size: var(--fs-sm); color: var(--text-primary);
      font-family: inherit; transition: all .15s; outline: none;
    }
    .ss-input:focus { border-color: var(--green); background: var(--surface); box-shadow: 0 0 0 3px rgba(22,163,74,.12); }
    .ss-input.num { text-align: right; font-variant-numeric: tabular-nums; }
    .ss-input.error { border-color: var(--red); background: var(--red-light); }

    .ss-cell-action { text-align: center; width: 44px; }
    .btn-del-row {
      padding: 4px; border-radius: 6px; border: none; background: none;
      color: var(--text-muted); cursor: pointer; transition: all .15s; display: inline-flex;
    }
    .btn-del-row:hover { background: var(--red-light); color: var(--red); }

    .ss-footer {
      padding: 14px 20px; border-top: 1px solid var(--border); background: var(--bg);
      display: flex; align-items: center; justify-content: space-between; gap: 10px; flex-wrap: wrap;
    }

    /* ── Error tooltip ── */
    .ss-error-tip {
      font-size: 9px; color: var(--red); font-weight: 600; margin-top: 1px;
      display: none; padding: 0 10px;
    }
    .ss-input.error + .ss-error-tip { display: block; }

    /* ══════════════════════════════════════════
       Buttons
    ══════════════════════════════════════════ */
    .btn {
      display: inline-flex; align-items: center; gap: 7px; padding: 10px 18px;
      border-radius: 10px; border: 1.5px solid var(--border); background: var(--surface);
      font-size: 13px; font-weight: 700; color: var(--text-primary);
      cursor: pointer; font-family: inherit; transition: all .2s; text-decoration: none;
    }
    .btn:hover { background: var(--bg); }
    .btn .material-symbols-rounded { font-size: 16px; }
    .btn-sm { padding: 8px 14px; font-size: 12px; }
    .btn-primary { background: var(--green); border-color: var(--green); color: #fff; }
    .btn-primary:hover { background: #15803d; border-color: #15803d; }
    .btn-primary:disabled { opacity: .45; cursor: not-allowed; }
    .btn-danger { background: transparent; border-color: #fca5a5; color: var(--red); }
    .btn-danger:hover { background: #fef2f2; }
    .btn-outline { background: transparent; }

    /* ══════════════════════════════════════════
       Empty State
    ══════════════════════════════════════════ */
    .empty-ss-state {
      text-align: center; padding: 60px 24px;
    }
    .empty-ss-state .material-symbols-rounded { font-size: 48px; color: var(--text-muted); opacity: .25; }
    .empty-ss-state p { font-size: 13px; color: var(--text-muted); margin-top: 8px; }

    /* ══════════════════════════════════════════
       Info Tip
    ══════════════════════════════════════════ */
    .info-tip {
      display: flex; align-items: center; gap: 8px; background: var(--bg);
      border: 1px solid var(--border); border-radius: 10px; padding: 10px 16px;
      margin-bottom: 16px; font-size: 12px; color: var(--text-muted);
    }
    .info-tip .material-symbols-rounded { font-size: 16px; color: #3b82f6; flex-shrink: 0; }

    /* ══════════════════════════════════════════
       Toast
    ══════════════════════════════════════════ */
    #toast {
      position: fixed; bottom: 24px; right: 24px;
      background: var(--text-primary); color: var(--surface); border-radius: 12px;
      padding: 12px 18px; font-size: 13px; font-weight: 600;
      display: flex; align-items: center; gap: 8px;
      opacity: 0; transform: translateY(10px); transition: all .3s ease;
      z-index: 9998; max-width: 380px; box-shadow: 0 8px 32px rgba(0,0,0,.15);
    }
    #toast.visible { opacity: 1; transform: translateY(0); }

    @media (max-width: 768px) {
      .canvas { padding: 14px; }
      .ss-toolbar { flex-direction: column; align-items: stretch; }
    }
  </style>
@endpush

@section('header_left')
<span class="topbar-title" style="font-weight: 700;">Spreadsheet Editor</span>
@endsection

@section('content')
    <div class="page-header">
      <div>
        <div class="breadcrumb">
          <a href="{{ route('admin.dashboard') }}">Dashboard</a>
          <span class="material-symbols-rounded" style="font-size:11px;">chevron_right</span>
          <a href="{{ route('admin.import') }}">Import Data</a>
          <span class="material-symbols-rounded" style="font-size:11px;">chevron_right</span>
          <span>Spreadsheet Editor</span>
        </div>
        <h2>Spreadsheet Editor</h2>
        <p>Input data anggota secara manual. Edit, tambah, atau hapus baris sebelum menyimpan sebagai draft.</p>
      </div>
      <a href="{{ route('admin.import') }}" class="btn" style="text-decoration:none;">
        <span class="material-symbols-rounded">arrow_back</span> Kembali ke Import
      </a>
    </div>

    <div class="info-tip">
      <span class="material-symbols-rounded">lightbulb</span>
      <span>Kolom <strong>NIA</strong> dan <strong>Nama</strong> wajib diisi. Setelah selesai, klik <strong>"Simpan ke Draft"</strong> lalu tinjau & konfirmasi di halaman draft.</span>
    </div>

    <div class="ss-card">
      <div class="ss-toolbar">
        <div class="ss-toolbar-left">
          <span class="material-symbols-rounded" style="color:var(--green);font-size:20px;">grid_on</span>
          <span style="font-weight:800; font-size:14px; color:var(--text-primary);">Data Anggota</span>
          <span class="ss-stat">Baris: <strong id="ssRowCount">0</strong></span>
          <span class="ss-stat" id="ssErrorStat" style="display:none;">Error: <strong style="color:var(--red);" id="ssErrorCount">0</strong></span>
        </div>
        <div class="ss-toolbar-right">
          <button class="btn btn-sm" onclick="ssAddRow()" title="Tambah baris baru">
            <span class="material-symbols-rounded">add</span> Tambah Baris
          </button>
          <button class="btn btn-sm btn-danger" onclick="ssClearAll()" title="Hapus semua baris">
            <span class="material-symbols-rounded">delete_sweep</span>
          </button>
        </div>
      </div>

      <div class="ss-wrap">
        <table class="ss-table" id="ssTable">
          <thead>
            <tr>
              <th style="width:44px; text-align:center;">#</th>
              <th style="min-width:130px;">NIA (No Anggota)</th>
              <th style="min-width:200px;">Nama Anggota</th>
              <th class="num" style="min-width:130px;">S. Pokok</th>
              <th class="num" style="min-width:130px;">S. Wajib</th>
              <th class="num" style="min-width:130px;">Monosuko</th>
              <th class="num" style="min-width:130px;">DPU</th>
              <th style="width:44px; text-align:center;">×</th>
            </tr>
          </thead>
          <tbody id="ssBody"></tbody>
        </table>
      </div>

      <div class="ss-footer">
        <div style="display:flex; gap:8px; align-items:center;">
          <button class="btn btn-sm" onclick="ssAddRow()"><span class="material-symbols-rounded">add</span> Tambah Baris</button>
          <button class="btn btn-sm" onclick="ssAdd5Rows()"><span class="material-symbols-rounded">playlist_add</span> +5 Baris</button>
        </div>
        <div style="display:flex; gap:8px;">
          <button class="btn btn-sm btn-primary" id="btnSaveDraft" onclick="ssSaveDraft()" disabled>
            <span class="material-symbols-rounded">save</span>
            <span id="btnSaveDraftLabel">Simpan ke Draft</span>
          </button>
        </div>
      </div>
    </div>
  </div>
@endsection

@push('scripts')
<div id="toast">
  <span class="material-symbols-rounded" id="toastIcon">check_circle</span>
  <span id="toastMsg">Berhasil!</span>
</div>

<script>
/* ══════════════════════════════════════════════════
   SPREADSHEET EDITOR — Core Logic
══════════════════════════════════════════════════ */
let ssRowId = 0;

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
    <td><input class="ss-input num" data-field="pokok" value="${escHtml(pokok)}" placeholder="0"></td>
    <td><input class="ss-input num" data-field="wajib" value="${escHtml(wajib)}" placeholder="0"></td>
    <td><input class="ss-input num" data-field="monosuko" value="${escHtml(monosuko)}" placeholder="0"></td>
    <td><input class="ss-input num" data-field="dpu" value="${escHtml(dpu)}" placeholder="0"></td>
    <td class="ss-cell-action"><button class="btn-del-row" onclick="ssDeleteRow(${id})" title="Hapus baris"><span class="material-symbols-rounded" style="font-size:16px;">close</span></button></td>
  </tr>`;
}

function escHtml(s) { const d = document.createElement('div'); d.textContent = s; return d.innerHTML; }

function ssAddRow(data = {}) {
  document.getElementById('ssBody').insertAdjacentHTML('beforeend', ssCreateRowHTML(data));
  ssUpdateStats();
  const rows = document.querySelectorAll('#ssBody tr');
  const lastRow = rows[rows.length - 1];
  if (lastRow) lastRow.querySelector('.ss-input')?.focus();
}

function ssAdd5Rows() { for (let i = 0; i < 5; i++) ssAddRow(); }

function ssDeleteRow(id) {
  const row = document.getElementById('ssr-' + id);
  if (row) {
    row.classList.add('deleting');
    setTimeout(() => { row.remove(); ssReindex(); ssUpdateStats(); }, 250);
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
  rows.forEach(tr => { tr.querySelectorAll('.ss-input.error').forEach(() => errors++); });
  const errStat = document.getElementById('ssErrorStat');
  if (errors > 0) { errStat.style.display = 'inline'; document.getElementById('ssErrorCount').textContent = errors; }
  else { errStat.style.display = 'none'; }
  document.getElementById('btnSaveDraft').disabled = rows.length === 0;
}

function ssValidateRow(input) {
  const field = input.dataset.field;
  const val = input.value.trim();
  const tip = input.nextElementSibling;
  if ((field === 'nia' || field === 'name') && val === '') {
    input.classList.add('error');
    if (tip) { tip.textContent = field === 'nia' ? 'NIA wajib diisi' : 'Nama wajib diisi'; tip.style.display = 'block'; }
  } else {
    input.classList.remove('error');
    if (tip) { tip.textContent = ''; tip.style.display = 'none'; }
  }
  ssUpdateStats();
}

function ssGetAllRows() {
  const rows = [];
  document.querySelectorAll('#ssBody tr').forEach(tr => {
    const inputs = tr.querySelectorAll('.ss-input');
    const nia = inputs[0]?.value.trim();
    const name = inputs[1]?.value.trim();
    if (!nia || !name) return;
    rows.push({
      nia, name,
      pokok: inputs[2]?.value || '0',
      wajib: inputs[3]?.value || '0',
      monosuko: inputs[4]?.value || '0',
      dpu: inputs[5]?.value || '0',
    });
  });
  return rows;
}

/* ── Save Draft via AJAX ── */
function ssSaveDraft() {
  const rows = ssGetAllRows();
  if (rows.length === 0) { showToast('Tidak ada data valid untuk disimpan.', true); return; }
  const btn = document.getElementById('btnSaveDraft');
  btn.disabled = true;
  document.getElementById('btnSaveDraftLabel').textContent = 'Menyimpan...';

  fetch('{{ route("admin.drafts.storeManual") }}', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json', 'Accept': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content },
    body: JSON.stringify({ rows })
  }).then(r => r.json()).then(res => {
    if (res.success) {
      showToast('Draft berhasil disimpan! (' + rows.length + ' baris)');
      // Redirect to draft review page
      setTimeout(() => {
        window.location.href = '{{ url("admin/drafts") }}/' + res.draft_id;
      }, 1200);
    } else { showToast('Gagal menyimpan draft.', true); }
  }).catch(() => showToast('Terjadi kesalahan jaringan.', true))
  .finally(() => { btn.disabled = false; document.getElementById('btnSaveDraftLabel').textContent = 'Simpan ke Draft'; });
}

/* ══════════════════════════════════════════════════
   TOAST
══════════════════════════════════════════════════ */
function showToast(msg, isError = false) {
  const toast = document.getElementById('toast');
  document.getElementById('toastIcon').textContent = isError ? 'error' : 'check_circle';
  document.getElementById('toastIcon').style.color = isError ? '#f87171' : '#4ade80';
  document.getElementById('toastMsg').textContent = msg;
  toast.classList.add('visible');
  clearTimeout(toast._timer);
  toast._timer = setTimeout(() => toast.classList.remove('visible'), 4000);
}

/* ══════════════════════════════════════════════════
   INIT — add 3 empty rows on load
══════════════════════════════════════════════════ */
for (let i = 0; i < 3; i++) ssAddRow();
</script>

@endpush
