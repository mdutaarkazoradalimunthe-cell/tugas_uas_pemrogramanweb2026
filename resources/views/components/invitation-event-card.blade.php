@props([
    'layoutType' => 'foto_atas',
    'namaAcara' => '',
    'tanggalUtama' => '',
    'jamUtama' => '',
    'lokasiUtama' => '',
    'namaPembicara' => '',
    'kapasitasPeserta' => '',
    'topikAgenda' => '',
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
    $uid = 'ec-' . \Illuminate\Support\Str::random(6);
    $isMakrab = str_contains(strtolower($templateName), 'casual') || str_contains(strtolower($templateName), 'gathering') || str_contains(strtolower($templateName), 'makrab');
    $isSeminar = str_contains(strtolower($templateName), 'professional') || str_contains(strtolower($templateName), 'brass') || str_contains(strtolower($templateName), 'seminar');

    $accentColor = $isMakrab ? 'evergreen' : ($isSeminar ? 'blue-800' : 'brass');
    $accentLabel = $isMakrab ? 'Makrab' : ($isSeminar ? 'Seminar' : 'Acara');
    $accentSvgClass = $isMakrab ? 'text-evergreen/20' : ($isSeminar ? 'text-blue-800/20' : 'text-brass/20');
    $borderClass = $isMakrab ? 'border-evergreen/20' : ($isSeminar ? 'border-blue-800/20' : 'border-brass/20');
    $borderLight = $isMakrab ? 'border-evergreen/15' : ($isSeminar ? 'border-blue-800/15' : 'border-brass/15');
    $bgAccent = $isMakrab ? 'bg-evergreen/8' : ($isSeminar ? 'bg-blue-800/8' : 'bg-brass/8');
    $hoverAccent = $isMakrab ? 'hover:bg-evergreen' : ($isSeminar ? 'hover:bg-blue-800' : 'hover:bg-brass');
    $focusBorder = $isMakrab ? 'focus:border-evergreen' : ($isSeminar ? 'focus:border-blue-800' : 'focus:border-brass');
    $btnSubmitClass = $isMakrab ? 'bg-evergreen text-white hover:bg-evergreen-dark' : ($isSeminar ? 'bg-blue-800 text-white hover:bg-blue-900' : 'bg-brass text-white hover:bg-brass');
    $checkedClass = $isMakrab ? 'peer-checked:bg-evergreen peer-checked:border-evergreen' : ($isSeminar ? 'peer-checked:bg-blue-800 peer-checked:border-blue-800' : 'peer-checked:bg-brass peer-checked:border-brass');
    $photoPlaceholderGrad = $isMakrab ? 'from-evergreen/10 to-paper' : ($isSeminar ? 'from-blue-800/10 to-paper' : 'from-brass/10 to-paper');
    $photoPlaceholderText = $isMakrab ? 'text-evergreen/25' : ($isSeminar ? 'text-blue-800/25' : 'text-brass/25');
    $undoBtnClass = $isMakrab ? 'hover:bg-evergreen hover:text-white' : ($isSeminar ? 'hover:bg-blue-800 hover:text-white' : 'hover:bg-brass hover:text-white');
    $textAccent = $isMakrab ? 'text-evergreen' : ($isSeminar ? 'text-blue-800' : 'text-brass');
    $textAccentMuted = $isMakrab ? 'text-evergreen/60' : ($isSeminar ? 'text-blue-800/60' : 'text-brass/60');
    $textAccentMuted2 = $isMakrab ? 'text-evergreen/50' : ($isSeminar ? 'text-blue-800/50' : 'text-brass/50');
    $textAccentMuted3 = $isMakrab ? 'text-evergreen/40' : ($isSeminar ? 'text-blue-800/40' : 'text-brass/40');
    $separatorClass = $isMakrab ? 'bg-evergreen/20' : ($isSeminar ? 'bg-blue-800/20' : 'bg-brass/20');
    $btnBorderClass = $isMakrab ? 'border-evergreen/25' : ($isSeminar ? 'border-blue-800/25' : 'border-brass/25');
    $cardClass = $isMakrab
        ? 'bg-gradient-to-br from-paper via-white to-evergreen/8 border-2 border-evergreen/30 rounded-[1.5rem] overflow-hidden shadow-sm'
        : ($isSeminar
            ? 'bg-white border-l-8 border-blue-800 rounded-none overflow-hidden shadow-sm'
            : 'bg-white border border-brass/30 rounded-[1.25rem] overflow-hidden shadow-sm');
    $innerBorderClass = $isMakrab ? 'border-evergreen/15' : ($isSeminar ? 'border-blue-800/10' : 'border-brass/10');
@endphp

<style>
    .ec-page {
        transition: opacity 0.5s ease, transform 0.5s ease;
    }
    .ec-page-enter {
        opacity: 0;
        transform: translateY(20px);
    }
    .ec-page-active {
        opacity: 1;
        transform: translateY(0);
    }
    .wishes-scroll::-webkit-scrollbar { width: 3px; }
    .wishes-scroll::-webkit-scrollbar-track { background: transparent; }
    .wishes-scroll::-webkit-scrollbar-thumb { background: #D8C39A; border-radius: 2px; }
</style>

<div class="event-card relative w-full {{ $cardClass }}" data-ec-uid="{{ $uid }}">
    {{-- ============================================================ --}}
    {{-- PAGE 1 — PEMBUKA --}}
    {{-- ============================================================ --}}
    <div data-ec-page="1" class="ec-page ec-page-active relative overflow-hidden">

        @if($isMakrab)
        {{-- Bonfire top-left --}}
        <svg class="absolute top-0 left-0 w-28 h-28 md:w-32 md:h-32 {{ $accentSvgClass }} pointer-events-none" viewBox="0 0 130 130" fill="none">
            <path d="M14 118 L32 98" stroke="currentColor" stroke-width="2.5" opacity="0.5"/>
            <path d="M32 118 L14 98" stroke="currentColor" stroke-width="2.5" opacity="0.5"/>
            <path d="M20 98 C16 82, 26 68, 28 58 C32 68, 36 76, 34 84 C38 80, 40 70, 38 60 C42 72, 44 82, 38 92 C44 88, 46 76, 42 66 C46 78, 44 90, 36 98 Z" fill="currentColor" opacity="0.6"/>
            <path d="M58 112 L56 100 L72 100 L70 112 Z" stroke="currentColor" stroke-width="1" fill="currentColor" opacity="0.2"/>
            <circle cx="63" cy="104" r="1.5" fill="currentColor" opacity="0.4"/>
            <circle cx="66" cy="107" r="1" fill="currentColor" opacity="0.3"/>
            <circle cx="62" cy="108" r="1" fill="currentColor" opacity="0.3"/>
            <path d="M80 100 C82 90, 78 82, 82 78" stroke="currentColor" stroke-width="0.8" opacity="0.4"/>
            <path d="M85 102 C88 92, 84 84, 88 80" stroke="currentColor" stroke-width="0.8" opacity="0.3"/>
            <circle cx="10" cy="50" r="2" fill="currentColor" opacity="0.3"/>
            <circle cx="90" cy="38" r="2.5" fill="currentColor" opacity="0.25"/>
        </svg>

        {{-- Bonfire bottom-right --}}
        <svg class="absolute bottom-0 right-0 w-28 h-28 md:w-32 md:h-32 {{ $accentSvgClass }} pointer-events-none rotate-180" viewBox="0 0 130 130" fill="none">
            <path d="M14 118 L32 98" stroke="currentColor" stroke-width="2.5" opacity="0.5"/>
            <path d="M32 118 L14 98" stroke="currentColor" stroke-width="2.5" opacity="0.5"/>
            <path d="M20 98 C16 82, 26 68, 28 58 C32 68, 36 76, 34 84 C38 80, 40 70, 38 60 C42 72, 44 82, 38 92 C44 88, 46 76, 42 66 C46 78, 44 90, 36 98 Z" fill="currentColor" opacity="0.6"/>
            <path d="M58 112 L56 100 L72 100 L70 112 Z" stroke="currentColor" stroke-width="1" fill="currentColor" opacity="0.2"/>
            <circle cx="63" cy="104" r="1.5" fill="currentColor" opacity="0.4"/>
            <circle cx="66" cy="107" r="1" fill="currentColor" opacity="0.3"/>
            <circle cx="10" cy="50" r="2" fill="currentColor" opacity="0.3"/>
        </svg>
        @elseif($isSeminar)
        {{-- Books top-left --}}
        <svg class="absolute top-0 left-0 w-28 h-28 md:w-32 md:h-32 {{ $accentSvgClass }} pointer-events-none" viewBox="0 0 130 130" fill="none">
            <rect x="14" y="88" width="52" height="14" rx="1.5" stroke="currentColor" stroke-width="1" fill="currentColor" opacity="0.25"/>
            <line x1="20" y1="93" x2="60" y2="93" stroke="currentColor" stroke-width="0.5" opacity="0.5"/>
            <line x1="20" y1="97" x2="55" y2="97" stroke="currentColor" stroke-width="0.5" opacity="0.5"/>
            <rect x="17" y="72" width="46" height="14" rx="1.5" stroke="currentColor" stroke-width="1" fill="currentColor" opacity="0.45"/>
            <line x1="23" y1="77" x2="56" y2="77" stroke="currentColor" stroke-width="0.5" opacity="0.5"/>
            <line x1="23" y1="81" x2="52" y2="81" stroke="currentColor" stroke-width="0.5" opacity="0.5"/>
            <rect x="22" y="56" width="38" height="14" rx="1.5" stroke="currentColor" stroke-width="1" fill="currentColor" opacity="0.35" transform="rotate(-6, 41, 63)"/>
            <path d="M72 84 L88 66" stroke="currentColor" stroke-width="1.5"/>
            <path d="M88 66 L92 62" stroke="currentColor" stroke-width="1.5"/>
            <circle cx="93" cy="60" r="2.5" fill="currentColor" opacity="0.5"/>
            <circle cx="8" cy="50" r="2" fill="currentColor" opacity="0.3"/>
            <circle cx="88" cy="28" r="2.5" fill="currentColor" opacity="0.25"/>
            <circle cx="100" cy="48" r="1.5" fill="currentColor" opacity="0.3"/>
        </svg>

        {{-- Books bottom-right --}}
        <svg class="absolute bottom-0 right-0 w-28 h-28 md:w-32 md:h-32 {{ $accentSvgClass }} pointer-events-none rotate-180" viewBox="0 0 130 130" fill="none">
            <rect x="14" y="88" width="52" height="14" rx="1.5" stroke="currentColor" stroke-width="1" fill="currentColor" opacity="0.25"/>
            <line x1="20" y1="93" x2="60" y2="93" stroke="currentColor" stroke-width="0.5" opacity="0.5"/>
            <line x1="20" y1="97" x2="55" y2="97" stroke="currentColor" stroke-width="0.5" opacity="0.5"/>
            <rect x="17" y="72" width="46" height="14" rx="1.5" stroke="currentColor" stroke-width="1" fill="currentColor" opacity="0.45"/>
            <rect x="22" y="56" width="38" height="14" rx="1.5" stroke="currentColor" stroke-width="1" fill="currentColor" opacity="0.35" transform="rotate(-6, 41, 63)"/>
            <path d="M72 84 L88 66" stroke="currentColor" stroke-width="1.5"/>
            <circle cx="93" cy="60" r="2.5" fill="currentColor" opacity="0.5"/>
            <circle cx="8" cy="50" r="2" fill="currentColor" opacity="0.3"/>
            <circle cx="88" cy="28" r="2.5" fill="currentColor" opacity="0.25"/>
        </svg>
        @else
        {{-- Generic decorations --}}
        <svg class="absolute top-0 left-0 w-28 h-28 md:w-32 md:h-32 {{ $accentSvgClass }} pointer-events-none" viewBox="0 0 130 130" fill="none">
            <path d="M8 122 C22 98, 48 80, 76 64 C96 52, 112 34, 122 8" stroke="currentColor" stroke-width="1.2" fill="none"/>
            <circle cx="122" cy="8" r="3.5" fill="currentColor" opacity="0.5"/>
            <circle cx="58" cy="82" r="2" fill="currentColor" opacity="0.3"/>
            <circle cx="112" cy="26" r="1.5" fill="currentColor" opacity="0.25"/>
        </svg>
        <svg class="absolute bottom-0 right-0 w-28 h-28 md:w-32 md:h-32 {{ $accentSvgClass }} pointer-events-none rotate-180" viewBox="0 0 130 130" fill="none">
            <path d="M8 122 C22 98, 48 80, 76 64 C96 52, 112 34, 122 8" stroke="currentColor" stroke-width="1.2" fill="none"/>
            <circle cx="122" cy="8" r="3.5" fill="currentColor" opacity="0.5"/>
            <circle cx="58" cy="82" r="2" fill="currentColor" opacity="0.3"/>
        </svg>
        @endif

        @if($layoutType === 'foto_samping')
            {{-- Split: photo left / text right --}}
            <div class="flex flex-col md:flex-row min-h-[500px]">
                <div class="w-full md:w-2/5 min-h-[200px] md:min-h-full">
                    @if($hasPhoto)
                    <div class="h-56 md:h-full overflow-hidden">
                        <img src="{{ $fotoUrl }}" alt="Foto Acara" class="w-full h-full object-cover" data-preview-img="foto_utama">
                    </div>
                    @else
                    <div class="h-56 md:h-full bg-gradient-to-br {{ $photoPlaceholderGrad }} flex items-center justify-center overflow-hidden" data-preview-img="foto_utama">
                        <div class="text-center">
                            <svg class="w-8 h-8 mx-auto {{ $photoPlaceholderText }} mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                            <p class="text-xs {{ $photoPlaceholderText }} font-medium">Foto</p>
                        </div>
                    </div>
                    @endif
                </div>
                <div class="w-full md:w-3/5 px-8 py-12 md:px-10 md:py-14 text-center relative">
                    @if($isMakrab)
                    <div class="pointer-events-none absolute -top-6 -right-6 h-24 w-24 rounded-full bg-evergreen/8"></div>
                    <div class="pointer-events-none absolute -bottom-8 -left-8 h-28 w-28 rounded-full bg-evergreen/6"></div>
                    @elseif($isSeminar)
                    <div class="pointer-events-none absolute inset-4 border border-blue-800/8 rounded-none"></div>
                    @endif
                    <p class="text-[10px] uppercase tracking-[0.25em] text-ink/35 font-medium mb-6">Undangan {{ ucfirst($accentLabel) }}</p>
                    <h1 class="font-playfair text-2xl md:text-3xl font-semibold {{ $textAccent }} leading-tight" data-preview="nama_acara">
                        {{ $namaAcara ?: 'Nama Acara' }}
                    </h1>
                    <p class="mt-4 text-sm text-ink/50 max-w-xs mx-auto leading-relaxed">Mohon doa dan kehadirannya</p>

                    <div class="mt-6 flex items-center justify-center gap-2">
                        <span class="w-8 h-px {{ $separatorClass }}"></span>
                        <span class="font-pinyon text-xl {{ $textAccentMuted3 }}">~</span>
                        <span class="w-8 h-px {{ $separatorClass }}"></span>
                    </div>
                    <p class="mt-6 font-playfair text-sm md:text-base text-ink font-medium tracking-wider" data-preview="tanggal_utama">
                        {{ $tanggalUtama ?: 'Tanggal' }}
                    </p>
                    <p class="mt-1 text-xs text-ink/50"><span data-preview="jam_utama">{{ $jamUtama ?: '' }}</span></p>
                    <p class="mt-1 text-xs text-ink/50" data-preview="lokasi_utama">{{ $lokasiUtama ?: 'Lokasi' }}</p>
                    <button onclick="ecGoTo(this, 2)" class="ec-next absolute bottom-6 right-6 w-9 h-9 rounded-full border {{ $btnBorderClass }} {{ $textAccentMuted }} {{ $undoBtnClass }} transition-all duration-200 flex items-center justify-center">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </button>
                </div>
            </div>
        @else
            {{-- Vertical layout (foto_atas or tanpa_foto) --}}
            <div class="px-10 py-14 md:px-14 md:py-20 text-center relative min-h-[520px]">
                @if($isMakrab)
                <div class="pointer-events-none absolute -top-8 -right-8 h-28 w-28 rounded-full bg-evergreen/8"></div>
                <div class="pointer-events-none absolute -bottom-10 -left-10 h-32 w-32 rounded-full bg-evergreen/6"></div>
                @elseif($isSeminar)
                <div class="pointer-events-none absolute inset-6 border border-blue-800/8 rounded-none"></div>
                @endif
                <p class="text-[10px] uppercase tracking-[0.25em] text-ink/35 font-medium mb-8">Undangan {{ ucfirst($accentLabel) }}</p>

                @if($layoutType === 'foto_atas')
                    @if($hasPhoto)
                    <div class="w-32 h-32 md:w-40 md:h-40 mx-auto mb-10 rounded-full overflow-hidden border-2 {{ $borderClass }} shadow-[0_8px_24px_-8px_rgba(0,0,0,0.12)]">
                        <img src="{{ $fotoUrl }}" alt="Foto Acara" class="w-full h-full object-cover" data-preview-img="foto_utama">
                    </div>
                    @else
                    <div class="w-32 h-32 md:w-40 md:h-40 mx-auto mb-10 rounded-full overflow-hidden border-2 border-dashed {{ $borderClass }} bg-paper flex items-center justify-center" data-preview-img="foto_utama">
                        <svg class="w-8 h-8 {{ $photoPlaceholderText }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                    </div>
                    @endif
                @endif

                <h1 class="font-playfair text-3xl md:text-4xl lg:text-5xl font-semibold tracking-[0.05em] {{ $textAccent }} leading-[1.15]" data-preview="nama_acara">
                    {{ $namaAcara ?: 'Nama Acara' }}
                </h1>

                <p class="mt-8 text-sm text-ink/50 max-w-xs mx-auto leading-relaxed">Mohon doa dan kehadirannya</p>

                <div class="mt-10 flex items-center justify-center gap-3">
                    <span class="w-10 h-px {{ $separatorClass }}"></span>
                    <span class="font-pinyon text-xl {{ $textAccentMuted3 }}">~</span>
                    <span class="w-10 h-px {{ $separatorClass }}"></span>
                </div>

                <p class="mt-6 font-playfair text-base md:text-lg text-ink font-medium tracking-wider" data-preview="tanggal_utama">
                    {{ $tanggalUtama ?: 'Tanggal' }}
                </p>
                <p class="mt-1 text-sm text-ink/50"><span data-preview="jam_utama">{{ $jamUtama ?: '' }}</span></p>
                <p class="mt-1 text-sm text-ink/50" data-preview="lokasi_utama">{{ $lokasiUtama ?: 'Lokasi' }}</p>

                <button onclick="ecGoTo(this, 2)" class="ec-next absolute bottom-6 right-6 w-9 h-9 rounded-full border {{ $btnBorderClass }} {{ $textAccentMuted }} {{ $undoBtnClass }} transition-all duration-200 flex items-center justify-center">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </button>
            </div>
        @endif
    </div>

    {{-- ============================================================ --}}
    {{-- PAGE 2 — DETAIL ACARA --}}
    {{-- ============================================================ --}}
    <div data-ec-page="2" class="ec-page hidden relative min-h-[420px] overflow-hidden">
        @if($isMakrab)
        {{-- Smoke vertical left --}}
        <svg class="absolute left-0 top-0 bottom-0 w-16 md:w-20 {{ $accentSvgClass }} pointer-events-none" viewBox="0 0 60 600" fill="none" preserveAspectRatio="none">
            <path d="M8 600 C6 520, 12 440, 8 360 C4 280, 14 200, 8 120 L8 0" stroke="currentColor" stroke-width="1.2" fill="none" opacity="0.5"/>
            <path d="M15 580 C20 540, 12 500, 18 460" stroke="currentColor" stroke-width="0.8" fill="none" opacity="0.3"/>
            <path d="M4 400 C10 370, 4 340, 8 310" stroke="currentColor" stroke-width="0.8" fill="none" opacity="0.3"/>
            <path d="M14 240 C20 210, 12 180, 16 150" stroke="currentColor" stroke-width="0.8" fill="none" opacity="0.3"/>
            <circle cx="10" cy="160" r="2" fill="currentColor" opacity="0.3"/>
            <circle cx="6" cy="280" r="1.5" fill="currentColor" opacity="0.25"/>
            <circle cx="12" cy="400" r="2" fill="currentColor" opacity="0.3"/>
            <circle cx="5" cy="500" r="1.5" fill="currentColor" opacity="0.25"/>
        </svg>
        @elseif($isSeminar)
        {{-- Books vertical left --}}
        <svg class="absolute left-0 top-0 bottom-0 w-16 md:w-20 {{ $accentSvgClass }} pointer-events-none" viewBox="0 0 60 600" fill="none" preserveAspectRatio="none">
            <rect x="8" y="40" width="30" height="10" rx="1" stroke="currentColor" stroke-width="1" fill="currentColor" opacity="0.25"/>
            <rect x="10" y="100" width="28" height="10" rx="1" stroke="currentColor" stroke-width="1" fill="currentColor" opacity="0.35"/>
            <rect x="6" y="160" width="32" height="10" rx="1" stroke="currentColor" stroke-width="1" fill="currentColor" opacity="0.25"/>
            <rect x="10" y="220" width="28" height="10" rx="1" stroke="currentColor" stroke-width="1" fill="currentColor" opacity="0.35"/>
            <rect x="8" y="280" width="30" height="10" rx="1" stroke="currentColor" stroke-width="1" fill="currentColor" opacity="0.25"/>
            <rect x="10" y="340" width="28" height="10" rx="1" stroke="currentColor" stroke-width="1" fill="currentColor" opacity="0.35"/>
            <rect x="6" y="400" width="32" height="10" rx="1" stroke="currentColor" stroke-width="1" fill="currentColor" opacity="0.25"/>
            <rect x="10" y="460" width="28" height="10" rx="1" stroke="currentColor" stroke-width="1" fill="currentColor" opacity="0.35"/>
            <rect x="8" y="520" width="30" height="10" rx="1" stroke="currentColor" stroke-width="1" fill="currentColor" opacity="0.25"/>
            <circle cx="38" cy="60" r="2" fill="currentColor" opacity="0.3"/>
            <circle cx="5" cy="310" r="1.5" fill="currentColor" opacity="0.25"/>
            <circle cx="4" cy="420" r="2" fill="currentColor" opacity="0.3"/>
        </svg>
        @else
        {{-- Generic decoration --}}
        <svg class="absolute left-0 top-0 bottom-0 w-16 md:w-20 {{ $accentSvgClass }} pointer-events-none" viewBox="0 0 60 600" fill="none" preserveAspectRatio="none">
            <path d="M8 0 C20 80, 10 160, 24 240 C38 320, 12 400, 8 500 L8 600" stroke="currentColor" stroke-width="1.2" fill="none"/>
            <circle cx="24" cy="240" r="3" fill="currentColor" opacity="0.5"/>
            <circle cx="8" cy="120" r="2" fill="currentColor" opacity="0.3"/>
            <circle cx="8" cy="450" r="2" fill="currentColor" opacity="0.3"/>
        </svg>
        @endif

        <div class="px-10 py-14 md:px-14 md:py-20 text-center relative z-10">
            @if($isMakrab)
            <div class="pointer-events-none absolute top-8 right-8 h-20 w-20 rounded-full bg-evergreen/6"></div>
            <div class="pointer-events-none absolute bottom-8 left-8 h-24 w-24 rounded-full bg-evergreen/5"></div>
            @elseif($isSeminar)
            <div class="pointer-events-none absolute inset-5 border border-blue-800/6 rounded-none"></div>
            @endif
            <p class="font-pinyon text-2xl md:text-3xl {{ $textAccent }} mb-1">~ Detail Acara ~</p>
            <h2 class="font-playfair text-lg md:text-xl font-semibold text-ink tracking-wider uppercase mb-10">Informasi {{ ucfirst($accentLabel) }}</h2>

            <div class="mb-8">
                <p class="text-[10px] uppercase tracking-[0.2em] text-ink/40 font-medium mb-3">Waktu & Tempat</p>
                <p class="font-playfair text-sm md:text-base text-ink font-medium" data-preview="tanggal_utama">
                    {{ $tanggalUtama ?: '-' }}
                </p>
                <p class="text-xs text-ink/50 mt-1"><span data-preview="jam_utama">{{ $jamUtama ?: '' }}</span></p>
                <p class="text-xs text-ink/50" data-preview="lokasi_utama">{{ $lokasiUtama ?: '' }}</p>
            </div>

            @if($isSeminar && ($namaPembicara || $topikAgenda))
            <div class="w-12 h-px {{ $separatorClass }} mx-auto mb-8"></div>
            <div class="mb-8">
                @if($namaPembicara)
                <p class="text-[10px] uppercase tracking-[0.2em] text-ink/40 font-medium mb-2">Pembicara</p>
                <p class="text-sm text-ink/70" data-preview="nama_pembicara">{{ $namaPembicara }}</p>
                @endif
                @if($topikAgenda)
                <p class="text-[10px] uppercase tracking-[0.2em] text-ink/40 font-medium mt-3 mb-2">Topik</p>
                <p class="text-sm text-ink/70" data-preview="topik_agenda">{{ $topikAgenda }}</p>
                @endif
            </div>
            @elseif($isMakrab && ($kapasitasPeserta || $dresscode))
            <div class="w-12 h-px {{ $separatorClass }} mx-auto mb-8"></div>
            <div class="mb-8">
                @if($kapasitasPeserta)
                <p class="text-[10px] uppercase tracking-[0.2em] text-ink/40 font-medium mb-2">Kapasitas</p>
                <p class="text-sm text-ink/70" data-preview="kapasitas_peserta">{{ $kapasitasPeserta }} peserta</p>
                @endif
            </div>
            @endif

            @if($dresscode)
            <div class="w-12 h-px {{ $separatorClass }} mx-auto mb-8"></div>
            <div class="mb-8">
                <p class="text-[10px] uppercase tracking-[0.2em] text-ink/40 font-medium mb-2">Dress Code</p>
                <p class="text-sm text-ink/70" data-preview="dresscode">{{ $dresscode }}</p>
            </div>
            @endif

            @if($catatanTambahan)
            <div class="w-12 h-px {{ $separatorClass }} mx-auto mb-8"></div>
            <div>
                <p class="text-[10px] uppercase tracking-[0.2em] text-ink/40 font-medium mb-2">Catatan</p>
                <p class="text-xs text-ink/50 max-w-xs mx-auto leading-relaxed" data-preview="catatan_tambahan">{{ $catatanTambahan }}</p>
            </div>
            @endif

            <div class="flex items-center justify-center gap-5 mt-10">
                <button onclick="ecGoTo(this, 1)" class="ec-back w-9 h-9 rounded-full border border-ink/15 text-ink/40 hover:bg-ink hover:text-white transition-all duration-200 flex items-center justify-center">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                </button>
                @if($showRsvp)
                <button onclick="ecGoTo(this, 3)" class="ec-next w-9 h-9 rounded-full border {{ $btnBorderClass }} {{ $textAccentMuted }} {{ $undoBtnClass }} transition-all duration-200 flex items-center justify-center">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </button>
                @endif
            </div>
        </div>
    </div>

    @if($showRsvp)
    {{-- ============================================================ --}}
    {{-- PAGE 3 — RSVP --}}
    {{-- ============================================================ --}}
    <div data-ec-page="3" class="ec-page hidden relative min-h-[480px] overflow-hidden">

        {{-- Top decoration --}}
        <svg class="absolute top-0 left-0 right-0 w-full h-14 {{ $accentSvgClass }} pointer-events-none" viewBox="0 0 400 50" fill="none" preserveAspectRatio="none">
            <path d="M0 35 C60 18, 120 38, 180 22 C240 6, 300 32, 360 16 C380 10, 390 18, 400 12 L400 0 L0 0 Z" fill="currentColor"/>
        </svg>

        <div class="px-10 py-14 md:px-14 md:py-20 text-center relative z-10">
            @if($isMakrab)
            <div class="pointer-events-none absolute -top-4 -right-4 h-20 w-20 rounded-full bg-evergreen/6"></div>
            @elseif($isSeminar)
            <div class="pointer-events-none absolute inset-5 border border-blue-800/6 rounded-none"></div>
            @endif
            <p class="font-pinyon text-2xl md:text-3xl {{ $textAccent }} mb-1">~ Konfirmasi Kehadiran ~</p>
            <h2 class="font-playfair text-lg md:text-xl font-semibold text-ink tracking-wider uppercase mb-2">RSVP</h2>
            <p class="text-xs text-ink/40 mb-8">Mohon konfirmasi kehadiran</p>

            @if ($success)
            <div class="mb-6 p-4 {{ $bgAccent }} {{ $textAccent }} border {{ $borderLight }} text-sm">
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
                    <input type="text" name="nama_tamu" value="{{ old('nama_tamu') }}" placeholder="Tulis namamu..." class="w-full {{ $borderLight }} px-4 py-3 text-sm text-ink placeholder:text-ink/25 {{ $focusBorder }} focus:ring-0 rounded-none" required>
                </div>
                <div>
                    <label class="block text-[10px] uppercase tracking-[0.15em] font-medium text-ink/50 mb-2">Konfirmasi Kehadiran</label>
                    <div class="flex gap-3">
                        <label class="flex-1 cursor-pointer">
                            <input type="radio" name="status_hadir" value="hadir" class="sr-only peer" {{ old('status_hadir') == 'hadir' ? 'checked' : '' }} required>
                            <div class="text-center px-4 py-3 border {{ $borderLight }} text-sm text-ink/50 {{ $checkedClass }} peer-checked:text-white transition-all duration-200 rounded-none">Hadir</div>
                        </label>
                        <label class="flex-1 cursor-pointer">
                            <input type="radio" name="status_hadir" value="tidak_hadir" class="sr-only peer" {{ old('status_hadir') == 'tidak_hadir' ? 'checked' : '' }} required>
                            <div class="text-center px-4 py-3 border {{ $borderLight }} text-sm text-ink/50 peer-checked:bg-ink/70 peer-checked:text-white peer-checked:border-ink/70 transition-all duration-200 rounded-none">Tidak Hadir</div>
                        </label>
                    </div>
                </div>
                <div>
                    <label class="block text-[10px] uppercase tracking-[0.15em] font-medium text-ink/50 mb-1.5">Jumlah Orang <span class="text-ink/25 normal-case">(termasuk kamu)</span></label>
                    <input type="number" name="jumlah_orang" value="{{ old('jumlah_orang', 1) }}" min="1" class="w-full {{ $borderLight }} px-4 py-3 text-sm text-ink {{ $focusBorder }} focus:ring-0 rounded-none" required>
                </div>
                <div>
                    <label class="block text-[10px] uppercase tracking-[0.15em] font-medium text-ink/50 mb-1.5">Ucapan & Doa <span class="text-ink/25 normal-case">(opsional)</span></label>
                    <textarea name="ucapan" rows="3" class="w-full {{ $borderLight }} px-4 py-3 text-sm text-ink placeholder:text-ink/25 {{ $focusBorder }} focus:ring-0 rounded-none" placeholder="Tulis ucapan...">{{ old('ucapan') }}</textarea>
                </div>
                <button type="submit" class="w-full py-3.5 {{ $btnSubmitClass }} text-sm font-medium tracking-wider uppercase transition-colors duration-200 rounded-none">Kirim Konfirmasi</button>
            </form>
            @else
            <form action="{{ route('rsvp.update', $editingRsvp->edit_token) }}" method="POST" class="space-y-5 text-left">
                @csrf
                @method('PUT')
                <p class="text-xs text-ink/40 mb-4 text-center">Edit data RSVP kamu di bawah ini</p>
                <div>
                    <label class="block text-[10px] uppercase tracking-[0.15em] font-medium text-ink/50 mb-1.5">Nama Kamu</label>
                    <input type="text" name="nama_tamu" value="{{ old('nama_tamu', $editingRsvp->nama_tamu) }}" class="w-full {{ $borderLight }} px-4 py-3 text-sm text-ink {{ $focusBorder }} focus:ring-0 rounded-none" required>
                </div>
                <div>
                    <label class="block text-[10px] uppercase tracking-[0.15em] font-medium text-ink/50 mb-2">Konfirmasi Kehadiran</label>
                    <div class="flex gap-3">
                        <label class="flex-1 cursor-pointer">
                            <input type="radio" name="status_hadir" value="hadir" class="sr-only peer" {{ old('status_hadir', $editingRsvp->status_hadir) == 'hadir' ? 'checked' : '' }} required>
                            <div class="text-center px-4 py-3 border {{ $borderLight }} text-sm text-ink/50 {{ $checkedClass }} peer-checked:text-white transition-all duration-200 rounded-none">Hadir</div>
                        </label>
                        <label class="flex-1 cursor-pointer">
                            <input type="radio" name="status_hadir" value="tidak_hadir" class="sr-only peer" {{ old('status_hadir', $editingRsvp->status_hadir) == 'tidak_hadir' ? 'checked' : '' }} required>
                            <div class="text-center px-4 py-3 border {{ $borderLight }} text-sm text-ink/50 peer-checked:bg-ink/70 peer-checked:text-white peer-checked:border-ink/70 transition-all duration-200 rounded-none">Tidak Hadir</div>
                        </label>
                    </div>
                </div>
                <div>
                    <label class="block text-[10px] uppercase tracking-[0.15em] font-medium text-ink/50 mb-1.5">Jumlah Orang <span class="text-ink/25 normal-case">(termasuk kamu)</span></label>
                    <input type="number" name="jumlah_orang" value="{{ old('jumlah_orang', $editingRsvp->jumlah_orang) }}" min="1" class="w-full {{ $borderLight }} px-4 py-3 text-sm text-ink {{ $focusBorder }} focus:ring-0 rounded-none" required>
                </div>
                <div>
                    <label class="block text-[10px] uppercase tracking-[0.15em] font-medium text-ink/50 mb-1.5">Ucapan & Doa <span class="text-ink/25 normal-case">(opsional)</span></label>
                    <textarea name="ucapan" rows="3" class="w-full {{ $borderLight }} px-4 py-3 text-sm text-ink placeholder:text-ink/25 {{ $focusBorder }} focus:ring-0 rounded-none" placeholder="Tulis ucapan...">{{ old('ucapan', $editingRsvp->ucapan) }}</textarea>
                </div>
                <button type="submit" class="w-full py-3.5 {{ $btnSubmitClass }} text-sm font-medium tracking-wider uppercase transition-colors duration-200 rounded-none">Simpan Perubahan</button>
            </form>
            @endif

            <div class="mt-8">
                <button onclick="ecGoTo(this, 2)" class="ec-back w-9 h-9 rounded-full border border-ink/15 text-ink/40 hover:bg-ink hover:text-white transition-all duration-200 flex items-center justify-center mx-auto">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                </button>
            </div>
        </div>

        {{-- Bottom decoration --}}
        <svg class="absolute bottom-0 left-0 right-0 w-full h-14 {{ $accentSvgClass }} pointer-events-none rotate-180" viewBox="0 0 400 50" fill="none" preserveAspectRatio="none">
            <path d="M0 35 C60 18, 120 38, 180 22 C240 6, 300 32, 360 16 C380 10, 390 18, 400 12 L400 0 L0 0 Z" fill="currentColor"/>
        </svg>
    </div>

    {{-- Wishes --}}
    @if($rsvps->isNotEmpty())
    <div class="border-t {{ $borderClass }}">
        <div class="px-10 py-8 md:px-12 text-center">
            <p class="font-pinyon text-lg {{ $textAccent }} mb-1">~ Ucapan & Doa ~</p>
            <h3 class="font-playfair text-xs font-semibold text-ink tracking-wider uppercase mb-5">{{ $rsvps->count() }} Ucapan</h3>
            <div class="space-y-3 max-h-60 overflow-y-auto wishes-scroll pr-1 text-left">
                @foreach ($rsvps as $wish)
                    @if ($wish->ucapan)
                    <div class="pb-3 border-b {{ $borderLight }} last:border-0 last:pb-0">
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
    function ecGoTo(btn, page) {
        var card = btn.closest('.event-card');
        if (!card) return;
        card.querySelectorAll('[data-ec-page]').forEach(function(el) {
            var p = parseInt(el.getAttribute('data-ec-page'));
            if (p === page) {
                el.classList.remove('hidden');
                el.classList.remove('ec-page-enter');
                void el.offsetWidth;
                el.classList.add('ec-page-active');
            } else {
                el.classList.remove('ec-page-active');
                el.classList.add('hidden');
            }
        });
    }
</script>
