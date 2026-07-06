<x-app-layout>
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-16 lg:py-20">
        @if (session('success'))
            <div class="mb-8 p-4 bg-evergreen/10 text-evergreen-dark border border-evergreen/20 rounded-lg text-sm">
                {{ session('success') }}
            </div>
        @endif

        <div class="flex items-start justify-between">
            <div>
                <p class="text-xs uppercase tracking-[0.2em] font-medium text-brass">Detail Undangan</p>
                <h1 class="mt-3 font-display text-3xl lg:text-4xl font-semibold text-ink leading-[1.08] tracking-tight">
                    {{ $event->nama_acara }}
                </h1>
            </div>
            <div class="flex gap-3 shrink-0">
                <a href="{{ route('events.edit', $event) }}" class="inline-flex items-center px-5 py-2 bg-evergreen text-paper font-medium rounded-full hover:bg-evergreen-dark transition-colors duration-200 text-sm">
                    Edit
                </a>
                <a href="{{ route('events.index') }}" class="inline-flex items-center px-5 py-2 text-ink/70 hover:text-ink font-medium rounded-full border border-ink/15 hover:border-ink/30 transition-colors duration-200 text-sm">
                    Kembali
                </a>
            </div>
        </div>

        {{-- Event Info --}}
        <div class="mt-12 grid gap-8 md:grid-cols-3">
            <div>
                <p class="text-xs uppercase tracking-[0.12em] font-medium text-ink/40">Tanggal</p>
                <p class="mt-2 font-display text-2xl font-semibold text-ink">{{ \Carbon\Carbon::parse($event->tanggal_utama)->format('d M Y') }}</p>
            </div>
            <div>
                <p class="text-xs uppercase tracking-[0.12em] font-medium text-ink/40">Jam</p>
                <p class="mt-2 font-display text-2xl font-semibold text-ink">{{ \Carbon\Carbon::parse($event->jam_utama)->format('H:i') }}</p>
            </div>
            <div>
                <p class="text-xs uppercase tracking-[0.12em] font-medium text-ink/40">Lokasi</p>
                <p class="mt-2 font-display text-2xl font-semibold text-ink">{{ $event->lokasi_utama }}</p>
            </div>
        </div>

        @if ($event->template->event_type === 'pernikahan')
        <div class="mt-12 grid gap-8 md:grid-cols-2">
            <div>
                <p class="text-xs uppercase tracking-[0.12em] font-medium text-ink/40">Mempelai Pria</p>
                <p class="mt-2 text-lg font-medium text-ink">{{ $event->nama_mempelai_pria }}</p>
            </div>
            <div>
                <p class="text-xs uppercase tracking-[0.12em] font-medium text-ink/40">Mempelai Wanita</p>
                <p class="mt-2 text-lg font-medium text-ink">{{ $event->nama_mempelai_wanita }}</p>
            </div>
        </div>
        @endif

        <div class="mt-10 p-5 bg-paper border border-mist/60 rounded-xl">
            <p class="text-xs tracking-[0.12em] font-medium text-ink/40 uppercase">Link Undangan</p>
            <div class="mt-2 flex items-center gap-2">
                <input type="text" value="{{ url('/undangan/' . $event->unique_slug) }}" readonly
                    class="flex-1 min-w-0 font-mono text-sm text-ink/60 bg-transparent border border-mist/60 rounded-lg px-3 py-2 focus:outline-none focus:border-brass/50 selection:bg-brass/20">
                <button onclick="salinLink('{{ url('/undangan/' . $event->unique_slug) }}', this)"
                    class="shrink-0 inline-flex items-center gap-1.5 px-4 py-2 bg-evergreen text-paper text-sm font-medium rounded-lg hover:bg-evergreen-dark transition-all duration-200 active:scale-95"
                    aria-label="Salin link undangan">
                    <svg class="w-4 h-4 copy-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3"/>
                    </svg>
                    <span class="copy-text">Salin</span>
                </button>
            </div>
        </div>

        <div class="mt-16 border-t border-mist/80"></div>

        {{-- RSVP Summary --}}
        @php
            $totalHadir = $event->rsvps()->where('status_hadir', 'hadir')->sum('jumlah_orang');
            $totalTidakHadir = $event->rsvps()->where('status_hadir', 'tidak_hadir')->count();
            $totalRespon = $event->rsvps()->count();
        @endphp

        <div class="mt-12">
            <p class="text-xs uppercase tracking-[0.2em] font-medium text-brass">RSVP</p>
            <h2 class="mt-3 font-display text-3xl font-semibold text-ink tracking-tight">Ringkasan Konfirmasi</h2>
        </div>

        <div class="mt-8 grid gap-8 md:grid-cols-3">
            <div>
                <p class="text-xs uppercase tracking-[0.12em] font-medium text-ink/40">Akan Hadir</p>
                <p class="mt-2 font-display text-5xl font-semibold text-evergreen leading-none tracking-tight">{{ $totalHadir }}</p>
                <div class="mt-3 w-8 h-px bg-evergreen/30"></div>
                <p class="mt-2 text-sm text-ink/50">Orang</p>
            </div>
            <div>
                <p class="text-xs uppercase tracking-[0.12em] font-medium text-ink/40">Tidak Hadir</p>
                <p class="mt-2 font-display text-5xl font-semibold text-ink leading-none tracking-tight">{{ $totalTidakHadir }}</p>
                <div class="mt-3 w-8 h-px bg-ink/10"></div>
                <p class="mt-2 text-sm text-ink/50">Tamu</p>
            </div>
            <div>
                <p class="text-xs uppercase tracking-[0.12em] font-medium text-ink/40">Total Respon</p>
                <p class="mt-2 font-display text-5xl font-semibold text-ink leading-none tracking-tight">{{ $totalRespon }}</p>
                <div class="mt-3 w-8 h-px bg-ink/10"></div>
                <p class="mt-2 text-sm text-ink/50">Respon</p>
            </div>
        </div>

        {{-- Guest List --}}
        <div class="mt-16">
            <h2 class="font-display text-2xl font-semibold text-ink tracking-tight">Daftar Tamu</h2>

            @if ($event->rsvps->isEmpty())
                <p class="mt-6 text-sm text-ink/50">Belum ada tamu yang mengisi RSVP.</p>
            @else
                <div class="mt-6 border-t border-mist/80">
                    <div class="divide-y divide-mist/50">
                        @foreach ($event->rsvps as $rsvp)
                            <div class="flex items-center justify-between py-4 gap-4 {{ $rsvp->is_hidden ? 'opacity-40' : '' }}">
                                <div class="min-w-0">
                                    <p class="font-medium text-ink text-sm">{{ $rsvp->nama_tamu }}</p>
                                    @if ($rsvp->ucapan)
                                        <p class="mt-0.5 text-sm text-ink/50 truncate">{{ $rsvp->ucapan }}</p>
                                    @endif
                                </div>
                                <div class="flex shrink-0 items-center gap-4 text-sm">
                                    @if ($rsvp->status_hadir === 'hadir')
                                        <span class="text-evergreen font-medium">{{ $rsvp->jumlah_orang }} org</span>
                                    @else
                                        <span class="text-ink/40">Tidak Hadir</span>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>