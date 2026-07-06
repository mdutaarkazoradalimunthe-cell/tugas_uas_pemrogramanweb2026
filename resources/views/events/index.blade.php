<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 lg:py-20">
        @if (session('success'))
            <div class="mb-8 p-4 bg-evergreen/10 text-evergreen-dark border border-evergreen/20 rounded-lg text-sm">
                {{ session('success') }}
            </div>
        @endif

        <div class="flex items-end justify-between">
            <div>
                <p class="text-xs uppercase tracking-[0.2em] font-medium text-brass">Undangan</p>
                <h1 class="mt-3 font-display text-4xl lg:text-5xl font-semibold text-ink leading-[1.08] tracking-tight">
                    Daftar Undangan
                </h1>
                <p class="mt-2 text-sm text-ink/50">Semua undangan yang sudah kamu buat.</p>
            </div>
            <a href="{{ route('events.create') }}" class="inline-flex items-center px-6 py-3 bg-evergreen text-paper font-medium rounded-full hover:bg-evergreen-dark transition-colors duration-200 text-sm shadow-sm">
                + Buat Baru
            </a>
        </div>

        @if ($events->isEmpty())
            <div class="mt-16 text-center py-16">
                <p class="text-2xl font-semibold text-ink">Belum ada undangan</p>
                <p class="mt-2 text-sm text-ink/50 max-w-sm mx-auto">Yuk buat undangan pertamamu sekarang.</p>
                <a href="{{ route('events.create') }}" class="mt-6 inline-flex items-center px-6 py-3 bg-evergreen text-paper font-medium rounded-full hover:bg-evergreen-dark transition-colors duration-200 text-sm shadow-sm">
                    Buat Undangan Pertama
                </a>
            </div>
        @else
            <div class="mt-12 border-t border-mist/80">
                <div class="divide-y divide-mist/50">
                    @foreach ($events as $event)
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between py-6 gap-4 transition-colors duration-150 hover:bg-paper/50 -mx-4 px-4 rounded-lg">
                            <div class="min-w-0 flex-1">
                                <h2 class="font-semibold text-ink text-lg">{{ $event->nama_acara }}</h2>
                                <p class="mt-0.5 text-sm text-ink/50">
                                    {{ \Carbon\Carbon::parse($event->tanggal_utama)->format('d M Y') }} &middot; {{ $event->lokasi_utama }}
                                </p>
                                <p class="mt-2 font-mono text-xs text-ink/30 truncate max-w-[280px] sm:max-w-[400px]">
                                    {{ url('/undangan/' . $event->unique_slug) }}
                                </p>
                            </div>
                            <div class="flex shrink-0 items-center gap-3">
                                <button onclick="salinLink('{{ url('/undangan/' . $event->unique_slug) }}', this)"
                                    class="inline-flex items-center gap-1 text-xs font-medium text-ink/30 hover:text-evergreen transition-colors"
                                    aria-label="Salin link undangan">
                                    <svg class="w-3.5 h-3.5 copy-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3"/>
                                    </svg>
                                    <span class="copy-text">Salin</span>
                                </button>
                                <span class="text-sm font-medium text-ink/50">{{ $event->rsvps_count ?? $event->rsvps->count() }} RSVP</span>
                                <a href="{{ route('events.show', $event) }}" class="inline-flex items-center gap-1 text-sm font-medium text-evergreen hover:text-evergreen-dark transition-colors">
                                    Detail
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                                    </svg>
                                </a>
                                <a href="{{ route('events.edit', $event) }}" class="text-sm font-medium text-ink/40 hover:text-ink transition-colors">Edit</a>
                                <form action="{{ route('events.destroy', $event) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus undangan ini?')" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-sm font-medium text-red-400 hover:text-red-600 transition-colors">Hapus</button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</x-app-layout>