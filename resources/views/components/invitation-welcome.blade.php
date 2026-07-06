@props(['event'])

@php
    $isWedding = $event->template->event_type === 'pernikahan';
@endphp

<div id="welcome-overlay" class="fixed inset-0 z-[60] bg-paper flex flex-col items-center justify-center transition-all duration-500 ease-in-out">
    <div class="text-center px-6 max-w-md">
        @if($isWedding)
            <p class="text-[10px] uppercase tracking-[0.25em] text-ink/30 font-medium mb-5">The Wedding of</p>
            <h1 class="font-playfair text-3xl md:text-4xl font-semibold text-ink leading-tight uppercase tracking-wide">
                {{ $event->nama_mempelai_wanita ?: 'Nama Wanita' }}
            </h1>
            <p class="font-pinyon text-3xl text-brass my-2">&</p>
            <h1 class="font-playfair text-3xl md:text-4xl font-semibold text-ink leading-tight uppercase tracking-wide">
                {{ $event->nama_mempelai_pria ?: 'Nama Pria' }}
            </h1>
        @else
            <p class="text-[10px] uppercase tracking-[0.25em] text-ink/30 font-medium mb-5">Undangan</p>
            <h1 class="font-playfair text-3xl md:text-4xl font-semibold text-ink leading-tight">
                {{ $event->nama_acara }}
            </h1>
        @endif

        <div class="mt-10 flex items-center justify-center gap-3 text-ink/20">
            <span class="w-8 h-px bg-ink/10"></span>
            <span class="font-pinyon text-xl">~</span>
            <span class="w-8 h-px bg-ink/10"></span>
        </div>

        <button onclick="bukaUndangan()" class="mt-10 inline-flex items-center gap-2 px-8 py-3 bg-evergreen text-paper font-medium rounded-full hover:bg-evergreen-dark transition-all duration-200 active:scale-95 text-sm shadow-sm">
            Buka Undangan
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"/></svg>
        </button>

        <p class="mt-6 text-[10px] uppercase tracking-[0.2em] text-ink/20">⏐ scroll untuk buka ⏐</p>
    </div>
</div>

<script>
    function bukaUndangan() {
        var overlay = document.getElementById('welcome-overlay');
        if (!overlay || overlay.dataset.opened) return;
        overlay.dataset.opened = '1';

        if (typeof playMusic === 'function') {
            playMusic();
        }

        overlay.style.opacity = '0';
        overlay.style.pointerEvents = 'none';
        setTimeout(function() {
            if (overlay && overlay.parentNode) {
                overlay.parentNode.removeChild(overlay);
            }
        }, 500);
    }
</script>
