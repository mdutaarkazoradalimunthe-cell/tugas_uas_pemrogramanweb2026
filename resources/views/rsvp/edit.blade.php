<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit RSVP - {{ $rsvp->event->nama_acara }}</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-100 min-h-screen py-10 px-4">
    <div class="max-w-xl mx-auto">

        @if (session('success'))
            <div class="mb-4 p-4 bg-green-100 text-green-800 rounded-lg text-center">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white rounded-2xl shadow-lg p-8 mb-6">
            <p class="text-sm text-gray-500 text-center">Undangan</p>
            <h1 class="text-2xl font-serif text-center text-gray-800">{{ $rsvp->event->nama_acara }}</h1>
            <p class="text-center text-sm text-gray-500 mt-2">
                {{ \Carbon\Carbon::parse($rsvp->event->tanggal_utama)->translatedFormat('d F Y') }}
                — {{ $rsvp->event->lokasi_utama }}
            </p>
        </div>

        <div class="bg-white rounded-2xl shadow-lg p-8">
            <h2 class="text-xl font-semibold mb-1 text-center">Edit RSVP Kamu</h2>
            <p class="text-sm text-gray-500 text-center mb-4">Ubah data di bawah kalau ada yang perlu diperbaiki</p>

            @if ($errors->any())
                <div class="mb-4 p-4 bg-red-100 text-red-800 rounded-lg">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('rsvp.update', $rsvp->edit_token) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label class="block font-medium mb-1">Nama Kamu</label>
                    <input type="text" name="nama_tamu" value="{{ old('nama_tamu', $rsvp->nama_tamu) }}" class="w-full border-gray-300 rounded-lg" required>
                </div>

                <div class="mb-4">
                    <label class="block font-medium mb-1">Konfirmasi Kehadiran</label>
                    <select name="status_hadir" class="w-full border-gray-300 rounded-lg" required>
                        <option value="hadir" {{ old('status_hadir', $rsvp->status_hadir) == 'hadir' ? 'selected' : '' }}>Hadir</option>
                        <option value="tidak_hadir" {{ old('status_hadir', $rsvp->status_hadir) == 'tidak_hadir' ? 'selected' : '' }}>Tidak Hadir</option>
                    </select>
                </div>

                <div class="mb-4">
                    <label class="block font-medium mb-1">Jumlah Orang (termasuk kamu)</label>
                    <input type="number" name="jumlah_orang" value="{{ old('jumlah_orang', $rsvp->jumlah_orang) }}" min="1" class="w-full border-gray-300 rounded-lg" required>
                </div>

                <div class="mb-4">
                    <label class="block font-medium mb-1">Ucapan & Doa</label>
                    <textarea name="ucapan" rows="3" class="w-full border-gray-300 rounded-lg">{{ old('ucapan', $rsvp->ucapan) }}</textarea>
                </div>

                <button type="submit" class="w-full py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-medium">
                    Simpan Perubahan
                </button>
            </form>

            <p class="text-xs text-gray-400 text-center mt-4">
                Simpan link halaman ini kalau nanti mau mengedit RSVP lagi.
            </p>
        </div>

    </div>
</body>
</html>