<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>Admin - Edit Struktur — Koperasi Ugoro</title>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet"/>
@include('admin.partials.layout_styles')
<style>
  *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
  .canvas { padding: 24px; max-width: 800px; width: 100%; margin: 0 auto; }
  .page-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 24px; }
  .page-header h2 { font-size: 20px; font-weight: 800; color: var(--text-primary); letter-spacing: -.5px; }
  .btn { display: inline-flex; align-items: center; gap: 6px; padding: 8px 16px; border-radius: 8px; font-size: 13px; font-weight: 700; cursor: pointer; border: none; font-family: inherit; text-decoration: none; transition: .15s; }
  .btn-outline { background: var(--surface); border: 1px solid var(--border); color: var(--text-secondary); }
  .btn-primary { background: var(--green); color: #fff; }
  .card { background: var(--surface); border: 1px solid var(--border); border-radius: var(--radius); padding: 32px; box-shadow: 0 4px 6px -1px rgba(0,0,0,.05); }
  .form-group { margin-bottom: 20px; }
  label { display: block; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: .5px; color: var(--text-muted); margin-bottom: 8px; }
  .form-control { width: 100%; padding: 10px 14px; border: 1.5px solid var(--border); border-radius: 8px; font-size: 14px; font-family: inherit; outline: none; transition: .15s; color: var(--text-primary); background: var(--bg); }
  .form-control:focus { border-color: var(--green); box-shadow: 0 0 0 4px var(--green-light); }
  .grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
  .photo-preview { width: 80px; height: 80px; border-radius: 12px; background: var(--bg); display: flex; align-items: center; justify-content: center; border: 2px dashed var(--border); margin-bottom: 12px; overflow: hidden; }
  .photo-preview img { width: 100%; height: 100%; object-fit: cover; }
  .material-symbols-rounded { font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 20; font-size: 16px; }
</style>
@include('admin.partials.theme')
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
    <div class="page-header">
      <h2>Edit Anggota: {{ $karyawan->name }}</h2>
      <a href="{{ route('karyawans.index') }}" class="btn btn-outline">Batal</a>
    </div>

    <div class="card">
      <form action="{{ route('karyawans.update', $karyawan->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="form-group">
          <label>Nama Lengkap</label>
          <input name="name" class="form-control" value="{{ $karyawan->name }}" placeholder="Masukkan nama lengkap..." required type="text"/>
        </div>

        <div class="grid-2">
          <div class="form-group">
            <label>Jabatan</label>
            <input name="position" class="form-control" value="{{ $karyawan->position }}" placeholder="Contoh: Ketua Koperasi, Admin IT..." required type="text"/>
          </div>
          <div class="form-group">
            <label>Tipe Struktur</label>
            <select name="type" class="form-control" required>
              <option value="Pengurus" {{ $karyawan->type == 'Pengurus' ? 'selected' : '' }}>Pengurus</option>
              <option value="Pengawas" {{ $karyawan->type == 'Pengawas' ? 'selected' : '' }}>Pengawas</option>
              <option value="Karyawan" {{ $karyawan->type == 'Karyawan' ? 'selected' : '' }}>Karyawan</option>
            </select>
          </div>
        </div>

        <div class="grid-2">
          <div class="form-group">
            <label>NIP / No. Identitas</label>
            <input name="nip" class="form-control" value="{{ $karyawan->nip }}" placeholder="Contoh: 1980... / EMP-001" type="text"/>
          </div>
          <div class="form-group">
            <label>Status</label>
            <select name="status" class="form-control" required>
              <option value="AKTIF" {{ $karyawan->status == 'AKTIF' ? 'selected' : '' }}>AKTIF</option>
              <option value="NONAKTIF" {{ $karyawan->status == 'NONAKTIF' ? 'selected' : '' }}>NONAKTIF</option>
            </select>
          </div>
        </div>

        <div class="form-group">
          <label>Urutan Tampil (Semakin kecil semakin di depan)</label>
          <input name="order_num" class="form-control" type="number" value="{{ $karyawan->order_num }}" required/>
        </div>

        <div class="form-group">
          <label>Bio / Keterangan Singkat</label>
          <textarea name="bio" class="form-control" rows="3" placeholder="Masukkan bio jika ada...">{{ $karyawan->bio }}</textarea>
        </div>

        <div class="form-group">
          <label>Foto Profil (JPG/PNG, Max 2MB)</label>
          <div id="previewBox" class="photo-preview">
            @if($karyawan->photo)
              <img src="{{ asset('storage/' . $karyawan->photo) }}" alt="Preview">
            @else
              <span class="material-symbols-rounded" style="font-size:24px; color:#d1d5d1">image</span>
            @endif
          </div>
          <input name="photo" class="form-control" type="file" accept="image/*" onchange="previewImage(this)"/>
          <p style="font-size:10px; color:var(--text-muted); margin-top:8px;">Biarkan kosong jika tidak ingin mengubah foto lama.</p>
        </div>

        <div style="margin-top:12px; display:flex; justify-content:flex-end;">
          <button class="btn btn-primary" type="submit" style="padding:12px 32px;">Perbarui Data</button>
        </div>
      </form>
    </div>
  </div>
</main>

<script>
  function previewImage(input) {
    if (input.files && input.files[0]) {
      var reader = new FileReader();
      reader.onload = function(e) {
        document.getElementById('previewBox').innerHTML = '<img src="' + e.target.result + '">';
      }
      reader.readAsDataURL(input.files[0]);
    }
  }
</script>

</body>
</html>

