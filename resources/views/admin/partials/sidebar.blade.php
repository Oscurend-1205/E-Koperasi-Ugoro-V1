<!-- ── Sidebar ── -->
<aside>
  <div class="sidebar-brand">
    <h1>E - Koperasi Ugoro</h1>
    <span>Admin System</span>
  </div>
  <nav>
    <div class="nav-section-label">Menu</div>
    <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
      <span class="material-symbols-rounded">dashboard</span>Dashboard
    </a>
    <a href="{{ route('admin.dataAnggota') }}" class="{{ request()->routeIs('admin.dataAnggota') ? 'active' : '' }}">
      <span class="material-symbols-rounded">group</span>Data Anggota
    </a>
    <a href="{{ route('admin.inputSimpanan') }}" class="{{ request()->routeIs('admin.inputSimpanan') ? 'active' : '' }}">
      <span class="material-symbols-rounded">savings</span>Simpanan
    </a>
    <a href="{{ route('admin.inputPinjaman') }}" class="{{ request()->routeIs('admin.inputPinjaman') ? 'active' : '' }}">
      <span class="material-symbols-rounded">payments</span>Pinjaman
    </a>
    <a href="#">
      <span class="material-symbols-rounded">event_repeat</span>Angsuran
    </a>
    <a href="{{ route('karyawans.index') }}" class="{{ request()->routeIs('karyawans.*') ? 'active' : '' }}">
      <span class="material-symbols-rounded">account_tree</span>Struktur Pegawai
    </a>
    <div class="nav-section-label" style="margin-top:8px;">Lainnya</div>
    <a href="{{ route('admin.import') }}" class="{{ request()->routeIs('admin.import*') ? 'active' : '' }}">
      <span class="material-symbols-rounded">upload_file</span>Import Excel
    </a>

    <a href="{{ route('admin.messages') }}" class="{{ request()->routeIs('admin.messages') ? 'active' : '' }}">
      <span class="material-symbols-rounded">mail</span>Pesan Masuk
    </a>
    <a href="{{ route('admin.informasi.index') }}" class="{{ request()->routeIs('admin.informasi.*') ? 'active' : '' }}">
      <span class="material-symbols-rounded">campaign</span>Kelola Informasi
    </a>
    <a href="#">
      <span class="material-symbols-rounded">assessment</span>Laporan
    </a>
    <a href="{{ route('admin.settings') }}" class="{{ request()->routeIs('admin.settings') ? 'active' : '' }}">
      <span class="material-symbols-rounded">settings</span>Pengaturan
    </a>
  </nav>
  <div class="sidebar-footer">
    <form action="{{ route('logout') }}" method="POST">
      @csrf
      <button type="submit"><span class="material-symbols-rounded">logout</span>Logout</button>
    </form>
  </div>
</aside>

@include('admin.partials.loader')
