@forelse ($users as $usr)
<tr>
  @php
    $simpananSum = $usr->simpanans ? $usr->simpanans->sum('jumlah') : 0;
    $pinjamanSum = $usr->pinjamans ? $usr->pinjamans->sum('jumlah_pinjaman') : 0;
    $simpananStr = 'Rp ' . number_format($simpananSum, 0, ',', '.');
    $pinjamanStr = 'Rp ' . number_format($pinjamanSum, 0, ',', '.');
    $initials = collect(explode(' ', $usr->name))->map(function($word) { return strtoupper(substr($word, 0, 1)); })->take(2)->implode('');
    $joinDate = \Carbon\Carbon::parse($usr->created_at)->translatedFormat('d M Y');
    
    $isActive = $usr->status !== 'non-aktif';
    $status = $isActive ? 'Aktif' : 'Non-Aktif';
    $pillClass = $isActive ? 'pill-blue' : 'pill-red';
    $dotClass = $isActive ? 'dot-blue' : 'dot-red';
    $avClass = $isActive ? 'av-blue' : 'av-red';
  @endphp
  <td style="text-align: center; padding: 0 0 0 16px;">
    @if($usr->role !== 'admin' && $usr->role !== 'Super Admin')
      <input type="checkbox" name="ids[]" value="{{ $usr->id }}" class="member-checkbox" style="cursor: pointer; width: 16px; height: 16px; accent-color: var(--green);">
    @else
      <span class="material-symbols-rounded" style="font-size: 16px; color: var(--text-muted); opacity: 0.5;">lock</span>
    @endif
  </td>
  <td style="font-weight:700;color:var(--text-primary);">{{ $usr->no_anggota }}</td>
  <td>
    <div class="member-cell">
      <div class="avatar {{ $avClass }}">{{ $initials }}</div>
      <div>
        <button type="button" class="member-name-btn" onclick="openModal('{{ addslashes($usr->name) }}','{{ $usr->no_anggota }}','{{ $usr->nik ?? '-' }}','{{ addslashes($usr->alamat) }}','{{ $usr->no_hp }}','{{ $usr->email }}','{{ $joinDate }}','{{ $status }}','{{ $simpananStr }}','{{ $pinjamanStr }}','{{ $initials }}','{{ $avClass }}')">{{ $usr->name }}</button>
        <div class="member-loc">
          @if($usr->role === 'Super Admin' || $usr->role === 'admin')
            <span style="color: var(--orange); font-weight: 800; font-size: 9px; text-transform: uppercase;">[ {{ $usr->role }} ]</span>
          @else
            {{ \Illuminate\Support\Str::limit($usr->alamat, 20) }}
          @endif
        </div>
      </div>
    </div>
  </td>
  <td>
    <span class="pill {{ $pillClass }}">
      <span class="status-dot {{ $dotClass }}"></span>
      {{ $status }}
    </span>
  </td>
  <td style="text-align:right;" class="amount-dark">{{ $simpananStr }}</td>
  <td style="text-align:right;" class="amount-orange">{{ $pinjamanStr }}</td>
  <td>
    <div class="action-cell">
      <button type="button" class="act-btn view" onclick="openModal('{{ addslashes($usr->name) }}','{{ $usr->no_anggota }}','{{ $usr->nik ?? '-' }}','{{ addslashes($usr->alamat) }}','{{ $usr->no_hp }}','{{ $usr->email }}','{{ $joinDate }}','{{ $status }}','{{ $simpananStr }}','{{ $pinjamanStr }}','{{ $initials }}','{{ $avClass }}')"><span class="material-symbols-rounded">visibility</span></button>
      <button type="button" class="act-btn edit js-univ-confirm" title="Masuk sebagai Anggota"
        data-title="Masuk sebagai Anggota?"
        data-desc="Anda akan diarahkan ke halaman akun <strong>{{ $usr->name }}</strong> untuk pengecekan data."
        data-action="{{ route('admin.impersonate', $usr->id) }}"
        data-method="POST"
        data-type="warning"
        data-confirm-label="Ya, Lanjutkan">
        <span class="material-symbols-rounded" style="color: var(--orange);">login</span>
      </button>
      <button type="button" class="act-btn edit js-univ-confirm" 
        title="{{ $isActive ? 'Nonaktifkan Anggota' : 'Aktifkan Anggota' }}"
        data-title="{{ $isActive ? 'Nonaktifkan Anggota?' : 'Aktifkan Anggota?' }}"
        data-desc="Apakah Anda yakin ingin <strong>{{ $isActive ? 'menonaktifkan' : 'mengaktifkan kembali' }}</strong> anggota <strong>{{ $usr->name }}</strong>?"
        data-action="{{ route('admin.members.toggleStatus', $usr->id) }}"
        data-method="PATCH"
        data-type="{{ $isActive ? 'warning' : 'info' }}"
        data-confirm-label="Ya, Lanjutkan">
        <span class="material-symbols-rounded">{{ $isActive ? 'person_off' : 'person_check' }}</span>
      </button>
      
      @if($usr->role !== 'admin' && $usr->role !== 'Super Admin')
      <button type="button" class="act-btn del js-univ-confirm" title="Hapus Anggota"
        data-title="Hapus Anggota?"
        data-desc="Semua data milik <strong>{{ $usr->name }}</strong> akan dihapus permanen (simpanan, pinjaman, akun)."
        data-action="{{ route('admin.members.destroy', $usr->id) }}"
        data-confirm-text="HAPUS">
        <span class="material-symbols-rounded">delete</span>
      </button>
      @endif
    </div>
  </td>
</tr>
@empty
<tr>
  <td colspan="7" style="text-align: center; padding: 20px;">Belum ada anggota yang terdaftar</td>
</tr>
@endforelse
