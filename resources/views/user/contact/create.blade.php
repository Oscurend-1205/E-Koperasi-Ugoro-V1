<!DOCTYPE html>
<html class="light" lang="id">
<head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>Hubungi Admin - Koperasi Ugoro</title>
@include('user.partials.theme_loader')
@include('user.partials.scroll')
</head>
<body class="bg-background-light text-slate-900 min-h-screen">

@include('user.partials.sidebar', ['activePage' => 'contact'])

<div class="min-h-screen transition-all bg-background-light dark:bg-background-dark" id="content-wrapper">

@include('user.partials.topnavbar', ['activePage' => 'contact'])

<!-- Page Content -->
<main class="max-w-7xl mx-auto w-full p-4 lg:p-10 pb-12">

    <!-- Page Header -->
    <div class="mb-10">
        <div class="flex items-center gap-3 mb-2">
            <div class="p-2 bg-primary/10 rounded-lg">
                <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path>
                </svg>
            </div>
            <h2 class="text-3xl font-extrabold text-slate-900 dark:text-white tracking-tight">Hubungi Admin</h2>
        </div>
        <p class="text-slate-500 text-sm max-w-2xl">Punya pertanyaan, kendala, atau menemukan bug? Tim Administrator kami siap membantu Anda kapan saja.</p>
    </div>

    @if (session('success'))
        <div class="p-4 mb-8 text-sm text-green-800 rounded-2xl bg-green-50 dark:bg-green-900/10 dark:text-green-400 border border-green-100 dark:border-green-800/50 flex items-center gap-3 animate-in fade-in slide-in-from-top-4 duration-500" role="alert">
            <svg class="w-5 h-5 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
            </svg>
            <span class="font-semibold text-base">Berhasil dikirim!</span> {{ session('success') }}
        </div>
    @endif

    <div class="flex flex-col lg:flex-row gap-10 items-start">
        <!-- Left Side: Form Container (Balanced Width) -->
        <div class="w-full lg:w-7/12 shrink-0">
            <div class="p-6 sm:p-8 bg-white dark:bg-slate-900 shadow-xl shadow-slate-200/50 dark:shadow-none sm:rounded-3xl border border-slate-100 dark:border-slate-800 border-t-8 border-t-primary sticky top-28 transition-all hover:shadow-2xl hover:shadow-slate-200/60 dark:hover:border-slate-700">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-2xl font-bold text-slate-800 dark:text-white flex items-center gap-2">
                        Kirim Pesan Baru
                        <span class="px-2 py-0.5 bg-primary/10 text-primary text-[10px] font-black uppercase rounded">Direct Support</span>
                    </h3>
                </div>

                <form method="POST" action="{{ route('contact.store') }}" class="space-y-6">
                    @csrf

                    <!-- Subject -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="subject" class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">Subjek Pesan</label>
                            <input id="subject" class="block w-full px-4 py-3 border-2 border-slate-100 dark:border-slate-800 dark:bg-slate-800/50 dark:text-white focus:border-primary focus:ring-0 rounded-2xl text-base transition-all placeholder:text-slate-400" type="text" name="subject" :value="old('subject')" required autofocus placeholder="Contoh: Kendala Upload Foto" />
                            <x-input-error :messages="$errors->get('subject')" class="mt-2" />
                        </div>

                        <!-- Tipe Pesan -->
                        <div>
                            <label for="type" class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">Jenis Pesan</label>
                            <div class="relative">
                                <select id="type" name="type" class="block w-full px-4 py-3 rounded-2xl border-2 border-slate-100 dark:border-slate-800 bg-white dark:bg-slate-800/50 dark:text-white focus:border-primary focus:ring-0 transition-all text-base appearance-none bg-none cursor-pointer pr-12" required>
                                    <option value="Pesan" {{ old('type') == 'Pesan' ? 'selected' : '' }}>Pesan / Pertanyaan Umum</option>
                                    <option value="Bug Report" {{ old('type') == 'Bug Report' ? 'selected' : '' }}>Laporan Bug / Masalah Teknis</option>
                                </select>
                                <div class="absolute inset-y-0 right-4 flex items-center pointer-events-none text-slate-400">
                                    <svg class="w-5 h-5 transition-transform group-focus-within:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                </div>
                            </div>
                            <x-input-error :messages="$errors->get('type')" class="mt-2" />
                        </div>
                    </div>

                    <!-- Pesan -->
                    <div>
                        <label for="message" class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">Isi Pesan Detail</label>
                        <textarea id="message" name="message" class="block w-full px-4 py-4 rounded-2xl border-2 border-slate-100 dark:border-slate-800 dark:bg-slate-800/50 dark:text-white focus:border-primary focus:ring-0 transition-all text-base placeholder:text-slate-400 min-h-[160px]" rows="5" required placeholder="Ceritakan detail pesan atau masalah Anda..."></textarea>
                        <x-input-error :messages="$errors->get('message')" class="mt-2" />
                    </div>

                    <div class="pt-4 flex justify-end">
                        <button type="submit" class="w-full md:w-auto group relative flex items-center justify-center px-6 py-3 bg-primary hover:bg-green-600 dark:bg-primary dark:hover:bg-green-700 text-white rounded-xl font-bold text-sm uppercase tracking-wider transition-all duration-300 shadow-md shadow-primary/10 hover:shadow-lg active:scale-95 overflow-hidden">
                            <span class="relative z-10 flex items-center gap-2">
                                Kirim Pesan
                                <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                            </span>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Right Side: History Messages -->
        <div class="flex-1 min-w-0">
            <div class="flex items-center justify-between mb-4 px-1">
                <div class="flex items-center gap-2">
                    <div class="w-1 h-5 bg-primary rounded-full"></div>
                    <h3 class="text-lg font-bold text-slate-800 dark:text-white">Riwayat</h3>
                </div>
                <div class="text-[10px] font-bold text-slate-400 uppercase tracking-widest bg-slate-100 dark:bg-slate-800 px-2 py-1 rounded-md border border-slate-200 dark:border-slate-700">
                    {{ count($messages) }}
                </div>
            </div>
            
            <div class="grid grid-cols-1 gap-3">
                @forelse($messages as $msg)
                    <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-xl shadow-sm hover:shadow-md transition-all duration-300 group overflow-hidden">
                        <!-- Clickable Header -->
                        <button onclick="toggleMessage('msg-{{ $msg->id }}')" class="w-full text-left p-4 focus:outline-none focus:bg-slate-50/50 dark:focus:bg-slate-800/20 transition-colors">
                            <div class="flex flex-col justify-between items-start gap-3">
                                <div class="w-full">
                                    <div class="flex items-center justify-between gap-2 mb-2">
                                        <span class="text-[9px] font-black uppercase px-2 py-0.5 rounded bg-slate-100 dark:bg-slate-800 text-slate-500 dark:text-slate-400 border border-slate-200 dark:border-slate-700">
                                            {{ $msg->type }}
                                        </span>
                                        <span class="text-[10px] text-slate-400 font-bold tracking-tighter">{{ $msg->created_at->translatedFormat('d M H:i') }}</span>
                                    </div>
                                    <div class="flex items-center justify-between gap-2">
                                        <h4 class="font-bold text-slate-800 dark:text-white text-sm group-hover:text-primary transition-colors leading-tight line-clamp-2">{{ $msg->subject }}</h4>
                                        <svg id="arrow-msg-{{ $msg->id }}" class="w-4 h-4 text-slate-400 transition-transform duration-300 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                    </div>
                                </div>
                                <div class="shrink-0 flex items-center justify-between w-full border-t border-slate-50 dark:border-slate-800/50 pt-3">
                                    @if($msg->status == 'Belum Dibaca')
                                        <div class="flex items-center gap-1.5 px-2 py-0.5 bg-amber-50 text-amber-600 rounded-full border border-amber-100 dark:bg-amber-900/20 dark:text-amber-400 dark:border-amber-800">
                                            <span class="relative flex h-1.5 w-1.5">
                                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-amber-400 opacity-75"></span>
                                                <span class="relative inline-flex rounded-full h-1.5 w-1.5 bg-amber-500"></span>
                                            </span>
                                            <span class="text-[9px] font-black uppercase tracking-wider">Menunggu</span>
                                        </div>
                                    @else
                                        <div class="flex items-center gap-1 px-2 py-0.5 bg-emerald-50 text-emerald-600 rounded-full border border-emerald-100 dark:bg-emerald-900/20 dark:text-emerald-400 dark:border-emerald-800">
                                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path d="M10 12a2 2 0 100-4 2 2 0 000 4z"/><path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"/></svg>
                                            <span class="text-[9px] font-black uppercase tracking-wider">Dibaca</span>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </button>
                        
                        <!-- Collapsible Body -->
                        <div id="body-msg-{{ $msg->id }}" class="hidden px-4 pb-4 animate-in slide-in-from-top-2 duration-300">
                            <div class="p-3 bg-slate-50/80 dark:bg-slate-800/50 rounded-lg text-[13px] text-slate-600 dark:text-slate-300 whitespace-pre-wrap border border-slate-100 dark:border-slate-700/50 leading-relaxed font-medium">
                                {{ $msg->message }}
                            </div>
                            
                            @if($msg->reply)
                                <div class="mt-4 p-3 bg-emerald-50/50 dark:bg-emerald-900/10 rounded-lg border border-emerald-100 dark:border-emerald-800/50">
                                    <div class="flex items-center gap-2 mb-2">
                                        <div class="w-1.5 h-1.5 bg-emerald-500 rounded-full"></div>
                                        <span class="text-[10px] font-black uppercase text-emerald-600 dark:text-emerald-400 tracking-wider">Tanggapan Admin</span>
                                        <span class="text-[9px] text-slate-400 font-bold ml-auto">{{ \Carbon\Carbon::parse($msg->replied_at)->translatedFormat('d M, H:i') }}</span>
                                    </div>
                                    <p class="text-[12px] text-slate-700 dark:text-slate-200 font-medium leading-relaxed italic">
                                        "{{ $msg->reply }}"
                                    </p>
                                </div>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="flex flex-col items-center justify-center p-12 bg-white dark:bg-slate-900 text-center rounded-2xl border-2 border-slate-100 dark:border-slate-800 border-dashed">
                        <div class="w-12 h-12 bg-slate-50 dark:bg-slate-800 rounded-full flex items-center justify-center mb-4 ring-8 ring-slate-50/50">
                            <svg class="w-6 h-6 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z"></path>
                            </svg>
                        </div>
                        <h4 class="text-slate-800 dark:text-white font-bold text-sm">Belum ada riwayat</h4>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</main>

</div>
<script>
    function toggleSidebar() {
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebarOverlay');
        sidebar.classList.toggle('-translate-x-full');
        overlay.classList.toggle('hidden');
    }

    function toggleMessage(id) {
        const body = document.getElementById('body-' + id);
        const arrow = document.getElementById('arrow-' + id);
        
        // Toggle body
        body.classList.toggle('hidden');
        
        // Rotate arrow
        if (body.classList.contains('hidden')) {
            arrow.classList.remove('rotate-180');
        } else {
            arrow.classList.add('rotate-180');
        }
    }
</script>
</body>
</html>
