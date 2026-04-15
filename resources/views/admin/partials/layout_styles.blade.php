<link rel="stylesheet" href="{{ asset('css/admin.css') }}">
<style>
/* ── OVERRIDE SIDEBAR & TOPBAR MENJADI MODERN ── */
/* Kustomisasi Scrollbar Tipis */
::-webkit-scrollbar {
  width: 6px;
  height: 6px;
}
::-webkit-scrollbar-track {
  background: transparent;
}
::-webkit-scrollbar-thumb {
  background-color: rgba(0,0,0,0.2);
  border-radius: 10px;
}
* {
  scrollbar-width: thin;
  scrollbar-color: rgba(0,0,0,0.2) transparent;
}
[data-theme="dark"] ::-webkit-scrollbar-thumb {
  background-color: rgba(255,255,255,0.2);
}
[data-theme="dark"] * {
  scrollbar-color: rgba(255,255,255,0.2) transparent;
}

body {
  display: flex !important;
  min-height: 100vh !important;
  margin: 0 !important;
  padding: 0 !important;
}

/* Sidebar / Navbar (Hijau Tua) */
aside {
  background-color: #213f34ff !important; /* Hijau Tua */
  border-right: none !important;
  color: #fff !important;
  z-index: 1001 !important; /* Selalu di atas */
  box-shadow: 2px 0 12px rgba(0,0,0,0.15) !important;
  position: fixed !important;
  top: 0 !important;
  bottom: 0 !important;
  left: 0 !important;
  height: 100vh !important;
  width: var(--sidebar-w, 210px) !important;
  overflow-y: auto !important;
  padding-top: 0 !important; /* Hilangkan padding kosong di atas */
  margin: 0 !important;
}

aside .sidebar-brand {
  background-color: #F7C85C !important; /* Kuning/Warna sesuai edit User */
  border-bottom: 2px solid #c09c49ff !important;
  padding: 20px 14px 18px !important;
  margin: 0 -9px 12px -9px !important; /* Reset margin atas karena padding-top aside 0 */
  border-radius: 0 0 12px 12px !important;
  box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1) !important;
}

aside .sidebar-brand h1 {
  color: #1F6F5F !important; /* Hijau Tua */
  font-weight: 800 !important;
  font-size: 19px !important;
  letter-spacing: 0.5px !important;
  line-height: 1.2 !important;
}

aside .sidebar-brand span {
  color: #1F6F5F !important; /* Hijau redup */
  font-weight: 700 !important;
  letter-spacing: 1.5px !important;
  font-size: 10px !important;
}

aside .nav-section-label {
  color: rgba(255,255,255,0.4) !important;
}

aside nav a {
  color: rgba(255,255,255,0.85) !important;
  transition: all 0.2s ease !important;
}

aside nav a:hover {
  background-color: rgba(255,255,255,0.15) !important;
  color: #fff !important;
  transform: translateX(4px); /* Efek interaktif panah */
}

aside nav a.active {
  background-color: rgba(255,255,255,0.25) !important;
  color: #fff !important;
  font-weight: 700 !important;
  box-shadow: 0 2px 6px rgba(0,0,0,0.1);
}

aside .sidebar-footer {
  border-top: 1px solid rgba(255,255,255,0.1) !important;
}

aside .sidebar-footer button {
  color: rgba(255,255,255,0.85) !important;
  transition: all 0.2s ease !important;
}

aside .sidebar-footer button:hover {
  background-color: rgba(239, 68, 68, 0.9) !important; /* Efek merah saat logout */
  color: #fff !important;
  transform: translateX(4px);
}

/* Topbar (Toska, tinggi lebih kecil, dan benar-benar fixed) */
header {
  background-color: #0d9488 !important; /* Toska */
  height: 48px !important; /* Tinggi lebih kecil */
  position: fixed !important;
  top: 0 !important;
  margin-top: 0 !important; /* Meniadakan gap atas jika ada */
  right: 0 !important;
  left: var(--sidebar-w, 210px) !important; /* Tidak menutupi sidebar */
  width: auto !important;
  z-index: 1000 !important;
  box-shadow: 0 2px 8px rgba(0,0,0,0.15) !important;
  border-bottom: none !important;
  display: flex !important;
  align-items: center !important;
  justify-content: space-between !important;
  padding: 0 20px !important;
}

header .topbar-right .icon-btn {
  color: rgba(255,255,255,0.9) !important;
}

header .topbar-right .icon-btn:hover {
  background-color: rgba(255,255,255,0.2) !important;
  color: #fff !important;
}

header .divider-v {
  background-color: rgba(255,255,255,0.3) !important;
}

header .user-chip {
  background-color: rgba(255,255,255,0.15) !important;
  border-color: rgba(255,255,255,0.2) !important;
  color: #fff !important;
}

header .user-chip:hover {
  background-color: rgba(255,255,255,0.25) !important;
}

header .user-chip .name {
  color: #fff !important;
}

header .user-chip .role {
  color: rgba(255,255,255,0.7) !important;
}

/* Main Content Adjustment for Fixed Sidebar & Topbar */
main {
  margin-left: var(--sidebar-w, 210px) !important; /* Menghindari overlap dengan fixed sidebar */
  padding-top: 48px !important; /* Menghindari overlap dengan fixed topbar */
  flex: 1 !important;
  min-height: 100vh !important;
  display: flex !important;
  flex-direction: column !important;
  box-sizing: border-box !important;
  width: auto !important;
}

/* Media Query untuk Mobile/Tablet */
@media (max-width: 768px) {
  aside {
    display: none !important; /* Bisa diganti offcanvas jika UI mobile dikembangkan */
  }
  header {
    left: 0 !important;
  }
  main {
    margin-left: 0 !important;
  }
}

/* Dark Mode Overrides for Modern Layout */
[data-theme="dark"] aside {
  background-color: #0f172a !important; /* Slate Darker */
  box-shadow: 2px 0 12px rgba(0,0,0,0.4) !important;
}

[data-theme="dark"] aside .sidebar-brand {
  background-color: #1e293b !important;
  border-bottom: 2px solid #334155 !important;
}

[data-theme="dark"] aside .sidebar-brand h1 {
  color: var(--green) !important;
}

[data-theme="dark"] aside .sidebar-brand span {
  color: var(--text-muted) !important;
}

[data-theme="dark"] header {
  background-color: #1e293b !important;
  box-shadow: 0 2px 8px rgba(0,0,0,0.4) !important;
  border-bottom: 1px solid var(--border) !important;
}

[data-theme="dark"] .user-chip {
  background-color: var(--bg) !important;
  border-color: var(--border) !important;
}
</style>
