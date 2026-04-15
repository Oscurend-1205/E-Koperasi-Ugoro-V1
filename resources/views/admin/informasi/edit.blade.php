@extends('layouts.admin')

@section('title', 'Edit Informasi — Koperasi Ugoro')

@push('styles')
<style>
  /* ── Canvas ── */
  .canvas { padding: 24px; display: flex; flex-direction: column; gap: 20px; max-width: 1400px; width: 100%; margin: 0 auto; }

  .page-header { display: flex; align-items: center; justify-content: space-between; gap: 16px; margin-bottom: 4px; }
  .page-header h2 { font-size: 22px; font-weight: 800; color: var(--text-primary); letter-spacing: -.5px; }
  .page-header p { font-size: 12px; color: var(--text-muted); font-weight: 500; margin-top: 2px; }

  .breadcrumb { display: flex; align-items: center; gap: 6px; font-size: 12px; color: var(--text-muted); }
  .breadcrumb a { color: var(--green); text-decoration: none; font-weight: 600; }
  .breadcrumb a:hover { text-decoration: underline; }

  .card { background: var(--surface); border: 1px solid var(--border); border-radius: 16px; box-shadow: var(--shadow); overflow: visible; }
  .card-header { padding: 12px 16px; border-bottom: 1px solid var(--border); display: flex; align-items: center; justify-content: space-between; }
  .card-title { display: flex; align-items: center; gap: 8px; font-size: 13px; font-weight: 700; color: var(--text-primary); }
  .card-title .material-symbols-rounded { font-size: 18px; }

  .composer-body { padding: 16px; display: flex; flex-direction: column; gap: 14px; }
  .form-group { display: flex; flex-direction: column; gap: 4px; }
  .form-group > label { font-size: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: .5px; color: var(--text-muted); }
  .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; }
  .form-input { width: 100%; padding: 8px 12px; border: 1px solid var(--border); border-radius: 8px; background: var(--bg); font-size: 13px; font-family: inherit; color: var(--text-primary); outline: none; transition: border-color .15s, box-shadow .15s; }
  .form-input:focus { border-color: var(--green); box-shadow: 0 0 0 3px rgba(22,163,74,.1); }
  .title-input { font-size: 20px; font-weight: 800; border: none; background: none; padding: 0; color: var(--text-primary); letter-spacing: -.3px; outline: none; width: 100%; }
  .title-input::placeholder { color: var(--text-muted); }

  .options-row { display: flex; align-items: center; gap: 16px; flex-wrap: wrap; }
  .toggle-wrap { display: flex; align-items: center; gap: 8px; }
  .toggle-wrap label { margin: 0; text-transform: none; font-size: 12px; font-weight: 600; color: var(--text-secondary); letter-spacing: 0; }
  .toggle { position: relative; width: 34px; height: 18px; appearance: none; background: #cbd5e1; border-radius: 999px; cursor: pointer; transition: background .2s; border: none; outline: none; }
  [data-theme="dark"] .toggle { background: #334155; }
  .toggle::before { content: ''; position: absolute; top: 2px; left: 2px; width: 14px; height: 14px; background: white; border-radius: 50%; transition: transform .2s; box-shadow: 0 1px 3px rgba(0,0,0,.15); }
  .toggle:checked { background: var(--green); }
  .toggle:checked::before { transform: translateX(16px); }

  .composer-footer { padding: 12px 16px; border-top: 1px solid var(--border); background: #fafbfa; display: flex; align-items: center; justify-content: space-between; gap: 12px; flex-wrap: wrap; border-radius: 0 0 16px 16px; }
  [data-theme="dark"] .composer-footer { background: #1e293b; }
  .char-count { font-size: 11px; color: var(--text-muted); font-weight: 500; }
  .btn-publish { padding: 8px 20px; background: linear-gradient(135deg, var(--green) 0%, #059669 100%); color: #fff; border: none; border-radius: 10px; font-size: 13px; font-weight: 700; font-family: inherit; cursor: pointer; transition: opacity .15s, transform .1s; box-shadow: 0 4px 14px rgba(22,163,74,.3); display: inline-flex; align-items: center; gap: 8px; }

  .error-list { background: #fef2f2; border: 1px solid #fee2e2; border-radius: 10px; padding: 10px 14px; margin-bottom: 20px; }
  [data-theme="dark"] .error-list { background: rgba(248, 113, 113, 0.1); border-color: rgba(248, 113, 113, 0.2); }
  .error-list p { font-size: 12px; font-weight: 700; color: #dc2626; margin-bottom: 2px; }
  .error-list ul { list-style: none; padding: 0; }
  .error-list li { font-size: 11px; color: #dc2626; padding: 1px 0; }
  .error-list li::before { content: '•'; margin-right: 6px; }

  @media (max-width: 768px) {
    .canvas { padding: 14px; }
    .form-row { grid-template-columns: 1fr; }
  }

  /* ── Cropper Modal ── */
  #cropperModal .modal-box { max-width: 800px; width: 95%; }
  .cropper-container-wrapper { width: 100%; height: 400px; background: #000; display: flex; align-items: center; justify-content: center; overflow: hidden; border-radius: 8px; }
  #cropperImg { max-width: 100%; display: block; }

  .card { background: var(--surface); border: 1px solid var(--border); border-radius: 16px; box-shadow: var(--shadow); overflow: visible; }
  .card-header { padding: 12px 16px; border-bottom: 1px solid var(--border); display: flex; align-items: center; justify-content: space-between; }
  .card-title { display: flex; align-items: center; gap: 8px; font-size: 13px; font-weight: 700; color: var(--text-primary); }
  .card-title .material-symbols-rounded { font-size: 18px; }

  .composer-body { padding: 16px; display: flex; flex-direction: column; gap: 14px; }
  .form-group { display: flex; flex-direction: column; gap: 4px; }
  .form-group > label { font-size: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: .5px; color: var(--text-muted); }
  .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; }
  .form-input { width: 100%; padding: 8px 12px; border: 1px solid var(--border); border-radius: 8px; background: var(--bg); font-size: 13px; font-family: inherit; color: var(--text-primary); outline: none; transition: border-color .15s, box-shadow .15s; }
  .form-input:focus { border-color: var(--green); box-shadow: 0 0 0 3px rgba(22,163,74,.1); }
  .title-input { font-size: 20px; font-weight: 800; border: none; background: none; padding: 0; color: var(--text-primary); letter-spacing: -.3px; outline: none; width: 100%; }
  .title-input::placeholder { color: var(--text-muted); }

  .options-row { display: flex; align-items: center; gap: 16px; flex-wrap: wrap; }
  .toggle-wrap { display: flex; align-items: center; gap: 8px; }
  .toggle-wrap label { margin: 0; text-transform: none; font-size: 12px; font-weight: 600; color: var(--text-secondary); letter-spacing: 0; }
  .toggle { position: relative; width: 34px; height: 18px; appearance: none; background: #cbd5e1; border-radius: 999px; cursor: pointer; transition: background .2s; border: none; outline: none; }
  [data-theme="dark"] .toggle { background: #334155; }
  .toggle::before { content: ''; position: absolute; top: 2px; left: 2px; width: 14px; height: 14px; background: white; border-radius: 50%; transition: transform .2s; box-shadow: 0 1px 3px rgba(0,0,0,.15); }
  .toggle:checked { background: var(--green); }
  .toggle:checked::before { transform: translateX(16px); }

  .composer-footer { padding: 12px 16px; border-top: 1px solid var(--border); background: #fafbfa; display: flex; align-items: center; justify-content: space-between; gap: 12px; flex-wrap: wrap; border-radius: 0 0 16px 16px; }
  [data-theme="dark"] .composer-footer { background: #1e293b; }
  .char-count { font-size: 11px; color: var(--text-muted); font-weight: 500; }
  .btn-publish { padding: 8px 20px; background: linear-gradient(135deg, var(--green) 0%, #059669 100%); color: #fff; border: none; border-radius: 10px; font-size: 13px; font-weight: 700; font-family: inherit; cursor: pointer; transition: opacity .15s, transform .1s; box-shadow: 0 4px 14px rgba(22,163,74,.3); display: inline-flex; align-items: center; gap: 8px; }
  .btn-publish:hover { opacity: .92; }
  .btn-publish:active { transform: scale(.98); }

  .error-list { background: #fef2f2; border: 1px solid #fee2e2; border-radius: 10px; padding: 10px 14px; }
  [data-theme="dark"] .error-list { background: rgba(248, 113, 113, 0.1); border-color: rgba(248, 113, 113, 0.2); }
  .error-list p { font-size: 12px; font-weight: 700; color: #dc2626; margin-bottom: 2px; }
  .error-list ul { list-style: none; padding: 0; }
  .error-list li { font-size: 11px; color: #dc2626; padding: 1px 0; }
  .error-list li::before { content: '•'; margin-right: 6px; }

  @media (max-width: 768px) {
    aside { display: none; }
    .canvas { padding: 14px; }
    .form-row { grid-template-columns: 1fr; }
  }

  /* ── Cropper Modal ── */
  #cropperModal .modal-box { max-width: 800px; width: 95%; }
  .cropper-container-wrapper { width: 100%; height: 400px; background: #000; display: flex; align-items: center; justify-content: center; overflow: hidden; border-radius: 8px; }
  #cropperImg { max-width: 100%; display: block; }
</style>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>
@endpush

@section('content')
    <div class="breadcrumb">
      <a href="{{ route('admin.informasi.index') }}">Informasi</a>
      <span class="material-symbols-rounded" style="font-size:14px;">chevron_right</span>
      <span>Edit</span>
    </div>

    <div class="page-header">
      <div style="display:flex; align-items:center; gap:12px;">
        <span class="material-symbols-rounded" style="font-size:28px; color:var(--orange)">edit_note</span>
        <div>
          <h2 style="font-size:18px; font-weight:800;">Edit Informasi</h2>
          <p style="font-size:11px; color:var(--text-muted);">Perbarui informasi "{{ $informasi->title }}"</p>
        </div>
      </div>
    </div>

    @if($errors->any())
      <div class="error-list">
        <p>Terjadi kesalahan:</p>
        <ul>@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
      </div>
    @endif

    <form action="{{ route('admin.informasi.update', $informasi) }}" method="POST" id="composerForm">
      @csrf
      @method('PUT')
      <div class="card">
        <div class="card-header">
          <div class="card-title">
            <span class="material-symbols-rounded" style="color:var(--orange)">edit_note</span>
            Edit Compose
          </div>
          <span style="font-size:10px; color:var(--text-muted); font-weight:600;">Rich Text Editor</span>
        </div>

        <div class="composer-body">
          <div class="form-group">
            <input type="text" name="title" class="title-input" placeholder="Judul informasi..." value="{{ old('title', $informasi->title) }}" required/>
          </div>

          <div class="form-row">
            <div class="form-group">
              <label>Kategori</label>
              <select name="category" class="form-input" required>
                @foreach(['Umum', 'Penting', 'Keuangan', 'Kegiatan'] as $cat)
                  <option value="{{ $cat }}" {{ old('category', $informasi->category) == $cat ? 'selected' : '' }}>
                    {{ $cat }}
                  </option>
                @endforeach
              </select>
            </div>
            <div class="form-group" style="justify-content:flex-end;">
              <div class="options-row" style="margin-top:auto;">
                <div class="toggle-wrap">
                  <input type="checkbox" name="is_pinned" value="1" class="toggle" id="togglePin" {{ old('is_pinned', $informasi->is_pinned) ? 'checked' : '' }}/>
                  <label for="togglePin">📌 Pin di atas</label>
                </div>
                <div class="toggle-wrap">
                  <input type="checkbox" name="is_active" value="1" class="toggle" id="toggleActive" {{ old('is_active', $informasi->is_active) ? 'checked' : '' }}/>
                  <label for="toggleActive">✅ Aktif</label>
                </div>
              </div>
            </div>
          </div>

          <!-- WYSIWYG Editor (pre-filled) -->
          @include('admin.informasi._editor', ['informasi' => $informasi])
        </div>

        <div class="composer-footer">
          <div class="char-count" id="charInfo">
            Terakhir diubah: {{ $informasi->updated_at->translatedFormat('d M Y, H:i') }}
          </div>
          <div style="display:flex; gap:8px;">
            <a href="{{ route('admin.informasi.index') }}" class="btn btn-outline">Batal</a>
            <button type="submit" class="btn-publish">
              <span class="material-symbols-rounded" style="font-size:16px;">save</span>
              Simpan Perubahan
            </button>
          </div>
        </div>
      </div>
    </form>
  </div>
@endsection

@push('scripts')
<script>
  const editorEl = document.getElementById('editorContent');
  const charInfo = document.getElementById('charInfo');
  function updateInfo() {
    if (!editorEl || !charInfo) return;
    const text = editorEl.innerText || '';
    const words = text.trim().split(/\s+/).filter(w => w.length > 0).length;
    const chars = text.length;
    const imgs = editorEl.querySelectorAll('img').length;
    charInfo.textContent = `${chars} karakter · ${words} kata` + (imgs ? ` · ${imgs} gambar` : '') + ' · Terakhir diubah: {{ $informasi->updated_at->translatedFormat("d M Y, H:i") }}';
  }
  if (editorEl) {
    editorEl.addEventListener('input', updateInfo);
    updateInfo();
  }
</script>
@endpush
