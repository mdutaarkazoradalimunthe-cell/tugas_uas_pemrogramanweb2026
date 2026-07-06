@props([
    'eventType' => 'ulang_tahun',
    'layoutType' => 'foto_atas',
    'namaAcara' => '',
    'tanggalUtama' => '',
    'jamUtama' => '',
    'lokasiUtama' => '',
    'namaMempelaiPria' => '',
    'namaMempelaiWanita' => '',
    'namaOrtuPria' => '',
    'namaOrtuWanita' => '',
    'tanggalResepsi' => '',
    'jamResepsi' => '',
    'lokasiResepsi' => '',
    'fotoUrl' => null,
    'templateName' => '',
])

@php
    $isWedding = $eventType === 'pernikahan';
    $isBirthday = $eventType === 'ulang_tahun';
    $isOther = $eventType === 'acara_lainnya';
    $templateKey = \Illuminate\Support\Str::slug($templateName ?: ($isWedding ? 'elegan-hijau' : ($isBirthday ? 'ceria-pink' : 'professional-brass')));
    
    $themeClass = $isWedding ? 'border-evergreen/20' : ($isBirthday ? 'border-blush/20' : 'border-brass/20');
    $titleClass = $isWedding ? 'text-evergreen' : ($isBirthday ? 'text-blush' : 'text-brass');
    $accentClass = $isWedding ? 'text-brass' : ($isBirthday ? 'text-blush-dark' : 'text-brass-light');

    $variant = match (true) {
        str_contains($templateKey, 'klasik-emas') => 'classic-gold',
        str_contains($templateKey, 'modern-minimalis') => 'modern-minimal',
        str_contains($templateKey, 'playful-pastel') => 'playful-pastel',
        str_contains($templateKey, 'simple-sweet') => 'simple-sweet',
        str_contains($templateKey, 'fun-celebration') => 'fun-celebration',
        str_contains($templateKey, 'professional-brass') => 'professional-brass',
        str_contains($templateKey, 'casual-gathering') => 'casual-gathering',
        str_contains($templateKey, 'template-ulang-tahun') || str_contains($templateKey, 'ceria-pink') => 'cheerful-pink',
        default => 'elegant-green',
    };

    $cardClass = match ($variant) {
        'classic-gold' => 'bg-gradient-to-b from-white via-paper to-white border-2 border-brass/60 rounded-[1.75rem] overflow-hidden shadow-[0_24px_80px_-50px_rgba(180,138,74,0.85)]',
        'modern-minimal' => 'bg-white border border-ink/10 rounded-sm overflow-hidden shadow-none',
        'cheerful-pink' => 'bg-gradient-to-br from-white via-blush/10 to-paper border-2 border-blush/35 rounded-[2rem] overflow-hidden shadow-[0_18px_55px_-40px_rgba(201,120,120,0.9)]',
        'playful-pastel' => 'bg-gradient-to-tr from-paper via-white to-blush/10 border-2 border-dashed border-blush/35 rounded-[2.25rem] overflow-hidden shadow-sm',
        'simple-sweet' => 'bg-white border border-mist/80 rounded-lg overflow-hidden shadow-sm',
        'fun-celebration' => 'bg-gradient-to-br from-blush/15 via-white to-brass/15 border border-blush/30 rounded-[1.5rem] overflow-hidden shadow-[0_20px_65px_-45px_rgba(201,120,120,0.75)]',
        'professional-brass' => 'bg-white border-l-8 border-brass rounded-none overflow-hidden shadow-sm',
        'casual-gathering' => 'bg-gradient-to-br from-paper via-white to-brass/10 border border-brass/30 rounded-[1.5rem] overflow-hidden shadow-sm',
        default => 'bg-white border-2 border-evergreen/30 rounded-xl overflow-hidden shadow-sm',
    };

    $contentClass = match ($variant) {
        'classic-gold' => 'px-10 py-14 text-center relative',
        'modern-minimal' => 'px-8 py-10 text-left',
        'cheerful-pink', 'playful-pastel', 'fun-celebration' => 'px-10 py-12 text-center relative',
        'professional-brass' => 'px-9 py-10 text-left',
        'casual-gathering' => 'px-10 py-12 text-center relative',
        default => 'px-10 py-12 text-center relative',
    };

    $headingSize = match ($variant) {
        'modern-minimal', 'professional-brass' => 'text-2xl md:text-3xl',
        'classic-gold', 'fun-celebration' => 'text-4xl md:text-5xl',
        default => 'text-3xl md:text-4xl',
    };
@endphp

<div class="{{ $cardClass }}">
    @if($layoutType === 'foto_atas')
        {{-- Layout: Foto di Atas --}}
        @if($fotoUrl)
            <div class="w-full h-64 md:h-80 overflow-hidden bg-mist/30">
                <img src="{{ $fotoUrl }}" alt="Foto Acara" class="w-full h-full object-cover" data-preview-img="foto_utama">
            </div>
        @else
            <div class="w-full h-64 md:h-80 bg-mist/30 flex items-center justify-center" data-preview-img="foto_utama">
                <p class="text-ink/40 text-sm">Foto belum diupload</p>
            </div>
        @endif

        <div class="{{ $contentClass }}">
            @if(in_array($variant, ['classic-gold', 'elegant-green', 'casual-gathering']))
                <div class="pointer-events-none absolute inset-4 border {{ $variant === 'classic-gold' ? 'border-brass/30' : ($variant === 'elegant-green' ? 'border-evergreen/15' : 'border-brass/20') }} rounded-[inherit]"></div>
            @endif
            @if(in_array($variant, ['cheerful-pink', 'playful-pastel', 'fun-celebration']))
                <div class="pointer-events-none absolute -top-6 -right-6 h-24 w-24 rounded-full {{ $variant === 'fun-celebration' ? 'bg-brass/20' : 'bg-blush/20' }}"></div>
                <div class="pointer-events-none absolute -bottom-8 -left-8 h-28 w-28 rounded-full {{ $variant === 'playful-pastel' ? 'bg-brass/15' : 'bg-blush/15' }}"></div>
            @endif
            @if($isWedding)
                <p class="relative text-xs uppercase tracking-wider text-ink/50 mb-4">Undangan Pernikahan</p>
                <h1 class="relative font-display {{ $headingSize }} font-semibold {{ $titleClass }} mb-6">
                    <span data-preview="nama_mempelai_wanita">{{ $namaMempelaiWanita ?: 'Nama Mempelai Wanita' }}</span>
                    <span class="{{ $accentClass }} {{ $variant === 'classic-gold' ? 'block my-2 text-3xl' : '' }}"> & </span>
                    <span data-preview="nama_mempelai_pria">{{ $namaMempelaiPria ?: 'Nama Mempelai Pria' }}</span>
                </h1>
            @elseif($isBirthday)
                <p class="relative text-xs uppercase tracking-wider text-ink/50 mb-4">Undangan Ulang Tahun</p>
                <h1 class="relative font-display {{ $headingSize }} font-semibold {{ $titleClass }} mb-6" data-preview="nama_acara">
                    {{ $namaAcara ?: 'Nama Acara' }}
                </h1>
            @else
                <p class="relative text-xs uppercase tracking-wider text-ink/50 mb-4">Undangan Acara</p>
                <h1 class="relative font-display {{ $headingSize }} font-semibold {{ $titleClass }} mb-6" data-preview="nama_acara">
                    {{ $namaAcara ?: 'Nama Acara' }}
                </h1>
            @endif

            <div class="relative {{ in_array($variant, ['modern-minimal', 'professional-brass']) ? 'grid gap-3 text-left' : 'space-y-4' }} text-sm text-ink/70">
                @if($isWedding)
                <div>
                    <p class="text-xs uppercase tracking-wider text-ink/50">Tanggal Resepsi</p>
                    <p class="mt-1 font-medium text-ink" data-preview="tanggal_resepsi">{{ $tanggalResepsi ?: '-' }}</p>
                </div>
                <div>
                    <p class="text-xs uppercase tracking-wider text-ink/50">Waktu</p>
                    <p class="mt-1 font-medium text-ink"><span data-preview="jam_resepsi">{{ $jamResepsi ?: '-' }}</span> WIB</p>
                </div>
                <div>
                    <p class="text-xs uppercase tracking-wider text-ink/50">Lokasi</p>
                    <p class="mt-1 font-medium text-ink" data-preview="lokasi_resepsi">{{ $lokasiResepsi ?: '-' }}</p>
                </div>
                @else
                <div>
                    <p class="text-xs uppercase tracking-wider text-ink/50">Tanggal</p>
                    <p class="mt-1 font-medium text-ink" data-preview="tanggal_utama">{{ $tanggalUtama ?: '-' }}</p>
                </div>
                <div>
                    <p class="text-xs uppercase tracking-wider text-ink/50">Waktu</p>
                    <p class="mt-1 font-medium text-ink"><span data-preview="jam_utama">{{ $jamUtama ?: '-' }}</span> WIB</p>
                </div>
                <div>
                    <p class="text-xs uppercase tracking-wider text-ink/50">Lokasi</p>
                    <p class="mt-1 font-medium text-ink" data-preview="lokasi_utama">{{ $lokasiUtama ?: '-' }}</p>
                </div>
                @endif
            </div>

            @if($isWedding && ($namaOrtuPria || $namaOrtuWanita))
                <div class="relative mt-8 pt-6 border-t border-mist/60 text-sm text-ink/60">
                    <p>Putri dari Bapak/Ibu <span data-preview="nama_ortu_wanita">{{ $namaOrtuWanita ?: '-' }}</span></p>
                    <p class="my-2 {{ $accentClass }}">&</p>
                    <p>Putra dari Bapak/Ibu <span data-preview="nama_ortu_pria">{{ $namaOrtuPria ?: '-' }}</span></p>
                </div>
            @endif
        </div>

    @elseif($layoutType === 'foto_samping')
        {{-- Layout: Foto di Samping --}}
        <div class="flex flex-col md:flex-row">
            <div class="w-full md:w-2/5">
                @if($fotoUrl)
                    <div class="h-64 md:h-full overflow-hidden bg-mist/30">
                        <img src="{{ $fotoUrl }}" alt="Foto Acara" class="w-full h-full object-cover" data-preview-img="foto_utama">
                    </div>
                @else
                    <div class="h-64 md:h-full bg-mist/30 flex items-center justify-center" data-preview-img="foto_utama">
                        <p class="text-ink/40 text-sm">Foto belum diupload</p>
                    </div>
                @endif
            </div>

            <div class="w-full md:w-3/5 {{ in_array($variant, ['modern-minimal', 'professional-brass']) ? 'px-8 py-9' : 'px-8 py-10' }} {{ in_array($variant, ['classic-gold', 'casual-gathering']) ? 'relative' : '' }}">
                @if($isWedding)
                    <p class="text-xs uppercase tracking-wider text-ink/50 mb-3">Undangan Pernikahan</p>
                    <h1 class="font-display {{ in_array($variant, ['classic-gold', 'fun-celebration']) ? 'text-3xl md:text-4xl' : 'text-2xl md:text-3xl' }} font-semibold {{ $titleClass }} mb-6">
                        <span data-preview="nama_mempelai_wanita">{{ $namaMempelaiWanita ?: 'Nama Mempelai Wanita' }}</span>
                        <span class="{{ $accentClass }}"> & </span>
                        <span data-preview="nama_mempelai_pria">{{ $namaMempelaiPria ?: 'Nama Mempelai Pria' }}</span>
                    </h1>
                @elseif($isBirthday)
                    <p class="text-xs uppercase tracking-wider text-ink/50 mb-3">Undangan Ulang Tahun</p>
                    <h1 class="font-display {{ in_array($variant, ['classic-gold', 'fun-celebration']) ? 'text-3xl md:text-4xl' : 'text-2xl md:text-3xl' }} font-semibold {{ $titleClass }} mb-6" data-preview="nama_acara">
                        {{ $namaAcara ?: 'Nama Acara' }}
                    </h1>
                @else
                    <p class="text-xs uppercase tracking-wider text-ink/50 mb-3">Undangan Acara</p>
                    <h1 class="font-display {{ in_array($variant, ['classic-gold', 'fun-celebration']) ? 'text-3xl md:text-4xl' : 'text-2xl md:text-3xl' }} font-semibold {{ $titleClass }} mb-6" data-preview="nama_acara">
                        {{ $namaAcara ?: 'Nama Acara' }}
                    </h1>
                @endif

                <div class="space-y-3 text-sm text-ink/70">
                    @if($isWedding)
                    <div>
                        <p class="text-xs uppercase tracking-wider text-ink/50">Tanggal Resepsi</p>
                        <p class="mt-1 font-medium text-ink" data-preview="tanggal_resepsi">{{ $tanggalResepsi ?: '-' }}</p>
                    </div>
                    <div>
                        <p class="text-xs uppercase tracking-wider text-ink/50">Waktu</p>
                        <p class="mt-1 font-medium text-ink"><span data-preview="jam_resepsi">{{ $jamResepsi ?: '-' }}</span> WIB</p>
                    </div>
                    <div>
                        <p class="text-xs uppercase tracking-wider text-ink/50">Lokasi</p>
                        <p class="mt-1 font-medium text-ink" data-preview="lokasi_resepsi">{{ $lokasiResepsi ?: '-' }}</p>
                    </div>
                    @else
                    <div>
                        <p class="text-xs uppercase tracking-wider text-ink/50">Tanggal</p>
                        <p class="mt-1 font-medium text-ink" data-preview="tanggal_utama">{{ $tanggalUtama ?: '-' }}</p>
                    </div>
                    <div>
                        <p class="text-xs uppercase tracking-wider text-ink/50">Waktu</p>
                        <p class="mt-1 font-medium text-ink"><span data-preview="jam_utama">{{ $jamUtama ?: '-' }}</span> WIB</p>
                    </div>
                    <div>
                        <p class="text-xs uppercase tracking-wider text-ink/50">Lokasi</p>
                        <p class="mt-1 font-medium text-ink" data-preview="lokasi_utama">{{ $lokasiUtama ?: '-' }}</p>
                    </div>
                    @endif
                </div>

                @if($isWedding && ($namaOrtuPria || $namaOrtuWanita))
                    <div class="mt-6 pt-6 border-t border-mist/60 text-sm text-ink/60">
                        <p>Putri dari Bapak/Ibu <span data-preview="nama_ortu_wanita">{{ $namaOrtuWanita ?: '-' }}</span></p>
                        <p class="my-2 {{ $accentClass }}">&</p>
                        <p>Putra dari Bapak/Ibu <span data-preview="nama_ortu_pria">{{ $namaOrtuPria ?: '-' }}</span></p>
                    </div>
                @endif
            </div>
        </div>

    @else
        {{-- Layout: Tanpa Foto (Fokus Teks) --}}
        <div class="px-10 py-16 text-center relative">
            {{-- Ornamen dekoratif SVG --}}
            <div class="absolute top-4 left-1/2 -translate-x-1/2 opacity-20">
                <svg width="120" height="60" viewBox="0 0 120 60" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M60 10 L70 30 L90 30 L75 42 L82 58 L60 46 L38 58 L45 42 L30 30 L50 30 Z" 
                          fill="{{ $isWedding ? '#B48A4A' : ($isBirthday ? '#C97878' : '#B48A4A') }}" opacity="0.3"/>
                </svg>
            </div>

            @if($isWedding)
                <p class="text-xs uppercase tracking-wider text-ink/50 mb-4">Undangan Pernikahan</p>
                <h1 class="font-display text-4xl md:text-5xl font-semibold {{ $titleClass }} mb-8">
                    <span data-preview="nama_mempelai_wanita">{{ $namaMempelaiWanita ?: 'Nama Mempelai Wanita' }}</span>
                    <span class="{{ $accentClass }}"> & </span>
                    <span data-preview="nama_mempelai_pria">{{ $namaMempelaiPria ?: 'Nama Mempelai Pria' }}</span>
                </h1>
            @elseif($isBirthday)
                <p class="text-xs uppercase tracking-wider text-ink/50 mb-4">Undangan Ulang Tahun</p>
                <h1 class="font-display text-4xl md:text-5xl font-semibold {{ $titleClass }} mb-8" data-preview="nama_acara">
                    {{ $namaAcara ?: 'Nama Acara' }}
                </h1>
            @else
                <p class="text-xs uppercase tracking-wider text-ink/50 mb-4">Undangan Acara</p>
                <h1 class="font-display text-4xl md:text-5xl font-semibold {{ $titleClass }} mb-8" data-preview="nama_acara">
                    {{ $namaAcara ?: 'Nama Acara' }}
                </h1>
            @endif

            <div class="max-w-md mx-auto space-y-6 text-ink/70">
                @if($isWedding)
                <div>
                    <p class="text-xs uppercase tracking-wider text-ink/50">Tanggal Resepsi</p>
                    <p class="mt-2 text-lg font-medium text-ink" data-preview="tanggal_resepsi">{{ $tanggalResepsi ?: '-' }}</p>
                </div>
                <div>
                    <p class="text-xs uppercase tracking-wider text-ink/50">Waktu</p>
                    <p class="mt-2 text-lg font-medium text-ink"><span data-preview="jam_resepsi">{{ $jamResepsi ?: '-' }}</span> WIB</p>
                </div>
                <div>
                    <p class="text-xs uppercase tracking-wider text-ink/50">Lokasi</p>
                    <p class="mt-2 text-lg font-medium text-ink" data-preview="lokasi_resepsi">{{ $lokasiResepsi ?: '-' }}</p>
                </div>
                @else
                <div>
                    <p class="text-xs uppercase tracking-wider text-ink/50">Tanggal</p>
                    <p class="mt-2 text-lg font-medium text-ink" data-preview="tanggal_utama">{{ $tanggalUtama ?: '-' }}</p>
                </div>
                <div>
                    <p class="text-xs uppercase tracking-wider text-ink/50">Waktu</p>
                    <p class="mt-2 text-lg font-medium text-ink"><span data-preview="jam_utama">{{ $jamUtama ?: '-' }}</span> WIB</p>
                </div>
                <div>
                    <p class="text-xs uppercase tracking-wider text-ink/50">Lokasi</p>
                    <p class="mt-2 text-lg font-medium text-ink" data-preview="lokasi_utama">{{ $lokasiUtama ?: '-' }}</p>
                </div>
                @endif
            </div>

            @if($isWedding && ($namaOrtuPria || $namaOrtuWanita))
                <div class="mt-10 pt-8 border-t border-mist/60 text-sm text-ink/60">
                    <p>Putri dari Bapak/Ibu <span data-preview="nama_ortu_wanita">{{ $namaOrtuWanita ?: '-' }}</span></p>
                    <p class="my-2 {{ $accentClass }}">&</p>
                    <p>Putra dari Bapak/Ibu <span data-preview="nama_ortu_pria">{{ $namaOrtuPria ?: '-' }}</span></p>
                </div>
            @endif

            {{-- Ornamen bawah --}}
            <div class="absolute bottom-4 left-1/2 -translate-x-1/2 opacity-20">
                <svg width="120" height="60" viewBox="0 0 120 60" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M60 50 L70 30 L90 30 L75 18 L82 2 L60 14 L38 2 L45 18 L30 30 L50 30 Z" 
                          fill="{{ $isWedding ? '#B48A4A' : ($isBirthday ? '#C97878' : '#B48A4A') }}" opacity="0.3"/>
                </svg>
            </div>
        </div>
    @endif
</div>
