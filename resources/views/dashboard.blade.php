<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 lg:py-20">
        {{-- Welcome --}}
        <div>
            <p class="text-xs uppercase tracking-[0.2em] font-medium text-brass">Dashboard</p>
            <h1 class="mt-4 font-display text-4xl lg:text-5xl font-semibold text-ink leading-[1.08] tracking-tight">
                Selamat datang,<br>
                <span class="text-evergreen">{{ Auth::user()->name }}</span>
            </h1>
            <p class="mt-4 text-ink/50 max-w-xl leading-relaxed">
                Kelola undangan digital, bagikan link ke tamu, dan pantau konfirmasi kehadiran dari sini.
            </p>
            <div class="mt-8 flex flex-wrap gap-3">
                <a href="{{ route('events.create') }}" class="inline-flex items-center px-6 py-3 bg-evergreen text-paper font-medium rounded-full hover:bg-evergreen-dark transition-colors duration-200 text-sm shadow-sm">
                    Buat Undangan
                </a>
                <a href="{{ route('events.index') }}" class="inline-flex items-center px-6 py-3 text-ink/70 hover:text-ink font-medium rounded-full border border-ink/15 hover:border-ink/30 transition-colors duration-200 text-sm">
                    Lihat Undangan
                </a>
            </div>
        </div>

        {{-- Stats --}}
        <div class="mt-16 lg:mt-20 grid gap-10 md:grid-cols-3">
            <div>
                <p class="text-xs uppercase tracking-[0.15em] font-medium text-ink/40">Total Undangan</p>
                <p class="mt-3 font-display text-6xl lg:text-7xl font-semibold text-evergreen leading-none tracking-tight">{{ $totalEvents }}</p>
                <div class="mt-4 w-8 h-px bg-evergreen/30"></div>
            </div>
            <div>
                <p class="text-xs uppercase tracking-[0.15em] font-medium text-ink/40">Total RSVP</p>
                <p class="mt-3 font-display text-6xl lg:text-7xl font-semibold text-ink leading-none tracking-tight">{{ $totalResponses }}</p>
                <div class="mt-4 w-8 h-px bg-ink/10"></div>
            </div>
            <div>
                <p class="text-xs uppercase tracking-[0.15em] font-medium text-ink/40">Tamu Akan Hadir</p>
                <p class="mt-3 font-display text-6xl lg:text-7xl font-semibold text-ink leading-none tracking-tight">{{ $totalGuests }}</p>
                <div class="mt-4 w-8 h-px bg-ink/10"></div>
            </div>
        </div>

        {{-- Latest Events --}}
        <div class="mt-20 lg:mt-24">
            <div class="flex items-end justify-between">
                <div>
                    <h2 class="font-display text-2xl font-semibold text-ink tracking-tight">Undangan Terbaru</h2>
                    <p class="mt-1 text-sm text-ink/50">Ringkasan undangan yang baru kamu buat</p>
                </div>
                <a href="{{ route('events.index') }}" class="text-sm font-medium text-evergreen hover:text-evergreen-dark transition-colors">
                    Lihat semua
                </a>
            </div>

            <div class="mt-8 border-t border-mist/80">
                @if ($events->isNotEmpty())
                    <div class="divide-y divide-mist/50">
                        @foreach ($events as $event)
                            <div class="flex flex-col sm:flex-row sm:items-center justify-between py-5 gap-3 transition-colors duration-150 hover:bg-paper/50 -mx-4 px-4 rounded-lg">
                                <div class="min-w-0 flex-1">
                                    <h3 class="font-semibold text-ink">{{ $event->nama_acara }}</h3>
                                    <p class="mt-0.5 text-sm text-ink/50 truncate">
                                        {{ \Carbon\Carbon::parse($event->tanggal_utama)->format('d M Y') }} &middot; {{ $event->lokasi_utama }}
                                    </p>
                                    <p class="mt-2 font-mono text-xs text-ink/30 truncate">
                                        {{ url('/undangan/' . $event->unique_slug) }}
                                    </p>
                                </div>
                                <div class="flex shrink-0 items-center gap-4">
                                    <span class="text-sm font-medium text-ink/50">{{ $event->rsvps_count }} RSVP</span>
                                    <a href="{{ route('events.show', $event) }}" class="inline-flex items-center gap-1 text-sm font-medium text-evergreen hover:text-evergreen-dark transition-colors">
                                        Detail
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="py-16 text-center">
                        <p class="text-2xl font-semibold text-ink">Belum ada undangan</p>
                        <p class="mt-2 text-sm text-ink/50 max-w-sm mx-auto">
                            Mulai dengan membuat undangan pertama, lalu bagikan link RSVP ke tamu undangan.
                        </p>
                        <a href="{{ route('events.create') }}" class="mt-6 inline-flex items-center px-6 py-3 bg-evergreen text-paper font-medium rounded-full hover:bg-evergreen-dark transition-colors duration-200 text-sm shadow-sm">
                            Buat Undangan Pertama
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>