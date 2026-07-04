<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $event->nama_acara }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if (session('success'))
                <div class="p-4 bg-green-100 text-green-800 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Detail Acara --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="flex justify-between items-start mb-4">
                    <h3 class="text-lg font-medium">Detail Acara</h3>
                    <div class="flex gap-2">
                        <a href="{{ route('events.edit', $event) }}" class="px-3 py-1 bg-yellow-100 rounded hover:bg-yellow-200 text-sm">
                            Edit
                        </a>
                        <a href="{{ route('events.index') }}" class="px-3 py-1 bg-gray-100 rounded hover:bg-gray-200 text-sm">
                            Kembali
                        </a>
                    </div>
                </div>

                <dl class="grid grid-cols-2 gap-4 text-sm">
                    <div>
                        <dt class="text-gray-500">Tanggal</dt>
                        <dd class="font-medium">{{ \Carbon\Carbon::parse($event->tanggal_utama)->format('d M Y') }}</dd>
                    </div>
                    <div>
                        <dt class="text-gray-500">Jam</dt>
                        <dd class="font-medium">{{ \Carbon\Carbon::parse($event->jam_utama)->format('H:i') }}</dd>
                    </div>
                    <div class="col-span-2">
                        <dt class="text-gray-500">Lokasi</dt>
                        <dd class="font-medium">{{ $event->lokasi_utama }}</dd>
                    </div>

                    @if ($event->template->event_type === 'pernikahan')
                        <div>
                            <dt class="text-gray-500">Mempelai Pria</dt>
                            <dd class="font-medium">{{ $event->nama_mempelai_pria }}</dd>
                        </div>
                        <div>
                            <dt class="text-gray-500">Mempelai Wanita</dt>
                            <dd class="font-medium">{{ $event->nama_mempelai_wanita }}</dd>
                        </div>
                        @if ($event->tanggal_resepsi)
                            <div>
                                <dt class="text-gray-500">Resepsi</dt>
                                <dd class="font-medium">
                                    {{ \Carbon\Carbon::parse($event->tanggal_resepsi)->format('d M Y') }}
                                    — {{ \Carbon\Carbon::parse($event->jam_resepsi)->format('H:i') }}
                                </dd>
                            </div>
                            <div>
                                <dt class="text-gray-500">Lokasi Resepsi</dt>
                                <dd class="font-medium">{{ $event->lokasi_resepsi }}</dd>
                            </div>
                        @endif
                    @endif
                </dl>

                <div class="mt-4 p-3 bg-blue-50 rounded-lg">
                    <p class="text-sm text-gray-600 mb-1">Link Undangan (bagikan ke tamu):</p>
                    <p class="text-blue-700 font-mono text-sm break-all">
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

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-medium mb-4">Ringkasan RSVP</h3>
                <div class="grid grid-cols-3 gap-4 text-center">
                    <div class="p-4 bg-green-50 rounded-lg">
                        <p class="text-2xl font-bold text-green-700">{{ $totalHadir }}</p>
                        <p class="text-sm text-gray-600">Orang Akan Hadir</p>
                    </div>
                    <div class="p-4 bg-red-50 rounded-lg">
                        <p class="text-2xl font-bold text-red-700">{{ $totalTidakHadir }}</p>
                        <p class="text-sm text-gray-600">Tamu Tidak Hadir</p>
                    </div>
                    <div class="p-4 bg-gray-50 rounded-lg">
                        <p class="text-2xl font-bold text-gray-700">{{ $totalRespon }}</p>
                        <p class="text-sm text-gray-600">Total Respon</p>
                    </div>
                </div>
            </div>

            {{-- Daftar Tamu --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-medium mb-4">Daftar Tamu</h3>

                @if ($event->rsvps->isEmpty())
                    <p class="text-gray-500">Belum ada tamu yang mengisi RSVP.</p>
                @else
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left">
                            <thead class="text-gray-500 border-b">
                                <tr>
                                    <th class="py-2 pr-4">Nama</th>
                                    <th class="py-2 pr-4">Status</th>
                                    <th class="py-2 pr-4">Jumlah</th>
                                    <th class="py-2 pr-4">Ucapan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($event->rsvps as $rsvp)
                                    <tr class="border-b {{ $rsvp->is_hidden ? 'opacity-40' : '' }}">
                                        <td class="py-2 pr-4 font-medium">{{ $rsvp->nama_tamu }}</td>
                                        <td class="py-2 pr-4">
                                            @if ($rsvp->status_hadir === 'hadir')
                                                <span class="text-green-700">Hadir</span>
                                            @else
                                                <span class="text-red-700">Tidak Hadir</span>
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