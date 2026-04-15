<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="utf-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<title>Masuk — Koperasi Ugoro</title>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet"/>
<style>
*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

:root {
    --green:       #13ec5b;
    --green-dark:  #0bc44b;
    --green-soft:  #e8fdf0;
    --red:         #e11d48;
    --gold:        #f59e0b;
    --text-main:   #0f172a;
    --text-muted:  #64748b;
    --text-hint:   #94a3b8;
    --border:      #e8ecf0;
    --surface:     #ffffff;
    --bg:          #f7f6f4ff;
    --radius-sm:   10px;
    --radius-md:   14px;
    --radius-lg:   20px;
    --radius-xl:   28px;
}

body {
    font-family: 'Plus Jakarta Sans', sans-serif;
    background: var(--bg);
    color: var(--text-main);
    min-height: 100dvh;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding: 24px 16px;
}

/* ── Shell ── */
.card {
    width: 100%;
    max-width: 980px;
    background: var(--surface);
    border-radius: var(--radius-xl);
    box-shadow: 0 8px 48px rgba(0,0,0,0.07), 0 1px 3px rgba(0,0,0,0.05);
    overflow: hidden;
    display: flex;
    min-height: 580px;
}

/* ── Left panel ── */
.panel-left {
    display: none;
    width: 46%;
    flex-shrink: 0;
    position: relative;
    background: #0a1f12;
    overflow: hidden;
}
@media (min-width: 900px) { .panel-left { display: flex; flex-direction: column; } }

.panel-bg {
    position: absolute;
    inset: 0;
    background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuDXTigYbeN-TIO7fi5Li7ZZmTeHqzQRh0Bv-3Gu7ZDwMUj51SSV2qR0hVU4n9UqZuD4zVkn8M91P55gmdyEk8j_gaLCsbOuyI3qOTE16dJcuszZ--VK_pg-xLh2k21TWuFcQQoIEGqOsW0qkKyknwr-VrFBhDS1o76zSEvZK2eDHbqtnqkdi_PbQ_CeIph9Mc3azCEhTLhm2dvCf5nvpek1Ik-ZbecZvFvxqpWNxW2QXj3MN4F9q4LOlXt3BSdrQhrRohWNyhBD5xU');
    background-size: cover;
    background-position: center;
    opacity: 0.18;
}
.panel-grad {
    position: absolute;
    inset: 0;
    background: linear-gradient(160deg, rgba(19,236,91,0.18) 0%, rgba(10,31,18,0.92) 60%);
}

.panel-content {
    position: relative;
    z-index: 2;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    height: 100%;
    padding: 40px 40px 36px;
}

.brand {
    display: flex;
    align-items: center;
    gap: 12px;
}
.brand-logo {
    width: 44px;
    height: 44px;
    border-radius: 12px;
    object-fit: contain;
    background: rgba(255,255,255,0.08);
    padding: 4px;
}
.brand-name {
    font-size: 1.125rem;
    font-weight: 800;
    color: #ffffff;
    letter-spacing: -0.02em;
}

.panel-body { flex: 1; display: flex; flex-direction: column; justify-content: center; padding: 24px 0; }
.panel-body h2 {
    font-size: 2rem;
    font-weight: 800;
    color: #fff;
    line-height: 1.2;
    letter-spacing: -0.03em;
    margin-bottom: 14px;
}
.panel-body p {
    font-size: 0.9rem;
    color: rgba(255,255,255,0.65);
    line-height: 1.7;
    max-width: 280px;
}

.stats-row {
    display: flex;
    gap: 10px;
}
.stat-pill {
    display: flex;
    align-items: center;
    gap: 7px;
    background: rgba(255,255,255,0.07);
    border: 1px solid rgba(255,255,255,0.1);
    border-radius: 50px;
    padding: 8px 14px;
}
.stat-dot { width: 7px; height: 7px; border-radius: 50%; flex-shrink: 0; }
.stat-dot.green { background: var(--green); }
.stat-dot.gold  { background: var(--gold); }
.stat-pill span {
    font-size: 0.72rem;
    font-weight: 700;
    letter-spacing: 0.04em;
    text-transform: uppercase;
    color: rgba(255,255,255,0.6);
}

/* ── Right panel ── */
.panel-right {
    flex: 1;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 40px 32px;
}

.form-wrap {
    width: 100%;
    max-width: 360px;
}

/* Mobile brand */
.mobile-brand {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 32px;
}
@media (min-width: 900px) { .mobile-brand { display: none; } }
.mobile-brand img {
    width: 36px; height: 36px;
    border-radius: 9px;
    object-fit: contain;
}
.mobile-brand span {
    font-size: 1rem;
    font-weight: 800;
    color: var(--text-main);
    letter-spacing: -0.02em;
}

.form-heading { margin-bottom: 28px; }
.form-heading h1 {
    font-size: 1.625rem;
    font-weight: 800;
    color: var(--text-main);
    letter-spacing: -0.03em;
    margin-bottom: 5px;
}
.form-heading p {
    font-size: 0.8375rem;
    color: var(--text-muted);
    line-height: 1.6;
}

/* Fields */
.field { display: flex; flex-direction: column; gap: 6px; margin-bottom: 18px; }
.field:last-of-type { margin-bottom: 0; }

.field-top {
    display: flex;
    align-items: center;
    justify-content: space-between;
}
.field label {
    font-size: 0.8rem;
    font-weight: 700;
    color: #374151;
    letter-spacing: 0.01em;
}
.forgot-link {
    font-size: 0.78rem;
    font-weight: 600;
    color: var(--red);
    text-decoration: none;
    transition: opacity 0.12s;
}
.forgot-link:hover { opacity: 0.75; }

.input-wrap { position: relative; }
.input-icon {
    position: absolute;
    left: 13px;
    top: 50%;
    transform: translateY(-50%);
    color: var(--text-hint);
    font-size: 18px;
    pointer-events: none;
    font-variation-settings: 'FILL' 0, 'wght' 300;
}
.inp {
    width: 100%;
    height: 46px;
    padding: 0 14px 0 42px;
    border: 1.5px solid var(--border);
    border-radius: var(--radius-md);
    font-family: inherit;
    font-size: 0.875rem;
    color: var(--text-main);
    background: #fcfcfd;
    transition: border-color 0.15s, box-shadow 0.15s, background 0.15s;
    outline: none;
}
.inp::placeholder { color: #c4ccd6; }
.inp:hover:not(:focus) { border-color: #c8d0da; background: #fff; }
.inp:focus {
    border-color: #6ee7a0;
    background: #fff;
    box-shadow: 0 0 0 3px rgba(19,236,91,0.1);
}
.inp:invalid:not(:placeholder-shown) {
    border-color: #fca5a5;
    box-shadow: 0 0 0 3px rgba(225,29,72,0.07);
}

.inp-password { padding-right: 44px; }
.toggle-pw {
    position: absolute;
    right: 12px;
    top: 50%;
    transform: translateY(-50%);
    background: none;
    border: none;
    cursor: pointer;
    color: var(--text-hint);
    display: flex;
    align-items: center;
    padding: 4px;
    border-radius: 6px;
    transition: color 0.12s, background 0.12s;
    font-variation-settings: 'FILL' 0, 'wght' 300;
}
.toggle-pw:hover { color: var(--text-muted); background: #f1f5f9; }
.toggle-pw .material-symbols-outlined { font-size: 18px; }

.field-error {
    font-size: 0.72rem;
    color: var(--red);
    display: none;
    padding-left: 2px;
}
input:invalid:not(:placeholder-shown) ~ .field-error { display: block; }

/* Remember */
.remember-row {
    display: flex;
    align-items: center;
    gap: 9px;
    margin: 18px 0 22px;
}
.remember-row input[type="checkbox"] {
    width: 16px; height: 16px;
    border: 1.5px solid #cbd5e1;
    border-radius: 5px;
    accent-color: var(--green-dark);
    cursor: pointer;
    flex-shrink: 0;
}
.remember-row label {
    font-size: 0.8125rem;
    color: var(--text-muted);
    cursor: pointer;
    user-select: none;
}

/* Submit */
.btn-submit {
    width: 100%;
    height: 48px;
    background: var(--green);
    color: #0a2014;
    border: none;
    border-radius: var(--radius-md);
    font-family: inherit;
    font-size: 0.9rem;
    font-weight: 800;
    letter-spacing: 0.01em;
    cursor: pointer;
    transition: background 0.15s, transform 0.1s, box-shadow 0.15s;
    box-shadow: 0 4px 16px rgba(19,236,91,0.28);
}
.btn-submit:hover {
    background: var(--green-dark);
    box-shadow: 0 6px 20px rgba(19,236,91,0.35);
}
.btn-submit:active { transform: scale(0.98); }

form:invalid .btn-submit {
    opacity: 0.6;
    cursor: not-allowed;
    box-shadow: none;
}

/* Divider */
.divider {
    margin: 24px 0 20px;
    border: none;
    border-top: 1px solid #eef0f3;
}

/* Register */
.register-row {
    text-align: center;
    font-size: 0.8125rem;
    color: var(--text-muted);
    margin-bottom: 20px;
}
.register-row a {
    font-weight: 700;
    color: var(--green-dark);
    text-decoration: none;
    transition: opacity 0.12s;
}
.register-row a:hover { opacity: 0.75; }

/* Trust badges */
.trust-row {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 20px;
}
.trust-item {
    display: flex;
    align-items: center;
    gap: 5px;
}
.trust-dot { width: 6px; height: 6px; border-radius: 50%; }
.trust-dot.gold  { background: var(--gold); }
.trust-dot.red   { background: var(--red); }
.trust-item span {
    font-size: 0.68rem;
    font-weight: 700;
    letter-spacing: 0.06em;
    text-transform: uppercase;
    color: var(--text-hint);
}

/* Footer */
.page-footer {
    margin-top: 20px;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 6px;
    text-align: center;
}
@media (min-width: 600px) {
    .page-footer { flex-direction: row; justify-content: space-between; width: 100%; max-width: 980px; }
}
.page-footer p, .page-footer a {
    font-size: 0.73rem;
    color: #a0adb8;
    text-decoration: none;
}
.page-footer a:hover { color: var(--green-dark); }
.footer-links { display: flex; gap: 16px; }
</style>
@include('partials.google_analytics')
</head>
<body>

<div class="card">

    <!-- Left panel -->
    <div class="panel-left">
        <div class="panel-bg"></div>
        <div class="panel-grad"></div>
        <div class="panel-content">
            <div class="brand">
                <img src="{{ asset('logo.png') }}" alt="Logo Koperasi Ugoro" class="brand-logo" onerror="this.style.display='none'"/>
                <span class="brand-name">Koperasi Ugoro</span>
            </div>

            <div class="panel-body">
                <h2>Sejahtera Bersama<br/>KPRI Ugoro</h2>
                <p>Wujudkan impian finansial Anda melalui ekosistem koperasi yang transparan, aman, dan mengutamakan kesejahteraan anggota.</p>
            </div>

            <div class="stats-row">
                <div class="stat-pill">
                    <span class="stat-dot green"></span>
                    <span>500+ Anggota</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Right panel -->
    <div class="panel-right">
        <div class="form-wrap">

            <!-- Mobile brand -->
            <div class="mobile-brand">
                <img src="{{ asset('logo.png') }}" alt="Logo" onerror="this.style.display='none'"/>
                <span>Koperasi Ugoro</span>
            </div>

            <div class="form-heading">
                <h1>Selamat Datang</h1>
                <p>Masuk ke akun anggota Anda untuk melanjutkan.</p>
            </div>

            @if ($errors->any())
                <div style="background: rgba(225,29,72,0.1); color: var(--red); padding: 12px; border-radius: var(--radius-md); font-size: 0.85rem; margin-bottom: 24px; text-align: center; font-weight: 600;">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" novalidate id="loginForm">
                @csrf

                <!-- ID Anggota -->
                <div class="field">
                    <label for="member-id">ID Anggota</label>
                    <div class="input-wrap">
                        <span class="material-symbols-outlined input-icon">person</span>
                        <input
                            class="inp"
                            id="member-id"
                            type="text"
                            name="no_anggota"
                            value="{{ old('no_anggota') }}"
                            placeholder="Contoh: 12345"
                            pattern="\d+"
                            required
                            autocomplete="username"
                        />
                    </div>
                    <span class="field-error">Format tidak valid — gunakan KOP-12345</span>
                </div>

                <!-- Password -->
                <div class="field">
                    <div class="field-top">
                        <label for="password">Kata Sandi</label>
                        <a href="#" class="forgot-link">Lupa kata sandi?</a>
                    </div>
                    <div class="input-wrap">
                        <span class="material-symbols-outlined input-icon">lock</span>
                        <input
                            class="inp inp-password"
                            id="password"
                            type="password"
                            name="password"
                            placeholder="••••••••"
                            minlength="6"
                            required
                            autocomplete="current-password"
                        />
                        <button class="toggle-pw" type="button" id="togglePw" aria-label="Tampilkan kata sandi">
                            <span class="material-symbols-outlined" id="pwIcon">visibility</span>
                        </button>
                    </div>
                    <span class="field-error">Kata sandi wajib diisi</span>
                </div>

                <!-- Remember -->
                <div class="remember-row">
                    <input type="checkbox" id="remember" name="remember"/>
                    <label for="remember">Ingat saya selama 30 hari</label>
                </div>

                <button class="btn-submit" type="submit">Masuk ke Dashboard</button>

            </form>

            <hr class="divider"/>

            <div class="register-row">
                Belum punya akun? <a href="#">Daftar Sekarang</a>
            </div>

            <div class="trust-row">
                <div class="trust-item">
                    <img src="{{ asset('asset/aman.png') }}" alt="Keamanan Terjamin" style="height: 48px; width: auto;"/>
                </div>
            </div>

        </div>
    </div>

</div>

<!-- Footer -->
<footer class="page-footer">
    <p>© 2025 Koperasi Ugoro. Seluruh Hak Cipta Dilindungi.</p>
    <div class="footer-links">
        <a href="#">Syarat &amp; Ketentuan</a>
        <a href="#">Kebijakan Privasi</a>
        <a href="#">Pusat Bantuan</a>
    </div>
</footer>

<script>
    // Toggle password visibility
    const pwInput = document.getElementById('password');
    const pwIcon  = document.getElementById('pwIcon');
    document.getElementById('togglePw').addEventListener('click', () => {
        const hidden = pwInput.type === 'password';
        pwInput.type = hidden ? 'text' : 'password';
        pwIcon.textContent = hidden ? 'visibility_off' : 'visibility';
    });

    // Native validation on submit
    document.getElementById('loginForm').addEventListener('submit', e => {
        if (!e.target.checkValidity()) {
            e.preventDefault();
            e.target.reportValidity();
        }
    });
</script>
</body>
</html>