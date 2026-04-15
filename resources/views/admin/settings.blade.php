@extends('layouts.admin')

@section('title', 'Koperasi Ugoro — Pengaturan')

@push('styles')
<style>
  /* Page Specific Styles */
  .material-symbols-rounded {
    font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 20;
    font-size: 16px;
    line-height: 1;
    vertical-align: middle;
  }

  /* ── Canvas ── */
  .canvas { padding: 24px; display: flex; flex-direction: column; gap: 20px; max-width: 1400px; width: 100%; margin: 0 auto; }
  .page-header { display: flex; align-items: flex-end; justify-content: space-between; gap: 12px; }
  .page-header h2 { font-size: 18px; font-weight: 800; color: var(--text-primary); letter-spacing: -.3px; line-height: 1.2; }
  .page-header p { font-size: 11px; color: var(--text-muted); font-weight: 500; margin-top: 2px; }

  /* ── Alerts ── */
  .alert { padding: 10px 14px; border-radius: 8px; font-size: 12px; font-weight: 600; display: flex; align-items: center; gap: 8px; }
  .alert-success { background: var(--green-light); color: var(--green); border: 1px solid var(--green-mid); }
  .alert-error { background: var(--red-light); color: var(--red); border: 1px solid #fecaca; }

  /* ── Cards ── */
  .card { background: var(--surface); border: 1px solid var(--border); border-radius: var(--radius); box-shadow: var(--shadow); overflow: hidden; }
  .card-head { padding: 14px 20px; border-bottom: 1px solid var(--border); display: flex; align-items: center; gap: 8px; }
  .card-head .material-symbols-rounded { font-size: 16px; }
  .card-head h3 { font-size: 14px; font-weight: 700; color: var(--text-primary); }
  .card-body { padding: 20px; }

  /* ── Forms ── */
  .fg { margin-bottom: 14px; }
  .fg:last-child { margin-bottom: 0; }
  .fg label { display: block; font-size: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: .5px; color: var(--text-muted); margin-bottom: 5px; }
  .fg .hint { font-size: 11px; color: var(--text-muted); margin-top: 3px; }

  .fi { width: 100%; padding: 8px 12px; border: 1px solid var(--border); border-radius: 8px; background: var(--bg); font-size: 13px; font-family: inherit; color: var(--text-primary); outline: none; transition: border-color .15s, box-shadow .15s; }
  .fi:focus { border-color: var(--green); box-shadow: 0 0 0 3px rgba(22,163,74,.1); }
  .fi::placeholder { color: var(--text-muted); }
  .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; }

  /* ── Toggle ── */
  .toggle-row { display: flex; align-items: center; justify-content: space-between; padding: 12px 0; border-bottom: 1px solid var(--border); }
  .toggle-row:last-child { border-bottom: none; }
  .toggle-label { font-size: 13px; font-weight: 600; color: var(--text-primary); }
  .toggle-sub { font-size: 11px; color: var(--text-muted); margin-top: 1px; }
  .switch { position: relative; display: inline-block; width: 36px; height: 20px; flex-shrink: 0; }
  .switch input { opacity: 0; width: 0; height: 0; }
  .slider { position: absolute; cursor: pointer; top: 0; left: 0; right: 0; bottom: 0; background-color: #cbd5e1; transition: .25s; border-radius: 20px; }
  [data-theme="dark"] .slider { background-color: #334155; }
  .slider:before { position: absolute; content: ""; height: 14px; width: 14px; left: 3px; bottom: 3px; background-color: white; transition: .25s; border-radius: 50%; box-shadow: 0 1px 3px rgba(0,0,0,.15); }
  input:checked + .slider { background-color: var(--green); }
  input:checked + .slider:before { transform: translateX(16px); }

  /* ── Buttons ── */
  .btn { display: inline-flex; align-items: center; gap: 8px; padding: 8px 16px; border-radius: 10px; font-size: 13px; font-weight: 700; font-family: inherit; cursor: pointer; border: none; transition: all .2s; text-decoration: none; }
  .btn-primary { background: var(--green); color: #fff; box-shadow: 0 4px 12px rgba(22,163,74,.2); }
  .btn-primary:hover { background: #15803d; transform: translateY(-1px); }
  .btn-outline { background: var(--surface); border: 1px solid var(--border); color: var(--text-primary); }
  .btn-outline:hover { background: var(--bg); border-color: var(--text-muted); }
  .card-footer { padding: 16px 20px; border-top: 1px solid var(--border); background: #fafbfa; display: flex; justify-content: flex-end; gap: 8px; }
  [data-theme="dark"] .card-footer { background: var(--surface); }
</style>
@endpush

@section('content')
<div style="max-width: 1200px; margin: 0 auto; width: 100%;">

    <!-- Page Title -->
    <div class="page-header">
      <div>
        <h2>Pengaturan Sistem</h2>
        <p>Konfigurasi dasar koperasi, simpanan, dan pinjaman</p>
      </div>
    </div>

    @if (session('success'))
    <div class="alert alert-success">
      <span class="material-symbols-rounded">check_circle</span>
      {{ session('success') }}
    </div>
    @endif
    @if ($errors->any() || session('error'))
    <div class="alert alert-error">
      <span class="material-symbols-rounded">error</span>
      {{ session('error') ?? $errors->first() }}
    </div>
    @endif

    <form action="{{ route('admin.settings.update') }}" method="POST">
      @csrf

      <!-- 1. Pengaturan Umum -->
      <div class="card" style="margin-bottom: 16px;">
        <div class="card-head">
          <span class="material-symbols-rounded" style="color:var(--green)">corporate_fare</span>
          <h3>Pengaturan Umum</h3>
        </div>
        <div class="card-body">
          <div class="fg">
            <label>Nama Koperasi</label>
            <input class="fi" type="text" name="koperasi_name" value="{{ $settings['koperasi_name'] ?? 'Koperasi Ugoro' }}">
          </div>
          <div class="fg">
            <label>Alamat Lengkap</label>
            <input class="fi" type="text" name="koperasi_address" value="{{ $settings['koperasi_address'] ?? '' }}" placeholder="Jl. Raya Koperasi No.1">
          </div>
          <div class="form-row">
            <div class="fg">
              <label>Email Kontak</label>
              <input class="fi" type="email" name="koperasi_email" value="{{ $settings['koperasi_email'] ?? '' }}" placeholder="info@koperasi.co.id">
            </div>
            <div class="fg">
              <label>No. Telepon</label>
              <input class="fi" type="text" name="koperasi_phone" value="{{ $settings['koperasi_phone'] ?? '' }}" placeholder="0812...">
            </div>
          </div>
        </div>
      </div>

      <!-- 2. Pengaturan Simpanan -->
      <div class="card" style="margin-bottom: 16px;">
        <div class="card-head">
          <span class="material-symbols-rounded" style="color:var(--orange)">savings</span>
          <h3>Pengaturan Simpanan</h3>
        </div>
        <div class="card-body">
          <div class="fg">
            <label>Nominal Simpanan Wajib (Per Bulan)</label>
            <input class="fi" type="number" name="simpanan_wajib_nominal" value="{{ $settings['simpanan_wajib_nominal'] ?? 20000 }}">
            <div class="hint">Otomatis muncul saat admin input simpanan bulanan anggota.</div>
          </div>

          <div style="margin-top: 18px;">
            <label style="display:block; font-size:10px; font-weight:700; text-transform:uppercase; letter-spacing:.5px; color:var(--text-muted); margin-bottom:8px;">Aktifkan Jenis Simpanan</label>

            <div class="toggle-row">
              <div><div class="toggle-label">Simpanan Pokok</div><div class="toggle-sub">Dibayar sekali saat pendaftaran</div></div>
              <label class="switch"><input type="checkbox" name="simpanan_pokok_active" {{ ($settings['simpanan_pokok_active'] ?? 'true') === 'true' ? 'checked' : '' }}><span class="slider"></span></label>
            </div>
            <div class="toggle-row">
              <div><div class="toggle-label">Simpanan Wajib</div><div class="toggle-sub">Rutinitas bulanan</div></div>
              <label class="switch"><input type="checkbox" name="simpanan_wajib_active" {{ ($settings['simpanan_wajib_active'] ?? 'true') === 'true' ? 'checked' : '' }}><span class="slider"></span></label>
            </div>
            <div class="toggle-row">
              <div><div class="toggle-label">Simpanan Monosuko</div><div class="toggle-sub">Bisa diambil kapan saja</div></div>
              <label class="switch"><input type="checkbox" name="simpanan_monosuko_active" {{ ($settings['simpanan_monosuko_active'] ?? 'true') === 'true' ? 'checked' : '' }}><span class="slider"></span></label>
            </div>
            <div class="toggle-row">
              <div><div class="toggle-label">Simpanan Sukarela</div><div class="toggle-sub">Opsional dari anggota</div></div>
              <label class="switch"><input type="checkbox" name="simpanan_sukarela_active" {{ ($settings['simpanan_sukarela_active'] ?? 'true') === 'true' ? 'checked' : '' }}><span class="slider"></span></label>
            </div>
          </div>
        </div>
      </div>

      <!-- 3. Pengaturan Pinjaman -->
      <div class="card" style="margin-bottom: 16px;">
        <div class="card-head">
          <span class="material-symbols-rounded" style="color:#3b82f6">payments</span>
          <h3>Pengaturan Pinjaman</h3>
        </div>
        <div class="card-body">
          <div class="fg">
            <label>Bunga Pinjaman (%)</label>
            <input class="fi" type="number" step="0.01" name="pinjaman_bunga" value="{{ $settings['pinjaman_bunga'] ?? 2 }}">
            <div class="hint">Digunakan otomatis saat input dan kalkulasi angsuran.</div>
          </div>
          <div class="form-row">
            <div class="fg">
              <label>Maksimal Pinjaman (Rp)</label>
              <input class="fi" type="number" name="pinjaman_max" value="{{ $settings['pinjaman_max'] ?? 50000000 }}">
            </div>
            <div class="fg">
              <label>Maksimal Tenor (Bulan)</label>
              <input class="fi" type="number" name="pinjaman_max_tenor" value="{{ $settings['pinjaman_max_tenor'] ?? 36 }}">
            </div>
          </div>
        </div>
      </div>

      <!-- 4. Pengaturan Tampilan -->
      <div class="card" style="margin-bottom: 16px;">
        <div class="card-head">
          <span class="material-symbols-rounded" style="color:var(--orange)">dark_mode</span>
          <h3>Pengaturan Tampilan</h3>
        </div>
        <div class="card-body">
          <div class="toggle-row">
            <div>
              <div class="toggle-label">Mode Gelap</div>
              <div class="toggle-sub">Gunakan tema gelap pada antarmuka admin</div>
            </div>
            <label class="switch">
              <input type="hidden" name="admin_theme" id="admin-theme-hidden" value="{{ $settings['admin_theme'] ?? 'light' }}">
              <input type="checkbox" id="admin-theme-switch" onchange="toggleTheme(); updateAdminToggleState()">
              <span class="slider"></span>
            </label>
          </div>
        </div>
      </div>

      <!-- 5. Akun Admin -->
      <div class="card" style="margin-bottom: 16px;">
        <div class="card-head">
          <span class="material-symbols-rounded" style="color:var(--text-secondary)">manage_accounts</span>
          <h3>Akun Admin</h3>
        </div>
        <div class="card-body">
          <div class="form-row">
            <div class="fg">
              <label>Nama Admin</label>
              <input class="fi" type="text" name="admin_name" value="{{ Auth::user()->name }}">
            </div>
            <div class="fg">
              <label>Email Admin</label>
              <input class="fi" type="email" name="admin_email" value="{{ Auth::user()->email }}">
            </div>
          </div>
          <div style="margin-top: 14px; padding-top: 14px; border-top: 1px solid var(--border);">
            <label style="display:block; font-size:10px; font-weight:700; text-transform:uppercase; letter-spacing:.5px; color:var(--orange); margin-bottom:8px;">Ubah Password (Opsional)</label>
            <div class="fg">
              <input class="fi" type="password" name="admin_old_password" placeholder="Password Lama">
            </div>
            <div class="form-row">
              <div class="fg">
                <input class="fi" type="password" name="admin_new_password" placeholder="Password Baru (Min 8 karakter)">
              </div>
              <div class="fg">
                <input class="fi" type="password" name="admin_new_password_confirmation" placeholder="Konfirmasi Password Baru">
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Footer Actions -->
      <div class="card">
        <div style="padding: 16px 20px; display: flex; justify-content: space-between; align-items: center;">
          <div style="font-size: 12px; color: var(--text-muted);">
            <span class="material-symbols-rounded" style="font-size: 14px; vertical-align: -2px;">info</span>
            Perubahan langsung berlaku setelah disimpan.
          </div>
          <div style="display: flex; gap: 8px;">
            <button type="reset" class="btn btn-outline">
              <span class="material-symbols-rounded" style="font-size:14px;">restart_alt</span> Reset
            </button>
            <button type="submit" class="btn btn-primary">
              <span class="material-symbols-rounded" style="font-size:14px;">save</span> Simpan Pengaturan
            </button>
          </div>
        </div>
      </div>

    </form>

</div>
@endsection

@push('scripts')
<script>
  function updateAdminToggleState() {
    const theme = document.documentElement.getAttribute('data-theme') || 'light';
    const isDark = theme === 'dark';
    const switchEl = document.getElementById('admin-theme-switch');
    const hiddenEl = document.getElementById('admin-theme-hidden');
    
    if (switchEl) switchEl.checked = isDark;
    if (hiddenEl) hiddenEl.value = theme;
  }
  document.addEventListener('DOMContentLoaded', updateAdminToggleState);
  window.addEventListener('themeChanged', updateAdminToggleState);
</script>
@endpush

