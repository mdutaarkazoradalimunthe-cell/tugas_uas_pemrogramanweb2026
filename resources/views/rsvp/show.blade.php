<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $event->nama_acara }}</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-100 min-h-screen py-10 px-4">
    <div class="max-w-xl mx-auto">

        @if (session('success'))
            <div class="mb-4 p-4 bg-green-100 text-green-800 rounded-lg text-center">
                {{ session('success') }}
            </div>
        @endif

        {{-- Kartu Undangan --}}
        <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
            <div class="bg-gradient-to-r from-rose-100 to-amber-100 p-8 text-center">
                @if ($event->template->event_type === 'pernikahan')
                    <p class="text-sm text-gray-500 mb-2">Undangan Pernikahan</p>
                    <h1 class="text-3xl font-serif text-gray-800">
                        {{ $event->nama_mempelai_wanita }} & {{ $event->nama_mempelai_pria }}
                    </h1>
                @else
                    <p class="text-sm text-gray-500 mb-2">Undangan Ulang Tahun</p>
                    <h1 class="text-3xl font-serif text-gray-800">{{ $event->nama_acara }}</h1>
                @endif
            </div>

            <div class="p-8 space-y-6">
                <div class="text-center">
                    <p class="text-gray-500 text-sm">Tanggal</p>
                    <p class="text-lg font-medium">{{ \Carbon\Carbon::parse($event->tanggal_utama)->translatedFormat('d F Y') }}</p>
                    <p class="text-gray-500 text-sm mt-2">Waktu</p>
                    <p class="text-lg font-medium">{{ \Carbon\Carbon::parse($event->jam_utama)->format('H:i') }} WIB</p>
                    <p class="text-gray-500 text-sm mt-2">Lokasi</p>
                    <p class="text-lg font-medium">{{ $event->lokasi_utama }}</p>
                </div>

                @if ($event->template->event_type === 'pernikahan' && $event->tanggal_resepsi)
                    <div class="border-t pt-6 text-center">
                        <p class="font-semibold text-gray-700 mb-2">Resepsi</p>
                        <p class="text-gray-500 text-sm">Tanggal</p>
                        <p class="text-lg font-medium">{{ \Carbon\Carbon::parse($event->tanggal_resepsi)->translatedFormat('d F Y') }}</p>
                        <p class="text-gray-500 text-sm mt-2">Waktu</p>
                        <p class="text-lg font-medium">{{ \Carbon\Carbon::parse($event->jam_resepsi)->format('H:i') }} WIB</p>
                        <p class="text-gray-500 text-sm mt-2">Lokasi</p>
                        <p class="text-lg font-medium">{{ $event->lokasi_resepsi }}</p>
                    </div>
                @endif

                @if ($event->template->event_type === 'pernikahan')
                    <div class="border-t pt-6 text-center text-sm text-gray-500">
                        <p>Putri/Putra dari Bapak {{ $event->nama_ortu_wanita }}</p>
                        <p>&</p>
                        <p>Putra/Putri dari Bapak {{ $event->nama_ortu_pria }}</p>
                    </div>
                @endif
            </div>
        </div>

        {{-- Form RSVP --}}
        <div class="bg-white rounded-2xl shadow-lg mt-6 p-8">
            <h2 class="text-xl font-semibold mb-4 text-center">Konfirmasi Kehadiran</h2>

            @if ($errors->any())
                <div class="mb-4 p-4 bg-red-100 text-red-800 rounded-lg">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('rsvp.store', $event->unique_slug) }}" method="POST">
                @csrf

                <div class="mb-4">
                    <label class="block font-medium mb-1">Nama Kamu</label>
                    <input type="text" name="nama_tamu" value="{{ old('nama_tamu') }}" class="w-full border-gray-300 rounded-lg" required>
                </div>

                <div class="mb-4">
                    <label class="block font-medium mb-1">Konfirmasi Kehadiran</label>
                    <select name="status_hadir" class="w-full border-gray-300 rounded-lg" required>
                        <option value="">-- Pilih --</option>
                        <option value="hadir" {{ old('status_hadir') == 'hadir' ? 'selected' : '' }}>Hadir</option>
                        <option value="tidak_hadir" {{ old('status_hadir') == 'tidak_hadir' ? 'selected' : '' }}>Tidak Hadir</option>
                    </select>
                </div>

                <div class="mb-4">
                    <label class="block font-medium mb-1">Jumlah Orang (termasuk kamu)</label>
                    <input type="number" name="jumlah_orang" value="{{ old('jumlah_orang', 1) }}" min="1" class="w-full border-gray-300 rounded-lg" required>
                </div>

                <div class="mb-4">
                    <label class="block font-medium mb-1">Ucapan & Doa</label>
                    <textarea name="ucapan" rows="3" class="w-full border-gray-300 rounded-lg">{{ old('ucapan') }}</textarea>
                </div>

                <button type="submit" class="w-full py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-medium">
                    Kirim RSVP
                </button>
            </form>
        </div>

        {{-- Daftar Ucapan --}}
        @if ($rsvps->isNotEmpty())
            <div class="bg-white rounded-2xl shadow-lg mt-6 p-8">
                <h2 class="text-xl font-semibold mb-4">Ucapan & Doa ({{ $rsvps->count() }})</h2>
                <div class="space-y-4 max-h-96 overflow-y-auto">
                    @foreach ($rsvps as $rsvp)
                        @if ($rsvp->ucapan)
                            <div class="border-b pb-3">
                                <p class="font-medium">{{ $rsvp->nama_tamu }}
                                    <span class="text-xs text-gray-400 font-normal">
                                        — {{ $rsvp->status_hadir === 'hadir' ? 'Hadir' : 'Tidak Hadir' }}
                                    </span>
                                </p>
                                <p class="text-gray-600 text-sm">{{ $rsvp->ucapan }}</p>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
        @endif

    </div>
</body>
</html>