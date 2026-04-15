<!DOCTYPE html>
<html class="light" lang="id">
<head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<link rel="icon" type="image/png" href="{{ asset('logo.png') }}">
<title>Profil Anggota - Koperasi Ugoro</title>
@include('user.partials.theme_loader')
<style>
  .card-animate { opacity: 0; transform: translateY(12px); transition: opacity 0.45s ease, transform 0.45s ease; }
  .card-animate.visible { opacity: 1; transform: translateY(0); }
  @keyframes fadeSlideIn { from { opacity: 0; transform: translateY(8px); } to   { opacity: 1; transform: translateY(0); } }
  .hover-lift { transition: box-shadow 0.2s, transform 0.2s; }
  .hover-lift:hover { box-shadow: 0 6px 20px -4px rgba(19,236,91,0.18); transform: translateY(-1px); }
</style>
<link href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.min.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.min.js"></script>
@include('user.partials.scroll')
</head>
<body class="bg-background-light text-slate-900 min-h-screen">

@include('user.partials.sidebar', ['activePage' => 'profil'])

<div class="min-h-screen transition-all bg-background-light" id="content-wrapper">
    @include('user.partials.topnavbar', ['activePage' => 'profil'])

    <!-- Main Content -->
    <main class="max-w-[1440px] mx-auto w-full px-4 lg:px-6 py-5 lg:py-6 space-y-5">
      <div class="max-w-5xl mx-auto space-y-8">
        
        <!-- Page Title Area -->
        <div class="card-animate flex flex-col gap-1 mb-8" style="transition-delay:0.05s">
          <span class="text-[10px] font-bold text-emerald-600 uppercase tracking-[0.2em]">Pengaturan Akun</span>
          <h1 class="text-2xl font-extrabold text-slate-900 dark:text-white leading-none tracking-tight">Profil Anggota</h1>
        </div>

        @if (session('status') === 'profile-updated')
            <div class="card-animate p-4 mb-4 text-sm text-emerald-800 rounded-xl bg-emerald-50 dark:bg-emerald-900/30 dark:text-emerald-300 border border-emerald-100 dark:border-emerald-800" role="alert" style="transition-delay:0.1s">
              <div class="flex items-center gap-2">
                <span class="material-symbols-outlined text-emerald-600" style="font-size:18px">check_circle</span>
                <span class="font-bold">Profil berhasil diperbarui.</span>
              </div>
            </div>
        @elseif (session('status') === 'password-updated')
            <div class="card-animate p-4 mb-4 text-sm text-emerald-800 rounded-xl bg-emerald-50 dark:bg-emerald-900/30 dark:text-emerald-300 border border-emerald-100 dark:border-emerald-800" role="alert" style="transition-delay:0.1s">
              <div class="flex items-center gap-2">
                <span class="material-symbols-outlined text-emerald-600" style="font-size:18px">check_circle</span>
                <span class="font-bold">Password berhasil diperbarui.</span>
              </div>
            </div>
        @endif

        @if ($errors->any())
            <div class="card-animate p-4 mb-4 text-sm text-red-800 rounded-xl bg-red-50 dark:bg-red-900/30 dark:text-red-300 border border-red-100 dark:border-red-800" role="alert" style="transition-delay:0.1s">
                <div class="flex items-center gap-2 mb-2">
                    <span class="material-symbols-outlined text-red-600" style="font-size:18px">error</span>
                    <span class="font-bold">Terjadi kesalahan:</span>
                </div>
                <ul class="list-disc list-inside text-xs">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form id="profile-update-form" method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data">
          @csrf
          @method('patch')
          <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            
            <!-- Left: Profile Photo Card -->
            <div class="card-animate lg:col-span-4 flex flex-col items-center" style="transition-delay:0.15s">
              <div class="w-full bg-white dark:bg-slate-800 rounded-2xl p-6 lg:p-8 shadow-sm border border-slate-100 dark:border-slate-700 sticky top-24">
                <div class="relative group mx-auto w-40 h-40 lg:w-48 lg:h-48 mb-6">
                  <!-- Avatar display / image -->
                  <div class="w-full h-full rounded-full bg-emerald-100 dark:bg-emerald-900/50 flex items-center justify-center border-4 border-emerald-50 dark:border-emerald-800 shadow-xl overflow-hidden relative">
                      @if($user->profile_photo)
                          <img id="photo-preview" src="{{ Storage::url($user->profile_photo) }}" alt="Profile Photo" class="w-full h-full object-cover">
                      @else
                          @php
                            $initials = collect(explode(' ', $user->name))->map(fn($w) => strtoupper(substr($w, 0, 1)))->take(2)->implode('');
                          @endphp
                          <span id="photo-initials" class="text-emerald-600 dark:text-emerald-400 font-extrabold text-5xl">{{ $initials }}</span>
                          <img id="photo-preview" src="#" alt="Profile Photo Preview" class="w-full h-full object-cover hidden">
                      @endif
                  </div>
                  <label for="profile_photo_input" class="absolute inset-0 bg-black/40 rounded-full opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center cursor-pointer">
                      <span class="material-symbols-outlined text-white text-3xl">photo_camera</span>
                  </label>
                  <input type="file" id="profile_photo_input" accept="image/*" class="hidden" onchange="openCropper(event)">
                  <input type="hidden" name="profile_photo_base64" id="profile_photo_base64">
                </div>
                <div class="text-center space-y-4">
                  <p class="text-[10px] text-slate-400 font-medium">upload JPG/PNG. Maks 2MB.</p>
                </div>
                <hr class="my-6 border-slate-100 dark:border-slate-700"/>
                <div class="space-y-4">
                  <div class="flex justify-between items-center">
                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Status Anggota</span>
                    <span class="px-3 py-1 bg-emerald-100 text-emerald-700 dark:bg-emerald-900/50 dark:text-emerald-400 text-[10px] font-bold rounded-full uppercase">Aktif</span>
                  </div>
                  <div class="flex justify-between items-center">
                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Bergabung</span>
                    <span class="text-[12px] font-semibold text-slate-700 dark:text-white">{{ \Carbon\Carbon::parse($user->created_at)->translatedFormat('M Y') }}</span>
                  </div>
                </div>
              </div>
            </div>

            <!-- Right: Profile Form Card -->
            <div class="card-animate lg:col-span-8 bg-white dark:bg-slate-800 rounded-2xl p-6 lg:p-8 shadow-sm border border-slate-100 dark:border-slate-700 hover-lift" style="transition-delay:0.2s">
              <div class="flex items-center gap-3 mb-8">
                <div class="w-10 h-10 bg-emerald-100 dark:bg-emerald-900/50 rounded-xl flex items-center justify-center shrink-0">
                  <span class="material-symbols-outlined text-emerald-600 dark:text-emerald-400">badge</span>
                </div>
                <h3 class="text-lg lg:text-xl font-bold text-slate-900 dark:text-white">Informasi Pribadi</h3>
              </div>
              
              <div class="space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                  @php
                    $canEditName = $user->isAdmin() || session()->has('admin_impersonate');
                  @endphp
                  <!-- Nama Lengkap -->
                  <div class="space-y-2 {{ !$canEditName ? 'opacity-85' : '' }}">
                    <label class="text-[10px] font-bold text-slate-400 uppercase tracking-wider px-1 flex items-center gap-1.5">
                        Nama Lengkap
                        @if(!$canEditName)
                            <span class="material-symbols-outlined text-[12px]">lock</span>
                        @endif
                    </label>
                    <input name="name" 
                           class="w-full {{ $canEditName ? 'bg-slate-50 dark:bg-slate-900 border-slate-100' : 'bg-slate-100 dark:bg-slate-900/50 border-slate-200 cursor-not-allowed' }} dark:border-slate-700 dark:text-white rounded-xl px-4 py-3 text-sm focus:ring-primary focus:border-primary transition-all" 
                           type="text" 
                           value="{{ old('name', $user->name) }}" 
                           required 
                           autocomplete="name" 
                           {{ $canEditName ? '' : 'readonly' }} />
                    @if(!$canEditName)
                        <p class="text-[10px] text-slate-400 italic px-1">* Hubungi admin untuk perubahan nama</p>
                    @endif
                  </div>
                  <!-- No Anggota (Read Only) -->
                  <div class="space-y-2 opacity-80">
                    <label class="text-[10px] font-bold text-slate-400 uppercase tracking-wider px-1">No Anggota</label>
                    <div class="w-full bg-slate-100 dark:bg-slate-900/50 border-slate-200 dark:border-slate-800 rounded-xl px-4 py-3 text-sm font-medium text-slate-500 dark:text-slate-400 flex items-center gap-2">
                      <span class="material-symbols-outlined text-[18px]">lock</span>
                      {{ $user->no_anggota }}
                    </div>
                  </div>
                  <!-- NIK -->
                  <div class="space-y-2">
                    <label class="text-[10px] font-bold text-slate-400 uppercase tracking-wider px-1">NIK (Nomor Induk Kependudukan)</label>
                    <input name="nik" class="w-full bg-slate-50 dark:bg-slate-900 border-slate-100 dark:border-slate-700 dark:text-white rounded-xl px-4 py-3 text-sm focus:ring-primary focus:border-primary transition-all cursor-not-allowed opacity-80" type="text" value="{{ $user->nik ?? '-' }}" readonly />
                  </div>
                  <!-- Email -->
                  <div class="space-y-2">
                    <label class="text-[10px] font-bold text-slate-400 uppercase tracking-wider px-1">Alamat Email</label>
                    <input name="email" class="w-full bg-slate-50 dark:bg-slate-900 border-slate-100 dark:border-slate-700 dark:text-white rounded-xl px-4 py-3 text-sm focus:ring-primary focus:border-primary transition-all" type="email" value="{{ old('email', $user->email) }}" required autocomplete="username" />
                  </div>
                  <!-- No HP -->
                  <div class="space-y-2">
                    <label class="text-[10px] font-bold text-slate-400 uppercase tracking-wider px-1">No. Handphone</label>
                    <input name="no_hp" class="w-full bg-slate-50 dark:bg-slate-900 border-slate-100 dark:border-slate-700 dark:text-white rounded-xl px-4 py-3 text-sm focus:ring-primary focus:border-primary transition-all" type="text" value="{{ old('no_hp', $user->no_hp) }}" />
                  </div>
                  <!-- Tanggal Bergabung (Read Only) -->
                  <div class="space-y-2 opacity-80">
                    <label class="text-[10px] font-bold text-slate-400 uppercase tracking-wider px-1">Tanggal Keanggotaan</label>
                    <div class="w-full bg-slate-100 dark:bg-slate-900/50 border-slate-200 dark:border-slate-800 rounded-xl px-4 py-3 text-sm font-medium text-slate-500 dark:text-slate-400 flex items-center gap-2">
                      <span class="material-symbols-outlined text-[18px]">calendar_today</span>
                      {{ \Carbon\Carbon::parse($user->created_at)->translatedFormat('d F Y') }}
                    </div>
                  </div>
                </div>
                
                <!-- Alamat -->
                <div class="space-y-2 mt-6">
                  <label class="text-[10px] font-bold text-slate-400 uppercase tracking-wider px-1">Alamat Domisili</label>
                  <textarea name="alamat" class="w-full bg-slate-50 dark:bg-slate-900 border-slate-100 dark:border-slate-700 dark:text-white rounded-xl px-4 py-3 text-sm focus:ring-primary focus:border-primary transition-all" rows="3">{{ old('alamat', $user->alamat) }}</textarea>
                </div>
                
                <div class="flex flex-col sm:flex-row gap-4 pt-6 border-t border-slate-100 dark:border-slate-700">
                  <button class="flex-1 py-3 px-6 bg-primary text-white rounded-xl font-bold text-sm shadow-lg shadow-primary/20 active:scale-95 transition-all text-center" type="submit">
                    Simpan Perubahan
                  </button>
                </div>
              </div>
            </div>

          </div>
        </form>

        <!-- Security Section -->
        @if(!session()->has('admin_impersonate'))
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 pb-10">
          <div class="card-animate lg:col-start-5 lg:col-span-8 bg-white dark:bg-slate-800 rounded-2xl p-6 lg:p-8 shadow-sm border border-slate-100 dark:border-slate-700 hover-lift" style="transition-delay:0.3s">
            <div class="flex items-center gap-3 mb-8">
              <div class="w-10 h-10 bg-orange-100 dark:bg-orange-900/40 rounded-xl flex items-center justify-center shrink-0">
                <span class="material-symbols-outlined text-orange-600 dark:text-orange-400">security</span>
              </div>
              <h3 class="text-lg lg:text-xl font-bold text-slate-900 dark:text-white">Ubah Password</h3>
            </div>
            
            <form method="post" action="{{ route('password.update') }}" class="space-y-6">
              @csrf
              @method('put')
              <div class="space-y-6">
                <div class="space-y-2">
                  <label class="text-[10px] font-bold text-slate-400 uppercase tracking-wider px-1">Password Saat Ini</label>
                  <div class="relative">
                    <input name="current_password" class="w-full bg-slate-50 dark:bg-slate-900 border-slate-100 dark:border-slate-700 dark:text-white rounded-xl px-4 py-3 text-sm focus:ring-orange-500 focus:border-orange-500 transition-all font-mono" placeholder="••••••••" type="password" required autocomplete="current-password" />
                  </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                  <div class="space-y-2">
                    <label class="text-[10px] font-bold text-slate-400 uppercase tracking-wider px-1">Password Baru</label>
                    <input name="password" class="w-full bg-slate-50 dark:bg-slate-900 border-slate-100 dark:border-slate-700 dark:text-white rounded-xl px-4 py-3 text-sm focus:ring-orange-500 focus:border-orange-500 transition-all font-mono" placeholder="Min. 8 Karakter" type="password" required autocomplete="new-password" />
                  </div>
                  <div class="space-y-2">
                    <label class="text-[10px] font-bold text-slate-400 uppercase tracking-wider px-1">Konfirmasi Password Baru</label>
                    <input name="password_confirmation" class="w-full bg-slate-50 dark:bg-slate-900 border-slate-100 dark:border-slate-700 dark:text-white rounded-xl px-4 py-3 text-sm focus:ring-orange-500 focus:border-orange-500 transition-all font-mono" placeholder="Ulangi Password Baru" type="password" required autocomplete="new-password" />
                  </div>
                </div>
              </div>
              <div class="pt-6 border-t border-slate-100 dark:border-slate-700 flex justify-end">
                <button class="w-full sm:w-auto py-3 px-8 bg-slate-900 dark:bg-slate-700 text-white rounded-xl font-bold text-sm shadow-lg hover:bg-slate-800 dark:hover:bg-slate-600 active:scale-95 transition-all text-center" type="submit">
                  Update Password
                </button>
              </div>
            </form>
          </div>
        </div>
        @endif

        <!-- Appearance Section -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 pb-10 mt-8">
          <div class="card-animate lg:col-start-5 lg:col-span-8 bg-white dark:bg-slate-800 rounded-2xl p-6 lg:p-8 shadow-sm border border-slate-100 dark:border-slate-700 hover-lift" style="transition-delay:0.4s">
            <div class="flex items-center gap-3 mb-8">
              <div class="w-10 h-10 bg-indigo-100 dark:bg-indigo-900/40 rounded-xl flex items-center justify-center shrink-0">
                <span class="material-symbols-outlined text-indigo-600 dark:text-indigo-400">dark_mode</span>
              </div>
              <h3 class="text-lg lg:text-xl font-bold text-slate-900 dark:text-white">Pengaturan Tampilan</h3>
            </div>
            
            <div class="flex items-center justify-between p-4 bg-slate-50 dark:bg-slate-900 rounded-xl border border-slate-100 dark:border-slate-700">
              <div>
                <h4 class="text-sm font-bold text-slate-900 dark:text-white">Mode Gelap</h4>
                <p class="text-[11px] text-slate-500 dark:text-slate-400 mt-1">Ubah tampilan menjadi mode gelap untuk kenyamanan mata di malam hari.</p>
              </div>
              <label class="relative inline-flex items-center cursor-pointer">
                <input type="checkbox" id="theme-toggle-switch" class="sr-only peer" onchange="toggleUserTheme(); updateToggleState()">
                <div class="w-11 h-6 bg-slate-200 peer-focus:outline-none rounded-full peer dark:bg-slate-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-slate-600 peer-checked:bg-indigo-500"></div>
              </label>
            </div>
          </div>
        </div>
        <!-- End Appearance Section -->

      </div>
    </main>

    <script>
      function updateToggleState() {
        const isDark = document.documentElement.classList.contains('dark');
        const toggleSwitch = document.getElementById('theme-toggle-switch');
        if (toggleSwitch) {
            toggleSwitch.checked = isDark;
        }
      }
      document.addEventListener('DOMContentLoaded', updateToggleState);
    </script>


    {{-- Footer --}}
    @include('user.partials.footer')
</div>

<!-- Cropper Modal -->
<div id="cropper-modal" class="fixed inset-0 z-[100] bg-black/80 hidden items-center justify-center p-4">
    <div class="bg-white dark:bg-slate-800 rounded-2xl max-w-lg w-full p-6 shadow-2xl flex flex-col">
        <h3 class="text-lg font-bold mb-4 text-slate-900 dark:text-white">Sesuaikan Foto</h3>
        <div class="relative w-full h-[300px] bg-slate-100 dark:bg-slate-900 rounded-xl overflow-hidden mb-4 flex items-center justify-center">
            <img id="image-to-crop" src="" class="max-w-full max-h-full block">
        </div>
        <div class="flex items-center justify-between gap-4 mt-auto">
            <div class="flex gap-2">
                <button type="button" onclick="cropper.rotate(-90)" class="p-2.5 bg-slate-100 hover:bg-slate-200 dark:bg-slate-700 dark:hover:bg-slate-600 rounded-xl text-slate-600 dark:text-slate-300 transition-colors flex items-center justify-center" title="Putar Kiri">
                    <span class="material-symbols-outlined" style="font-size: 20px;">rotate_left</span>
                </button>
                <button type="button" onclick="cropper.rotate(90)" class="p-2.5 bg-slate-100 hover:bg-slate-200 dark:bg-slate-700 dark:hover:bg-slate-600 rounded-xl text-slate-600 dark:text-slate-300 transition-colors flex items-center justify-center" title="Putar Kanan">
                    <span class="material-symbols-outlined" style="font-size: 20px;">rotate_right</span>
                </button>
            </div>
            <div class="flex gap-2">
                <button type="button" onclick="closeCropper()" class="px-5 py-2.5 font-bold text-sm bg-slate-100 hover:bg-slate-200 dark:bg-slate-700 dark:hover:bg-slate-600 text-slate-600 dark:text-slate-300 rounded-xl transition-colors">Batal</button>
                <button type="button" onclick="applyCrop()" class="px-5 py-2.5 font-bold text-sm bg-primary hover:bg-emerald-600 text-white rounded-xl transition-colors shadow-lg shadow-primary/20">Pasang Foto</button>
            </div>
        </div>
    </div>
</div>

<script>
let cropper = null;
const cropperModal = document.getElementById('cropper-modal');
const imageToCrop = document.getElementById('image-to-crop');
const fileInput = document.getElementById('profile_photo_input');

function openCropper(event) {
    const input = event.target;
    if (input.files && input.files[0]) {
        const file = input.files[0];
        
        // Cek jika bukan gambar
        if (!file.type.startsWith('image/')) {
            alert('File harus berupa gambar.');
            return;
        }

        const reader = new FileReader();
        reader.onload = function(e) {
            // Tampilkan modal
            cropperModal.classList.remove('hidden');
            cropperModal.classList.add('flex');
            
            // Set source image
            imageToCrop.src = e.target.result;
            
            // Inisialisasi Cropper di dalam setTimeout agar modal selesai render
            setTimeout(() => {
                if (cropper) {
                    cropper.destroy();
                }
                cropper = new Cropper(imageToCrop, {
                    aspectRatio: 1,
                    viewMode: 1,
                    dragMode: 'move',
                    autoCropArea: 1,
                    restore: false,
                    guides: true,
                    center: true,
                    highlight: false,
                    cropBoxMovable: true,
                    cropBoxResizable: true,
                    toggleDragModeOnDblclick: false,
                });
            }, 50);
        }
        reader.readAsDataURL(file);
    }
}

function closeCropper() {
    cropperModal.classList.add('hidden');
    cropperModal.classList.remove('flex');
    if (cropper) {
        cropper.destroy();
        cropper = null;
    }
    // Hapus value file input agar bisa dipilih lagi meskipun file sama
    fileInput.value = '';
}

function applyCrop() {
    if (!cropper) return;
    
    // Dapatkan area yang ter-crop dengan spesifikasi kompresi
    const canvas = cropper.getCroppedCanvas({
        width: 400, // dimensi yang wajar
        height: 400,
        imageSmoothingEnabled: true,
        imageSmoothingQuality: 'high',
    });
    
    // Kompresi kualitas gambar (misal 0.82)
    const compressedBase64 = canvas.toDataURL('image/jpeg', 0.82);
    
    // Set ke hidden input
    document.getElementById('profile_photo_base64').value = compressedBase64;
    
    // Tutup Modal
    closeCropper();
    
    // Otomatis simpan form agar tersimpan di penyimpanan
    document.getElementById('profile-update-form').submit();
}

document.addEventListener('DOMContentLoaded', function () {
  // Card entrance animations
  const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) { entry.target.classList.add('visible'); observer.unobserve(entry.target); }
    });
  }, { threshold: 0.05 });
  document.querySelectorAll('.card-animate').forEach(el => observer.observe(el));
});
</script>
</body>
</html>