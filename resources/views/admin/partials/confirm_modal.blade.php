{{-- ─────────────────────────────────────────────────────────────
     Universal Premium Modal
     Usage:
       1. @include('admin.partials.confirm_modal') in <body>
       2. Use JS: 
          showConfirmModal({
            title: 'Hapus Data?',
            description: 'Data ini akan dihapus permanen.',
            confirmLabel: 'Ya, Hapus',
            action: '/delete-url',
            method: 'DELETE', // optional, default DELETE
            type: 'danger',   // danger, warning, info
            confirmText: 'HAPUS' // optional, if set user must type this to enable button
          })
     ──────────────────────────────────────────────────────────── --}}

<div id="univConfirmModal" class="univ-modal-overlay" onclick="if(event.target===this) closeConfirmModal()">
    <div class="univ-modal-card">
        {{-- Close Button --}}
        <button class="univ-modal-close" onclick="closeConfirmModal()">
            <span class="material-symbols-rounded">close</span>
        </button>

        {{-- Icon Section --}}
        <div id="univModalIconContainer" class="univ-modal-icon-box danger">
            <span id="univModalIcon" class="material-symbols-rounded">delete_forever</span>
        </div>

        {{-- Text Content --}}
        <div class="univ-modal-content">
            <h3 id="univModalTitle">Konfirmasi</h3>
            <p id="univModalDesc">Apakah Anda yakin ingin melanjutkan tindakan ini?</p>
        </div>

        {{-- Optional: Typing Confirmation --}}
        <div id="univModalConfirmTextSection" style="display: none; width: 100%; margin-top: 8px;">
            <label id="univModalConfirmLabel" style="font-size: 11px; font-weight: 700; color: var(--text-muted); display: block; margin-bottom: 8px; text-align: left; text-transform: uppercase; letter-spacing: 0.5px;">
                Ketik <span id="univModalTargetText" style="color: var(--red);">HAPUS</span> untuk konfirmasi:
            </label>
            <input type="text" id="univModalConfirmInput" autocomplete="off" 
                   style="width: 100%; padding: 12px; border: 2px solid var(--border); border-radius: 12px; font-size: 14px; font-family: inherit; font-weight: 800; text-align: center; outline: none; transition: all 0.2s; letter-spacing: 1px;"
                   oninput="validateUnivConfirmInput()">
        </div>

        {{-- Footer Buttons --}}
        <div class="univ-modal-footer">
            <button type="button" class="univ-modal-btn cancel" onclick="closeConfirmModal()">Batal</button>
            <form id="univModalForm" method="POST" style="flex: 1;">
                @csrf
                <input type="hidden" name="_method" id="univModalMethod" value="DELETE">
                <button type="submit" id="univModalSubmitBtn" class="univ-modal-btn confirm">Ya, Lanjutkan</button>
            </form>
        </div>
    </div>
</div>

<style>
    /* ── Overlay ── */
    .univ-modal-overlay {
        position: fixed; inset: 0; z-index: 9999;
        background: rgba(15, 23, 42, 0.4);
        backdrop-filter: blur(8px);
        display: flex; align-items: center; justify-content: center;
        opacity: 0; pointer-events: none;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        padding: 20px;
    }
    .univ-modal-overlay.open { opacity: 1; pointer-events: auto; }

    /* ── Card ── */
    .univ-modal-card {
        background: var(--surface);
        width: 100%; max-width: 400px;
        border-radius: 24px;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        padding: 32px 24px 24px;
        text-align: center;
        position: relative;
        transform: translateY(20px) scale(0.95);
        transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
        display: flex; flex-direction: column; align-items: center; gap: 20px;
        border: 1px solid var(--border);
    }
    .univ-modal-overlay.open .univ-modal-card { transform: translateY(0) scale(1); }

    .univ-modal-close {
        position: absolute; top: 16px; right: 16px;
        width: 32px; height: 32px; border-radius: 10px;
        display: flex; align-items: center; justify-content: center;
        background: var(--bg); color: var(--text-muted); border: none; cursor: pointer;
        transition: all 0.2s;
    }
    .univ-modal-close:hover { background: var(--red-light); color: var(--red); transform: rotate(90deg); }

    /* ── Icon Box ── */
    .univ-modal-icon-box {
        width: 72px; height: 72px; border-radius: 22px;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
        animation: univ-bounce 2s infinite ease-in-out;
    }
    .univ-modal-icon-box.danger { background: #fee2e2; color: #dc2626; box-shadow: 0 0 0 8px rgba(220, 38, 38, 0.05); }
    .univ-modal-icon-box.warning { background: #fff7ed; color: #ea580c; box-shadow: 0 0 0 8px rgba(234, 88, 12, 0.05); }
    .univ-modal-icon-box.info { background: #eff6ff; color: #2563eb; box-shadow: 0 0 0 8px rgba(37, 99, 235, 0.05); }

    @keyframes univ-bounce {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-5px); }
    }

    /* ── Text ── */
    .univ-modal-content { display: flex; flex-direction: column; gap: 8px; }
    #univModalTitle { font-size: 20px; font-weight: 800; color: var(--text-primary); letter-spacing: -0.5px; }
    #univModalDesc { font-size: 14px; color: var(--text-secondary); line-height: 1.6; }

    /* ── Footer ── */
    .univ-modal-footer { display: flex; gap: 12px; width: 100%; margin-top: 8px; }
    .univ-modal-btn {
        padding: 12px 20px; border-radius: 14px;
        font-size: 14px; font-weight: 700; cursor: pointer;
        border: none; font-family: inherit; transition: all 0.2s;
        flex: 1;
    }
    .univ-modal-btn.cancel { background: var(--bg); color: var(--text-secondary); border: 1px solid var(--border); }
    .univ-modal-btn.cancel:hover { background: var(--border); color: var(--text-primary); }
    
    .univ-modal-btn.confirm { background: var(--green); color: #fff; box-shadow: 0 4px 12px rgba(22, 163, 74, 0.2); }
    .univ-modal-btn.confirm:hover { background: #15803d; transform: translateY(-2px); box-shadow: 0 6px 15px rgba(22, 163, 74, 0.3); }
    .univ-modal-btn.confirm:active { transform: translateY(0); }
    .univ-modal-btn.confirm:disabled { background: #cbd5e1; color: #94a3b8; cursor: not-allowed; box-shadow: none; transform: none; }

    /* Theme overrides for Dark Mode */
    [data-theme="dark"] .univ-modal-card { background: #1e293b; border-color: #334155; }
    [data-theme="dark"] .univ-modal-btn.cancel { background: #334155; border-color: #475569; color: #cbd5e1; }
    [data-theme="dark"] .univ-modal-btn.confirm:disabled { background: #334155; color: #64748b; }
</style>

<script>
    let univTargetText = '';
    
    /**
     * Show the universal confirmation modal
     * @param {Object} options 
     */
    function showConfirmModal(options) {
        const modal = document.getElementById('univConfirmModal');
        const form = document.getElementById('univModalForm');
        const titleEl = document.getElementById('univModalTitle');
        const descEl = document.getElementById('univModalDesc');
        const submitBtn = document.getElementById('univModalSubmitBtn');
        const methodEl = document.getElementById('univModalMethod');
        const iconCont = document.getElementById('univModalIconContainer');
        const iconEl = document.getElementById('univModalIcon');
        const confirmSection = document.getElementById('univModalConfirmTextSection');
        const targetTextEl = document.getElementById('univModalTargetText');
        const confirmInput = document.getElementById('univModalConfirmInput');

        // Reset state
        confirmSection.style.display = 'none';
        confirmInput.value = '';
        submitBtn.disabled = false;
        univTargetText = '';

        // Apply options
        titleEl.innerText = options.title || 'Konfirmasi';
        descEl.innerHTML = options.description || 'Apakah Anda yakin?';
        submitBtn.innerText = options.confirmLabel || 'Ya, Lanjutkan';
        
        if (options.formId) {
            // Handle specific form submission
            form.onsubmit = function(e) {
                e.preventDefault();
                showLoader('Memproses permintaan Anda...');
                document.getElementById(options.formId).submit();
            };
            form.action = '#';
        } else {
            form.onsubmit = function() {
                showLoader('Memproses permintaan Anda...');
                return true;
            };
            form.action = options.action || '#';
        }
        
        methodEl.value = options.method || 'DELETE';

        // Type styles
        iconCont.className = 'univ-modal-icon-box ' + (options.type || 'danger');
        if (options.type === 'warning') {
            iconEl.innerText = 'warning';
            submitBtn.style.background = '#ea580c';
        } else if (options.type === 'info') {
            iconEl.innerText = 'info';
            submitBtn.style.background = '#2563eb';
        } else {
            iconEl.innerText = 'delete_forever';
            submitBtn.style.background = '#dc2626';
        }

        // Typing confirmation
        if (options.confirmText) {
            univTargetText = options.confirmText.toUpperCase();
            targetTextEl.innerText = univTargetText;
            confirmSection.style.display = 'block';
            submitBtn.disabled = true;
            confirmInput.style.borderColor = 'var(--border)';
            setTimeout(() => confirmInput.focus(), 400);
        }

        // Show
        modal.classList.add('open');
        document.body.style.overflow = 'hidden';
    }

    function closeConfirmModal() {
        document.getElementById('univConfirmModal').classList.remove('open');
        document.body.style.overflow = '';
    }

    function validateUnivConfirmInput() {
        const input = document.getElementById('univModalConfirmInput');
        const btn = document.getElementById('univModalSubmitBtn');
        const val = input.value.toUpperCase();

        if (val === univTargetText) {
            btn.disabled = false;
            input.style.borderColor = '#22c55e';
            input.style.boxShadow = '0 0 0 4px rgba(34, 197, 94, 0.1)';
        } else {
            btn.disabled = true;
            input.style.borderColor = 'var(--border)';
            input.style.boxShadow = 'none';
        }
    }

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') closeConfirmModal();
    });
</script>
