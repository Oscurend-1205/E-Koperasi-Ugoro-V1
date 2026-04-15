<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>Koperasi Ugoro — Detail Draft</title>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet"/>
@include('admin.partials.layout_styles')
@include('admin.partials.theme')

<style>
    .canvas { padding: 24px; max-width: 1400px; margin: 0 auto; display: flex; flex-direction: column; gap: 20px; }
    .page-header { display: flex; justify-content: space-between; align-items: flex-end; }
    .page-header h2 { font-size: var(--fs-h2); font-weight: 800; color: var(--text-primary); letter-spacing: -0.5px; }
    .page-header p { font-size: var(--fs-sm); color: var(--text-muted); margin-top: 2px; }

    .draft-table-card { background: var(--surface); border: 1px solid var(--border); border-radius: 14px; overflow: hidden; box-shadow: var(--shadow); }
    .table-toolbar { padding: 12px 16px; border-bottom: 1px solid var(--border); display: flex; justify-content: space-between; align-items: center; background: var(--bg); }
    
    .sim-table { width: 100%; border-collapse: collapse; }
    .sim-table thead th { 
        padding: 9px 16px; text-align: left; font-size: var(--fs-xxs); font-weight: 700; 
        text-transform: uppercase; color: var(--text-muted); border-bottom: 1px solid var(--border);
        white-space: nowrap; position: sticky; top: 0; background: var(--surface); z-index: 10;
    }
    .sim-table tbody td { padding: 10px 16px; font-size: var(--fs-sm); color: var(--text-primary); border-bottom: 1px solid var(--border); }
    .sim-table tbody tr:hover td { background: var(--bg); }
    
    .editable-input { 
        width: 100%; border: 1px solid transparent; background: transparent; 
        padding: 4px 8px; border-radius: 4px; font-size: inherit; color: inherit; transition: all .15s;
    }
    .editable-input:focus { border-color: var(--green); background: var(--surface); outline: none; box-shadow: 0 0 0 3px var(--green-light); }
    .editable-input.num { text-align: right; font-variant-numeric: tabular-nums; }

    .btn-row-action { 
        padding: 4px; border-radius: 4px; border: none; background: none; 
        color: var(--text-muted); cursor: pointer; transition: all .15s; display: flex; align-items: center;
    }
    .btn-row-action:hover { background: var(--border); color: var(--text-primary); }
    .btn-row-action.danger:hover { background: var(--red-light); color: var(--red); }
    
    .confirm-panel {
        position: sticky; bottom: 20px; left: 0; right: 0;
        background: var(--surface); border: 1.5px solid var(--green); border-radius: 14px;
        padding: 16px 24px; box-shadow: 0 10px 30px rgba(22, 163, 74, 0.15);
        display: flex; justify-content: space-between; align-items: center; z-index: 100;
        margin-top: 20px;
    }
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
                    <a href="{{ route('admin.drafts.index') }}">Draft Antrian</a>
                    <span class="material-symbols-rounded" style="font-size:11px;">chevron_right</span>
                    <span>Tinjau Data</span>
                </div>
                <h2>{{ $draft->file_name }}</h2>
                <p>Silakan edit data langsung pada tabel jika diperlukan, lalu klik Konfirmasi.</p>
            </div>
            <a href="{{ route('admin.drafts.index') }}" class="btn btn-outline" style="text-decoration:none; display:inline-flex; align-items:center; gap:6px;">
                <span class="material-symbols-rounded">arrow_back</span>
                Kembali ke Daftar
            </a>
        </div>

        <div class="draft-table-card">
            <div class="table-toolbar">
                <div style="display:flex; gap:16px; font-size:var(--fs-sm);">
                    <span>Total: <strong>{{ count($draft->data) }} Baris</strong></span>
                    <span>Tipe: <strong style="text-transform:capitalize;">{{ $draft->type }}</strong></span>
                </div>
                <p style="font-size:10px; color:var(--text-muted); font-style:italic;">* Perubahan disimpan otomatis saat berpindah kolom</p>
            </div>

            <div style="max-height: 60vh; overflow-y: auto;">
                <table class="sim-table">
                    <thead>
                        <tr>
                            <th style="width:50px;">#</th>
                            <th>NIA (No Anggota)</th>
                            <th>Nama Anggota</th>
                            <th style="text-align:right;">S. Pokok</th>
                            <th style="text-align:right;">S. Wajib</th>
                            <th style="text-align:right;">Monosuko</th>
                            <th style="text-align:right;">DPU</th>
                            <th style="width:50px; text-align:center;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($draft->data as $index => $row)
                        <tr id="row-{{ $index }}">
                            <td>{{ $index + 1 }}</td>
                            <td>
                                <input type="text" class="editable-input" value="{{ $row['nia'] }}" 
                                    onblur="updateRow('{{ $index }}', this, 'nia')">
                            </td>
                            <td>
                                <input type="text" class="editable-input" value="{{ $row['name'] }}" 
                                    onblur="updateRow('{{ $index }}', this, 'name')">
                            </td>
                            <td>
                                <input type="text" class="editable-input num format-rupiah" value="{{ number_format($row['pokok'], 0, ',', '.') }}" 
                                    onblur="updateRow('{{ $index }}', this, 'pokok')">
                            </td>
                            <td>
                                <input type="text" class="editable-input num format-rupiah" value="{{ number_format($row['wajib'], 0, ',', '.') }}" 
                                    onblur="updateRow('{{ $index }}', this, 'wajib')">
                            </td>
                            <td>
                                <input type="text" class="editable-input num format-rupiah" value="{{ number_format($row['monosuko'], 0, ',', '.') }}" 
                                    onblur="updateRow('{{ $index }}', this, 'monosuko')">
                            </td>
                            <td>
                                <input type="text" class="editable-input num format-rupiah" value="{{ number_format($row['dpu'], 0, ',', '.') }}" 
                                    onblur="updateRow('{{ $index }}', this, 'dpu')">
                            </td>
                            <td style="text-align:center;">
                                <button class="btn-row-action danger" onclick="removeRow('{{ $index }}')" title="Hapus baris">
                                    <span class="material-symbols-rounded" style="font-size:18px;">delete_sweep</span>
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="confirm-panel">
            <div>
                <p style="font-size:var(--fs-base); font-weight:700; color:var(--text-primary); display:flex; align-items:center; gap:8px;">
                    <span class="material-symbols-rounded" style="color:var(--green);">verified</span>
                    Siap untuk Konfirmasi?
                </p>
                <p style="font-size:var(--fs-xs); color:var(--text-muted);">Pastikan data sudah benar sebelum menyimpan ke database utama.</p>
            </div>
            <div style="display:flex; gap:12px;">
                <button type="button" class="btn js-univ-confirm" 
                        style="background:var(--red-light); color:var(--red); font-weight:700;"
                        data-title="Hapus Draft?"
                        data-desc="Hapus seluruh draft ini? Data akan hilang."
                        data-action="{{ route('admin.drafts.destroy', $draft->id) }}">
                    Hapus Draft
                </button>
                <button type="button" class="btn btn-primary js-univ-confirm" 
                        style="padding: 10px 30px; color:#fff; cursor:pointer;"
                        data-title="Konfirmasi Import?"
                        data-desc="Proses <strong>{{ count($draft->data) }}</strong> data ke database utama?"
                        data-action="{{ route('admin.drafts.confirm', $draft->id) }}"
                        data-method="POST"
                        data-type="info"
                        data-confirm-label="Ya, Simpan Sekarang">
                    <span class="material-symbols-rounded">check_circle</span>
                    Konfirmasi & Simpan
                </button>
            </div>
        </div>
    </div>
</main>

<script>
    function updateRow(index, input, field) {
        const row = document.getElementById(`row-${index}`);
        const inputs = row.querySelectorAll('.editable-input');
        const data = {
            _token: '{{ csrf_token() }}',
            row_index: index,
            nia: inputs[0].value,
            name: inputs[1].value,
            pokok: inputs[2].value,
            wajib: inputs[3].value,
            monosuko: inputs[4].value,
            dpu: inputs[5].value
        };

        fetch('{{ route("admin.drafts.update", $draft->id) }}', {
            method: 'PUT',
            headers: { 'Content-Type': 'application/json', 'Accept': 'application/json' },
            body: JSON.stringify(data)
        }).then(res => res.json()).then(res => {
            if (res.success) {
                input.style.borderColor = 'var(--green)';
                setTimeout(() => input.style.borderColor = 'transparent', 1000);
            }
        });
    }

    function removeRow(index) {
        if (!confirm('Hapus baris ini dari draft?')) return;

        fetch('{{ route("admin.drafts.removeRow", $draft->id) }}', {
            method: 'POST',
            headers: { 
                'Content-Type': 'application/json', 
                'Accept': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ row_index: index })
        }).then(res => res.json()).then(res => {
            if (res.success) {
                const row = document.getElementById(`row-${index}`);
                row.style.opacity = '0';
                row.style.transform = 'translateX(-20px)';
                setTimeout(() => row.remove(), 300);
            }
        });
    }
</script>
@include('admin.partials.confirm_modal')
@include('admin.partials.layout_scripts')
</body>
</html>
