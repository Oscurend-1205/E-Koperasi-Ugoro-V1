<!-- Informasi dari Admin -->
<div class="mb-6 mt-2">
    <div class="flex items-center gap-2 mb-4">
        <div class="h-5 w-1 bg-primary rounded-full"></div>
        <div>
            <h3 class="text-xs font-bold text-slate-900 leading-none">Informasi & Pengumuman</h3>
            <p class="text-[10px] text-slate-400 mt-0.5">Update terbaru dari pengurus koperasi</p>
        </div>
    </div>

    @if(isset($informasis) && $informasis->count() > 0)
        <div class="space-y-3">
            @foreach($informasis as $info)
                <div class="group bg-white rounded-xl border border-slate-200 shadow-sm hover:shadow-md hover:border-primary/30 transition-all duration-300 overflow-hidden {{ $info->is_pinned ? 'ring-2 ring-primary/20' : '' }}">
                    {{-- Header --}}
                    <div class="px-4 py-3 flex items-start justify-between gap-3 cursor-pointer" onclick="toggleInfoContent('{{ $info->id }}')">
                        <div class="flex items-start gap-3 flex-1 min-w-0">
                            {{-- Icon --}}
                            <div class="mt-0.5 shrink-0">
                                @if($info->is_pinned)
                                    <div class="w-8 h-8 rounded-lg bg-amber-50 text-amber-500 flex items-center justify-center">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M10 2a1 1 0 00-.707.293l-7 7a1 1 0 001.414 1.414L10 4.414l6.293 6.293a1 1 0 001.414-1.414l-7-7A1 1 0 0010 2z"/>
                                        </svg>
                                    </div>
                                @else
                                    <div class="w-8 h-8 rounded-lg bg-primary/10 text-primary flex items-center justify-center">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                    </div>
                                @endif
                            </div>
                            {{-- Title & Meta --}}
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center gap-2 flex-wrap">
                                    <h4 class="text-sm font-bold text-slate-800 leading-tight truncate">{{ $info->title }}</h4>
                                    @if($info->is_pinned)
                                        <span class="shrink-0 inline-flex items-center gap-0.5 px-1.5 py-0.5 rounded-full bg-amber-50 text-amber-600 text-[9px] font-bold uppercase tracking-wider">
                                            <svg class="w-2.5 h-2.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.05 3.636a1 1 0 010 1.414 7 7 0 000 9.9 1 1 0 11-1.414 1.414 9 9 0 010-12.728 1 1 0 011.414 0zm9.9 0a1 1 0 011.414 0 9 9 0 010 12.728 1 1 0 11-1.414-1.414 7 7 0 000-9.9 1 1 0 010-1.414zM7.879 6.464a1 1 0 010 1.414 3 3 0 000 4.243 1 1 0 11-1.415 1.414 5 5 0 010-7.07 1 1 0 011.415 0zm4.242 0a1 1 0 011.415 0 5 5 0 010 7.072 1 1 0 01-1.415-1.415 3 3 0 000-4.242 1 1 0 010-1.415zM10 9a1 1 0 100 2 1 1 0 000-2z" clip-rule="evenodd"/></svg>
                                            Pinned
                                        </span>
                                    @endif
                                </div>
                                <div class="flex items-center gap-2 mt-1">
                                    <span class="inline-block px-1.5 py-0.5 rounded text-[9px] font-bold uppercase tracking-wide
                                        @if($info->category === 'Penting') bg-red-50 text-red-600
                                        @elseif($info->category === 'Keuangan') bg-blue-50 text-blue-600
                                        @elseif($info->category === 'Kegiatan') bg-purple-50 text-purple-600
                                        @else bg-slate-100 text-slate-500
                                        @endif
                                    ">{{ $info->category }}</span>
                                    <span class="text-[10px] text-slate-400">{{ $info->published_at ? $info->published_at->translatedFormat('d M Y, H:i') : $info->created_at->translatedFormat('d M Y, H:i') }}</span>
                                    @if($info->author)
                                        <span class="text-[10px] text-slate-400">• {{ $info->author->name }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        {{-- Chevron --}}
                        <div class="shrink-0 mt-1">
                            <svg id="chevron-{{ $info->id }}" class="w-4 h-4 text-slate-400 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </div>
                    </div>
                    {{-- Content (collapsible) --}}
                    <div id="info-content-{{ $info->id }}" class="info-content-collapse" style="max-height: 0; overflow: hidden; transition: max-height 0.4s cubic-bezier(0.4, 0, 0.2, 1);">
                        <div class="px-4 pb-4 pt-0">
                            <div class="border-t border-slate-100 pt-3">
                                <div class="prose-info text-xs text-slate-600 leading-relaxed [&_img]:max-w-full [&_img]:h-auto [&_img]:rounded-lg [&_img]:my-2 [&_h1]:text-base [&_h1]:font-bold [&_h1]:text-slate-800 [&_h1]:mt-2 [&_h2]:text-sm [&_h2]:font-bold [&_h2]:text-slate-800 [&_h2]:mt-2 [&_h3]:text-xs [&_h3]:font-bold [&_h3]:text-slate-700 [&_h3]:mt-1 [&_ul]:list-disc [&_ul]:pl-4 [&_ul]:my-1 [&_ol]:list-decimal [&_ol]:pl-4 [&_ol]:my-1 [&_blockquote]:border-l-4 [&_blockquote]:border-green-200 [&_blockquote]:bg-green-50 [&_blockquote]:pl-3 [&_blockquote]:py-1 [&_blockquote]:my-2 [&_blockquote]:rounded-r [&_blockquote]:text-slate-500 [&_table]:w-full [&_table]:border-collapse [&_table]:my-2 [&_td]:border [&_td]:border-slate-200 [&_td]:px-2 [&_td]:py-1 [&_th]:border [&_th]:border-slate-200 [&_th]:px-2 [&_th]:py-1 [&_th]:bg-slate-50 [&_th]:font-bold [&_a]:text-primary [&_a]:underline [&_hr]:border-t [&_hr]:border-slate-200 [&_hr]:my-3">
                                    {!! $info->content !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-8 text-center">
            <div class="w-14 h-14 mx-auto rounded-2xl bg-slate-50 flex items-center justify-center mb-3">
                <svg class="w-7 h-7 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                </svg>
            </div>
            <p class="text-xs font-semibold text-slate-500">Belum ada informasi terbaru</p>
            <p class="text-[10px] text-slate-400 mt-0.5">Informasi dari pengurus akan tampil di sini</p>
        </div>
    @endif
</div>

<script>
function toggleInfoContent(id) {
    const content = document.getElementById('info-content-' + id);
    const chevron = document.getElementById('chevron-' + id);
    
    if (content.style.maxHeight && content.style.maxHeight !== '0px') {
        content.style.maxHeight = '0px';
        chevron.style.transform = 'rotate(0deg)';
    } else {
        content.style.maxHeight = content.scrollHeight + 'px';
        chevron.style.transform = 'rotate(180deg)';
    }
}
</script>
