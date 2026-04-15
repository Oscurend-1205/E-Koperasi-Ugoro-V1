@extends('layouts.admin')

@section('title', 'Kelola Informasi — Koperasi Ugoro')

@push('styles')
<style>
  /* ── Canvas ── */
  .canvas { padding: 24px; display: flex; flex-direction: column; gap: 20px; max-width: 1400px; width: 100%; margin: 0 auto; }

  /* ── Canvas ── */
  .canvas { padding: 24px; display: flex; flex-direction: column; gap: 20px; max-width: 1400px; width: 100%; margin: 0 auto; }

  .page-header { display: flex; align-items: center; justify-content: space-between; gap: 16px; margin-bottom: 4px; }
  .page-header h2 { font-size: 22px; font-weight: 800; color: var(--text-primary); letter-spacing: -.5px; }
  .page-header p { font-size: 12px; color: var(--text-muted); font-weight: 500; margin-top: 2px; }

  .btn { display: inline-flex; align-items: center; gap: 8px; padding: 8px 16px; border-radius: 10px; font-size: 13px; font-weight: 700; font-family: inherit; cursor: pointer; border: none; transition: all .2s; text-decoration: none; }
  .btn-primary { background: var(--green); color: #fff; box-shadow: 0 4px 12px rgba(22,163,74,.2); }
  .btn-primary:hover { background: #15803d; transform: translateY(-1px); }
  .btn-outline { background: var(--surface); border: 1px solid var(--border); color: var(--text-primary); }
  .btn-outline:hover { background: var(--bg); border-color: var(--text-muted); }
  .btn-danger { background: var(--red); color: #fff; }
  .btn-danger:hover { background: #b91c1c; }
  .btn-sm { padding: 4px 10px; font-size: 11px; border-radius: 6px; }

  /* ── Cards ── */
  .card { background: var(--surface); border: 1px solid var(--border); border-radius: 16px; box-shadow: var(--shadow); overflow: hidden; }
  .card-header { padding: 12px 16px; border-bottom: 1px solid var(--border); display: flex; align-items: center; justify-content: space-between; }
  .card-title { display: flex; align-items: center; gap: 8px; font-size: 13px; font-weight: 700; color: var(--text-primary); }
  .card-title .material-symbols-rounded { font-size: 16px; }

  /* ── Info Cards Grid ── */
  .info-grid { display: flex; flex-direction: column; gap: 0; }
  .info-card { display: flex; align-items: flex-start; gap: 12px; padding: 12px 16px; border-bottom: 1px solid var(--border); transition: background .15s; }
  .info-card:last-child { border-bottom: none; }
  .info-card:hover { background: var(--bg); }

  .info-icon { width: 32px; height: 32px; border-radius: 8px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; font-size: 14px; }
  .info-icon.pinned { background: var(--amber-light); color: var(--amber); }
  .info-icon.normal { background: var(--green-light); color: var(--green); }
  .info-icon.inactive { background: #f1f3f1; color: var(--text-muted); }

  .info-body { flex: 1; min-width: 0; }
  .info-title { font-size: 13px; font-weight: 700; color: var(--text-primary); line-height: 1.3; display: flex; align-items: center; gap: 6px; flex-wrap: wrap; }
  .info-excerpt { font-size: 12px; color: var(--text-secondary); margin-top: 3px; line-height: 1.4; display: -webkit-box; -webkit-line-clamp: 2; line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
  .info-meta { display: flex; align-items: center; gap: 8px; margin-top: 6px; flex-wrap: wrap; }
  .info-meta span { font-size: 10px; color: var(--text-muted); font-weight: 500; }

  .pill { display: inline-flex; align-items: center; gap: 4px; font-size: 9px; font-weight: 800; text-transform: uppercase; padding: 3px 8px; border-radius: 99px; letter-spacing: .3px; }
  .pill-green { background: var(--green-light); color: var(--green); border: 1px solid var(--green-mid); }
  .pill-red { background: #fef2f2; color: #dc2626; border: 1px solid #fee2e2; }
  .pill-blue { background: var(--blue-light); color: var(--blue); border: 1px solid #dbeafe; }
  .pill-purple { background: var(--purple-light); color: var(--purple); border: 1px solid #ede9fe; }
  .pill-amber { background: var(--amber-light); color: var(--amber); border: 1px solid #fde68a; }
  .pill-gray { background: #f1f3f1; color: var(--text-muted); border: 1px solid var(--border); }

  .info-actions { display: flex; align-items: center; gap: 2px; flex-shrink: 0; }
  .act-btn { width: 28px; height: 28px; display: flex; align-items: center; justify-content: center; border-radius: 6px; border: none; background: none; cursor: pointer; color: var(--text-muted); transition: background .15s, color .15s; }
  .act-btn:hover { background: var(--bg); color: var(--text-primary); }
  .act-btn.del:hover { background: var(--red-light); color: var(--red); }
  .act-btn .material-symbols-rounded { font-size: 16px; }
  .act-btn .is-pinned-icon { color: var(--amber); }

  /* ── Stats Row ── */
  .stats-row { display: grid; grid-template-columns: repeat(3, 1fr); gap: 12px; }
  .stat-card { background: var(--surface); border: 1px solid var(--border); border-radius: 16px; padding: 14px 16px; display: flex; align-items: center; gap: 10px; box-shadow: var(--shadow); }
  .stat-icon { width: 36px; height: 36px; border-radius: 10px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
  .stat-icon.green { background: var(--green-light); color: var(--green); }
  .stat-icon.amber { background: var(--amber-light); color: var(--amber); }
  .stat-icon.blue { background: var(--blue-light); color: var(--blue); }
  .stat-label { font-size: 10px; font-weight: 700; color: var(--text-muted); text-transform: uppercase; letter-spacing: .5px; }
  .stat-value { font-size: 20px; font-weight: 800; color: var(--text-primary); line-height: 1.1; }

  /* ── Alert ── */
  .alert { padding: 10px 14px; border-radius: 10px; font-size: 12px; font-weight: 600; display: flex; align-items: center; gap: 8px; }
  .alert-success { background: var(--green-light); color: var(--green); border: 1px solid var(--green-mid); }
  .alert .material-symbols-rounded { font-size: 18px; }

  /* ── Empty State ── */
  .empty-state { text-align: center; padding: 40px 20px; }
  .empty-state .icon-wrap { width: 56px; height: 56px; border-radius: 16px; background: var(--bg); margin: 0 auto 12px; display: flex; align-items: center; justify-content: center; }
  .empty-state .icon-wrap .material-symbols-rounded { font-size: 28px; color: var(--text-muted); }
  .empty-state h4 { font-size: 15px; font-weight: 700; color: var(--text-primary); margin-bottom: 4px; }
  .empty-state p { font-size: 12px; color: var(--text-muted); }

  /* ── Responsive ── */
  @media (max-width: 768px) {
    aside { display: none; }
    .canvas { padding: 14px; }
    .stats-row { grid-template-columns: 1fr; }
    .page-header { flex-direction: column; align-items: flex-start; }
  }

  /* ── Delete Form ── */
  .delete-form { display: inline; }
</style>
@endpush

@section('content')

    @if(session('success'))
      <div class="alert alert-success">
        <span class="material-symbols-rounded">check_circle</span>
        {{ session('success') }}
      </div>
    @endif

    <!-- Page Header -->
    <div class="page-header">
      <div>
        <h2>Kelola Informasi</h2>
        <p>Buat dan kelola informasi & pengumuman untuk anggota</p>
      </div>
      <div style="display:flex; gap:8px;">
        <a href="{{ route('admin.informasi.create') }}" class="btn btn-primary">
          <span class="material-symbols-rounded" style="font-size:15px;">add</span>
          Tulis Informasi Baru
        </a>
      </div>
    </div>

    <!-- Stats -->
    <div class="stats-row">
      <div class="stat-card">
        <div class="stat-icon green">
          <span class="material-symbols-rounded" style="font-size:18px;">article</span>
        </div>
        <div>
          <div class="stat-label">Total Informasi</div>
          <div class="stat-value">{{ $informasis->count() }}</div>
        </div>
      </div>
      <div class="stat-card">
        <div class="stat-icon amber">
          <span class="material-symbols-rounded" style="font-size:18px;">push_pin</span>
        </div>
        <div>
          <div class="stat-label">Di-Pin</div>
          <div class="stat-value">{{ $informasis->where('is_pinned', true)->count() }}</div>
        </div>
      </div>
      <div class="stat-card">
        <div class="stat-icon blue">
          <span class="material-symbols-rounded" style="font-size:18px;">visibility</span>
        </div>
        <div>
          <div class="stat-label">Aktif</div>
          <div class="stat-value">{{ $informasis->where('is_active', true)->count() }}</div>
        </div>
      </div>
    </div>

    <!-- Info List -->
    <div class="card">
      <div class="card-header">
        <div class="card-title">
          <span class="material-symbols-rounded" style="color:var(--green)">feed</span>
          Daftar Informasi
        </div>
        <span style="font-size:10px; color:var(--text-muted); font-weight:600;">{{ $informasis->count() }} item</span>
      </div>

      @if($informasis->count() > 0)
        <div class="info-grid">
          @foreach($informasis as $info)
            <div class="info-card">
              <div class="info-icon {{ $info->is_pinned ? 'pinned' : ($info->is_active ? 'normal' : 'inactive') }}">
                <span class="material-symbols-rounded">
                  @if($info->is_pinned) push_pin
                  @elseif(!$info->is_active) visibility_off
                  @else campaign
                  @endif
                </span>
              </div>

              <div class="info-body">
                <div class="info-title">
                  {{ $info->title }}
                  @if(!$info->is_active)
                    <span class="pill pill-gray">Nonaktif</span>
                  @endif
                </div>
                <div class="info-excerpt">{{ Str::limit(strip_tags($info->content), 120) }}</div>
                <div class="info-meta">
                  <span class="pill
                    @if($info->category === 'Penting') pill-red
                    @elseif($info->category === 'Keuangan') pill-blue
                    @elseif($info->category === 'Kegiatan') pill-purple
                    @elseif($info->category === 'Umum') pill-green
                    @else pill-gray
                    @endif
                  ">{{ $info->category }}</span>
                  <span>{{ $info->published_at ? $info->published_at->translatedFormat('d M Y, H:i') : $info->created_at->translatedFormat('d M Y, H:i') }}</span>
                  @if($info->author)
                    <span>oleh {{ $info->author->name }}</span>
                  @endif
                </div>
              </div>

              <div class="info-actions">
                {{-- Toggle Pin --}}
                <form action="{{ route('admin.informasi.togglePin', $info) }}" method="POST" style="display:inline;">
                  @csrf @method('PATCH')
                  <button type="submit" class="act-btn" title="{{ $info->is_pinned ? 'Cabut Pin' : 'Pin' }}">
                    <span class="material-symbols-rounded {{ $info->is_pinned ? 'is-pinned-icon' : '' }}">push_pin</span>
                  </button>
                </form>
                {{-- Toggle Active --}}
                <form action="{{ route('admin.informasi.toggleActive', $info) }}" method="POST" style="display:inline;">
                  @csrf @method('PATCH')
                  <button type="submit" class="act-btn" title="{{ $info->is_active ? 'Nonaktifkan' : 'Aktifkan' }}">
                    <span class="material-symbols-rounded">{{ $info->is_active ? 'visibility' : 'visibility_off' }}</span>
                  </button>
                </form>
                {{-- Edit --}}
                <a href="{{ route('admin.informasi.edit', $info) }}" class="act-btn" title="Edit">
                  <span class="material-symbols-rounded">edit</span>
                </a>
                {{-- Delete --}}
                <button type="button" class="act-btn del js-univ-confirm" title="Hapus"
                  data-title="Hapus Informasi?"
                  data-desc="Apakah Anda yakin ingin menghapus informasi <strong>{{ $info->title }}</strong>? Tindakan ini tidak dapat dibatalkan."
                  data-action="{{ route('admin.informasi.destroy', $info) }}">
                  <span class="material-symbols-rounded">delete</span>
                </button>
              </div>
            </div>
          @endforeach
        </div>
      @else
        <div class="empty-state">
          <div class="icon-wrap">
            <span class="material-symbols-rounded">article</span>
          </div>
          <h4>Belum Ada Informasi</h4>
          <p>Klik "Tulis Informasi Baru" untuk membuat informasi pertama.</p>
        </div>
      @endif
    </div>

  </div>
@endsection
