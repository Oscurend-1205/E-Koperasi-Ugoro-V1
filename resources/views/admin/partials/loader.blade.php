{{-- ─────────────────────────────────────────────────────────────
     Universal Premium Loader / Buffering Overlay
     Usage:
       1. @include('admin.partials.loader') in <body>
       2. Use JS: 
          showLoader('Memproses data...'); // Show with optional text
          hideLoader();                    // Hide
     ──────────────────────────────────────────────────────────── --}}

<div id="univLoader" class="univ-loader-overlay">
    <div class="univ-loader-container">
        {{-- Elegant Animated Spinner --}}
        <div class="univ-spinner">
            <div class="spinner-ring"></div>
            <div class="spinner-ring"></div>
            <div class="spinner-ring"></div>
            <div class="spinner-logo">
                <span class="material-symbols-rounded">sync</span>
            </div>
        </div>
        
        {{-- Loading Text --}}
        <div class="univ-loader-text">
            <h3 id="univLoaderTitle">SEDANG MEMUAT</h3>
            <p id="univLoaderSub">Mohon tunggu sebentar...</p>
        </div>

        {{-- Decorative Line --}}
        <div class="univ-loader-footer">
            <div class="loader-line"></div>
        </div>
    </div>
</div>

<style>
    /* ── Overlay ── */
    .univ-loader-overlay {
        position: fixed; inset: 0; z-index: 10000;
        background: rgba(15, 23, 42, 0.1);
        backdrop-filter: blur(4px);
        display: flex; align-items: center; justify-content: center;
        opacity: 0; pointer-events: none;
        transition: all 0.3s ease;
    }
    .univ-loader-overlay.show { opacity: 1; pointer-events: auto; }

    /* ── 4:3 Container ── */
    .univ-loader-container {
        display: flex; flex-direction: column; align-items: center; justify-content: center;
        gap: 20px;
        background: var(--surface, #ffffff);
        width: 280px; 
        aspect-ratio: 4 / 3;
        border-radius: 24px;
        box-shadow: 0 20px 40px rgba(0,0,0,0.12), 0 0 0 1px var(--border, rgba(0,0,0,0.05));
        position: relative;
        overflow: hidden;
        transform: translateY(20px); transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
    }
    .univ-loader-overlay.show .univ-loader-container { transform: translateY(0); }

    /* ── Advanced Spinner ── */
    .univ-spinner {
        position: relative; width: 64px; height: 64px;
        display: flex; align-items: center; justify-content: center;
    }
    .spinner-ring {
        position: absolute; inset: 0;
        border: 3px solid transparent;
        border-top-color: var(--green, #16a34a);
        border-radius: 50%;
        animation: univ-spin 1s cubic-bezier(0.5, 0, 0.5, 1) infinite;
    }
    .spinner-ring:nth-child(2) { border-top-color: #86efac; animation-delay: -0.2s; opacity: 0.6; }
    .spinner-ring:nth-child(3) { border-top-color: #059669; animation-delay: -0.4s; opacity: 0.3; }
    
    .spinner-logo {
        color: #fff; background: var(--green, #16a34a);
        width: 28px; height: 28px; border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        box-shadow: 0 0 15px rgba(22, 163, 74, 0.3);
        z-index: 2;
    }
    .spinner-logo span { font-size: 16px; animation: univ-spin-logo 2s linear infinite; }

    @keyframes univ-spin { 0% { transform: rotate(0deg); } 100% { transform: rotate(360deg); } }
    @keyframes univ-spin-logo { 0% { transform: rotate(0deg); } 100% { transform: rotate(-360deg); } }

    /* ── Text ── */
    .univ-loader-text { text-align: center; }
    #univLoaderTitle { 
        font-size: 14px; font-weight: 800; color: var(--text-primary, #111); 
        letter-spacing: 1px; margin-bottom: 4px; text-transform: uppercase;
    }
    #univLoaderSub { font-size: 11px; color: var(--text-muted, #6b7280); font-weight: 500; }

    /* ── Footer Decor ── */
    .univ-loader-footer {
        position: absolute; bottom: 0; left: 0; right: 0; height: 3px;
        background: rgba(0,0,0,0.03);
    }
    .loader-line {
        height: 100%; width: 30%; background: var(--green, #16a34a);
        animation: univ-progress-line 1.5s infinite ease-in-out;
    }

    @keyframes univ-progress-line { 0% { transform: translateX(-100%); } 100% { transform: translateX(350%); } }

    /* Dark Mode */
    [data-theme="dark"] .univ-loader-container { background: #1e293b; border-color: #334155; }
    [data-theme="dark"] .univ-loader-overlay { background: rgba(2, 6, 23, 0.4); }
</style>

<script>
    /**
     * Show universal loader
     * @param {string} subText - Optional secondary text
     * @param {string} title - Optional title
     */
    function showLoader(subText = '', title = '') {
        const loader = document.getElementById('univLoader');
        const titleEl = document.getElementById('univLoaderTitle');
        const subEl = document.getElementById('univLoaderSub');

        if (title) titleEl.innerText = title;
        if (subText) subEl.innerText = subText;

        loader.classList.add('show');
        document.body.style.overflow = 'hidden';
    }

    /**
     * Hide universal loader
     */
    function hideLoader() {
        const loader = document.getElementById('univLoader');
        loader.classList.remove('show');
        document.body.style.overflow = '';
        
        // Reset texts after transition
        setTimeout(() => {
            document.getElementById('univLoaderTitle').innerText = 'Mohon Tunggu';
            document.getElementById('univLoaderSub').innerText = 'Sedang memproses permintaan Anda...';
        }, 400);
    }
</script>
