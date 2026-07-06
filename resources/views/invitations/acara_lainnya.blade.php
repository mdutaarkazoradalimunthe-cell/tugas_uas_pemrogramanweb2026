<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $event->nama_acara ?: 'Undangan Acara' }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,500;0,600;0,700;1,500;1,600&family=Pinyon+Script&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Inter', sans-serif; }
        .font-playfair { font-family: 'Playfair Display', serif; }
        .font-pinyon { font-family: 'Pinyon Script', cursive; }
    </style>
</head>
<body class="bg-paper min-h-screen flex flex-col items-center justify-center antialiased text-ink px-4 py-8 md:py-12">

    <x-invitation-welcome :event="$event" />

    <x-invitation-event-card
        :layoutType="$event->layout_type"
        :namaAcara="$event->nama_acara"
        :tanggalUtama="$event->tanggal_utama ? \Carbon\Carbon::parse($event->tanggal_utama)->translatedFormat('l, d F Y') : ''"
        :jamUtama="$event->jam_utama ? \Carbon\Carbon::parse($event->jam_utama)->format('H:i').' WIB' : ''"
        :lokasiUtama="$event->lokasi_utama"
        :namaPembicara="$event->nama_pembicara"
        :kapasitasPeserta="$event->kapasitas_peserta"
        :topikAgenda="$event->topik_agenda"
        :dresscode="$event->dresscode"
        :catatanTambahan="$event->catatan_tambahan"
        :fotoUrl="$event->foto_utama_url"
        :showRsvp="true"
        :eventSlug="$event->unique_slug"
        :editingRsvp="$rsvp ?? null"
        :rsvps="$rsvps"
        :success="session('success')"
        :errors="$errors"
        :templateName="$event->template->nama_template"
    />

    @if(!isset($rsvp))
    <p class="mt-6 text-[10px] uppercase tracking-[0.2em] text-ink/20 font-medium">Digital Invitation</p>
    @endif
    <x-floating-music :event="$event" />
</body>
</html>
