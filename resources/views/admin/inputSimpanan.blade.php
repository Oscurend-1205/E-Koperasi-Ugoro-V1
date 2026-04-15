<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>Koperasi Ugoro — Input Simpanan</title>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet"/>
@include('admin.partials.layout_styles')
@include('admin.partials.theme')

<style>
/* ── Local Style Overrides ── */
.canvas { padding: 24px; display: flex; flex-direction: column; gap: 16px; max-width: 1400px; width: 100%; margin: 0 auto; }

.user-chip .name { font-size: var(--fs-sm); font-weight: 700; color: var(--text-primary); line-height: 1.1; }
.user-chip .role { font-size: var(--fs-xxs); font-weight: 600; color: var(--green); text-transform: uppercase; letter-spacing: .4px; }


  /* ── Canvas ── */
  .canvas { padding: 24px; display: flex; flex-direction: column; gap: 16px; max-width: 1400px; width: 100%; margin: 0 auto; }
  .page-header { display: flex; align-items: flex-end; justify-content: space-between; gap: 12px; }
  .page-header h2 { font-size: var(--fs-h2); font-weight: 800; color: var(--text-primary); letter-spacing: -.3px; }
  .page-header p { font-size: var(--fs-md); color: var(--text-muted); font-weight: 500; margin-top: 2px; }

  /* ── Cards ── */
  .card {
    background: var(--surface); border: 1px solid var(--border);
    border-radius: 16px; box-shadow: var(--shadow); overflow: hidden;
  }
  .card-header {
    padding: 16px 20px; border-bottom: 1px solid var(--border);
    display: flex; align-items: center; justify-content: space-between;
  }
  .card-title {
    display: flex; align-items: center; gap: 8px;
    font-size: 14px; font-weight: 700; color: var(--text-primary);
  }
  .card-title .material-symbols-rounded { font-size: 18px; }

  /* ── Top Row Grid ── */
  .top-row { display: grid; grid-template-columns: 280px 1fr; gap: 20px; }

  /* ── Member Card ── */
  .member-card-body { padding: 20px; }
  .member-header { display: flex; align-items: center; gap: 12px; margin-bottom: 16px; }
  .member-avatar {
    width: 48px; height: 48px; border-radius: 12px; overflow: hidden;
    background: var(--bg); flex-shrink: 0;
  }
  .member-avatar img { width: 100%; height: 100%; object-fit: cover; }
  .member-info .id { font-size: var(--fs-xs); font-weight: 700; color: var(--text-muted); text-transform: uppercase; letter-spacing: .5px; }
  .member-info .mname { font-size: var(--fs-xl); font-weight: 800; color: var(--text-primary); line-height: 1.2; }
  .member-info .since { font-size: var(--fs-sm); color: var(--text-muted); }

  .pill {
    display: inline-flex; align-items: center; gap: 4px; font-size: var(--fs-xs); font-weight: 800;
    text-transform: uppercase; padding: 4px 10px; border-radius: 99px; letter-spacing: .3px;
  }
  .pill-green { background: var(--green-light); color: var(--green); border: 1px solid var(--green-mid); }
  .pill-gray { background: var(--bg); color: var(--text-muted); border: 1px solid var(--border); }
  .pill-blue { background: var(--blue-light); color: var(--blue); border: 1px solid rgba(59, 130, 246, 0.3); }
  .pill-amber { background: var(--amber-light); color: var(--amber); border: 1px solid rgba(245, 158, 11, 0.3); }

  .savings-box {
    background: var(--surface); border: 1px solid var(--border); border-radius: 10px;
    padding: 14px;
  }
  .savings-box .label { font-size: var(--fs-xs); font-weight: 700; color: var(--text-muted); text-transform: uppercase; letter-spacing: .5px; }
  .savings-box .amount { font-size: var(--fs-h2); font-weight: 800; color: var(--green); margin-top: 4px; }

  /* ── Form Card ── */
  .form-body { padding: 20px; }
  .form-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 14px; }
  .form-grid .full { grid-column: 1 / -1; }

  label {
    display: block; font-size: var(--fs-xs); font-weight: 700;
    text-transform: uppercase; letter-spacing: .5px;
    color: var(--text-muted); margin-bottom: 5px;
  }
  .input-wrap { position: relative; }
  .input-wrap .prefix {
    position: absolute; left: 12px; top: 50%; transform: translateY(-50%);
    font-size: 13px; font-weight: 600; color: var(--text-muted);
    pointer-events: none;
  }
  .form-input {
    width: 100%; padding: 8px 12px; border: 1px solid var(--border);
    border-radius: 8px; background: var(--surface); font-size: var(--fs-base);
    font-family: inherit; color: var(--text-primary); outline: none; transition: all .15s;
  }
  .form-input.has-prefix { padding-left: 32px; }
  .form-input:focus { border-color: var(--green); box-shadow: 0 0 0 3px rgba(22,163,74,.1); }
  .form-input::placeholder { color: var(--text-muted); }
  textarea.form-input { resize: none; }

  .form-actions { display: flex; gap: 8px; margin-top: 16px; padding-top: 16px; border-top: 1px solid var(--border); }
  .btn-save {
    flex: 1; padding: 10px 20px; background: var(--green); color: #fff;
    border: none; border-radius: 10px; font-size: var(--fs-base); font-weight: 700;
    font-family: inherit; cursor: pointer; display: flex; align-items: center;
    justify-content: center; gap: 8px; transition: all .2s;
  }
  .btn-save:hover { background: #15803d; transform: translateY(-1px); }
  .btn-reset {
    padding: 10px 20px; background: none; border: 1px solid var(--border);
    border-radius: 10px; font-size: var(--fs-base); font-weight: 600;
    color: var(--text-secondary); cursor: pointer; font-family: inherit; transition: all .2s;
  }
  .btn-reset:hover { background: var(--bg); }

  /* ── History Table ── */
  .table-header { display: flex; align-items: center; justify-content: space-between; }
  .view-all { font-size: var(--fs-md); font-weight: 700; color: var(--green); text-decoration: none; display: flex; align-items: center; gap: 3px; }

  table.data-table { width: 100%; border-collapse: collapse; }
  .data-table thead th {
    padding: 8px 12px; font-size: var(--fs-xs); font-weight: 700;
    text-transform: uppercase; letter-spacing: .6px;
    color: var(--text-muted); background: var(--surface);
    border-bottom: 1px solid var(--border); text-align: left;
    white-space: nowrap;
  }
  .data-table tbody tr { border-bottom: 1px solid var(--border); transition: background .1s; }
  .data-table tbody tr:hover { background: var(--bg); }
  .data-table tbody tr:last-child { border-bottom: none; }
  .data-table td { padding: 12px 20px; font-size: var(--fs-base); color: var(--text-secondary); }
  .data-table td.bold { font-weight: 700; color: var(--text-primary); }
  .data-table td.green { font-weight: 700; color: var(--green); }

  .op-cell { display: flex; align-items: center; gap: 8px; }
  .op-dot { width: 24px; height: 24px; border-radius: 50%; background: var(--surface); border: 1px solid var(--border); display: flex; align-items: center; justify-content: center; font-size: 10px; font-weight: 700; color: var(--text-muted); }

  .act-btn {
    width: 30px; height: 30px; display: flex; align-items: center; justify-content: center;
    border-radius: 7px; border: none; background: none; cursor: pointer;
    color: var(--text-muted); transition: background .15s, color .15s;
  }
  .act-btn:hover { background: var(--orange-light); color: var(--orange); }
  .act-btn .material-symbols-rounded { font-size: 16px; }
  .search-container { position: relative; width: 300px; }
  .search-results {
    position: absolute; top: 100%; left: 0; right: 0;
    background: var(--surface); border: 1px solid var(--border);
    border-radius: 10px; margin-top: 5px; box-shadow: 0 10px 25px -5px rgba(0,0,0,0.1);
    max-height: 250px; overflow-y: auto; z-index: 1000;
    display: none;
  }
  .search-results.show { display: block; }
  .search-item {
    padding: 10px 14px; font-size: var(--fs-base); color: var(--text-primary);
    cursor: pointer; border-bottom: 1px solid var(--border);
    transition: background .15s;
    line-height: 1.3;
  }
  .search-item:last-child { border-bottom: none; }
  .search-item:hover { background: var(--bg); }
  .search-item strong { display: block; font-size: 13px; color: var(--text-primary); }
  .search-item span { font-size: 10px; color: var(--text-muted); font-weight: 600; text-transform: uppercase; }
  .clear-btn {
    position: absolute; right: 8px; top: 50%; transform: translateY(-50%);
    width: 20px; height: 20px; border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    color: var(--text-muted); text-decoration: none;
    transition: all .15s;
  }
  .clear-btn:hover { background: var(--bg); color: var(--red); }
  .empty-state {
    grid-column: 1 / -1;
    display: flex; flex-direction: column; align-items: center; justify-content: center;
    padding: 80px 20px; text-align: center;
    background: var(--surface); border: 1px dashed var(--border);
    border-radius: 16px; margin-top: 20px;
  }
  .empty-icon {
    width: 64px; height: 64px; background: var(--bg); border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    margin-bottom: 20px;
  }
  .empty-icon .material-symbols-rounded { font-size: 32px; color: var(--text-muted); }
  .empty-state h3 { font-size: 18px; font-weight: 800; color: var(--text-primary); margin-bottom: 8px; }
  .empty-state p { font-size: 13px; color: var(--text-muted); max-width: 320px; line-height: 1.5; }
</style>
</head>
<body>

<!-- Sidebar -->
@include('admin.partials.sidebar')

<!-- Main -->
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

    <!-- Page Title -->
    <div class="page-header">
      <div>
        <h2>Input Simpanan Bulanan</h2>
        <p>Update data simpanan anggota koperasi</p>
      </div>
      
      @if($users->isEmpty())
        <p style="font-size:12px; color:var(--text-muted);">Belum ada anggota terdaftar.</p>
      @else
      <div class="search-container" style="width: 320px; margin-top: 0;">
        <div class="input-wrap">
          <span class="material-symbols-rounded" style="position:absolute; left:12px; top:50%; transform:translateY(-50%); font-size:18px; color:var(--text-muted);">search</span>
          <input type="text" id="memberSearch" class="form-input" style="padding-left:38px; padding-right:32px;" 
                 placeholder="Cari Nama atau No. Anggota..." 
                 value="{{ $selectedUser ? $selectedUser->name : '' }}" autocomplete="off">
          @if($selectedUser)
            <a href="{{ route('admin.inputSimpanan') }}" class="clear-btn" title="Hapus Pilihan">
              <span class="material-symbols-rounded" style="font-size:16px;">close</span>
            </a>
          @endif
        </div>
        <div id="searchResults" class="search-results"></div>
        
        <form id="selectionForm" action="{{ route('admin.inputSimpanan') }}" method="GET">
          <input type="hidden" name="user_id" id="selectedUserId" value="{{ $selectedUser ? $selectedUser->id : '' }}">
        </form>
      </div>
      @endif
    </div>
    
    @if(session('success'))
      <div style="background:#e6ffe6; border:1px solid #00cc00; color:#006600; padding:12px; border-radius:8px; font-weight:bold;">
        {{ session('success') }}
      </div>
    @endif

    @if($selectedUser)
      <div class="top-row">
        <!-- Member Card -->
        <div class="card">
          <div class="card-header">
            <div class="card-title">
              <span class="material-symbols-rounded" style="color:var(--green)">person</span>
              Info Anggota
            </div>
            <div style="display:flex; align-items:center; gap:8px;">
              <span class="pill pill-green">Aktif</span>
              <a href="{{ route('admin.inputSimpanan') }}" class="btn-reset" style="padding:4px 8px; font-size:10px; text-decoration:none; display:flex; align-items:center; gap:4px;">
                <span class="material-symbols-rounded" style="font-size:14px;">close</span>
                Tutup
              </a>
            </div>
          </div>
            <div class="member-card-body">
              <div class="member-header">
                <div class="member-avatar">
                  @php
                    $initials = collect(explode(' ', $selectedUser->name))->map(fn($w) => strtoupper(substr($w, 0, 1)))->take(2)->implode('');
                  @endphp
                  <div style="width:100%;height:100%;display:flex;align-items:center;justify-content:center;font-size:18px;font-weight:bold;color:var(--green);">
                    {{ $initials }}
                  </div>
                </div>
                <div class="member-info">
                  <div class="id">{{ $selectedUser->no_anggota }}</div>
                  <div class="mname">{{ $selectedUser->name }}</div>
                  <div class="since">Terdaftar {{ \Carbon\Carbon::parse($selectedUser->created_at)->translatedFormat('M Y') }}</div>
                </div>
              </div>
              <div class="savings-box">
                <div class="label">Total Simpanan</div>
                <div class="amount">Rp {{ number_format($selectedUser->simpanans->sum('jumlah'), 0, ',', '.') }}</div>
              </div>
            </div>
        </div>

        <!-- Form Card -->
        <div class="card">
          <div class="card-header">
            <div class="card-title">
              <span class="material-symbols-rounded" style="color:var(--orange)">edit_note</span>
              Update Simpanan
            </div>
          </div>
          <div class="form-body">
            <form action="{{ route('admin.storeSimpanan') }}" method="POST">
              @csrf
              <input type="hidden" name="user_id" value="{{ $selectedUser->id }}">
              
              <div class="form-grid">
                <div>
                  <label>Jenis Simpanan</label>
                  <select name="jenis_simpanan" class="form-input" required>
                    <option value="Wajib">Simpanan Wajib</option>
                    <option value="Sukarela">Simpanan Sukarela</option>
                    <option value="Monosuko">Simpanan Monosuko</option>
                    <option value="DPU">Simpanan DPU</option>
                    <option value="Pokok">Simpanan Pokok</option>
                  </select>
                </div>
                <div>
                  <label>Nominal (Rp)</label>
                  <div class="input-wrap">
                    <span class="prefix">Rp</span>
                    <input type="text" name="jumlah" class="form-input has-prefix format-rupiah" placeholder="0" required>
                  </div>
                </div>
                <div>
                  <label>Tanggal Transaksi</label>
                  <input type="date" name="tanggal_transaksi" class="form-input" value="{{ date('Y-m-d') }}" required>
                </div>
                <div class="full">
                  <label>Keterangan (Opsional)</label>
                  <textarea name="keterangan" class="form-input" placeholder="Misal: Pembayaran simpanan bulan ini..." rows="2"></textarea>
                </div>
              </div>
              <div class="form-actions">
                <button type="submit" class="btn-save">
                  <span class="material-symbols-rounded">save</span>
                  Simpan Transaksi
                </button>
                <button type="reset" class="btn-reset">Reset</button>
              </div>
            </form>
          </div>
        </div>
      </div>

      <!-- History Card -->
      <div class="card">
        <div class="card-header">
          <div class="card-title">
            <span class="material-symbols-rounded" style="color:var(--blue)">history</span>
            Riwayat Simpanan Terakhir
          </div>
          <a href="#" class="view-all">Lihat Semua <span class="material-symbols-rounded">chevron_right</span></a>
        </div>
        <div style="overflow-x: auto;">
          <table class="data-table">
            <thead>
              <tr>
                <th>Bulan/Tahun</th>
                <th>Jenis</th>
                <th>Nominal</th>
                <th>Total Saldo</th>
                <th>Operator</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              @forelse ($simpanans as $simpanan)
              <tr>
                <td class="bold">{{ \Carbon\Carbon::parse($simpanan->tanggal_transaksi)->translatedFormat('F Y') }}</td>
                <td><span class="pill {{ $simpanan->jenis_simpanan == 'Pokok' ? 'pill-amber' : 'pill-blue' }}">{{ $simpanan->jenis_simpanan }}</span></td>
                <td class="bold">Rp {{ number_format($simpanan->jumlah, 0, ',', '.') }}</td>
                <td class="green">-</td>
                <td>
                  <div class="op-cell">
                    <div class="op-dot">SYS</div>
                    System
                  </div>
                </td>
                <td>
                  <button class="act-btn"><span class="material-symbols-rounded">print</span></button>
                </td>
              </tr>
              @empty
              <tr>
                <td colspan="6" style="text-align: center; padding: 20px;">Belum ada riwayat simpanan</td>
              </tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>
    @else
      <div class="empty-state">
        <div class="empty-icon"><span class="material-symbols-rounded">ads_click</span></div>
        <h3>Tidak ada data yang ditampilkan</h3>
        <p>Gunakan fitur pencarian di atas untuk memilih anggota koperasi.</p>
      </div>
    @endif

  </div>
</main>
@include('admin.partials.confirm_modal')
@include('admin.partials.layout_scripts')

<script>
  const members = <?php echo json_encode($users->map(function($u) { 
    return ['id' => $u->id, 'name' => $u->name, 'no' => $u->no_anggota]; 
  })->toArray()); ?>;

  const searchInput = document.getElementById('memberSearch');
  const resultsDiv = document.getElementById('searchResults');
  const hiddenInput = document.getElementById('selectedUserId');
  const selectionForm = document.getElementById('selectionForm');

  if (searchInput) {
    searchInput.addEventListener('input', function() {
      const val = this.value.toLowerCase();
      resultsDiv.innerHTML = '';
      
      if (val.length < 1) {
        resultsDiv.classList.remove('show');
        return;
      }

      const filtered = members.filter(m => 
        m.name.toLowerCase().includes(val) || 
        m.no.toLowerCase().includes(val)
      );

      if (filtered.length > 0) {
        filtered.forEach(m => {
          const item = document.createElement('div');
          item.className = 'search-item';
          item.innerHTML = `<strong>${m.name}</strong><span>${m.no}</span>`;
          item.onclick = function() {
            searchInput.value = m.name;
            hiddenInput.value = m.id;
            resultsDiv.classList.remove('show');
            selectionForm.submit();
          };
          resultsDiv.appendChild(item);
        });
        resultsDiv.classList.add('show');
      } else {
        resultsDiv.classList.remove('show');
      }
    });

    // Close when clicking outside
    document.addEventListener('click', function(e) {
      if (!searchInput.contains(e.target) && !resultsDiv.contains(e.target)) {
        resultsDiv.classList.remove('show');
      }
    });
  }

  function toggleTheme() {
    const html = document.documentElement;
    const current = html.getAttribute('data-theme');
    const target = current === 'dark' ? 'light' : 'dark';
    html.setAttribute('data-theme', target);
    localStorage.setItem('admin-theme', target);
  }
</script>
</body>
</html>
