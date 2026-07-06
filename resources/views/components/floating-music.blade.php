@php
    $firstMusic = $event->musics->first();
    $isPlus = $event->user->isPlus();
@endphp

@if ($isPlus && $firstMusic)
    <div id="music-player" class="fixed bottom-6 left-6 z-50 flex items-center gap-3 bg-white/90 backdrop-blur-md border border-mist/60 rounded-full px-4 py-2 shadow-lg shadow-ink/5">
        <button id="music-play-btn" onclick="toggleMusic()" class="shrink-0 flex items-center justify-center w-9 h-9 bg-evergreen text-paper rounded-full hover:bg-evergreen-dark transition-colors active:scale-95" aria-label="Putar atau hentikan musik">
            <svg id="music-play-icon" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
        </button>
        <div class="flex flex-col min-w-0 max-w-[160px]">
            <span class="text-xs font-medium text-ink truncate">{{ $firstMusic->judul ?? 'Musik Latar' }}</span>
            <span class="text-[10px] text-ink/40">Musik latar</span>
        </div>
        <button onclick="stopMusic()" class="shrink-0 text-ink/20 hover:text-ink/50 transition-colors" aria-label="Tutup pemutar musik">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
        </button>
    </div>

    <audio id="bg-music" src="{{ $firstMusic->audio_url }}" preload="auto" loop></audio>

    <script>
        let musicAudio = document.getElementById('bg-music');
        let musicBtn = document.getElementById('music-play-btn');
        let musicIcon = document.getElementById('music-play-icon');
        let _musicStarted = false;

        function playMusic() {
            if (_musicStarted) return;
            _musicStarted = true;
            if (musicAudio && musicAudio.paused) {
                musicAudio.play().catch(function(){});
                musicIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 9v6m4-6v6m7-3a9 9 0 11-18 0 9 9 0 0118 0z"/>';
            }
        }

        function toggleMusic() {
            if (musicAudio.paused) {
                musicAudio.play();
                musicIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 9v6m4-6v6m7-3a9 9 0 11-18 0 9 9 0 0118 0z"/>';
            } else {
                musicAudio.pause();
                musicIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>';
            }
        }

        function stopMusic() {
            musicAudio.pause();
            musicAudio.currentTime = 0;
            document.getElementById('music-player').remove();
        }
    </script>
@endif
