<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit RSVP - {{ $rsvp->event->nama_acara }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,500;9..144,600;9..144,700&family=IBM+Plex+Mono:wght@400;500&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
@php
    $isWedding = $rsvp->event->template->event_type === 'pernikahan';
    $isBirthday = $rsvp->event->template->event_type === 'ulang_tahun';
    $isOther = $rsvp->event->template->event_type === 'acara_lainnya';
    
    $cardClass = 'bg-white border border-mist/60 rounded-xl';
    $titleClass = $isWedding ? 'text-evergreen' : ($isBirthday ? 'text-blush' : 'text-brass');
    $buttonClass = $isWedding
        ? 'bg-evergreen text-paper hover:bg-evergreen-dark focus:ring-evergreen'
        : ($isBirthday ? 'bg-blush text-white hover:bg-blush-dark focus:ring-blush' : 'bg-brass text-white hover:bg-brass focus:ring-brass');
    $inputFocusClass = $isWedding ? 'focus:border-evergreen focus:ring-evergreen' : ($isBirthday ? 'focus:border-blush focus:ring-blush' : 'focus:border-brass focus:ring-brass');
@endphp
<body class="bg-paper min-h-screen px-4 py-16 text-ink antialiased">
    <div class="relative z-10 max-w-3xl mx-auto">
        @if (session('success'))
            <div class="mb-6 p-4 bg-evergreen/10 text-evergreen-dark border border-evergreen/20 rounded-lg text-center">
                {{ session('success') }}
            </div>
        @endif

        {{-- Kartu Undangan --}}
        <div class="mb-12">
            <x-invitation-card
                :eventType="$rsvp->event->template->event_type"
                :layoutType="$rsvp->event->layout_type"
                :namaAcara="$rsvp->event->nama_acara"
                :tanggalUtama="\Carbon\Carbon::parse($rsvp->event->tanggal_utama)->translatedFormat('d F Y')"
                :jamUtama="\Carbon\Carbon::parse($rsvp->event->jam_utama)->format('H:i')"
                :lokasiUtama="$rsvp->event->lokasi_utama"
                :namaMempelaiPria="$rsvp->event->nama_mempelai_pria"
                :namaMempelaiWanita="$rsvp->event->nama_mempelai_wanita"
                :namaOrtuPria="$rsvp->event->nama_ortu_pria"
                :namaOrtuWanita="$rsvp->event->nama_ortu_wanita"
                :fotoUrl="$rsvp->event->foto_utama_url"
                :templateName="$rsvp->event->template->nama_template"
            />
        </div>

        {{-- Form Edit RSVP --}}
        <div class="{{ $cardClass }} p-10 md:p-12">
            <h2 class="text-2xl font-semibold mb-1 text-center {{ $titleClass }}">Edit RSVP Kamu</h2>
            <p class="text-sm text-ink/50 text-center mb-6">Ubah data di bawah kalau ada yang perlu diperbaiki</p>

            @if ($errors->any())
                <div class="mb-4 p-4 bg-red-50 text-red-700 border border-red-100 rounded-lg">
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
                    <label class="block text-sm font-medium text-ink/70 mb-1">Nama Kamu</label>
                    <input type="text" name="nama_tamu" value="{{ old('nama_tamu', $rsvp->nama_tamu) }}" class="w-full border-mist rounded-lg {{ $inputFocusClass }}" required>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-ink/70 mb-1">Konfirmasi Kehadiran</label>
                    <select name="status_hadir" class="w-full border-mist rounded-lg {{ $inputFocusClass }}" required>
                        <option value="hadir" {{ old('status_hadir', $rsvp->status_hadir) == 'hadir' ? 'selected' : '' }}>Hadir</option>
                        <option value="tidak_hadir" {{ old('status_hadir', $rsvp->status_hadir) == 'tidak_hadir' ? 'selected' : '' }}>Tidak Hadir</option>
                    </select>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-ink/70 mb-1">Jumlah Orang (termasuk kamu)</label>
                    <input type="number" name="jumlah_orang" value="{{ old('jumlah_orang', $rsvp->jumlah_orang) }}" min="1" class="w-full border-mist rounded-lg {{ $inputFocusClass }}" required>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-ink/70 mb-1">Ucapan & Doa</label>
                    <textarea name="ucapan" rows="3" class="w-full border-mist rounded-lg {{ $inputFocusClass }}">{{ old('ucapan', $rsvp->ucapan) }}</textarea>
                </div>

                <button type="submit" class="w-full py-3 rounded-md font-medium focus:outline-none focus:ring-2 focus:ring-offset-2 transition-colors duration-150 {{ $buttonClass }}">
                    Simpan Perubahan
                </button>
            </form>

            <p class="text-xs text-ink/40 text-center mt-4">
                Simpan link halaman ini kalau nanti mau mengedit RSVP lagi.
            </p>
        </div>
    </div>
</body>
</html>
