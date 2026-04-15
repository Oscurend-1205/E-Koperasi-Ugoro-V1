<!DOCTYPE html>
<html lang="id" data-theme="{{ request()->cookie('admin-theme', \App\Models\Setting::get('admin_theme', 'light')) }}">
<head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>@yield('title', 'Koperasi Ugoro — Admin')</title>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet"/>
@include('admin.partials.layout_styles')
@include('admin.partials.theme')

@stack('styles')
</head>
<body>

<!-- Sidebar -->
@include('admin.partials.sidebar')

<!-- Main -->
<main>
  <!-- Topbar -->
  @include('admin.partials.topbar')

  <!-- Canvas -->
  <div class="canvas">
    @yield('content')
  </div>
</main>

@include('admin.partials.confirm_modal')
@include('admin.partials.loader')
@include('admin.partials.layout_scripts')
@stack('scripts')

<!-- Theme handling is moved to public/js/admin.js -->
</body>
</html>
