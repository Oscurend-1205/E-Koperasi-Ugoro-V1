<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>Admin — Pesan Anggota</title>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet"/>
@include('admin.partials.layout_styles')
@include('admin.partials.theme')

<style>
    /* Override Canvas for "Not too big" and consistent behavior */
    .canvas {
        max-width: 1400px;
        padding: 24px;
        display: flex;
        flex-direction: column;
        gap: 16px;
        margin: 0 auto;
    }

    /* Message List - Card Styles */
    .msg-list-wrapper {
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .msg-card {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: 16px;
        transition: all 0.2s ease;
        overflow: hidden; /* Ensure content doesn't push width and affect sidebar */
    }
    .msg-card:hover { border-color: var(--green-mid); box-shadow: var(--shadow); }

    .msg-header {
        padding: 10px 16px;
        cursor: pointer;
        display: grid;
        grid-template-columns: 100px 100px 1fr 110px 30px;
        align-items: center;
        gap: 12px;
        background: var(--surface);
    }

    .msg-content {
        max-height: 0;
        overflow: hidden; /* CRITICAL: prevents sidebar from shifting when opening */
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        background: var(--bg);
    }
    .msg-content.active {
        max-height: 1500px;
        border-top: 1px solid var(--border);
    }

    /* Inner components */
    .msg-details {
        padding: 20px;
        display: flex;
        flex-direction: column;
        gap: 16px;
    }

    .msg-bubble {
        padding: 16px;
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: 12px;
        font-size: 13px;
        line-height: 1.6;
        color: var(--text-primary);
    }

    /* Reply Section */
    .reply-form-box {
        padding: 16px;
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: 16px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.02);
    }
    .reply-area-textarea {
        width: 100%;
        min-height: 100px;
        padding: 12px;
        border: 1px solid var(--border);
        border-radius: 10px;
        font-size: 13px;
        font-family: inherit;
        outline: none;
        resize: vertical;
        transition: border-color .2s;
        background: var(--bg);
        color: var(--text-primary);
    }
    .reply-area-textarea:focus { border-color: var(--green); }

    .admin-reply-bubble {
        padding: 16px;
        background: var(--green-light);
        border: 1px solid var(--green-mid);
        border-radius: 12px;
        position: relative;
    }

    /* Badges */
    .status-pill-small {
        font-size: 9px;
        font-weight: 800;
        text-transform: uppercase;
        padding: 2px 8px;
        border-radius: 99px;
        display: inline-flex;
        align-items: center;
        gap: 4px;
    }
    .status-pill-waiting { background: var(--orange-light); color: var(--orange); border: 1px solid var(--orange-dim); }
    .status-pill-done { background: var(--green-light); color: var(--green); border: 1px solid var(--green-mid); }

/* ── Topbar ── */
header {
  height: 44px; background: var(--surface);
  border-bottom: 1px solid var(--border);
  display: flex; align-items: center; justify-content: space-between;
  padding: 0 20px; position: sticky; top: 0; z-index: 40;
}
.topbar-right { display: flex; align-items: center; gap: 4px; }
.icon-btn {
  width: 32px; height: 32px; display: flex; align-items: center; justify-content: center;
  border-radius: 8px; border: none; background: none;
  color: var(--text-secondary); cursor: pointer; transition: background .15s;
}
.icon-btn:hover { background: var(--bg); color: var(--text-primary); }
.divider-v { width: 1px; height: 20px; background: var(--border); margin: 0 4px; }
.user-chip {
  display: flex; align-items: center; gap: 8px;
  padding: 4px 4px 4px 10px;
  border: 1px solid var(--border);
  border-radius: 40px;
  cursor: pointer;
  transition: background .15s;
  background: var(--bg);
}
.user-chip:hover { border-color: var(--green-mid); }
.user-chip .name { font-size: 11px; font-weight: 700; color: var(--text-primary); line-height: 1.1; }
.user-chip .role { font-size: 9px; font-weight: 600; color: var(--green); text-transform: uppercase; letter-spacing: .4px; }
.user-chip img {
  width: 26px; height: 26px;
  border-radius: 50%;
  object-fit: cover;
  border: 1px solid var(--border);
}

/* Fix to ensure Main & Sidebar behavior matches dashboard exactly */
body { font-family: 'Plus Jakarta Sans', sans-serif; background: var(--bg); display: flex; min-height: 100vh; color: var(--text-primary); }
main { flex: 1; min-width: 0; } /* min-width: 0 is key for flex children overflow */
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
                <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name ?? 'Admin+Ugoro') }}&background=dcfce7&color=16a34a&bold=true" alt="Admin"/>
            </div>
        </div>
    </header>

    <div class="canvas">
        <div class="page-header">
            <div>
                <h2>Pesan Anggota</h2>
                <p>Kelola laporan dan interaksi dari anggota koperasi.</p>
            </div>
            @if(session('success'))
            <div class="pill pill-green">
                <span class="material-symbols-rounded" style="font-size: 14px;">check_circle</span>
                {{ session('success') }}
            </div>
            @endif
        </div>

        <div class="msg-list-wrapper">
            <!-- List Header Style Penanda -->
            <div style="display: grid; grid-template-columns: 100px 100px 1fr 110px 30px; padding: 10px 20px; font-size: 9px; font-weight: 800; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.5px;">
                <span>Tgl Pengajuan</span>
                <span>Jenis</span>
                <span>Subjek Pesan</span>
                <span>Status</span>
                <span></span>
            </div>

            @forelse($messages as $msg)
            <div class="msg-card">
                <div class="msg-header" onclick="toggleMessage('{{ $msg->id }}')">
                    <div style="font-size: 12px; font-weight: 600;">
                        {{ $msg->created_at->format('d M y') }}
                        <div style="font-size: 10px; color: var(--text-muted); font-weight: 500;">{{ $msg->created_at->format('H:i') }} WIB</div>
                    </div>
                    
                    <div>
                        <span class="pill {{ $msg->type == 'Pesan' ? 'pill-green' : 'pill-red' }}" style="font-size: 8px;">{{ $msg->type }}</span>
                    </div>

                    <div style="overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                        <span style="font-weight: 700; font-size: 13px;">{{ $msg->subject }}</span>
                        <span id="preview-text-{{ $msg->id }}" style="font-size: 12px; color: var(--text-muted); margin-left: 8px;">— {{ $msg->message }}</span>
                    </div>

                    <div>
                        @if($msg->status == 'Belum Dibaca')
                            <span class="status-pill-small status-pill-waiting">Menunggu</span>
                        @else
                            <span class="status-pill-small status-pill-done">Selesai</span>
                        @endif
                    </div>

                    <span id="icon-{{ $msg->id }}" class="material-symbols-rounded text-muted" style="transition: 0.2s; font-size: 18px;">expand_more</span>
                </div>

                <div id="content-{{ $msg->id }}" class="msg-content">
                    <div class="msg-details">
                        <!-- Sender Info -->
                        <div style="background: var(--surface); padding: 12px 16px; border: 1px solid var(--border); border-radius: 10px; display: flex; align-items: center; justify-content: space-between;">
                            <div style="display: flex; align-items: center; gap: 10px;">
                                <div style="width: 32px; height: 32px; border-radius: 8px; background: var(--bg); display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 12px; color: var(--green);">
                                    {{ substr($msg->user->name ?? 'A', 0, 1) }}
                                </div>
                                <div>
                                    <div style="font-weight: 700; font-size: 13px;">{{ $msg->user->name ?? 'Anonim' }}</div>
                                    <div style="font-size: 11px; color: var(--text-muted);">{{ $msg->user->no_anggota ?? 'N/A' }}</div>
                                </div>
                            </div>
                            <div style="text-align: right;">
                                <div style="font-size: 9px; font-weight: 700; color: var(--text-muted); text-transform: uppercase;">Topik</div>
                                <div style="font-size: 12px; font-weight: 600;">{{ $msg->subject }}</div>
                            </div>
                        </div>

                        <!-- Message Body -->
                        <div class="msg-bubble">
                            <p style="white-space: pre-wrap;">{{ $msg->message }}</p>
                        </div>

                        <!-- Admin Action / Reply Area -->
                        @if($msg->reply)
                            <div class="admin-reply-bubble">
                                <div style="display: flex; align-items: center; gap: 6px; margin-bottom: 8px;">
                                    <span class="material-symbols-rounded" style="color: var(--green); font-size: 16px;">verified_user</span>
                                    <span style="font-weight: 800; font-size: 10px; color: #15803d; text-transform: uppercase;">Jawaban Admin</span>
                                    <span style="font-size: 9px; color: var(--text-muted); margin-left: auto;">{{ \Carbon\Carbon::parse($msg->replied_at)->format('d/m/Y H:i') }}</span>
                                </div>
                                <div style="color: #166534; font-weight: 500;">{{ $msg->reply }}</div>
                            </div>
                        @else
                            <div class="reply-form-box">
                                <form action="{{ route('admin.messages.reply', $msg->id) }}" method="POST">
                                    @csrf
                                    <div style="font-weight: 800; font-size: 10px; color: var(--text-muted); text-transform: uppercase; margin-bottom: 8px;">Informasikan Kembali ke Anggota</div>
                                    <textarea name="reply" class="reply-area-textarea" placeholder="Tuliskan respon atau jawaban untuk anggota..." required></textarea>
                                    <div style="display: flex; justify-content: flex-end; margin-top: 12px;">
                                        <button type="submit" class="btn btn-primary" style="padding: 8px 20px; font-size: 12px; border-radius: 8px;">
                                            Kirim Jawaban
                                            <span class="material-symbols-rounded" style="font-size: 16px;">send</span>
                                        </button>
                                    </div>
                                </form>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            @empty
            <div class="card" style="padding: 60px; text-align: center; color: var(--text-muted);">
                <span class="material-symbols-rounded" style="font-size: 40px; opacity: 0.4;">inbox</span>
                <p style="margin-top: 12px; font-weight: 600;">Kotak masuk pesan kosong.</p>
            </div>
            @endforelse
        </div>
    </div>
</main>

<script>
    function toggleMessage(id) {
        const content = document.getElementById('content-' + id);
        const icon = document.getElementById('icon-' + id);
        const preview = document.getElementById('preview-text-' + id);
        
        const isActive = content.classList.contains('active');
        
        // Opt-in: Close others
        // document.querySelectorAll('.msg-content').forEach(el => el.classList.remove('active'));

        if (!isActive) {
            content.classList.add('active');
            icon.style.transform = 'rotate(180deg)';
            icon.style.color = 'var(--green)';
            if(preview) preview.style.display = 'none';
        } else {
            content.classList.remove('active');
            icon.style.transform = 'rotate(0deg)';
            icon.style.color = 'var(--text-muted)';
            if(preview) preview.style.display = 'inline';
        }
    }
</script>

@include('admin.partials.confirm_modal')
@include('admin.partials.layout_scripts')
</body>
</html>