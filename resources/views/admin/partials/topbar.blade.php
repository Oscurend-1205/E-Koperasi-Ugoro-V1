<header>
  <div>
    @yield('header_left')
  </div>
  <div class="topbar-right">
    <button class="icon-btn" onclick="toggleTheme()" title="Toggle Theme">
      <span class="material-symbols-rounded">dark_mode</span>
    </button>
    <button class="icon-btn"><span class="material-symbols-rounded">notifications</span></button>
    <button class="icon-btn"><span class="material-symbols-rounded">help_outline</span></button>
    <div class="divider-v"></div>
    <div class="user-chip">
      <div>
        <div class="name">{{ auth()->user()->name ?? 'Admin Ugoro' }}</div>
        <div class="role">{{ auth()->user()->role ?? 'Super Admin' }}</div>
      </div>
      <img alt="Admin" src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name ?? 'Admin Ugoro') }}&background=dcfce7&color=16a34a&bold=true&size=64"/>
    </div>
  </div>
</header>
