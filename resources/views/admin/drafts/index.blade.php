<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>Koperasi Ugoro — Draft Import</title>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet"/>
@include('admin.partials.layout_styles')
@include('admin.partials.theme')

<style>
    .canvas { padding: 24px; max-width: 1400px; margin: 0 auto; display: flex; flex-direction: column; gap: 20px; }
    .page-header { display: flex; justify-content: space-between; align-items: flex-end; }
    .page-header h2 { font-size: var(--fs-h2); font-weight: 800; color: var(--text-primary); letter-spacing: -0.5px; }
    .page-header p { font-size: var(--fs-sm); color: var(--text-muted); margin-top: 2px; }

    .draft-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); gap: 16px; }
    .draft-card { 
        background: var(--surface); border: 1px solid var(--border); border-radius: 14px; padding: 16px;
        display: flex; flex-direction: column; gap: 12px; transition: all .2s;
    }
    .draft-card:hover { transform: translateY(-3px); box-shadow: var(--shadow-md); border-color: var(--green-mid); }
    
    .draft-icon {
        width: 40px; height: 40px; border-radius: 10px; background: var(--bg);
        display: flex; align-items: center; justify-content: center; color: var(--green);
    }
    .draft-title { font-size: var(--fs-base); font-weight: 700; color: var(--text-primary); margin-bottom: 2px; }
    .draft-meta { font-size: var(--fs-xxs); color: var(--text-muted); display: flex; gap: 10px; }
    
    .draft-stats {
        display: grid; grid-template-columns: 1fr 1fr; gap: 8px; margin-top: 4px;
        padding: 10px; background: var(--bg); border-radius: 8px;
    }
    .dst-item { display: flex; flex-direction: column; }
    .dst-label { font-size: 8px; font-weight: 600; text-transform: uppercase; color: var(--text-muted); letter-spacing: .5px; }
    .dst-val { font-size: 14px; font-weight: 700; color: var(--text-primary); }
    
    .draft-actions { display: flex; gap: 8px; margin-top: auto; padding-top: 12px; border-top: 1px solid var(--border); }
    .btn-icon {
        width: 32px; height: 32px; border-radius: 6px; border: 1px solid var(--border);
        display: flex; align-items: center; justify-content: center; background: var(--surface);
        color: var(--text-secondary); cursor: pointer; transition: all .15s;
    }
    .btn-icon:hover { background: var(--bg); color: var(--text-primary); border-color: var(--text-muted); }
    .btn-icon.danger:hover { background: var(--red-light); color: var(--red); border-color: var(--red); }
</style>
</head>
<body>

@include('admin.partials.sidebar')

<main>
    <header>
        <div></div>
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
        <div class="page-header">
            <div>
                <div class="breadcrumb">
                    <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                    <span class="material-symbols-rounded" style="font-size:11px;">chevron_right</span>
                    <a href="{{ route('admin.import') }}">Import Excel</a>
                    <span class="material-symbols-rounded" style="font-size:11px;">chevron_right</span>
                    <span>Draft Antrian</span>
                </div>
                <h2>Draft Import Antrian</h2>
                <p>Kelola data yang telah diupload sebelum masuk ke database utama.</p>
            </div>
            <a href="{{ route('admin.import') }}" class="btn btn-primary" style="display:inline-flex; align-items:center; gap:6px; color:#fff; text-decoration:none;">
                <span class="material-symbols-rounded">add</span>
                Upload Baru
            </a>
        </div>

        @if(session('success'))
        <div style="background:var(--green-light); color:var(--green); padding:12px; border-radius:10px; border:1px solid var(--green); font-size: var(--fs-sm); display:flex; align-items:center; gap:8px;">
            <span class="material-symbols-rounded">check_circle</span>
            {{ session('success') }}
        </div>
        @endif

        @if($drafts->isEmpty())
        <div style="text-align:center; padding:60px 20px; background:var(--surface); border:1px dashed var(--border); border-radius:14px; color:var(--text-muted);">
            <span class="material-symbols-rounded" style="font-size:48px; margin-bottom:12px; opacity:.3;">inventory_2</span>
            <p style="font-size:var(--fs-base); font-weight:600;">Belum ada draft antrian</p>
            <p style="font-size:var(--fs-sm);">Silakan upload file Excel dan simpan sebagai draft terlebih dahulu.</p>
        </div>
        @else
        <div class="draft-grid">
            @foreach($drafts as $draft)
            <div class="draft-card">
                <div style="display:flex; gap:12px; align-items:flex-start;">
                    <div class="draft-icon">
                        <span class="material-symbols-rounded">description</span>
                    </div>
                    <div style="flex:1; min-width:0;">
                        <div class="draft-title">{{ $draft->file_name ?? 'Import Tanpa Nama' }}</div>
                        <div class="draft-meta">
                            <span><span class="material-symbols-rounded" style="font-size:12px; vertical-align:middle;">person</span> {{ $draft->user->name }}</span>
                            <span><span class="material-symbols-rounded" style="font-size:12px; vertical-align:middle;">calendar_today</span> {{ $draft->created_at->diffForHumans() }}</span>
                        </div>
                    </div>
                </div>

                <div class="draft-stats">
                    <div class="dst-item">
                        <div class="dst-label">Total Baris</div>
                        <div class="dst-val">{{ count($draft->data) }}</div>
                    </div>
                    <div class="dst-item">
                        <div class="dst-label">Tipe</div>
                        <div class="dst-val" style="text-transform:capitalize;">{{ $draft->type }}</div>
                    </div>
                </div>

                <div class="draft-actions">
                    <a href="{{ route('admin.drafts.show', $draft->id) }}" class="btn btn-primary" style="flex:1; font-size:var(--fs-sm); text-decoration:none; display:inline-flex; align-items:center; justify-content:center; gap:6px;">
                        <span class="material-symbols-rounded" style="font-size:14px;">visibility</span>
                        Tinjau & Edit
                    </a>
                    <button type="button" class="btn-icon danger js-univ-confirm" title="Hapus Draft"
                        data-title="Hapus Draft?"
                        data-desc="Apakah Anda yakin ingin menghapus draft <strong>{{ addslashes($draft->file_name ?? 'Import Tanpa Nama') }}</strong>? Data yang belum diproses akan hilang."
                        data-action="{{ route('admin.drafts.destroy', $draft->id) }}">
                        <span class="material-symbols-rounded" style="font-size:18px;">delete</span>
                    </button>
                </div>
            </div>
            @endforeach
        </div>
        @endif
    </div>
</main>
@include('admin.partials.confirm_modal')
@include('admin.partials.layout_scripts')
</body>
</html>
