@props([
    'layoutType' => 'foto_atas',
    'namaMempelaiWanita' => '',
    'namaMempelaiPria' => '',
    'namaOrtuWanita' => '',
    'namaOrtuPria' => '',
    'tanggalUtama' => '',
    'jamUtama' => '',
    'lokasiUtama' => '',
    'tanggalResepsi' => '',
    'jamResepsi' => '',
    'lokasiResepsi' => '',
    'dresscode' => '',
    'catatanTambahan' => '',
    'fotoUrl' => null,
    'showRsvp' => false,
    'eventSlug' => '',
    'editingRsvp' => null,
    'rsvps' => collect([]),
    'success' => null,
    'errors' => null,
    'templateName' => '',
])

@php
    $hasPhoto = !is_null($fotoUrl);
    $uid = 'wc-' . \Illuminate\Support\Str::random(6);
    $isElegan = str_contains(strtolower($templateName), 'elegan') || str_contains(strtolower($templateName), 'hijau');
    $isModern = str_contains(strtolower($templateName), 'modern') || str_contains(strtolower($templateName), 'minimalis');
    $isKlasik = str_contains(strtolower($templateName), 'klasik') || str_contains(strtolower($templateName), 'emas');

    $accent = $isElegan ? 'evergreen' : ($isModern ? 'slate-700' : ($isKlasik ? 'amber-700' : 'evergreen'));
    $accentLight = $isElegan ? 'brass' : ($isModern ? 'ink' : ($isKlasik ? 'amber-600' : 'brass'));
    $textAccent = $isElegan ? 'text-evergreen' : ($isModern ? 'text-slate-700' : ($isKlasik ? 'text-amber-700' : 'text-evergreen'));
    $textAccentMuted = $isElegan ? 'text-brass' : ($isModern ? 'text-ink/40' : ($isKlasik ? 'text-amber-600' : 'text-brass'));
    $textAccentDim = $isElegan ? 'text-brass/60' : ($isModern ? 'text-ink/30' : ($isKlasik ? 'text-amber-600/60' : 'text-brass/60'));
    $textAccentHalf = $isElegan ? 'text-brass/50' : ($isModern ? 'text-ink/25' : ($isKlasik ? 'text-amber-600/50' : 'text-brass/50'));
    $textAccentFaded = $isElegan ? 'text-brass/30' : ($isModern ? 'text-ink/20' : ($isKlasik ? 'text-amber-600/30' : 'text-brass/30'));
    $borderAccent = $isElegan ? 'border-brass/30' : ($isModern ? 'border-ink/20' : ($isKlasik ? 'border-amber-700/30' : 'border-brass/30'));
    $borderMuted = $isElegan ? 'border-brass/25' : ($isModern ? 'border-ink/15' : ($isKlasik ? 'border-amber-700/25' : 'border-brass/25'));
    $borderFaded = $isElegan ? 'border-brass/20' : ($isModern ? 'border-ink/12' : ($isKlasik ? 'border-amber-700/20' : 'border-brass/20'));
    $borderThin = $isElegan ? 'border-brass/15' : ($isModern ? 'border-ink/10' : ($isKlasik ? 'border-amber-700/15' : 'border-brass/15'));
    $separator = $isElegan ? 'bg-brass/30' : ($isModern ? 'bg-ink/20' : ($isKlasik ? 'bg-amber-700/30' : 'bg-brass/30'));
    $separatorDim = $isElegan ? 'bg-brass/20' : ($isModern ? 'bg-ink/15' : ($isKlasik ? 'bg-amber-700/20' : 'bg-brass/20'));
    $decoSvgClass = $isElegan ? 'text-brass/25' : ($isModern ? 'text-ink/12' : ($isKlasik ? 'text-amber-700/20' : 'text-brass/25'));
    $decoSvgDim = $isElegan ? 'text-brass/15' : ($isModern ? 'text-ink/8' : ($isKlasik ? 'text-amber-700/12' : 'text-brass/15'));
    $decoSvgLight = $isElegan ? 'text-brass/10' : ($isModern ? 'text-ink/6' : ($isKlasik ? 'text-amber-700/8' : 'text-brass/10'));
    $cardBorder = $isElegan ? 'border-brass/30' : ($isModern ? 'border-ink/10' : ($isKlasik ? 'border-amber-700/25' : 'border-brass/30'));
    $photoBorder = $isElegan ? 'border-brass/20' : ($isModern ? 'border-ink/12' : ($isKlasik ? 'border-amber-700/20' : 'border-brass/20'));
    $photoBorderDash = $isElegan ? 'border-brass/20' : ($isModern ? 'border-ink/12' : ($isKlasik ? 'border-amber-700/20' : 'border-brass/20'));
    $photoPlaceholder = $isElegan ? 'from-brass/10 to-evergreen/10' : ($isModern ? 'from-ink/5 to-slate-700/5' : ($isKlasik ? 'from-amber-700/10 to-amber-900/10' : 'from-brass/10 to-evergreen/10'));
    $photoPlaceholderText = $isElegan ? 'text-brass/25' : ($isModern ? 'text-ink/20' : ($isKlasik ? 'text-amber-700/25' : 'text-brass/25'));
    $photoShadow = $isElegan ? 'shadow-[0_8px_24px_-8px_rgba(180,138,74,0.2)]' : ($isModern ? 'shadow-[0_8px_24px_-8px_rgba(33,38,31,0.08)]' : ($isKlasik ? 'shadow-[0_8px_24px_-8px_rgba(180,83,9,0.2)]' : 'shadow-[0_8px_24px_-8px_rgba(180,138,74,0.2)]'));
    $btnNav = $isElegan ? 'border-brass/25 text-brass/60 hover:bg-brass hover:text-white' : ($isModern ? 'border-ink/15 text-ink/40 hover:bg-ink hover:text-white' : ($isKlasik ? 'border-amber-700/25 text-amber-700/60 hover:bg-amber-700 hover:text-white' : 'border-brass/25 text-brass/60 hover:bg-brass hover:text-white'));
    $btnNavGreen = $isElegan ? 'border-evergreen/25 text-evergreen/60 hover:bg-evergreen hover:text-white' : ($isModern ? 'border-ink/15 text-ink/40 hover:bg-ink hover:text-white' : ($isKlasik ? 'border-amber-700/25 text-amber-700/60 hover:bg-amber-700 hover:text-white' : 'border-evergreen/25 text-evergreen/60 hover:bg-evergreen hover:text-white'));
    $btnSubmit = $isElegan ? 'bg-evergreen text-paper hover:bg-evergreen-dark' : ($isModern ? 'bg-slate-700 text-white hover:bg-slate-800' : ($isKlasik ? 'bg-amber-700 text-white hover:bg-amber-800' : 'bg-evergreen text-paper hover:bg-evergreen-dark'));
    $inputBorder = $isElegan ? 'border-brass/15 focus:border-brass' : ($isModern ? 'border-ink/10 focus:border-ink' : ($isKlasik ? 'border-amber-700/15 focus:border-amber-700' : 'border-brass/15 focus:border-brass'));
    $checkedClass = $isElegan ? 'peer-checked:bg-evergreen peer-checked:border-evergreen' : ($isModern ? 'peer-checked:bg-slate-700 peer-checked:border-slate-700' : ($isKlasik ? 'peer-checked:bg-amber-700 peer-checked:border-amber-700' : 'peer-checked:bg-evergreen peer-checked:border-evergreen'));
    $successBg = $isElegan ? 'bg-evergreen/8 border-evergreen/15 text-evergreen-dark' : ($isModern ? 'bg-slate-700/8 border-slate-700/15 text-slate-700' : ($isKlasik ? 'bg-amber-700/8 border-amber-700/15 text-amber-800' : 'bg-evergreen/8 border-evergreen/15 text-evergreen-dark'));
    $wishesSeparator = $isElegan ? 'border-brass/10' : ($isModern ? 'border-ink/8' : ($isKlasik ? 'border-amber-700/10' : 'border-brass/10'));
    $wishesSeparatorThin = $isElegan ? 'border-brass/8' : ($isModern ? 'border-ink/6' : ($isKlasik ? 'border-amber-700/8' : 'border-brass/8'));
    $andTextClass = $isElegan ? 'text-brass' : ($isModern ? 'text-ink/40' : ($isKlasik ? 'text-amber-600' : 'text-brass'));
    $andFontClass = $isModern ? 'font-sans text-2xl font-light italic tracking-wide' : 'font-pinyon text-2xl md:text-3xl';
    $scrollbarColor = $isElegan ? '#D8C39A' : ($isModern ? '#9CA3AF' : ($isKlasik ? '#D97706' : '#D8C39A'));
    $headingText = $isElegan ? 'Resepsi Pernikahan' : ($isModern ? 'Pernikahan' : ($isKlasik ? 'Resepsi Pernikahan' : 'Resepsi Pernikahan'));
    $page1Label = $isElegan ? 'Dengan Penuh Sukacita' : ($isModern ? 'The Wedding' : ($isKlasik ? 'Dengan Rahmat Tuhan' : 'Dengan Penuh Sukacita'));
    $page2OrnateLabel = $isElegan ? '~ Detail Acara ~' : ($isModern ? 'Information' : ($isKlasik ? '~ Detail Acara ~' : '~ Detail Acara ~'));
    $rsvpTitle = $isElegan ? '~ Konfirmasi Kehadiran ~' : ($isModern ? 'RSVP' : ($isKlasik ? '~ Konfirmasi Kehadiran ~' : '~ Konfirmasi Kehadiran ~'));
    $wishesTitle = $isElegan ? '~ Ucapan & Doa ~' : ($isModern ? 'Wishes' : ($isKlasik ? '~ Ucapan & Doa ~' : '~ Ucapan & Doa ~'));
@endphp

<style>
    .wc-page { transition: opacity 0.5s ease, transform 0.5s ease; }
    .wc-page-enter { opacity: 0; transform: translateY(20px); }
    .wc-page-active { opacity: 1; transform: translateY(0); }
    .wishes-scroll::-webkit-scrollbar { width: 3px; }
    .wishes-scroll::-webkit-scrollbar-track { background: transparent; }
    .wishes-scroll::-webkit-scrollbar-thumb { background: {{ $scrollbarColor }}; border-radius: 2px; }
</style>

<div class="wedding-card relative w-full bg-white border {{ $cardBorder }}" data-wc-uid="{{ $uid }}">

    {{-- ============================================================ --}}
    {{-- PAGE 1 — PEMBUKA --}}
    {{-- ============================================================ --}}
    <div data-wc-page="1" class="wc-page wc-page-active relative overflow-hidden">

        @if($isElegan)
        {{-- Floral top-left --}}
        <svg class="absolute top-0 left-0 w-28 h-28 md:w-32 md:h-32 {{ $decoSvgClass }} pointer-events-none" viewBox="0 0 130 130" fill="none">
            <path d="M8 122 C22 98, 48 80, 76 64 C96 52, 112 34, 122 8" stroke="currentColor" stroke-width="1.2" fill="none"/>
            <path d="M28 102 C42 96, 54 88, 58 82" stroke="currentColor" stroke-width="0.8" fill="none"/>
            <path d="M44 90 C50 84, 56 83, 56 88 C54 93, 48 94, 44 90Z" fill="currentColor"/>
            <path d="M72 58 C78 52, 84 50, 84 56 C82 62, 76 63, 72 58Z" fill="currentColor"/>
            <path d="M100 28 C106 22, 112 20, 112 26 C110 32, 104 33, 100 28Z" fill="currentColor"/>
            <circle cx="122" cy="8" r="3.5" fill="currentColor" opacity="0.7"/>
            <circle cx="58" cy="82" r="2" fill="currentColor" opacity="0.5"/>
            <circle cx="112" cy="26" r="1.5" fill="currentColor" opacity="0.4"/>
        </svg>
        {{-- Floral bottom-right --}}
        <svg class="absolute bottom-0 right-0 w-28 h-28 md:w-32 md:h-32 {{ $decoSvgClass }} pointer-events-none rotate-180" viewBox="0 0 130 130" fill="none">
            <path d="M8 122 C22 98, 48 80, 76 64 C96 52, 112 34, 122 8" stroke="currentColor" stroke-width="1.2" fill="none"/>
            <path d="M28 102 C42 96, 54 88, 58 82" stroke="currentColor" stroke-width="0.8" fill="none"/>
            <path d="M44 90 C50 84, 56 83, 56 88 C54 93, 48 94, 44 90Z" fill="currentColor"/>
            <path d="M72 58 C78 52, 84 50, 84 56 C82 62, 76 63, 72 58Z" fill="currentColor"/>
            <circle cx="122" cy="8" r="3.5" fill="currentColor" opacity="0.7"/>
            <circle cx="58" cy="82" r="2" fill="currentColor" opacity="0.5"/>
        </svg>

        @elseif($isModern)
        {{-- Geometric top-left --}}
        <svg class="absolute top-0 left-0 w-28 h-28 md:w-32 md:h-32 {{ $decoSvgClass }} pointer-events-none" viewBox="0 0 130 130" fill="none">
            <circle cx="16" cy="16" r="12" stroke="currentColor" stroke-width="0.8" fill="none"/>
            <line x1="32" y1="26" x2="56" y2="48" stroke="currentColor" stroke-width="0.6"/>
            <line x1="56" y1="26" x2="32" y2="48" stroke="currentColor" stroke-width="0.6"/>
            <rect x="54" y="58" width="18" height="18" stroke="currentColor" stroke-width="0.8" fill="none" transform="rotate(25, 63, 67)"/>
            <path d="M80 16 L94 30" stroke="currentColor" stroke-width="0.6"/>
            <path d="M94 16 L80 30" stroke="currentColor" stroke-width="0.6"/>
            <circle cx="108" cy="22" r="1.5" fill="currentColor" opacity="0.5"/>
            <circle cx="32" cy="74" r="2" fill="currentColor" opacity="0.4"/>
            <circle cx="12" cy="58" r="1.5" fill="currentColor" opacity="0.3"/>
        </svg>
        {{-- Geometric bottom-right --}}
        <svg class="absolute bottom-0 right-0 w-28 h-28 md:w-32 md:h-32 {{ $decoSvgClass }} pointer-events-none rotate-180" viewBox="0 0 130 130" fill="none">
            <circle cx="16" cy="16" r="12" stroke="currentColor" stroke-width="0.8" fill="none"/>
            <line x1="32" y1="26" x2="56" y2="48" stroke="currentColor" stroke-width="0.6"/>
            <line x1="56" y1="26" x2="32" y2="48" stroke="currentColor" stroke-width="0.6"/>
            <rect x="54" y="58" width="18" height="18" stroke="currentColor" stroke-width="0.8" fill="none" transform="rotate(25, 63, 67)"/>
            <circle cx="108" cy="22" r="1.5" fill="currentColor" opacity="0.5"/>
            <circle cx="32" cy="74" r="2" fill="currentColor" opacity="0.4"/>
        </svg>

        @elseif($isKlasik)
        {{-- Ornate top-left --}}
        <svg class="absolute top-0 left-0 w-28 h-28 md:w-32 md:h-32 {{ $decoSvgClass }} pointer-events-none" viewBox="0 0 130 130" fill="none">
            <path d="M8 56 C20 34, 40 20, 64 12" stroke="currentColor" stroke-width="1.5" fill="none"/>
            <path d="M8 56 C20 70, 36 76, 44 84" stroke="currentColor" stroke-width="1" fill="none"/>
            <path d="M32 28 C40 20, 52 18, 56 24" stroke="currentColor" stroke-width="0.8" fill="none"/>
            <path d="M48 16 C56 10, 68 8, 72 14" stroke="currentColor" stroke-width="0.8" fill="none"/>
            <circle cx="64" cy="12" r="3" fill="currentColor" opacity="0.6"/>
            <circle cx="8" cy="56" r="3" fill="currentColor" opacity="0.6"/>
            <circle cx="44" cy="84" r="2" fill="currentColor" opacity="0.4"/>
            <circle cx="86" cy="40" r="2" fill="currentColor" opacity="0.4"/>
            <circle cx="104" cy="18" r="1.5" fill="currentColor" opacity="0.3"/>
            <path d="M96 32 C100 28, 106 28, 108 32" stroke="currentColor" stroke-width="0.6" fill="none"/>
        </svg>
        {{-- Ornate bottom-right --}}
        <svg class="absolute bottom-0 right-0 w-28 h-28 md:w-32 md:h-32 {{ $decoSvgClass }} pointer-events-none rotate-180" viewBox="0 0 130 130" fill="none">
            <path d="M8 56 C20 34, 40 20, 64 12" stroke="currentColor" stroke-width="1.5" fill="none"/>
            <path d="M8 56 C20 70, 36 76, 44 84" stroke="currentColor" stroke-width="1" fill="none"/>
            <path d="M32 28 C40 20, 52 18, 56 24" stroke="currentColor" stroke-width="0.8" fill="none"/>
            <circle cx="64" cy="12" r="3" fill="currentColor" opacity="0.6"/>
            <circle cx="8" cy="56" r="3" fill="currentColor" opacity="0.6"/>
            <circle cx="44" cy="84" r="2" fill="currentColor" opacity="0.4"/>
            <circle cx="86" cy="40" r="2" fill="currentColor" opacity="0.4"/>
        </svg>
        @endif

        @if($layoutType === 'foto_samping')
            {{-- Split: photo left / text right --}}
            <div class="flex flex-col md:flex-row min-h-[500px]">
                <div class="w-full md:w-2/5 min-h-[200px] md:min-h-full">
                    @if($hasPhoto)
                    <div class="h-56 md:h-full overflow-hidden">
                        <img src="{{ $fotoUrl }}" alt="Foto Pengantin" class="w-full h-full object-cover" data-preview-img="foto_utama">
                    </div>
                    @else
                    <div class="h-56 md:h-full bg-gradient-to-br {{ $photoPlaceholder }} flex items-center justify-center overflow-hidden" data-preview-img="foto_utama">
                        <div class="text-center">
                            <svg class="w-8 h-8 mx-auto {{ $photoPlaceholderText }} mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                            <p class="text-xs {{ $photoPlaceholderText }} font-medium">Foto</p>
                        </div>
                    </div>
                    @endif
                </div>
                <div class="w-full md:w-3/5 px-8 py-12 md:px-10 md:py-14 text-center relative">
                    <p class="text-[10px] uppercase tracking-[0.25em] {{ $textAccentFaded }} font-medium mb-6">{{ $page1Label }}</p>
                    <h1 class="font-playfair text-2xl md:text-3xl font-semibold tracking-[0.12em] text-ink leading-tight uppercase" data-preview="nama_mempelai_wanita">
                        {{ $namaMempelaiWanita ?: 'Nama Wanita' }}
                    </h1>
                    <p class="{{ $andFontClass }} {{ $andTextClass }} my-3">&</p>
                    <h1 class="font-playfair text-2xl md:text-3xl font-semibold tracking-[0.12em] text-ink leading-tight uppercase" data-preview="nama_mempelai_pria">
                        {{ $namaMempelaiPria ?: 'Nama Pria' }}
                    </h1>

                    @if($namaOrtuWanita || $namaOrtuPria)
                    <p class="mt-6 text-[10px] text-ink/40 uppercase tracking-[0.12em]">Putra-putri dari</p>
                    <p class="mt-1 text-sm text-ink/60" data-preview="nama_ortu_wanita">{{ $namaOrtuWanita ?: 'Keluarga Wanita' }}</p>
                    <p class="font-pinyon text-base {{ $andTextClass }} my-0.5">&</p>
                    <p class="text-sm text-ink/60" data-preview="nama_ortu_pria">{{ $namaOrtuPria ?: 'Keluarga Pria' }}</p>
                    @endif

                    <div class="mt-6 flex items-center justify-center gap-2">
                        <span class="w-8 h-px {{ $separator }}"></span>
                        <span class="font-pinyon text-xl {{ $textAccentHalf }}">~</span>
                        <span class="w-8 h-px {{ $separator }}"></span>
                    </div>
                    <p class="mt-6 font-playfair text-sm md:text-base text-ink font-medium tracking-wider" data-preview="tanggal_resepsi">
                        {{ $tanggalResepsi ?: ($tanggalUtama ?: 'Tanggal') }}
                    </p>
                    <p class="mt-1 text-xs text-ink/50"><span data-preview="jam_resepsi">{{ $jamResepsi ?: ($jamUtama ?: '') }}</span></p>
                    <p class="mt-1 text-xs text-ink/50" data-preview="lokasi_resepsi">{{ $lokasiResepsi ?: ($lokasiUtama ?: 'Lokasi') }}</p>
                    <button onclick="wcGoTo(this, 2)" class="wc-next absolute bottom-6 right-6 w-9 h-9 rounded-full border {{ $btnNav }} transition-all duration-200 flex items-center justify-center">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </button>
                </div>
            </div>
        @else
            {{-- Vertical layout (foto_atas or tanpa_foto) --}}
            <div class="px-10 py-14 md:px-14 md:py-20 text-center relative min-h-[520px]">
                <p class="text-[10px] uppercase tracking-[0.25em] {{ $textAccentFaded }} font-medium mb-8">{{ $page1Label }}</p>

                @if($layoutType === 'foto_atas')
                    @if($hasPhoto)
                    <div class="w-32 h-32 md:w-40 md:h-40 mx-auto mb-10 rounded-full overflow-hidden border-2 {{ $photoBorder }} {{ $photoShadow }}">
                        <img src="{{ $fotoUrl }}" alt="Foto Pengantin" class="w-full h-full object-cover" data-preview-img="foto_utama">
                    </div>
                    @else
                    <div class="w-32 h-32 md:w-40 md:h-40 mx-auto mb-10 rounded-full overflow-hidden border-2 border-dashed {{ $photoBorderDash }} bg-paper flex items-center justify-center" data-preview-img="foto_utama">
                        <svg class="w-8 h-8 {{ $photoPlaceholderText }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                    </div>
                    @endif
                @endif

                <h1 class="font-playfair text-3xl md:text-4xl lg:text-5xl font-semibold tracking-[0.12em] text-ink leading-[1.15] uppercase" data-preview="nama_mempelai_wanita">
                    {{ $namaMempelaiWanita ?: 'Nama Wanita' }}
                </h1>
                <p class="{{ $andFontClass }} {{ $andTextClass }} my-4">&</p>
                <h1 class="font-playfair text-3xl md:text-4xl lg:text-5xl font-semibold tracking-[0.12em] text-ink leading-[1.15] uppercase" data-preview="nama_mempelai_pria">
                    {{ $namaMempelaiPria ?: 'Nama Pria' }}
                </h1>

                <p class="mt-8 text-sm text-ink/50 max-w-xs mx-auto leading-relaxed">Memohon kehadiran Bapak/Ibu/Saudara/i di acara pernikahan kami</p>

                @if($namaOrtuWanita || $namaOrtuPria)
                <p class="mt-5 text-xs text-ink/40 uppercase tracking-[0.12em]">Putra-putri dari</p>
                <p class="mt-1 text-sm text-ink/60" data-preview="nama_ortu_wanita">{{ $namaOrtuWanita ?: 'Keluarga Wanita' }}</p>
                <p class="font-pinyon text-base {{ $andTextClass }} my-0.5">&</p>
                <p class="text-sm text-ink/60" data-preview="nama_ortu_pria">{{ $namaOrtuPria ?: 'Keluarga Pria' }}</p>
                @endif

                <div class="mt-10 flex items-center justify-center gap-3">
                    <span class="w-10 h-px {{ $separator }}"></span>
                    <span class="font-pinyon text-xl {{ $textAccentHalf }}">~</span>
                    <span class="w-10 h-px {{ $separator }}"></span>
                </div>

                <p class="mt-6 font-playfair text-base md:text-lg text-ink font-medium tracking-wider" data-preview="tanggal_resepsi">
                    {{ $tanggalResepsi ?: ($tanggalUtama ?: 'Tanggal') }}
                </p>
                <p class="mt-1 text-sm text-ink/50"><span data-preview="jam_resepsi">{{ $jamResepsi ?: ($jamUtama ?: '') }}</span></p>
                <p class="mt-1 text-sm text-ink/50" data-preview="lokasi_resepsi">{{ $lokasiResepsi ?: ($lokasiUtama ?: 'Lokasi') }}</p>

                <button onclick="wcGoTo(this, 2)" class="wc-next absolute bottom-6 right-6 w-9 h-9 rounded-full border {{ $btnNav }} transition-all duration-200 flex items-center justify-center">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </button>
            </div>
        @endif
    </div>

    {{-- ============================================================ --}}
    {{-- PAGE 2 — DETAIL ACARA --}}
    {{-- ============================================================ --}}
    <div data-wc-page="2" class="wc-page hidden relative min-h-[420px] overflow-hidden">

        @if($isElegan)
        {{-- Floral left side --}}
        <svg class="absolute left-0 top-0 bottom-0 w-16 md:w-20 {{ $decoSvgDim }} pointer-events-none" viewBox="0 0 60 600" fill="none" preserveAspectRatio="none">
            <path d="M8 0 C20 80, 10 160, 24 240 C38 320, 12 400, 8 500 L8 600" stroke="currentColor" stroke-width="1.2" fill="none"/>
            <path d="M12 60 C24 54, 28 68, 18 74 C8 70, 6 66, 12 60Z" fill="currentColor"/>
            <path d="M20 180 C32 174, 36 188, 26 194 C16 190, 14 186, 20 180Z" fill="currentColor"/>
            <path d="M16 300 C28 294, 32 308, 22 314 C12 310, 10 306, 16 300Z" fill="currentColor"/>
            <path d="M10 420 C22 414, 26 428, 16 434 C6 430, 4 426, 10 420Z" fill="currentColor"/>
            <circle cx="24" cy="240" r="3" fill="currentColor" opacity="0.6"/>
            <circle cx="8" cy="120" r="2" fill="currentColor" opacity="0.4"/>
            <circle cx="8" cy="450" r="2" fill="currentColor" opacity="0.4"/>
        </svg>

        @elseif($isModern)
        {{-- Minimal left line --}}
        <svg class="absolute left-0 top-0 bottom-0 w-16 md:w-20 {{ $decoSvgDim }} pointer-events-none" viewBox="0 0 60 600" fill="none" preserveAspectRatio="none">
            <line x1="8" y1="0" x2="8" y2="600" stroke="currentColor" stroke-width="0.5"/>
            <circle cx="8" cy="80" r="2.5" fill="currentColor" opacity="0.5"/>
            <circle cx="8" cy="200" r="1.5" fill="currentColor" opacity="0.3"/>
            <circle cx="8" cy="320" r="2.5" fill="currentColor" opacity="0.5"/>
            <circle cx="8" cy="440" r="1.5" fill="currentColor" opacity="0.3"/>
            <circle cx="8" cy="540" r="2.5" fill="currentColor" opacity="0.5"/>
        </svg>

        @elseif($isKlasik)
        {{-- Ornate left border --}}
        <svg class="absolute left-0 top-0 bottom-0 w-16 md:w-20 {{ $decoSvgDim }} pointer-events-none" viewBox="0 0 60 600" fill="none" preserveAspectRatio="none">
            <path d="M8 0 C16 40, 4 100, 12 160 C20 220, 4 280, 12 340 C20 400, 4 460, 12 520 L12 600" stroke="currentColor" stroke-width="1" fill="none"/>
            <path d="M8 30 C14 26, 14 34, 8 30Z" fill="currentColor"/>
            <path d="M10 150 C16 146, 16 154, 10 150Z" fill="currentColor"/>
            <path d="M8 270 C14 266, 14 274, 8 270Z" fill="currentColor"/>
            <path d="M10 390 C16 386, 16 394, 10 390Z" fill="currentColor"/>
            <circle cx="12" cy="520" r="2.5" fill="currentColor" opacity="0.5"/>
            <circle cx="4" cy="80" r="2" fill="currentColor" opacity="0.4"/>
            <circle cx="4" cy="200" r="2" fill="currentColor" opacity="0.4"/>
            <circle cx="4" cy="440" r="2" fill="currentColor" opacity="0.4"/>
        </svg>
        @endif

        <div class="px-10 py-14 md:px-14 md:py-20 text-center relative z-10">
            <p class="font-pinyon text-2xl md:text-3xl {{ $textAccent }} mb-1">{{ $page2OrnateLabel }}</p>
            <h2 class="font-playfair text-lg md:text-xl font-semibold text-ink tracking-wider uppercase mb-10">{{ $headingText }}</h2>

            @if($tanggalUtama || $jamUtama || $lokasiUtama)
            <div class="mb-8">
                <p class="text-[10px] uppercase tracking-[0.2em] text-ink/40 font-medium mb-3">Akad Nikah</p>
                <p class="font-playfair text-sm md:text-base text-ink font-medium" data-preview="tanggal_utama">
                    {{ $tanggalUtama ?: '-' }}
                </p>
                <p class="text-xs text-ink/50 mt-1"><span data-preview="jam_utama">{{ $jamUtama ?: '' }}</span></p>
                <p class="text-xs text-ink/50" data-preview="lokasi_utama">{{ $lokasiUtama ?: '' }}</p>
            </div>
            <div class="w-12 h-px {{ $separatorDim }} mx-auto mb-8"></div>
            @endif

            <div class="mb-8">
                <p class="text-[10px] uppercase tracking-[0.2em] text-ink/40 font-medium mb-3">Resepsi</p>
                <p class="font-playfair text-sm md:text-base text-ink font-medium" data-preview="tanggal_resepsi">
                    {{ $tanggalResepsi ?: '-' }}
                </p>
                <p class="text-xs text-ink/50 mt-1"><span data-preview="jam_resepsi">{{ $jamResepsi ?: '' }}</span></p>
                <p class="text-xs text-ink/50" data-preview="lokasi_resepsi">{{ $lokasiResepsi ?: '' }}</p>
            </div>

            @if($dresscode)
            <div class="w-12 h-px {{ $separatorDim }} mx-auto mb-8"></div>
            <div class="mb-8">
                <p class="text-[10px] uppercase tracking-[0.2em] text-ink/40 font-medium mb-2">Dress Code</p>
                <p class="text-sm text-ink/70" data-preview="dresscode">{{ $dresscode }}</p>
            </div>
            @endif

            @if($catatanTambahan)
            <div class="w-12 h-px {{ $separatorDim }} mx-auto mb-8"></div>
            <div>
                <p class="text-[10px] uppercase tracking-[0.2em] text-ink/40 font-medium mb-2">Catatan</p>
                <p class="text-xs text-ink/50 max-w-xs mx-auto leading-relaxed" data-preview="catatan_tambahan">{{ $catatanTambahan }}</p>
            </div>
            @endif

            <div class="flex items-center justify-center gap-5 mt-10">
                <button onclick="wcGoTo(this, 1)" class="wc-back w-9 h-9 rounded-full border border-ink/15 text-ink/40 hover:bg-ink hover:text-white transition-all duration-200 flex items-center justify-center">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                </button>
                @if($showRsvp)
                <button onclick="wcGoTo(this, 3)" class="wc-next w-9 h-9 rounded-full border {{ $btnNavGreen }} transition-all duration-200 flex items-center justify-center">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </button>
                @endif
            </div>
        </div>
    </div>

    @if($showRsvp)
    <div data-wc-page="3" class="wc-page hidden relative min-h-[480px] overflow-hidden">

        {{-- Top decoration --}}
        @if($isElegan)
        <svg class="absolute top-0 left-0 right-0 w-full h-14 {{ $decoSvgLight }} pointer-events-none" viewBox="0 0 400 50" fill="none" preserveAspectRatio="none">
            <path d="M0 35 C60 18, 120 38, 180 22 C240 6, 300 32, 360 16 C380 10, 390 18, 400 12 L400 0 L0 0 Z" fill="currentColor"/>
        </svg>
        @elseif($isModern)
        <div class="absolute top-0 left-0 right-0 h-px {{ $separator }} mx-10"></div>
        @elseif($isKlasik)
        <svg class="absolute top-0 left-0 right-0 w-full h-14 {{ $decoSvgLight }} pointer-events-none" viewBox="0 0 400 50" fill="none" preserveAspectRatio="none">
            <path d="M0 28 C40 20, 80 32, 120 24 C160 16, 200 30, 240 22 C280 14, 320 28, 360 18 C380 14, 390 22, 400 16 L400 0 L0 0 Z" fill="currentColor"/>
        </svg>
        @endif

        <div class="px-10 py-14 md:px-14 md:py-20 text-center relative z-10">
            @if($isModern)
            <h2 class="font-playfair text-xl md:text-2xl font-semibold {{ $textAccent }} tracking-wider uppercase mb-2">{{ $rsvpTitle }}</h2>
            @else
            <p class="font-pinyon text-2xl md:text-3xl {{ $textAccent }} mb-1">{{ $rsvpTitle }}</p>
            <h2 class="font-playfair text-lg md:text-xl font-semibold text-ink tracking-wider uppercase mb-2">RSVP</h2>
            @endif
            <p class="text-xs text-ink/40 mb-8">Mohon konfirmasi kehadiran</p>

            @if ($success)
            <div class="mb-6 p-4 {{ $successBg }} text-sm">
                {{ $success }}
            </div>
            @endif

            @if ($errors && $errors->any())
            <div class="mb-4 p-4 bg-red-50 text-red-700 border border-red-100 text-sm">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            @if(!$editingRsvp)
            <form action="{{ route('rsvp.store', $eventSlug) }}" method="POST" class="space-y-5 text-left">
                @csrf
                <div>
                    <label class="block text-[10px] uppercase tracking-[0.15em] font-medium text-ink/50 mb-1.5">Nama Kamu</label>
                    <input type="text" name="nama_tamu" value="{{ old('nama_tamu') }}" placeholder="Tulis namamu..." class="w-full {{ $inputBorder }} px-4 py-3 text-sm text-ink placeholder:text-ink/25 focus:ring-0 rounded-none" required>
                </div>
                <div>
                    <label class="block text-[10px] uppercase tracking-[0.15em] font-medium text-ink/50 mb-2">Konfirmasi Kehadiran</label>
                    <div class="flex gap-3">
                        <label class="flex-1 cursor-pointer">
                            <input type="radio" name="status_hadir" value="hadir" class="sr-only peer" {{ old('status_hadir') == 'hadir' ? 'checked' : '' }} required>
                            <div class="text-center px-4 py-3 border {{ $borderThin }} text-sm text-ink/50 {{ $checkedClass }} peer-checked:text-white transition-all duration-200 rounded-none">Hadir</div>
                        </label>
                        <label class="flex-1 cursor-pointer">
                            <input type="radio" name="status_hadir" value="tidak_hadir" class="sr-only peer" {{ old('status_hadir') == 'tidak_hadir' ? 'checked' : '' }} required>
                            <div class="text-center px-4 py-3 border {{ $borderThin }} text-sm text-ink/50 peer-checked:bg-ink/70 peer-checked:text-white peer-checked:border-ink/70 transition-all duration-200 rounded-none">Tidak Hadir</div>
                        </label>
                    </div>
                </div>
                <div>
                    <label class="block text-[10px] uppercase tracking-[0.15em] font-medium text-ink/50 mb-1.5">Jumlah Orang <span class="text-ink/25 normal-case">(termasuk kamu)</span></label>
                    <input type="number" name="jumlah_orang" value="{{ old('jumlah_orang', 1) }}" min="1" class="w-full {{ $inputBorder }} px-4 py-3 text-sm text-ink focus:ring-0 rounded-none" required>
                </div>
                <div>
                    <label class="block text-[10px] uppercase tracking-[0.15em] font-medium text-ink/50 mb-1.5">Ucapan & Doa <span class="text-ink/25 normal-case">(opsional)</span></label>
                    <textarea name="ucapan" rows="3" class="w-full {{ $inputBorder }} px-4 py-3 text-sm text-ink placeholder:text-ink/25 focus:ring-0 rounded-none" placeholder="Tulis ucapan untuk kedua mempelai...">{{ old('ucapan') }}</textarea>
                </div>
                <button type="submit" class="w-full py-3.5 {{ $btnSubmit }} text-sm font-medium tracking-wider uppercase transition-colors duration-200 rounded-none">Kirim Konfirmasi</button>
            </form>
            @else
            <form action="{{ route('rsvp.update', $editingRsvp->edit_token) }}" method="POST" class="space-y-5 text-left">
                @csrf
                @method('PUT')
                <p class="text-xs text-ink/40 mb-4 text-center">Edit data RSVP kamu di bawah ini</p>
                <div>
                    <label class="block text-[10px] uppercase tracking-[0.15em] font-medium text-ink/50 mb-1.5">Nama Kamu</label>
                    <input type="text" name="nama_tamu" value="{{ old('nama_tamu', $editingRsvp->nama_tamu) }}" class="w-full {{ $inputBorder }} px-4 py-3 text-sm text-ink focus:ring-0 rounded-none" required>
                </div>
                <div>
                    <label class="block text-[10px] uppercase tracking-[0.15em] font-medium text-ink/50 mb-2">Konfirmasi Kehadiran</label>
                    <div class="flex gap-3">
                        <label class="flex-1 cursor-pointer">
                            <input type="radio" name="status_hadir" value="hadir" class="sr-only peer" {{ old('status_hadir', $editingRsvp->status_hadir) == 'hadir' ? 'checked' : '' }} required>
                            <div class="text-center px-4 py-3 border {{ $borderThin }} text-sm text-ink/50 {{ $checkedClass }} peer-checked:text-white transition-all duration-200 rounded-none">Hadir</div>
                        </label>
                        <label class="flex-1 cursor-pointer">
                            <input type="radio" name="status_hadir" value="tidak_hadir" class="sr-only peer" {{ old('status_hadir', $editingRsvp->status_hadir) == 'tidak_hadir' ? 'checked' : '' }} required>
                            <div class="text-center px-4 py-3 border {{ $borderThin }} text-sm text-ink/50 peer-checked:bg-ink/70 peer-checked:text-white peer-checked:border-ink/70 transition-all duration-200 rounded-none">Tidak Hadir</div>
                        </label>
                    </div>
                </div>
                <div>
                    <label class="block text-[10px] uppercase tracking-[0.15em] font-medium text-ink/50 mb-1.5">Jumlah Orang <span class="text-ink/25 normal-case">(termasuk kamu)</span></label>
                    <input type="number" name="jumlah_orang" value="{{ old('jumlah_orang', $editingRsvp->jumlah_orang) }}" min="1" class="w-full {{ $inputBorder }} px-4 py-3 text-sm text-ink focus:ring-0 rounded-none" required>
                </div>
                <div>
                    <label class="block text-[10px] uppercase tracking-[0.15em] font-medium text-ink/50 mb-1.5">Ucapan & Doa <span class="text-ink/25 normal-case">(opsional)</span></label>
                    <textarea name="ucapan" rows="3" class="w-full {{ $inputBorder }} px-4 py-3 text-sm text-ink placeholder:text-ink/25 focus:ring-0 rounded-none" placeholder="Tulis ucapan untuk kedua mempelai...">{{ old('ucapan', $editingRsvp->ucapan) }}</textarea>
                </div>
                <button type="submit" class="w-full py-3.5 {{ $btnSubmit }} text-sm font-medium tracking-wider uppercase transition-colors duration-200 rounded-none">Simpan Perubahan</button>
            </form>
            @endif

            <div class="mt-8">
                <button onclick="wcGoTo(this, 2)" class="wc-back w-9 h-9 rounded-full border border-ink/15 text-ink/40 hover:bg-ink hover:text-white transition-all duration-200 flex items-center justify-center mx-auto">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                </button>
            </div>
        </div>

        @if($isKlasik)
        <svg class="absolute bottom-0 left-0 right-0 w-full h-14 {{ $decoSvgLight }} pointer-events-none rotate-180" viewBox="0 0 400 50" fill="none" preserveAspectRatio="none">
            <path d="M0 28 C40 20, 80 32, 120 24 C160 16, 200 30, 240 22 C280 14, 320 28, 360 18 C380 14, 390 22, 400 16 L400 0 L0 0 Z" fill="currentColor"/>
        </svg>
        @elseif($isElegan)
        <svg class="absolute bottom-0 left-0 right-0 w-full h-14 {{ $decoSvgLight }} pointer-events-none rotate-180" viewBox="0 0 400 50" fill="none" preserveAspectRatio="none">
            <path d="M0 35 C60 18, 120 38, 180 22 C240 6, 300 32, 360 16 C380 10, 390 18, 400 12 L400 0 L0 0 Z" fill="currentColor"/>
        </svg>
        @endif
    </div>

    {{-- Wishes --}}
    @if($rsvps->isNotEmpty())
    <div class="border-t {{ $wishesSeparator }}">
        <div class="px-10 py-8 md:px-12 text-center">
            @if($isModern)
            <h3 class="font-playfair text-sm font-semibold {{ $textAccent }} tracking-wider uppercase mb-5">{{ $rsvps->count() }} {{ $wishesTitle }}</h3>
            @else
            <p class="font-pinyon text-lg {{ $textAccent }} mb-1">{{ $wishesTitle }}</p>
            <h3 class="font-playfair text-xs font-semibold text-ink tracking-wider uppercase mb-5">{{ $rsvps->count() }} Ucapan</h3>
            @endif
            <div class="space-y-3 max-h-60 overflow-y-auto wishes-scroll pr-1 text-left">
                @foreach ($rsvps as $wish)
                    @if ($wish->ucapan)
                    <div class="pb-3 border-b {{ $wishesSeparatorThin }} last:border-0 last:pb-0">
                        <p class="font-medium text-ink text-sm">{{ $wish->nama_tamu }}
                            <span class="text-xs text-ink/30 font-normal">{{ $wish->status_hadir === 'hadir' ? '• Hadir' : '• Tidak Hadir' }}</span>
                        </p>
                        <p class="mt-0.5 text-sm text-ink/50 leading-relaxed">{{ $wish->ucapan }}</p>
                    </div>
                    @endif
                @endforeach
            </div>
        </div>
    </div>
    @endif
    @endif
</div>

<script>
    function wcGoTo(btn, page) {
        var card = btn.closest('.wedding-card');
        if (!card) return;
        card.querySelectorAll('[data-wc-page]').forEach(function(el) {
            var p = parseInt(el.getAttribute('data-wc-page'));
            if (p === page) {
                el.classList.remove('hidden');
                el.classList.remove('wc-page-enter');
                void el.offsetWidth;
                el.classList.add('wc-page-active');
            } else {
                el.classList.remove('wc-page-active');
                el.classList.add('hidden');
            }
        });
    }
</script>
