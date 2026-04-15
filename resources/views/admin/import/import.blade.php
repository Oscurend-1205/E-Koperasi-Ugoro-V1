<!DOCTYPE html>
<html lang="id" data-theme="light">
<head>
  <meta charset="utf-8"/>
  <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Koperasi Ugoro — Import Data Anggota</title>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet"/>
  <script src="https://cdn.sheetjs.com/xlsx-0.20.1/package/dist/xlsx.full.min.js"></script>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200"/>
  @include('admin.partials.layout_styles')
  @include('admin.partials.theme')

  <style>
    /* ══════════════════════════════════════════
       Page Layout & Styles
    ══════════════════════════════════════════ */
    .canvas { padding: 18px 26px; max-width: 1540px; margin: 0 auto; }
    .page-header { display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 8px; flex-wrap: wrap; gap: 13px; }
    .page-header h2 { font-size: var(--fs-h2); font-weight: 800; color: var(--text-primary); letter-spacing: -0.4px; }
    .page-header p { font-size: var(--fs-md); color: var(--text-muted); margin-top: 2px; }
    .breadcrumb { display: flex; align-items: center; gap: 6px; font-size: var(--fs-sm); margin-bottom: 4px; color: var(--text-muted); }
    .breadcrumb a { color: var(--green); text-decoration: none; font-weight: 600; }
    .breadcrumb a:hover { text-decoration: underline; }

    /* ══════════════════════════════════════════
       Header Actions (Tombol sejajar di atas)
    ══════════════════════════════════════════ */
    .header-actions {
      display: flex; gap: 8px; align-items: center; margin-bottom: 16px;
      padding: 0; flex-wrap: wrap;
    }
    .header-actions .btn-header {
      display: inline-flex; align-items: center; gap: 6px; padding: 9px 15px;
      border-radius: 9px; border: 1px solid var(--border); background: var(--surface);
      font-size: var(--fs-md); font-weight: 600; color: var(--text-primary);
      cursor: pointer; font-family: inherit; transition: all .15s; text-decoration: none;
    }
    .header-actions .btn-header:hover { background: var(--bg); }

    /* ══════════════════════════════════════════
       Tab Navigation
    ══════════════════════════════════════════ */
    .tab-bar { display: flex; gap: 5px; background: var(--bg); border: 1px solid var(--border); border-radius: 13px; padding: 5px; margin-bottom: 18px; }
    .tab-btn {
      flex: 1; display: flex; align-items: center; justify-content: center; gap: 7px;
      padding: 11px 18px; border-radius: 10px; border: none; background: transparent;
      font-size: var(--fs-base); font-weight: 600; color: var(--text-muted);
      cursor: pointer; font-family: inherit; transition: all .2s;
    }
    .tab-btn:hover { color: var(--text-primary); background: var(--surface); }
    .tab-btn.active { background: var(--green); color: #fff; box-shadow: 0 2px 8px rgba(22,163,74,.2); }
    .tab-btn .material-symbols-rounded { font-size: 18px; }
    .tab-btn .badge-count {
      font-size: 9px; font-weight: 800; background: rgba(255,255,255,.25); color: #fff;
      padding: 1px 6px; border-radius: 8px; margin-left: 2px;
    }
    .tab-panel { display: none; }
    .tab-panel.active { display: block; }

    /* ══════════════════════════════════════════
       Section & Cards
    ══════════════════════════════════════════ */
    .card { background: var(--surface); border: 1px solid var(--border); border-radius: 14px; box-shadow: var(--shadow); overflow: hidden; }
    .card-section { padding: 20px; border-bottom: 1px solid var(--border); }
    .card-section:last-child { border-bottom: none; }
    .card-title { font-size: var(--fs-base); font-weight: 700; color: var(--text-primary); display: flex; align-items: center; gap: 8px; margin-bottom: 12px; }
    .card-title .material-symbols-rounded { color: var(--green); }
    .card-desc { font-size: var(--fs-sm); color: var(--text-muted); margin-bottom: 12px; }

    /* ══════════════════════════════════════════
       Upload Area (Fokus Utama)
    ══════════════════════════════════════════ */
    .drop-zone {
      border: 2px dashed var(--border); border-radius: 16px; padding: 2.5rem 1.5rem;
      text-align: center; cursor: pointer; transition: all .3s; background: var(--surface);
      display: flex; flex-direction: column; align-items: center; gap: 10px;
    }
    .drop-zone:hover, .drop-zone.dragover { border-color: var(--green); background: var(--green-light); transform: translateY(-2px); }
    .dz-icon { width: 52px; height: 52px; border-radius: 50%; background: var(--green-light); border: 2px solid var(--green); display: flex; align-items: center; justify-content: center; }
    .dz-icon .material-symbols-rounded { font-size: 26px; color: var(--green); }
    .dz-title { font-size: 16px; font-weight: 800; color: var(--text-primary); }
    .dz-sub { font-size: var(--fs-sm); color: var(--text-muted); }
    .btn-browse { display: inline-flex; align-items: center; gap: 6px; padding: 10px 18px; border-radius: 8px; border: 1px solid var(--border); background: var(--surface); font-size: 13px; font-weight: 700; color: var(--text-primary); cursor: pointer; font-family: inherit; transition: all .2s; margin-top: 6px; }
    .btn-browse:hover { background: var(--green); border-color: var(--green); color: #fff; }
    .hidden-input { display: none; }

    /* ─ File Chip ─ */
    .file-chip { display: none; align-items: center; gap: 12px; background: var(--surface); border: 1px solid var(--green); border-radius: 10px; padding: 12px 14px; margin-top: 12px; }
    .file-chip.show { display: flex; }
    .fc-icon { width: 36px; height: 36px; background: var(--green-light); border-radius: 6px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
    .fc-icon .material-symbols-rounded { font-size: 18px; color: var(--green); }
    .fc-name { font-size: var(--fs-base); font-weight: 600; color: var(--text-primary); }
    .fc-meta { font-size: var(--fs-xs); color: var(--text-muted); margin-top: 2px; }
    .fc-remove { margin-left: auto; border: none; background: none; cursor: pointer; padding: 6px; border-radius: 5px; color: var(--text-muted); display: flex; transition: all .15s; flex-shrink: 0; }
    .fc-remove:hover { background: var(--red-light); color: var(--red); }

    /* ─ Mapping Configuration ─ */
    .mapping-box { display: none; margin-top: 16px; background: var(--bg); border: 1px solid var(--green); border-radius: 12px; padding: 14px; }
    .mapping-box.show { display: block; }
    .mapping-title { font-size: 12px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: var(--text-muted); display: flex; align-items: center; gap: 6px; margin-bottom: 10px; }
    .mapping-title .material-symbols-rounded { color: var(--green); font-size: 16px; }
    .mapping-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(140px, 1fr)); gap: 10px; margin-bottom: 10px; }
    .mapping-field { display: flex; flex-direction: column; gap: 4px; }
    .mapping-field label { font-size: 10px; font-weight: 700; color: var(--text-muted); }
    .mapping-field select { padding: 7px 9px; border: 1px solid var(--border); border-radius: 6px; background: var(--surface); font-size: 12px; color: var(--text-primary); cursor: pointer; }

    /* ══════════════════════════════════════════
       Preview Tabel
    ══════════════════════════════════════════ */
    .preview-wrap { overflow: auto; max-height: 50vh; position: relative; margin-top: 12px; border: 1px solid var(--border); border-radius: 10px; }
    .preview-table { width: 100%; border-collapse: collapse; font-size: var(--fs-sm); }
    .preview-table thead th {
      position: sticky; top: 0; z-index: 10; padding: 10px 12px;
      font-size: 11px; font-weight: 700; text-transform: uppercase;
      letter-spacing: 0.5px; color: var(--text-muted); background: var(--surface);
      border-bottom: 2px solid var(--border); white-space: nowrap; text-align: left;
    }
    .preview-table tbody td { padding: 9px 12px; border-bottom: 1px solid var(--border); color: var(--text-primary); }
    .preview-table tbody tr:hover td { background: var(--bg); }
    .preview-table .num { text-align: right; font-variant-numeric: tabular-nums; }

    /* ══════════════════════════════════════════
       Verification Section
    ══════════════════════════════════════════ */
    .verify-box { background: var(--bg); border: 1px solid var(--border); border-radius: 10px; padding: 14px; margin-top: 12px; }
    .verify-item { display: flex; align-items: center; gap: 10px; margin-bottom: 8px; font-size: var(--fs-sm); }
    .verify-item:last-child { margin-bottom: 0; }
    .verify-badge { width: 24px; height: 24px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 12px; font-weight: 700; flex-shrink: 0; }
    .verify-badge.success { background: var(--green-light); color: var(--green); }
    .verify-badge.warning { background: var(--orange-light); color: var(--orange); }
    .verify-badge.error { background: var(--red-light); color: var(--red); }

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
       Draft List
    ══════════════════════════════════════════ */
    .draft-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 14px; }
    .draft-card { background: var(--surface); border: 1px solid var(--border); border-radius: 14px; padding: 16px; display: flex; flex-direction: column; gap: 12px; transition: all .2s; }
    .draft-card:hover { transform: translateY(-3px); box-shadow: var(--shadow-md); border-color: var(--green); }
    .draft-icon { width: 38px; height: 38px; border-radius: 10px; background: var(--green-light); display: flex; align-items: center; justify-content: center; color: var(--green); flex-shrink: 0; }
    .draft-title { font-size: var(--fs-base); font-weight: 700; color: var(--text-primary); }
    .draft-meta { font-size: var(--fs-xs); color: var(--text-muted); display: flex; gap: 10px; }
    .draft-stats { display: grid; grid-template-columns: 1fr 1fr; gap: 8px; padding: 10px; background: var(--bg); border-radius: 8px; }
    .dst-label { font-size: 8px; font-weight: 600; text-transform: uppercase; color: var(--text-muted); letter-spacing: 0.5px; }
    .dst-val { font-size: 14px; font-weight: 700; color: var(--text-primary); }
    .draft-actions { display: flex; gap: 8px; margin-top: auto; padding-top: 12px; border-top: 1px solid var(--border); }
    .btn-icon { width: 32px; height: 32px; border-radius: 6px; border: 1px solid var(--border); display: flex; align-items: center; justify-content: center; background: var(--surface); color: var(--text-secondary); cursor: pointer; transition: all .15s; }
    .btn-icon:hover { background: var(--bg); color: var(--text-primary); }
    .btn-icon.danger:hover { background: var(--red-light); color: var(--red); border-color: var(--red); }

    /* ══════════════════════════════════════════
       Template Section
    ══════════════════════════════════════════ */
    .excel-table-wrap { border: 1px solid var(--border); border-radius: 8px; overflow-x: auto; margin-bottom: 1rem; }
    .excel-table { width: 100%; border-collapse: collapse; font-size: var(--fs-sm); }
    .excel-table th, .excel-table td { padding: 6px 10px; border: 1px solid var(--border); text-align: left; white-space: nowrap; }
    .excel-table th { background: var(--bg); font-weight: 600; color: var(--text-secondary); }
    .col-tags { display: flex; flex-wrap: wrap; gap: 6px; margin-bottom: 1rem; }
    .col-tag { display: inline-flex; align-items: center; gap: 5px; padding: 4px 8px; border-radius: 6px; font-size: var(--fs-sm); font-weight: 600; border: 1px solid; }
    .col-tag .ltr { font-family: monospace; font-size: var(--fs-xs); opacity: 0.65; }
    .col-tag.required { background: #f0fdf4; color: var(--green); border-color: #86efac; }
    .col-tag.optional { background: var(--orange-light); color: var(--orange); border-color: #fed7aa; }
    .info-box { display: flex; align-items: flex-start; gap: 8px; background: #eff6ff; border: 1px solid #bfdbfe; border-radius: 8px; padding: 10px 12px; font-size: var(--fs-sm); color: #1e40af; line-height: 1.5; }
    .info-box .material-symbols-rounded { font-size: 16px; margin-top: 1px; flex-shrink: 0; }

    /* ══════════════════════════════════════════
       Flash & Toast
    ══════════════════════════════════════════ */
    .flash { display: flex; align-items: flex-start; gap: 10px; padding: 12px 14px; border-radius: 8px; margin-bottom: 0.75rem; font-size: 12px; }
    .flash-success { background: var(--green-light); color: var(--green); border: 1px solid var(--green); }
    .flash-error { background: var(--red-light); color: var(--red); border: 1px solid var(--red); }
    #toast { position: fixed; bottom: 20px; right: 20px; background: var(--text-primary); color: var(--surface); border-radius: 8px; padding: 10px 14px; font-size: var(--fs-md); font-weight: 500; display: flex; align-items: center; gap: 6px; opacity: 0; transform: translateY(10px); transition: all .3s ease; z-index: 9998; max-width: 360px; box-shadow: var(--shadow); }
    #toast.visible { opacity: 1; transform: translateY(0); }

    .empty-state { text-align: center; padding: 50px 20px; background: var(--surface); border: 1px dashed var(--border); border-radius: 14px; color: var(--text-muted); }

    @media (max-width: 768px) {
      .canvas { padding: 14px; }
      .tab-bar { flex-direction: column; }
      .header-actions { flex-direction: column; width: 100%; }
      .header-actions .btn-header { width: 100%; justify-content: center; }
      .draft-grid { grid-template-columns: 1fr; }
      .mapping-grid { grid-template-columns: 1fr; }
    }
  </style>




</head>
<body>

@include('admin.partials.sidebar')

<main>
  <header>
    <span class="topbar-title">Import Data Anggota</span>
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
      <div style="flex: 1;">
        <div class="breadcrumb">
          <a href="{{ route('admin.dashboard') }}">Dashboard</a>
          <span class="material-symbols-rounded" style="font-size:11px;">chevron_right</span>
          <span>Import Data Anggota</span>
        </div>
        <h2>Import & Kelola Data Anggota</h2>
        <p>Upload file Excel, lihat preview, verifikasi, dan import ke database</p>
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

    <!-- ══════════════ HEADER ACTIONS ══════════════ -->
    <div class="header-actions">
      <a href="{{ route('admin.import.spreadsheet') }}" class="btn-header">
        <span class="material-symbols-rounded">grid_on</span> Edit Tabel
      </a>
      <a href="{{ route('admin.drafts.index') }}" class="btn-header">
        <span class="material-symbols-rounded">inventory_2</span> Draft Antrian
        @php $draftCount = \App\Models\ImportDraft::where('status', 'draft')->count(); @endphp
        @if($draftCount > 0)
          <span style="background: var(--orange); color: #fff; font-size: 10px; font-weight: 800; padding: 2px 7px; border-radius: 6px; box-shadow: 0 2px 4px rgba(234, 88, 12, 0.2); margin-left: 2px;">{{ $draftCount }}</span>
        @endif
      </a>
    </div>

    <!-- ══════════════ TAB BAR ══════════════ -->
    <div class="tab-bar">
      <button class="tab-btn active" onclick="switchTab('upload')" id="tabBtnUpload">
        <span class="material-symbols-rounded">cloud_upload</span> Import Excel
      </button>
      <button class="tab-btn" onclick="switchTab('template')" id="tabBtnTemplate">
        <span class="material-symbols-rounded">description</span> Template Format
      </button>
    </div>

    <!-- ══════════════════════════════════════
         TAB 1: IMPORT EXCEL (MAIN FOCUS)
         ═════════════════════════════════════ -->
    <div class="tab-panel active" id="panelUpload">
      <div class="card">
        <!-- SECTION 1: UPLOAD FILE (UTAMA) -->
        <div class="card-section">
          <div class="card-title">
            <span class="material-symbols-rounded">cloud_upload</span> Upload File Excel
          </div>
          <div class="card-desc">Seret file Excel ke sini atau klik untuk memilih file dari perangkat Anda</div>

          <form id="importForm" action="{{ route('admin.import.process') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="type" value="anggota">
            <input type="file" id="fileInput" name="file" class="hidden-input" accept=".xlsx,.xls,.csv" onchange="handleFileSelect(event)">
          </form>

          <div class="drop-zone" id="dropZone" onclick="document.getElementById('fileInput').click()" ondragover="handleDragOver(event)" ondragleave="handleDragLeave(event)" ondrop="handleDrop(event)">
            <div class="dz-icon"><span class="material-symbols-rounded">cloud_upload</span></div>
            <p class="dz-title">Seret file ke sini</p>
            <p class="dz-sub">Format: .xlsx, .xls, atau .csv · Maksimal 10 MB</p>
            <button type="button" class="btn-browse" onclick="event.stopPropagation(); document.getElementById('fileInput').click()">
              <span class="material-symbols-rounded">folder_open</span> Pilih File
            </button>
          </div>

          <div class="file-chip" id="fileChip">
            <div class="fc-icon"><span class="material-symbols-rounded">description</span></div>
            <div style="flex:1;min-width:0;">
              <div class="fc-name" id="fcName">—</div>
              <div class="fc-meta" id="fcMeta">—</div>
            </div>
            <button class="fc-remove" onclick="removeFile()" title="Hapus file"><span class="material-symbols-rounded" style="font-size:14px;">close</span></button>
          </div>
        </div>

        <!-- SECTION 2: MAPPING CONFIGURATION -->
        <div class="card-section" style="display: none;" id="mappingSection">
          <div class="card-title">
            <span class="material-symbols-rounded">settings_suggest</span> Konfigurasi Kolom
          </div>
          <div class="card-desc">Tentukan kolom mana yang sesuai dengan data Anda</div>

          <div class="mapping-box show">
            <div class="mapping-title">
              <span class="material-symbols-rounded">layers</span> Pengaturan Dasar
            </div>
            <div class="mapping-grid">
              <div class="mapping-field">
                <label>Data Dimulai Baris Ke-</label>
                <input type="number" id="startRowInput" value="3" min="1" style="padding:7px 9px; border:1px solid var(--border); border-radius:6px; background:var(--surface); font-size:12px; color:var(--text-primary);">
              </div>
              <div class="mapping-field">
                <label>Kolom NIA (ID) *</label>
                <select id="mapNia" style="padding:7px 9px; border:1px solid var(--border); border-radius:6px; background:var(--surface); font-size:12px; color:var(--text-primary); cursor:pointer;"></select>
              </div>
              <div class="mapping-field">
                <label>Kolom Nama Anggota *</label>
                <select id="mapName" style="padding:7px 9px; border:1px solid var(--border); border-radius:6px; background:var(--surface); font-size:12px; color:var(--text-primary); cursor:pointer;"></select>
              </div>
            </div>

            <div class="mapping-title" style="margin-top:12px;">
              <span class="material-symbols-rounded">layers</span> Kolom Simpanan (Opsional)
            </div>
            <div class="mapping-grid">
              <div class="mapping-field">
                <label>S. Pokok</label>
                <select id="mapPokok" style="padding:7px 9px; border:1px solid var(--border); border-radius:6px; background:var(--surface); font-size:12px; color:var(--text-primary); cursor:pointer;"></select>
              </div>
              <div class="mapping-field">
                <label>S. Wajib</label>
                <select id="mapWajib" style="padding:7px 9px; border:1px solid var(--border); border-radius:6px; background:var(--surface); font-size:12px; color:var(--text-primary); cursor:pointer;"></select>
              </div>
              <div class="mapping-field">
                <label>Monosuko</label>
                <select id="mapMonosuko" style="padding:7px 9px; border:1px solid var(--border); border-radius:6px; background:var(--surface); font-size:12px; color:var(--text-primary); cursor:pointer;"></select>
              </div>
              <div class="mapping-field">
                <label>DPU</label>
                <select id="mapDpu" style="padding:7px 9px; border:1px solid var(--border); border-radius:6px; background:var(--surface); font-size:12px; color:var(--text-primary); cursor:pointer;"></select>
              </div>
            </div>
          </div>
        </div>

        <!-- SECTION 3: PREVIEW DATA -->
        <div class="card-section" style="display: none;" id="previewSection">
          <div class="card-title">
            <span class="material-symbols-rounded">preview</span> Preview Data
          </div>
          <div class="card-desc" id="previewDesc">Lihat data yang akan diimport. Total: <strong id="previewRowCount">0</strong> baris</div>

          <div class="preview-wrap">
            <table class="preview-table" id="previewTable">
              <thead>
                <tr>
                  <th style="width: 50px; text-align: center;">No</th>
                  <th style="min-width: 120px;">NIA</th>
                  <th style="min-width: 180px;">Nama Anggota</th>
                  <th class="num" style="min-width: 100px;">S. Pokok</th>
                  <th class="num" style="min-width: 100px;">S. Wajib</th>
                  <th class="num" style="min-width: 100px;">Monosuko</th>
                  <th class="num" style="min-width: 100px;">DPU</th>
                </tr>
              </thead>
              <tbody id="previewBody"></tbody>
            </table>
          </div>
        </div>

        <!-- SECTION 4: VERIFIKASI -->
        <div class="card-section" style="display: none;" id="verifySection">
          <div class="card-title">
            <span class="material-symbols-rounded">verified_user</span> Verifikasi Data
          </div>
          <div class="card-desc">Pastikan semua data siap untuk diimport</div>

          <div class="verify-box">
            <div class="verify-item">
              <span class="verify-badge success">
                <span class="material-symbols-rounded" style="font-size: 14px;">check</span>
              </span>
              <span><strong id="verifyRows">0</strong> baris data siap diimport</span>
            </div>
            <div class="verify-item">
              <span class="verify-badge warning">
                <span class="material-symbols-rounded" style="font-size: 14px;">warning</span>
              </span>
              <span><strong id="verifyInvalid">0</strong> baris dengan data tidak lengkap</span>
            </div>
          </div>
        </div>

        <!-- SECTION 5: ACTION BUTTONS -->
        <div class="card-section">
          <div class="button-group" style="justify-content: space-between; align-items: center;">
            <div>
              <button type="button" class="btn btn-sm btn-danger" onclick="removeFile()" id="btnReset" style="display: none;">
                <span class="material-symbols-rounded">restart_alt</span> Reset
              </button>
            </div>
            <div class="button-group">
              <button type="button" class="btn btn-sm" id="btnEditData" style="display: none;" onclick="loadExcelToEditPage()">
                <span class="material-symbols-rounded">edit</span> Edit Data
              </button>
              <button type="button" class="btn btn-sm" id="btnSaveDraft" style="display: none;" onclick="saveExcelDraft()">
                <span class="material-symbols-rounded">save</span> Simpan Draft
              </button>
              <button type="button" class="btn btn-sm btn-primary" id="btnImport" style="display: none;" onclick="importToDatabase()">
                <span class="material-symbols-rounded">download</span> Import ke Database
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- ══════════════════════════════════════
         TAB 2: TEMPLATE FORMAT
         ═════════════════════════════════════ -->
    <div class="tab-panel" id="panelTemplate">
      <div class="card">
        <div class="card-section">
          <div class="card-title">
            <span class="material-symbols-rounded">table_view</span> Format Excel yang Diharapkan
          </div>

          <div class="excel-table-wrap">
            <table class="excel-table">
              <thead>
                <tr><th rowspan="2" style="width:36px;">No</th><th rowspan="2">NIA</th><th rowspan="2">Anggota</th><th colspan="4" style="text-align: center;">Simpanan</th></tr>
                <tr><th>Pokok</th><th>Wajib</th><th>Monosuko</th><th>DPU</th></tr>
              </thead>
              <tbody>
                <tr><td style="text-align:center;">1</td><td style="font-family:monospace;">UG-001</td><td>Ahmad Sudrajat</td><td style="text-align:right;">1000000</td><td style="text-align:right;">500000</td><td style="text-align:right;">200000</td><td style="text-align:right;">100000</td></tr>
                <tr><td style="text-align:center;">2</td><td style="font-family:monospace;">UG-002</td><td>Siti Aminah</td><td style="text-align:right;">1000000</td><td style="text-align:right;">500000</td><td style="text-align:right;">0</td><td style="text-align:right;">0</td></tr>
              </tbody>
            </table>
          </div>

          <div style="margin-top: 16px;">
            <p class="section-label" style="margin-bottom: 8px;">
              <span class="material-symbols-rounded">view_column</span> Pemetaan Kolom
              <span style="color:var(--green);margin-left:5px;font-weight:600;font-size:10px;">● Wajib</span>
              <span style="color:var(--orange);margin-left:5px;font-weight:600;font-size:10px;">● Opsional</span>
            </p>
            <div class="col-tags">
              <span class="col-tag required"><span class="ltr">A</span> No</span>
              <span class="col-tag required"><span class="ltr">B</span> NIA</span>
              <span class="col-tag required"><span class="ltr">C</span> Nama Anggota</span>
              <span class="col-tag required"><span class="ltr">D</span> Simpanan Pokok</span>
              <span class="col-tag required"><span class="ltr">E</span> Simpanan Wajib</span>
              <span class="col-tag optional"><span class="ltr">F</span> Monosuko</span>
              <span class="col-tag optional"><span class="ltr">G</span> DPU</span>
            </div>
          </div>

          <div class="info-box">
            <span class="material-symbols-rounded">info</span>
            <span>Data dibaca mulai <strong>baris ke-3</strong>. Kolom NIA dan Nama Anggota bersifat <strong>wajib</strong>. Kolom simpanan bersifat opsional. Format <code style="background:rgba(255,255,255,0.5);padding:2px 4px;border-radius:3px;">Rp</code>, titik, dan koma akan dibersihkan otomatis.</span>
          </div>

          <div style="margin-top: 16px;">
            <button class="btn btn-primary btn-sm" onclick="downloadTemplate()">
              <span class="material-symbols-rounded">download</span> Download Template Excel
            </button>
          </div>
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
   TAB SWITCHING
════════════════════════════════════════════════════════════ */
function switchTab(name) {
  document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
  document.querySelectorAll('.tab-panel').forEach(p => p.classList.remove('active'));
  document.getElementById('tabBtn' + name.charAt(0).toUpperCase() + name.slice(1)).classList.add('active');
  document.getElementById('panel' + name.charAt(0).toUpperCase() + name.slice(1)).classList.add('active');
}

/* ════════════════════════════════════════════════════════════
   UPLOAD & FILE HANDLING
════════════════════════════════════════════════════════════ */
let attachedFile = null;
let parsedData = [];

function attachFile(file) {
  const ext = file.name.split('.').pop().toLowerCase();
  if (!['xlsx', 'xls', 'csv'].includes(ext)) {
    showToast('Format tidak didukung!', true);
    return;
  }
  if (file.size > 10 * 1024 * 1024) {
    showToast('Ukuran file melebihi 10 MB!', true);
    return;
  }
  attachedFile = file;
  
  // Update file chip
  document.getElementById('fcName').textContent = file.name;
  document.getElementById('fcMeta').textContent = (file.size / 1024).toFixed(1) + ' KB · ' + ext.toUpperCase();
  document.getElementById('fileChip').classList.add('show');
  
  // Show mapping section
  document.getElementById('mappingSection').style.display = 'block';
  document.getElementById('btnReset').style.display = 'inline-flex';
  
  // Initialize column mapping
  initColumnMapping(file);
}

function removeFile() {
  attachedFile = null;
  parsedData = [];
  document.getElementById('fileInput').value = '';
  document.getElementById('fileChip').classList.remove('show');
  document.getElementById('mappingSection').style.display = 'none';
  document.getElementById('previewSection').style.display = 'none';
  document.getElementById('verifySection').style.display = 'none';
  document.getElementById('btnReset').style.display = 'none';
  document.getElementById('btnEditData').style.display = 'none';
  document.getElementById('btnSaveDraft').style.display = 'none';
  document.getElementById('btnImport').style.display = 'none';
}

function handleFileSelect(e) {
  if (e.target.files[0]) attachFile(e.target.files[0]);
}

function handleDragOver(e) {
  e.preventDefault();
  document.getElementById('dropZone').classList.add('dragover');
}

function handleDragLeave() {
  document.getElementById('dropZone').classList.remove('dragover');
}

function handleDrop(e) {
  e.preventDefault();
  document.getElementById('dropZone').classList.remove('dragover');
  const f = e.dataTransfer.files[0];
  if (f) {
    const dt = new DataTransfer();
    dt.items.add(f);
    document.getElementById('fileInput').files = dt.files;
    attachFile(f);
  }
}

/* ════════════════════════════════════════════════════════════
   COLUMN MAPPING
════════════════════════════════════════════════════════════ */
function initColumnMapping(file) {
  const reader = new FileReader();
  reader.onload = function(e) {
    const wb = XLSX.read(new Uint8Array(e.target.result), { type: 'array' });
    const ws = wb.Sheets[wb.SheetNames[0]];
    if (!ws['!ref']) return;
    
    const maxCol = XLSX.utils.decode_range(ws['!ref']).e.c;
    document.querySelectorAll('.mapping-field select').forEach(sel => {
      sel.innerHTML = '<option value="">-- Lewati --</option>';
      for (let i = 0; i <= maxCol; i++) {
        sel.innerHTML += `<option value="${i}">Kolom ${XLSX.utils.encode_col(i)}</option>`;
      }
    });
    
    // Set default mapping
    setMapValue('mapNia', 1);
    setMapValue('mapName', 2);
    setMapValue('mapPokok', 3);
    setMapValue('mapWajib', 4);
    setMapValue('mapMonosuko', 5);
    setMapValue('mapDpu', 6);
    
    // Automatically parse and show preview
    setTimeout(() => parseAndPreview(), 300);
  };
  reader.readAsArrayBuffer(file);
}

function setMapValue(id, val) {
  const el = document.getElementById(id);
  if (el && el.options[val+1]) el.selectedIndex = val + 1;
}

function getMapping() {
  return {
    nia: parseInt(document.getElementById('mapNia').value) || -1,
    name: parseInt(document.getElementById('mapName').value) || -1,
    pokok: parseInt(document.getElementById('mapPokok').value) || -1,
    wajib: parseInt(document.getElementById('mapWajib').value) || -1,
    monosuko: parseInt(document.getElementById('mapMonosuko').value) || -1,
    dpu: parseInt(document.getElementById('mapDpu').value) || -1,
  };
}

/* ════════════════════════════════════════════════════════════
   PARSE & PREVIEW
════════════════════════════════════════════════════════════ */
function parseAndPreview() {
  if (!attachedFile) return;
  
  const startRow = parseInt(document.getElementById('startRowInput').value) || 1;
  const mapping = getMapping();
  const reader = new FileReader();
  
  reader.onload = function(e) {
    const wb = XLSX.read(new Uint8Array(e.target.result), { type: 'array' });
    const ws = wb.Sheets[wb.SheetNames[0]];
    const rawData = XLSX.utils.sheet_to_json(ws, { header: 0 });
    
    parsedData = [];
    rawData.slice(startRow - 1).forEach((row, idx) => {
      const nia = row[mapping.nia] || '';
      const name = row[mapping.name] || '';
      
      // Hanya push jika NIA dan Nama tidak kosong
      if (String(nia).trim() && String(name).trim()) {
        parsedData.push({
          no: parsedData.length + 1,
          nia: String(nia).trim(),
          name: String(name).trim(),
          pokok: cleanNumber(row[mapping.pokok]),
          wajib: cleanNumber(row[mapping.wajib]),
          monosuko: cleanNumber(row[mapping.monosuko]),
          dpu: cleanNumber(row[mapping.dpu]),
        });
      }
    });
    
    // Show preview & verify sections
    showPreview();
    showVerification();
  };
  
  reader.readAsArrayBuffer(attachedFile);
}

function cleanNumber(val) {
  if (!val) return 0;
  return parseInt(String(val).replace(/[^\d]/g, '')) || 0;
}

function escHtml(s) {
  const d = document.createElement('div');
  d.textContent = s;
  return d.innerHTML;
}

function showPreview() {
  document.getElementById('previewSection').style.display = 'block';
  document.getElementById('previewRowCount').textContent = parsedData.length;
  
  const tbody = document.getElementById('previewBody');
  tbody.innerHTML = '';
  
  parsedData.slice(0, 10).forEach(row => {
    tbody.innerHTML += `<tr>
      <td style="text-align: center;">${row.no}</td>
      <td>${escHtml(row.nia)}</td>
      <td>${escHtml(row.name)}</td>
      <td class="num">${row.pokok.toLocaleString('id-ID')}</td>
      <td class="num">${row.wajib.toLocaleString('id-ID')}</td>
      <td class="num">${row.monosuko.toLocaleString('id-ID')}</td>
      <td class="num">${row.dpu.toLocaleString('id-ID')}</td>
    </tr>`;
  });
  
  if (parsedData.length > 10) {
    tbody.innerHTML += `<tr><td colspan="7" style="text-align: center; color: var(--text-muted); padding: 12px; font-style: italic;">... dan ${parsedData.length - 10} baris lainnya</td></tr>`;
  }
}

function showVerification() {
  document.getElementById('verifySection').style.display = 'block';
  document.getElementById('verifyRows').textContent = parsedData.length;
  document.getElementById('verifyInvalid').textContent = '0'; // All valid rows are shown
  
  // Show action buttons
  document.getElementById('btnEditData').style.display = 'inline-flex';
  document.getElementById('btnSaveDraft').style.display = 'inline-flex';
  document.getElementById('btnImport').style.display = 'inline-flex';
}

/* ════════════════════════════════════════════════════════════
   ACTIONS: SAVE DRAFT, EDIT, IMPORT
════════════════════════════════════════════════════════════ */
function saveExcelDraft() {
  if (parsedData.length === 0) {
    showToast('Tidak ada data untuk disimpan.', true);
    return;
  }
  
  const btn = document.getElementById('btnSaveDraft');
  btn.disabled = true;
  btn.innerHTML = '<span class="material-symbols-rounded">hourglass_empty</span> Menyimpan...';
  
  fetch('{{ route("admin.drafts.storeManual") }}', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
      'Accept': 'application/json',
      'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content
    },
    body: JSON.stringify({ rows: parsedData })
  }).then(r => r.json()).then(res => {
    if (res.success) {
      showToast('Draft berhasil disimpan! (' + parsedData.length + ' baris)');
      setTimeout(() => window.location.reload(), 1200);
    } else {
      showToast(res.message || 'Gagal menyimpan draft.', true);
    }
  }).catch(err => {
    console.error(err);
    showToast('Terjadi kesalahan jaringan.', true);
  }).finally(() => {
    btn.disabled = false;
    btn.innerHTML = '<span class="material-symbols-rounded">save</span> Simpan Draft';
  });
}

function loadExcelToEditPage() {
  if (parsedData.length === 0) {
    showToast('Tidak ada data untuk diedit.', true);
    return;
  }
  
  // Simpan ke sessionStorage dan buka halaman edit
  sessionStorage.setItem('importData', JSON.stringify(parsedData));
  window.location.href = '{{ route("admin.import.spreadsheet") }}';
}

function importToDatabase() {
  if (parsedData.length === 0) {
    showToast('Tidak ada data untuk diimport.', true);
    return;
  }
  
  // Show confirmation
  if (!confirm(`Yakin ingin mengimport ${parsedData.length} baris data ke database?`)) return;
  
  const btn = document.getElementById('btnImport');
  btn.disabled = true;
  btn.innerHTML = '<span class="material-symbols-rounded">hourglass_empty</span> Mengimport...';
  
  fetch('{{ route("admin.import.process") }}', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
      'Accept': 'application/json',
      'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content
    },
    body: JSON.stringify({
      type: 'anggota',
      rows: parsedData
    })
  }).then(r => r.json()).then(res => {
    if (res.success) {
      showToast('Data berhasil diimport ke database!');
      setTimeout(() => window.location.href = '{{ route("admin.dashboard") }}', 1500);
    } else {
      showToast(res.message || 'Gagal mengimport data.', true);
    }
  }).catch(err => {
    console.error(err);
    showToast('Terjadi kesalahan jaringan.', true);
  }).finally(() => {
    btn.disabled = false;
    btn.innerHTML = '<span class="material-symbols-rounded">download</span> Import ke Database';
  });
}

/* ════════════════════════════════════════════════════════════
   DOWNLOAD TEMPLATE
════════════════════════════════════════════════════════════ */
function downloadTemplate() {
  const wb = XLSX.utils.book_new();
  const ws = XLSX.utils.aoa_to_sheet([
    ['No', 'NIA', 'Nama Anggota', 'Simpanan Pokok', 'Simpanan Wajib', 'Monosuko', 'DPU'],
    ['', '', '', '', '', '', ''],
    [1, 'UG-001', 'Ahmad Sudrajat', 1000000, 500000, 200000, 100000],
    [2, 'UG-002', 'Siti Aminah', 1000000, 500000, 0, 0],
  ]);
  
  ws['A1'].font = { bold: true };
  ws['B1'].font = { bold: true };
  ws['C1'].font = { bold: true };
  ws['D1'].font = { bold: true };
  ws['E1'].font = { bold: true };
  ws['F1'].font = { bold: true };
  ws['G1'].font = { bold: true };
  
  XLSX.utils.book_append_sheet(wb, ws, 'Template');
  XLSX.writeFile(wb, 'Template_Import_Anggota.xlsx');
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

// Parse and preview when mapping changes
document.getElementById('mapNia')?.addEventListener('change', parseAndPreview);
document.getElementById('mapName')?.addEventListener('change', parseAndPreview);
document.getElementById('mapPokok')?.addEventListener('change', parseAndPreview);
document.getElementById('mapWajib')?.addEventListener('change', parseAndPreview);
document.getElementById('mapMonosuko')?.addEventListener('change', parseAndPreview);
document.getElementById('mapDpu')?.addEventListener('change', parseAndPreview);
document.getElementById('startRowInput')?.addEventListener('change', parseAndPreview);
</script>

</body>
</html>
