<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $event->nama_acara }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,500;9..144,600;9..144,700&family=IBM+Plex+Mono:wght@400;500&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
@php
    $isWedding = $event->template->event_type === 'pernikahan';
    $isBirthday = $event->template->event_type === 'ulang_tahun';
    $isOther = $event->template->event_type === 'acara_lainnya';
    
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
        <x-invitation-card
            :eventType="$event->template->event_type"
            :layoutType="$event->layout_type"
            :namaAcara="$event->nama_acara"
            :tanggalUtama="\Carbon\Carbon::parse($event->tanggal_utama)->translatedFormat('d F Y')"
            :jamUtama="\Carbon\Carbon::parse($event->jam_utama)->format('H:i')"
            :lokasiUtama="$event->lokasi_utama"
            :namaMempelaiPria="$event->nama_mempelai_pria"
            :namaMempelaiWanita="$event->nama_mempelai_wanita"
            :namaOrtuPria="$event->nama_ortu_pria"
            :namaOrtuWanita="$event->nama_ortu_wanita"
            :fotoUrl="$event->foto_utama_url"
            :templateName="$event->template->nama_template"
        />

        {{-- Form RSVP --}}
        <div class="{{ $cardClass }} p-10 md:p-12 mt-12">
            <h2 class="text-2xl font-semibold mb-6 text-center {{ $titleClass }}">Konfirmasi Kehadiran</h2>

            @if ($errors->any())
                <div class="mb-4 p-4 bg-red-50 text-red-700 border border-red-100 rounded-lg">
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
                    <label class="block text-sm font-medium text-ink/70 mb-1">Nama Kamu</label>
                    <input type="text" name="nama_tamu" value="{{ old('nama_tamu') }}" class="w-full border-mist rounded-lg {{ $inputFocusClass }}" required>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-ink/70 mb-1">Konfirmasi Kehadiran</label>
                    <select name="status_hadir" class="w-full border-mist rounded-lg {{ $inputFocusClass }}" required>
                        <option value="">-- Pilih --</option>
                        <option value="hadir" {{ old('status_hadir') == 'hadir' ? 'selected' : '' }}>Hadir</option>
                        <option value="tidak_hadir" {{ old('status_hadir') == 'tidak_hadir' ? 'selected' : '' }}>Tidak Hadir</option>
                    </select>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-ink/70 mb-1">Jumlah Orang (termasuk kamu)</label>
                    <input type="number" name="jumlah_orang" value="{{ old('jumlah_orang', 1) }}" min="1" class="w-full border-mist rounded-lg {{ $inputFocusClass }}" required>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-ink/70 mb-1">Ucapan & Doa</label>
                    <textarea name="ucapan" rows="3" class="w-full border-mist rounded-lg {{ $inputFocusClass }}">{{ old('ucapan') }}</textarea>
                </div>

                <button type="submit" class="w-full py-3 rounded-md font-medium focus:outline-none focus:ring-2 focus:ring-offset-2 transition-colors duration-150 {{ $buttonClass }}">
                    Kirim RSVP
                </button>
            </form>
        </div>

        {{-- Daftar Ucapan --}}
        @if ($rsvps->isNotEmpty())
            <div class="{{ $cardClass }} p-10 md:p-12 mt-12">
                <h2 class="text-2xl font-semibold mb-6 {{ $titleClass }}">Ucapan & Doa ({{ $rsvps->count() }})</h2>
                <div class="space-y-4 max-h-96 overflow-y-auto pr-1">
                    @foreach ($rsvps as $rsvp)
                        @if ($rsvp->ucapan)
                            <div class="rounded-lg border border-mist/60 bg-paper p-5">
                                <p class="font-medium text-ink">{{ $rsvp->nama_tamu }}
                                    <span class="text-xs text-ink/40 font-normal">
                                        • {{ $rsvp->status_hadir === 'hadir' ? 'Hadir' : 'Tidak Hadir' }}
                                    </span>
                                </p>
                                <p class="mt-2 text-sm text-ink/60">{{ $rsvp->ucapan }}</p>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</body>
</html>
