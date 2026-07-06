<x-app-layout>
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-16 lg:py-20">
        <div class="flex items-start justify-between">
            <div>
                <p class="text-xs uppercase tracking-[0.2em] font-medium text-brass">Template</p>
                <h1 class="mt-3 font-display text-3xl lg:text-4xl font-semibold text-ink leading-[1.08] tracking-tight">
                    {{ $template->nama_template }}
                </h1>
                <p class="mt-2 text-sm text-ink/50">{{ $template->deskripsi }}</p>
            </div>
            <div class="flex gap-3 shrink-0">
                <a href="{{ route('events.create') }}?template={{ $template->id }}" class="inline-flex items-center px-5 py-2 bg-evergreen text-paper font-medium rounded-full hover:bg-evergreen-dark transition-colors duration-200 text-sm shadow-sm">
                    Gunakan
                </a>
                <a href="{{ route('templates.index') }}" class="inline-flex items-center px-5 py-2 text-ink/70 hover:text-ink font-medium rounded-full border border-ink/15 hover:border-ink/30 transition-colors duration-200 text-sm">
                    Kembali
                </a>
            </div>
        </div>

        @php
            $isWedding = $template->event_type === 'pernikahan';
            $isBirthday = $template->event_type === 'ulang_tahun';
            $eventTypeLabel = $isWedding ? 'Pernikahan' : ($isBirthday ? 'Ulang Tahun' : (str($template->nama_template)->contains('Professional') || str($template->nama_template)->contains('Brass') ? 'Seminar' : 'Makrab'));
        @endphp

        <div class="mt-10 p-5 bg-paper border border-mist/60 rounded-xl inline-block">
            <p class="text-xs tracking-[0.12em] font-medium text-ink/40 uppercase">Jenis Acara</p>
            <p class="mt-1 font-medium text-ink">{{ $eventTypeLabel }}</p>
        </div>

        <div class="mt-12">
            <h2 class="font-display text-2xl font-semibold text-ink tracking-tight">Pratinjau Layout</h2>
            <p class="mt-1 text-sm text-ink/50">Lihat bagaimana template ini terlihat dengan berbagai tata letak.</p>
        </div>

        <div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach (['foto_atas', 'foto_samping', 'tanpa_foto'] as $layout)
                @php
                    $layoutLabel = $layout === 'foto_atas' ? 'Foto di Atas' : ($layout === 'foto_samping' ? 'Foto di Samping' : 'Tanpa Foto');
                    $layoutDesc = $layout === 'foto_atas' ? 'Foto penuh lebar, teks di bawah.' : ($layout === 'foto_samping' ? 'Foto kiri, teks kanan.' : 'Fokus pada teks dan ornamen.');
                @endphp
                <div class="border border-mist/60 rounded-2xl p-5">
                    <x-invitation-card
                        :eventType="$template->event_type"
                        :layoutType="$layout"
                        :templateName="$template->nama_template"
                        namaAcara="{{ $isWedding ? 'Pernikahan Kami' : ($isBirthday ? 'Ulang Tahun ke-25' : 'Workshop Digital Marketing') }}"
                        tanggalUtama="15 Agustus 2026"
                        jamUtama="10:00"
                        lokasiUtama="Grand Ballroom, Jakarta"
                        namaMempelaiPria="Ahmad"
                        namaMempelaiWanita="Sarah"
                        namaOrtuPria="Bapak Hasan & Ibu Aminah"
                        namaOrtuWanita="Bapak Budi & Ibu Sari"
                        tanggalResepsi="15 Agustus 2026"
                        jamResepsi="11:00"
                        lokasiResepsi="Grand Ballroom, Jakarta"
                    />
                    <p class="text-xs text-ink/50 text-center mt-4">{{ $layoutLabel }} — {{ $layoutDesc }}</p>
                </div>
            @endforeach
        </div>

        <div class="mt-12 text-center">
            <a href="{{ route('events.create') }}?template={{ $template->id }}" class="inline-flex items-center px-8 py-3 bg-evergreen text-paper font-medium rounded-full hover:bg-evergreen-dark transition-colors duration-200 text-sm shadow-sm">
                Gunakan Template Ini
            </a>
        </div>
    </div>
</x-app-layout>