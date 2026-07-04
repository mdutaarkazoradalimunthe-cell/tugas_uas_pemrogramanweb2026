<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-semibold text-ink leading-tight">
            {{ $event->nama_acara }}
        </h2>
    </x-slot>

    <div class="py-16">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-8">

            @if (session('success'))
                <div class="p-4 bg-evergreen/10 text-evergreen-dark border border-evergreen/20 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Detail Acara --}}
            <div class="bg-white overflow-hidden border border-mist/60 rounded-xl p-10">
                <div class="flex justify-between items-start mb-6">
                    <h3 class="text-2xl font-semibold">Detail Acara</h3>
                    <div class="flex gap-2">
                        <a href="{{ route('events.edit', $event) }}" class="px-4 py-1.5 border border-ink/20 rounded-md text-ink hover:bg-ink/5 text-sm transition-colors duration-150">
                            Edit
                        </a>
                        <a href="{{ route('events.index') }}" class="px-4 py-1.5 border border-ink/20 rounded-md text-ink hover:bg-ink/5 text-sm transition-colors duration-150">
                            Kembali
                        </a>
                    </div>
                </div>

                <dl class="grid grid-cols-2 gap-4 text-sm">
                    <div>
                        <dt class="text-ink/50">Tanggal</dt>
                        <dd class="font-medium text-ink">{{ \Carbon\Carbon::parse($event->tanggal_utama)->format('d M Y') }}</dd>
                    </div>
                    <div>
                        <dt class="text-ink/50">Jam</dt>
                        <dd class="font-medium text-ink">{{ \Carbon\Carbon::parse($event->jam_utama)->format('H:i') }}</dd>
                    </div>
                    <div class="col-span-2">
                        <dt class="text-ink/50">Lokasi</dt>
                        <dd class="font-medium text-ink">{{ $event->lokasi_utama }}</dd>
                    </div>

                    @if ($event->template->event_type === 'pernikahan')
                        <div>
                            <dt class="text-ink/50">Mempelai Pria</dt>
                            <dd class="font-medium text-ink">{{ $event->nama_mempelai_pria }}</dd>
                        </div>
                        <div>
                            <dt class="text-ink/50">Mempelai Wanita</dt>
                            <dd class="font-medium text-ink">{{ $event->nama_mempelai_wanita }}</dd>
                        </div>
                        @if ($event->tanggal_resepsi)
                            <div>
                                <dt class="text-ink/50">Resepsi</dt>
                                <dd class="font-medium text-ink">
                                    {{ \Carbon\Carbon::parse($event->tanggal_resepsi)->format('d M Y') }}
                                    - {{ \Carbon\Carbon::parse($event->jam_resepsi)->format('H:i') }}
                                </dd>
                            </div>
                            <div>
                                <dt class="text-ink/50">Lokasi Resepsi</dt>
                                <dd class="font-medium text-ink">{{ $event->lokasi_resepsi }}</dd>
                            </div>
                        @endif
                    @endif
                </dl>

                <div class="mt-6 p-4 bg-paper border border-mist/60 rounded-lg">
                    <p class="text-sm text-ink/50 mb-1">Link Undangan (bagikan ke tamu):</p>
                    <p class="text-ink/60 font-mono text-sm break-all">
                        {{ url('/undangan/' . $event->unique_slug) }}
                    </p>
                </div>
            </div>

            {{-- Ringkasan RSVP --}}
            @php
                $totalHadir = $event->rsvps()->where('status_hadir', 'hadir')->sum('jumlah_orang');
                $totalTidakHadir = $event->rsvps()->where('status_hadir', 'tidak_hadir')->count();
                $totalRespon = $event->rsvps()->count();
            @endphp

            <div class="bg-white overflow-hidden border border-mist/60 rounded-xl p-10">
                <h3 class="text-2xl font-semibold mb-6">Ringkasan RSVP</h3>
                <div class="grid grid-cols-3 gap-6 text-center">
                    <div class="p-6 bg-white border border-mist/60 rounded-lg">
                        <p class="text-3xl font-semibold text-evergreen">{{ $totalHadir }}</p>
                        <p class="text-sm text-ink/50 mt-2">Orang Akan Hadir</p>
                    </div>
                    <div class="p-6 bg-white border border-mist/60 rounded-lg">
                        <p class="text-3xl font-semibold text-ink">{{ $totalTidakHadir }}</p>
                        <p class="text-sm text-ink/50 mt-2">Tamu Tidak Hadir</p>
                    </div>
                    <div class="p-6 bg-white border border-mist/60 rounded-lg">
                        <p class="text-3xl font-semibold text-ink">{{ $totalRespon }}</p>
                        <p class="text-sm text-ink/50 mt-2">Total Respon</p>
                    </div>
                </div>
            </div>

            {{-- Daftar Tamu --}}
            <div class="bg-white overflow-hidden border border-mist/60 rounded-xl p-10">
                <h3 class="text-2xl font-semibold mb-6">Daftar Tamu</h3>

                @if ($event->rsvps->isEmpty())
                    <p class="text-ink/50">Belum ada tamu yang mengisi RSVP.</p>
                @else
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left">
                            <thead class="text-ink/50 border-b border-mist/60">
                                <tr>
                                    <th class="py-2 pr-4">Nama</th>
                                    <th class="py-2 pr-4">Status</th>
                                    <th class="py-2 pr-4">Jumlah</th>
                                    <th class="py-2 pr-4">Ucapan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($event->rsvps as $rsvp)
                                    <tr class="border-b border-mist/60 {{ $rsvp->is_hidden ? 'opacity-40' : '' }}">
                                        <td class="py-2 pr-4 font-medium">{{ $rsvp->nama_tamu }}</td>
                                        <td class="py-2 pr-4">
                                            @if ($rsvp->status_hadir === 'hadir')
                                                <span class="text-evergreen">Hadir</span>
                                            @else
                                                <span class="text-ink/50">Tidak Hadir</span>
                                            @endif
                                        </td>
                                        <td class="py-2 pr-4">{{ $rsvp->jumlah_orang }}</td>
                                        <td class="py-2 pr-4">{{ $rsvp->ucapan ?? '-' }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>
