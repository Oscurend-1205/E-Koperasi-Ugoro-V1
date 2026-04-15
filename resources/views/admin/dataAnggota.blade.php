@extends('layouts.admin')

@section('title', 'Koperasi Ugoro — Data Anggota')

@push('styles')
<style>
  /* ── Local Style Overrides ── */
  .canvas { padding: 24px; display: flex; flex-direction: column; gap: 20px; max-width: 1400px; width: 100%; margin: 0 auto; }

  .page-header { display: flex; align-items: flex-end; justify-content: space-between; }
  .page-header h2 { font-size: var(--fs-h2); font-weight: 800; color: var(--text-primary); letter-spacing: -.5px; }
  .page-header p { font-size: var(--fs-xs); color: var(--text-muted); font-weight: 500; margin-top: 2px; }

  /* ── Buttons ── */
  .btn {
    display: inline-flex; align-items: center; gap: 6px;
    padding: 7px 14px; border-radius: 8px; font-size: var(--fs-sm);
    font-weight: 700; font-family: inherit; cursor: pointer; border: none;
    transition: all .15s;
  }
  .btn-primary { background: var(--green); color: #fff; }
  .btn-primary:hover { background: #15803d; }
  .btn-outline { background: var(--surface); border: 1px solid var(--border); color: var(--text-secondary); }
  .btn-outline:hover { background: var(--bg); }
  .btn-dark { background: #1a1f1a; color: #fff; }
  .btn-dark:hover { background: #111; }

  /* ── Card ── */
  .card {
    background: var(--surface); border: 1px solid var(--border);
    border-radius: var(--radius); box-shadow: var(--shadow); overflow: hidden;
  }

  /* ── Filter Bar ── */
  .filter-bar {
    padding: 12px 16px;
    display: flex; align-items: flex-end; gap: 10px;
    border-bottom: 1px solid var(--border);
  }
  .filter-field { display: flex; flex-direction: column; gap: 3px; }
  .filter-field label { font-size: var(--fs-xxs); font-weight: 700; text-transform: uppercase; letter-spacing: .5px; color: var(--text-muted); }
  .filter-input {
    padding: 6px 10px; border: 1px solid var(--border); border-radius: 7px;
    background: var(--surface); font-size: var(--fs-sm); font-family: inherit;
    color: var(--text-primary); outline: none;
  }
  .filter-input:focus { border-color: var(--green); }
  .filter-input.wide { width: 220px; }
  select.filter-input { padding-right: 24px; appearance: none; background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='10' height='10' viewBox='0 0 24 24' fill='none' stroke='%239aaa98' stroke-width='2'%3E%3Cpath d='M6 9l6 6 6-6'/%3E%3C/svg%3E"); background-repeat: no-repeat; background-position: right 7px center; }

  /* ── Table ── */
  table.data-table { width: 100%; border-collapse: collapse; }
  .data-table thead th {
    padding: 12px 16px; font-size: 11px; font-weight: 800;
    text-transform: uppercase; letter-spacing: .8px;
    color: var(--text-primary); background: #f8fafc;
    border-bottom: 2px solid var(--border); text-align: left;
  }
  .data-table tbody tr { border-bottom: 1px solid var(--border); transition: background .1s; }
  .data-table tbody tr:last-child { border-bottom: none; }
  .data-table tbody tr:hover { background: var(--bg); }
  .data-table td { padding: 12px 16px; font-size: var(--fs-sm); color: var(--text-primary); font-weight: 500; }

  .member-cell { display: flex; align-items: center; gap: 8px; }
  .avatar {
    width: 30px; height: 30px; border-radius: 8px;
    display: flex; align-items: center; justify-content: center;
    font-size: var(--fs-xs); font-weight: 800; flex-shrink: 0;
  }
  .av-green { background: var(--green-light); color: var(--green); }
  .av-orange { background: #fff7ed; color: var(--orange); }
  .av-gray { background: var(--bg); color: var(--text-muted); }
  .av-blue { background: rgba(37, 99, 235, 0.1); color: #2563eb; }
  .av-red { background: var(--red-light); color: #dc2626; }

  .member-name-btn {
    background: none; border: none; cursor: pointer; font-family: inherit;
    font-size: var(--fs-sm); font-weight: 700; color: var(--text-primary);
    text-align: left; padding: 0; text-decoration: underline;
    text-decoration-color: transparent;
    transition: color .15s, text-decoration-color .15s;
  }
  .member-name-btn:hover { color: var(--green); text-decoration-color: var(--green-light); }

  .member-loc { font-size: var(--fs-xs); color: var(--text-muted); }

  .pill { display: inline-block; font-size: var(--fs-xxs); font-weight: 700; text-transform: uppercase; padding: 2px 7px; border-radius: 99px; }
  .pill-green { background: var(--green-light); color: var(--green); }
  .pill-gray { background: var(--bg); color: var(--text-muted); }
  .pill-blue { background: rgba(37, 99, 235, 0.1); color: #2563eb; }
  .pill-red { background: var(--red-light); color: #dc2626; }
  
  .status-dot { display: inline-block; width: 6px; height: 6px; border-radius: 50%; margin-right: 4px; vertical-align: middle; }
  .dot-blue { background: #2563eb; box-shadow: 0 0 0 2px rgba(37, 99, 235, 0.2); }
  .dot-red { background: #dc2626; box-shadow: 0 0 0 2px rgba(220, 38, 38, 0.2); }

  .amount-dark { font-weight: 700; color: var(--text-primary); }
  .amount-orange { font-weight: 700; color: var(--orange); }
  .amount-muted { color: var(--text-muted); }

  .action-cell { display: flex; justify-content: center; gap: 3px; }
  .act-btn {
    width: 28px; height: 28px; display: flex; align-items: center; justify-content: center;
    border-radius: 6px; border: none; background: none; cursor: pointer;
    color: var(--text-muted); transition: background .15s, color .15s;
  }
  .act-btn.view:hover { background: var(--green-light); color: var(--green); }
  .act-btn.edit:hover { background: var(--bg); color: var(--text-primary); }
  .act-btn.del:hover { background: var(--red-light); color: var(--red); }
  .act-btn .material-symbols-rounded { font-size: var(--fs-md); }

  /* ── Table Footer ── */
  .table-footer {
    padding: 10px 16px; border-top: 1px solid var(--border);
    background: var(--surface); display: flex; align-items: center; justify-content: space-between;
  }
  .table-footer p { font-size: var(--fs-sm); color: var(--text-muted); font-weight: 500; }
  .pagination { display: flex; gap: 3px; }
  .pg-btn {
    min-width: 28px; height: 28px; padding: 0 6px;
    border-radius: 6px; border: 1px solid var(--border);
    background: var(--surface); font-size: var(--fs-xs); font-weight: 600;
    font-family: inherit; color: var(--text-secondary); cursor: pointer;
    display: flex; align-items: center; justify-content: center;
    transition: all .15s;
  }
  .pg-btn:hover:not(:disabled) { background: var(--bg); }
  .pg-btn:disabled { opacity: .5; cursor: not-allowed; }
  .pg-btn.active { background: var(--green); color: #fff; border-color: var(--green); }

  /* ── Modal ── */
  .modal-overlay {
    position: fixed; inset: 0; z-index: 100;
    background: rgba(0,0,0,.35);
    display: flex; align-items: center; justify-content: center;
    opacity: 0; pointer-events: none;
    transition: opacity .2s;
    backdrop-filter: blur(2px);
  }
  .modal-overlay.open { opacity: 1; pointer-events: all; }

  .modal {
    background: var(--surface);
    border-radius: 14px;
    width: 480px;
    max-width: calc(100vw - 40px);
    box-shadow: 0 20px 60px rgba(0,0,0,.15), 0 4px 16px rgba(0,0,0,.08);
    overflow: hidden;
    transform: translateY(12px) scale(.97);
    transition: transform .2s, opacity .2s;
    opacity: 0;
  }
  .modal-overlay.open .modal { transform: translateY(0) scale(1); opacity: 1; }

  .modal-banner {
    height: 72px;
    background: linear-gradient(135deg, #16a34a 0%, #22c55e 100%);
    position: relative;
    display: flex; align-items: flex-end;
    padding: 0 20px 0;
  }
  .modal-avatar {
    position: absolute; bottom: -20px; left: 20px;
    width: 44px; height: 44px; border-radius: 10px;
    background: var(--surface); border: 2px solid var(--surface);
    display: flex; align-items: center; justify-content: center;
    font-size: var(--fs-md); font-weight: 800;
    box-shadow: 0 2px 8px rgba(0,0,0,.1);
  }
  .modal-close {
    position: absolute; top: 10px; right: 12px;
    width: 28px; height: 28px; border-radius: 50%;
    background: rgba(255,255,255,.2); border: none; cursor: pointer;
    display: flex; align-items: center; justify-content: center;
    color: #fff; transition: background .15s;
  }
  .modal-close:hover { background: rgba(255,255,255,.35); }
  .modal-close .material-symbols-rounded { font-size: 16px; }

  .modal-body { padding: 32px 20px 20px; }

  .modal-name { font-size: var(--fs-xl); font-weight: 800; color: var(--text-primary); }
  .modal-id { font-size: var(--fs-sm); font-weight: 600; color: var(--green); margin-top: 1px; }

  .modal-grid {
    display: grid; grid-template-columns: 1fr 1fr;
    gap: 10px; margin-top: 14px;
  }
  .modal-field {
    background: var(--bg); border: 1px solid var(--border);
    border-radius: 8px; padding: 9px 11px;
  }
  .modal-field.full { grid-column: 1 / -1; }
  .modal-field .flabel { font-size: var(--fs-xs); font-weight: 700; text-transform: uppercase; letter-spacing: .5px; color: var(--text-muted); margin-bottom: 2px; }
  .modal-field .fval { font-size: var(--fs-md); font-weight: 600; color: var(--text-primary); }
  .modal-field .fval.green { color: var(--green); font-size: var(--fs-xl); font-weight: 800; }
  .modal-field .fval.orange { color: var(--orange); font-size: var(--fs-xl); font-weight: 800; }

  .modal-actions { display: flex; gap: 8px; margin-top: 14px; padding-top: 14px; border-top: 1px solid var(--border); }
</style>
@endpush

@section('content')
    <div class="page-header">
      <div>
        <h2>Data Anggota</h2>
        <p>Kelola informasi dan status keanggotaan</p>
      </div>
      <button class="btn btn-primary">
        <span class="material-symbols-rounded" style="font-size:15px;">person_add</span>
        Tambah Anggota
      </button>
    </div>

    <div class="card" style="background: var(--surface) !important;">
      <!-- Filter Bar -->
      <div class="filter-bar">
        <form id="filterForm" action="{{ route('admin.dataAnggota') }}" method="GET" style="display: flex; align-items: flex-end; gap: 10px; flex: 1;">
          <div class="filter-field">
            <label>Cari Anggota</label>
            <div style="position:relative;">
              <span class="material-symbols-rounded" style="position:absolute;left:8px;top:50%;transform:translateY(-50%);color:var(--text-muted);font-size:14px;">person_search</span>
              <input id="searchInput" name="search" class="filter-input wide" style="padding-left:28px;" placeholder="Nama atau No Anggota..." type="text" value="{{ request('search') }}" autocomplete="off"/>
            </div>
          </div>
          <div class="filter-field">
            <label>Status</label>
            <select id="statusSelect" name="status" class="filter-input">
              <option value="">Semua Status</option>
              <option value="Aktif" {{ request('status') == 'Aktif' ? 'selected' : '' }}>Aktif</option>
              <option value="Nonaktif" {{ request('status') == 'Nonaktif' ? 'selected' : '' }}>Nonaktif</option>
            </select>
          </div>
          <button type="submit" class="btn btn-dark" style="margin-bottom:1px;">
            <span class="material-symbols-rounded" style="font-size:14px;">filter_list</span>
            Filter
          </button>
          @if(request()->filled('search') || request()->filled('status'))
            <a href="{{ route('admin.dataAnggota') }}" class="btn btn-outline" style="margin-bottom:1px; text-decoration: none; display: inline-flex; align-items: center; justify-content: center;">Reset</a>
          @endif
        </form>
        <button type="button" id="bulkDeleteBtn" class="btn js-univ-confirm" 
                style="margin-bottom:1px; background: var(--red); color: white; display: none;"
                data-title="Hapus Anggota Terpilih?"
                data-desc="Anda akan menghapus anggota terpilih sekaligus. Semua data terkait akan dihapus permanen. Tindakan ini tidak dapat dibatalkan."
                data-confirm-text="HAPUS SEMUA"
                data-form-id="bulkDeleteForm">
          <span class="material-symbols-rounded" style="font-size:14px;">delete_sweep</span>
          Hapus Terpilih (<span id="selectedCount">0</span>)
        </button>
      </div>

      <!-- Table Section -->
      <form id="bulkDeleteForm" action="{{ route('admin.members.bulkDestroy') }}" method="POST">
        @csrf
        <div style="overflow-x:auto;">
          <table class="data-table">
            <thead>
              <tr>
                <th style="width: 30px; text-align: center; padding: 0 0 0 16px;">
                  <input type="checkbox" id="selectAll" style="cursor: pointer; width: 16px; height: 16px; accent-color: var(--green);">
                </th>
                <th>No Anggota</th>
                <th>Nama Anggota</th>
                <th>Status</th>
                <th style="text-align:right;">Simpanan</th>
                <th style="text-align:right;">Pinjaman</th>
                <th style="text-align:center;">Aksi</th>
              </tr>
            </thead>
            <tbody id="memberTableBody">
              @include('admin.partials.data_anggota_rows')
            </tbody>
          </table>
        </div>

        <!-- Pagination -->
        <div class="table-footer">
          <p>Menampilkan <strong>{{ $users->count() }}</strong> anggota</p>
          <div class="pagination">
            <button type="button" class="pg-btn active">1</button>
          </div>
        </div>
      </form>
    </div>
  </div>
<!-- Modal Detail -->
<div class="modal-overlay" id="modalOverlay" onclick="handleOverlayClick(event)">
  <div class="modal" id="modal">
    <div class="modal-banner">
      <div class="modal-avatar" id="modalAvatar"></div>
      <button class="modal-close" onclick="closeModal()">
        <span class="material-symbols-rounded">close</span>
      </button>
    </div>
    <div class="modal-body">
      <div id="modalName" class="modal-name"></div>
      <div id="modalId" class="modal-id"></div>
      <div class="modal-grid">
        <div class="modal-field">
          <div class="flabel">NIK</div>
          <div class="fval" id="modalNik"></div>
        </div>
        <div class="modal-field">
          <div class="flabel">Bergabung</div>
          <div class="fval" id="modalJoin"></div>
        </div>
        <div class="modal-field full">
          <div class="flabel">Alamat</div>
          <div class="fval" id="modalAlamat"></div>
        </div>
        <div class="modal-field">
          <div class="flabel">No. WhatsApp</div>
          <div class="fval" id="modalPhone"></div>
        </div>
        <div class="modal-field">
          <div class="flabel">Email</div>
          <div class="fval" id="modalEmail"></div>
        </div>
        <div class="modal-field">
          <div class="flabel">Total Simpanan</div>
          <div class="fval green" id="modalSimpanan"></div>
        </div>
        <div class="modal-field">
          <div class="flabel">Pinjaman Aktif</div>
          <div class="fval orange" id="modalPinjaman"></div>
        </div>
        <div class="modal-field">
          <div class="flabel">Status</div>
          <div class="fval" id="modalStatus"></div>
        </div>
      </div>
      <div class="modal-actions">
        <button class="btn btn-dark" style="flex:1;">
          <span class="material-symbols-rounded" style="font-size:14px;">history</span>
          Riwayat Transaksi
        </button>
        <button class="btn btn-outline" style="flex:1;">
          <span class="material-symbols-rounded" style="font-size:14px;">picture_as_pdf</span>
          Ekspor PDF
        </button>
        <button class="btn btn-outline" onclick="closeModal()">Tutup</button>
      </div>
    </div>
  </div>
</div>

@endsection

@push('scripts')

<script>
  // --- Global State ---
  let checkboxes = document.querySelectorAll('.member-checkbox');
  const selectAll = document.getElementById('selectAll');
  const bulkDeleteBtn = document.getElementById('bulkDeleteBtn');
  const selectedCountSpan = document.getElementById('selectedCount');
  const memberTableBody = document.getElementById('memberTableBody');
  const filterForm = document.getElementById('filterForm');
  const searchInput = document.getElementById('searchInput');
  const statusSelect = document.getElementById('statusSelect');

  // --- Live Search Logic ---
  let debounceTimer;
  const debounceSearch = () => {
    clearTimeout(debounceTimer);
    debounceTimer = setTimeout(() => performSearch(), 300);
  };

  if (searchInput) searchInput.addEventListener('input', debounceSearch);
  if (statusSelect) statusSelect.addEventListener('change', () => performSearch());

  function performSearch() {
    const formData = new FormData(filterForm);
    const params = new URLSearchParams(formData);
    const url = `${filterForm.action}?${params.toString()}`;

    // Show buffering status
    memberTableBody.style.opacity = '0.5';
    // showLoader('Mencari data...'); // Optional: if you want full overlay during search

    fetch(url, {
      headers: { 'X-Requested-With': 'XMLHttpRequest' }
    })
    .then(response => response.text())
    .then(html => {
      // The response is now directly the rows from the partial
      memberTableBody.innerHTML = html;
      
      // Update browser URL
      window.history.pushState({}, '', url);

      // Re-init specialized listeners after DOM update
      checkboxes = document.querySelectorAll('.member-checkbox');
      attachCheckboxListeners();
      updateBulkDeleteUI();
      
      memberTableBody.style.opacity = '1';
    })
    .catch(error => {
      console.error('Search error:', error);
      memberTableBody.style.opacity = '1';
    });
  }

  // --- Checkbox Logic ---
  function attachCheckboxListeners() {
    checkboxes.forEach(cb => {
      cb.addEventListener('change', updateBulkDeleteUI);
    });
  }

  if (selectAll) {
    selectAll.addEventListener('change', function() {
      checkboxes.forEach(cb => cb.checked = selectAll.checked);
      updateBulkDeleteUI();
    });
  }

  function updateBulkDeleteUI() {
    const checkedCount = document.querySelectorAll('.member-checkbox:checked').length;
    if (selectedCountSpan) selectedCountSpan.textContent = checkedCount;
    if (bulkDeleteBtn) bulkDeleteBtn.style.display = checkedCount > 0 ? 'inline-flex' : 'none';
    
    if (selectAll) {
      const allChecked = Array.from(checkboxes).every(cb => cb.checked) && checkboxes.length > 0;
      selectAll.checked = allChecked;
    }
  }

  // Init listeners
  attachCheckboxListeners();

  // Prevent form submission flash
  if (filterForm) {
    filterForm.addEventListener('submit', (e) => {
      e.preventDefault();
      performSearch();
    });
  }

  // --- Existing Modal Logic ---
  function openModal(name, id, nik, alamat, phone, email, join, status, simpanan, pinjaman, initials, avClass) {
    document.getElementById('modalName').textContent = name;
    document.getElementById('modalId').textContent = id;
    document.getElementById('modalNik').textContent = nik;
    document.getElementById('modalAlamat').textContent = alamat;
    document.getElementById('modalPhone').textContent = phone;
    document.getElementById('modalEmail').textContent = email;
    document.getElementById('modalJoin').textContent = join;
    document.getElementById('modalSimpanan').textContent = simpanan;
    document.getElementById('modalPinjaman').textContent = pinjaman;

    const statusEl = document.getElementById('modalStatus');
    statusEl.innerHTML = status === 'Aktif'
      ? '<span style="display:inline-flex;align-items:center;gap:4px;"><span style="width:7px;height:7px;border-radius:50%;background:var(--green);display:inline-block;"></span> Aktif</span>'
      : '<span style="display:inline-flex;align-items:center;gap:4px;"><span style="width:7px;height:7px;border-radius:50%;background:var(--text-muted);display:inline-block;"></span> Nonaktif</span>';

    const av = document.getElementById('modalAvatar');
    av.textContent = initials;
    av.className = 'modal-avatar ' + avClass;

    document.getElementById('modalOverlay').classList.add('open');
    document.body.style.overflow = 'hidden';
  }

  function closeModal() {
    document.getElementById('modalOverlay').classList.remove('open');
    document.body.style.overflow = '';
  }

  // --- Event Listeners ---
  function handleOverlayClick(e) { if (e.target === document.getElementById('modalOverlay')) closeModal(); }

  document.addEventListener('keydown', e => { 
    if (e.key === 'Escape') {
      closeModal(); 
    }
  });
</script>
@endpush
