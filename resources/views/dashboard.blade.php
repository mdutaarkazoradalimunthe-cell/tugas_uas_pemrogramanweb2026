<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-semibold text-ink leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-16">
        <div class="max-w-7xl mx-auto space-y-12 sm:px-6 lg:px-8">
            <div class="overflow-hidden rounded-xl border border-mist/60 bg-white">
                <div class="p-10 lg:p-12">
                    <p class="text-xs font-medium uppercase tracking-wider text-ink/50">Undangan Digital & RSVP</p>
                    <h3 class="mt-3 text-3xl font-semibold text-ink">
                        Selamat datang, {{ Auth::user()->name }}
                    </h3>
                    <p class="mt-4 max-w-2xl text-ink/60 leading-relaxed">
                        Kelola undangan digital, bagikan link ke tamu, dan pantau konfirmasi kehadiran dari satu dashboard yang rapi.
                    </p>

                    <div class="mt-8 flex flex-wrap gap-3">
                        <a href="{{ route('events.create') }}" class="inline-flex items-center rounded-md bg-evergreen px-5 py-2.5 font-medium text-paper transition-colors duration-150 hover:bg-evergreen-dark">
                            Buat Undangan
                        </a>
                        <a href="{{ route('events.index') }}" class="inline-flex items-center rounded-md border border-ink/20 px-5 py-2.5 font-medium text-ink transition-colors duration-150 hover:bg-ink/5">
                            Lihat Undangan
                        </a>
                    </div>
                </div>
            </div>

            <div class="grid gap-6 md:grid-cols-3">
                <div class="rounded-xl border border-mist/60 bg-white p-8">
                    <p class="text-sm font-medium text-ink/50">Total Undangan</p>
                    <p class="mt-4 text-5xl font-semibold text-evergreen">{{ $totalEvents }}</p>
                    <p class="mt-2 text-sm text-ink/50">Undangan yang sudah dibuat</p>
                </div>

                <div class="rounded-xl border border-mist/60 bg-white p-8">
                    <p class="text-sm font-medium text-ink/50">Total RSVP</p>
                    <p class="mt-4 text-5xl font-semibold text-ink">{{ $totalResponses }}</p>
                    <p class="mt-2 text-sm text-ink/50">Konfirmasi dari semua undangan</p>
                </div>

                <div class="rounded-xl border border-mist/60 bg-white p-8">
                    <p class="text-sm font-medium text-ink/50">Tamu Akan Hadir</p>
                    <p class="mt-4 text-5xl font-semibold text-ink">{{ $totalGuests }}</p>
                    <p class="mt-2 text-sm text-ink/50">Akumulasi jumlah tamu hadir</p>
                </div>
            </div>

            <div class="rounded-xl border border-mist/60 bg-white p-10">
                <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <h3 class="text-2xl font-semibold text-ink">Undangan Terbaru</h3>
                        <p class="mt-1 text-sm text-ink/50">Lihat ringkasan undangan yang baru kamu buat</p>
                    </div>
                    <a href="{{ route('events.index') }}" class="text-sm font-medium text-evergreen hover:text-evergreen-dark">
                        Lihat semua
                    </a>
                </div>

                @if ($events->isNotEmpty())
                    <div class="mt-8 space-y-6">
                        @foreach ($events as $event)
                            <div class="rounded-lg border border-mist/60 p-6 transition-colors duration-150 hover:bg-paper/50">
                                <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
                                    <div class="flex-1">
                                        <h4 class="font-semibold text-ink">{{ $event->nama_acara }}</h4>
                                        <p class="mt-1 text-sm text-ink/50">
                                            {{ \Carbon\Carbon::parse($event->tanggal_utama)->format('d M Y') }} • {{ $event->lokasi_utama }}
                                        </p>
                                        <p class="mt-3 break-all font-mono text-xs text-ink/40">
                                            {{ url('/undangan/' . $event->unique_slug) }}
                                        </p>
                                    </div>

                                    <div class="flex shrink-0 items-center gap-3 sm:flex-col sm:items-end">
                                        <span class="rounded-full bg-paper px-3 py-1 text-xs font-medium text-ink/60">
                                            {{ $event->rsvps_count }} RSVP
                                        </span>
                                        <a href="{{ route('events.show', $event) }}" class="rounded-md border border-ink/20 px-4 py-1.5 text-sm font-medium text-ink transition-colors duration-150 hover:bg-ink/5">
                                            Detail
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="mt-8 rounded-lg border border-dashed border-mist p-12 text-center">
                        <p class="text-2xl font-semibold text-ink">Belum ada undangan aktif</p>
                        <p class="mx-auto mt-2 max-w-md text-sm text-ink/50">
                            Mulai dengan membuat undangan pertama, lalu bagikan link RSVP ke tamu undangan.
                        </p>
                        <a href="{{ route('events.create') }}" class="mt-6 inline-flex rounded-md bg-evergreen px-5 py-2.5 font-medium text-paper transition-colors duration-150 hover:bg-evergreen-dark">
                            Buat Undangan Pertama
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
