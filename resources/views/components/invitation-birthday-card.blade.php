@props([
    'layoutType' => 'foto_atas',
    'namaAcara' => '',
    'tanggalUtama' => '',
    'jamUtama' => '',
    'lokasiUtama' => '',
    'dresscode' => '',
    'catatanTambahan' => '',
    'fotoUrl' => null,
    'showRsvp' => false,
    'eventSlug' => '',
    'editingRsvp' => null,
    'rsvps' => collect([]),
    'success' => null,
    'errors' => null,
])

@php
    $hasPhoto = !is_null($fotoUrl);
    $uid = 'bc-' . \Illuminate\Support\Str::random(6);
@endphp

<style>
    .bc-page {
        transition: opacity 0.5s ease, transform 0.5s ease;
    }
    .bc-page-enter {
        opacity: 0;
        transform: translateY(20px);
    }
    .bc-page-active {
        opacity: 1;
        transform: translateY(0);
    }
    .wishes-scroll::-webkit-scrollbar { width: 3px; }
    .wishes-scroll::-webkit-scrollbar-track { background: transparent; }
    .wishes-scroll::-webkit-scrollbar-thumb { background: #D8C39A; border-radius: 2px; }
</style>

<div class="birthday-card relative w-full bg-white border border-blush/30" data-bc-uid="{{ $uid }}">
    {{-- ============================================================ --}}
    {{-- PAGE 1 — PEMBUKA --}}
    {{-- ============================================================ --}}
    <div data-bc-page="1" class="bc-page bc-page-active relative overflow-hidden">

        {{-- Balloon top-left --}}
        <svg class="absolute top-0 left-0 w-28 h-28 md:w-32 md:h-32 text-blush/20 pointer-events-none" viewBox="0 0 130 130" fill="none">
            <path d="M18 120 C16 100, 22 82, 30 64" stroke="currentColor" stroke-width="0.8"/>
            <path d="M34 120 C32 104, 38 88, 46 70" stroke="currentColor" stroke-width="0.8"/>
            <path d="M50 120 C52 106, 48 90, 58 76" stroke="currentColor" stroke-width="0.8"/>
            <ellipse cx="30" cy="46" rx="12" ry="16" stroke="currentColor" stroke-width="1.2"/>
            <path d="M26 50 C28 46, 32 46, 34 50" fill="currentColor" opacity="0.4"/>
            <ellipse cx="46" cy="52" rx="10" ry="14" stroke="currentColor" stroke-width="1" opacity="0.7"/>
            <path d="M42 55 C44 52, 48 52, 50 55" fill="currentColor" opacity="0.4"/>
            <ellipse cx="58" cy="58" rx="9" ry="12" stroke="currentColor" stroke-width="1" opacity="0.5"/>
            <path d="M54 60 C56 58, 60 58, 62 60" fill="currentColor" opacity="0.4"/>
            <circle cx="10" cy="22" r="2.5" fill="currentColor" opacity="0.3"/>
            <circle cx="75" cy="18" r="2" fill="currentColor" opacity="0.25"/>
            <circle cx="88" cy="45" r="3" fill="currentColor" opacity="0.3"/>
            <circle cx="8" cy="60" r="1.5" fill="currentColor" opacity="0.2"/>
        </svg>

        {{-- Balloon bottom-right --}}
        <svg class="absolute bottom-0 right-0 w-28 h-28 md:w-32 md:h-32 text-blush/20 pointer-events-none rotate-180" viewBox="0 0 130 130" fill="none">
            <path d="M18 120 C16 100, 22 82, 30 64" stroke="currentColor" stroke-width="0.8"/>
            <path d="M34 120 C32 104, 38 88, 46 70" stroke="currentColor" stroke-width="0.8"/>
            <path d="M50 120 C52 106, 48 90, 58 76" stroke="currentColor" stroke-width="0.8"/>
            <ellipse cx="30" cy="46" rx="12" ry="16" stroke="currentColor" stroke-width="1.2"/>
            <path d="M26 50 C28 46, 32 46, 34 50" fill="currentColor" opacity="0.4"/>
            <ellipse cx="46" cy="52" rx="10" ry="14" stroke="currentColor" stroke-width="1" opacity="0.7"/>
            <path d="M42 55 C44 52, 48 52, 50 55" fill="currentColor" opacity="0.4"/>
            <ellipse cx="58" cy="58" rx="9" ry="12" stroke="currentColor" stroke-width="1" opacity="0.5"/>
            <circle cx="10" cy="22" r="2.5" fill="currentColor" opacity="0.3"/>
            <circle cx="88" cy="45" r="3" fill="currentColor" opacity="0.3"/>
        </svg>

        @if($layoutType === 'foto_samping')
            {{-- Split: photo left / text right --}}
            <div class="flex flex-col md:flex-row min-h-[500px]">
                <div class="w-full md:w-2/5 min-h-[200px] md:min-h-full">
                    @if($hasPhoto)
                    <div class="h-56 md:h-full overflow-hidden">
                        <img src="{{ $fotoUrl }}" alt="Foto Acara" class="w-full h-full object-cover" data-preview-img="foto_utama">
                    </div>
                    @else
                    <div class="h-56 md:h-full bg-gradient-to-br from-blush/10 to-paper flex items-center justify-center overflow-hidden" data-preview-img="foto_utama">
                        <div class="text-center">
                            <svg class="w-8 h-8 mx-auto text-blush/25 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                            <p class="text-xs text-blush/25 font-medium">Foto</p>
                        </div>
                    </div>
                    @endif
                </div>
                <div class="w-full md:w-3/5 px-8 py-12 md:px-10 md:py-14 text-center relative">
                    <p class="text-[10px] uppercase tracking-[0.25em] text-ink/35 font-medium mb-6">Undangan Ulang Tahun</p>
                    <h1 class="font-playfair text-2xl md:text-3xl font-semibold text-blush leading-tight" data-preview="nama_acara">
                        {{ $namaAcara ?: 'Nama Acara' }}
                    </h1>
                    <p class="mt-4 text-sm text-ink/50 max-w-xs mx-auto leading-relaxed">Mohon doa dan kehadirannya</p>

                    <div class="mt-6 flex items-center justify-center gap-2">
                        <span class="w-8 h-px bg-blush/30"></span>
                        <span class="font-pinyon text-xl text-blush/50">~</span>
                        <span class="w-8 h-px bg-blush/30"></span>
                    </div>
                    <p class="mt-6 font-playfair text-sm md:text-base text-ink font-medium tracking-wider" data-preview="tanggal_utama">
                        {{ $tanggalUtama ?: 'Tanggal' }}
                    </p>
                    <p class="mt-1 text-xs text-ink/50"><span data-preview="jam_utama">{{ $jamUtama ?: '' }}</span></p>
                    <p class="mt-1 text-xs text-ink/50" data-preview="lokasi_utama">{{ $lokasiUtama ?: 'Lokasi' }}</p>
                    <button onclick="bcGoTo(this, 2)" class="bc-next absolute bottom-6 right-6 w-9 h-9 rounded-full border border-blush/25 text-blush/60 hover:bg-blush hover:text-white transition-all duration-200 flex items-center justify-center">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </button>
                </div>
            </div>
        @else
            {{-- Vertical layout (foto_atas or tanpa_foto) --}}
            <div class="px-10 py-14 md:px-14 md:py-20 text-center relative min-h-[520px]">
                <p class="text-[10px] uppercase tracking-[0.25em] text-ink/35 font-medium mb-8">Undangan Ulang Tahun</p>

                @if($layoutType === 'foto_atas')
                    @if($hasPhoto)
                    <div class="w-32 h-32 md:w-40 md:h-40 mx-auto mb-10 rounded-full overflow-hidden border-2 border-blush/20 shadow-[0_8px_24px_-8px_rgba(201,120,120,0.2)]">
                        <img src="{{ $fotoUrl }}" alt="Foto Acara" class="w-full h-full object-cover" data-preview-img="foto_utama">
                    </div>
                    @else
                    <div class="w-32 h-32 md:w-40 md:h-40 mx-auto mb-10 rounded-full overflow-hidden border-2 border-dashed border-blush/20 bg-paper flex items-center justify-center" data-preview-img="foto_utama">
                        <svg class="w-8 h-8 text-blush/25" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                    </div>
                    @endif
                @endif

                <h1 class="font-playfair text-3xl md:text-4xl lg:text-5xl font-semibold tracking-[0.05em] text-blush leading-[1.15]" data-preview="nama_acara">
                    {{ $namaAcara ?: 'Nama Acara' }}
                </h1>

                <p class="mt-8 text-sm text-ink/50 max-w-xs mx-auto leading-relaxed">Mohon doa dan kehadirannya</p>

                <div class="mt-10 flex items-center justify-center gap-3">
                    <span class="w-10 h-px bg-blush/25"></span>
                    <span class="font-pinyon text-xl text-blush/40">~</span>
                    <span class="w-10 h-px bg-blush/25"></span>
                </div>

                <p class="mt-6 font-playfair text-base md:text-lg text-ink font-medium tracking-wider" data-preview="tanggal_utama">
                    {{ $tanggalUtama ?: 'Tanggal' }}
                </p>
                <p class="mt-1 text-sm text-ink/50"><span data-preview="jam_utama">{{ $jamUtama ?: '' }}</span></p>
                <p class="mt-1 text-sm text-ink/50" data-preview="lokasi_utama">{{ $lokasiUtama ?: 'Lokasi' }}</p>

                <button onclick="bcGoTo(this, 2)" class="bc-next absolute bottom-6 right-6 w-9 h-9 rounded-full border border-blush/25 text-blush/60 hover:bg-blush hover:text-white transition-all duration-200 flex items-center justify-center">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </button>
            </div>
        @endif
    </div>

    {{-- ============================================================ --}}
    {{-- PAGE 2 — DETAIL ACARA --}}
    {{-- ============================================================ --}}
    <div data-bc-page="2" class="bc-page hidden relative min-h-[420px] overflow-hidden">
        {{-- Balloon vertical left --}}
        <svg class="absolute left-0 top-0 bottom-0 w-16 md:w-20 text-blush/15 pointer-events-none" viewBox="0 0 60 600" fill="none" preserveAspectRatio="none">
            <path d="M8 600 C6 520, 12 440, 8 360 C4 280, 14 200, 8 120 L8 0" stroke="currentColor" stroke-width="0.8" fill="none"/>
            <ellipse cx="10" cy="80" rx="8" ry="11" stroke="currentColor" stroke-width="1" opacity="0.7"/>
            <ellipse cx="6" cy="200" rx="6" ry="9" stroke="currentColor" stroke-width="1" opacity="0.5"/>
            <ellipse cx="10" cy="320" rx="7" ry="10" stroke="currentColor" stroke-width="1" opacity="0.6"/>
            <ellipse cx="6" cy="440" rx="6" ry="9" stroke="currentColor" stroke-width="1" opacity="0.4"/>
            <circle cx="15" cy="120" r="2" fill="currentColor" opacity="0.3"/>
            <circle cx="3" cy="280" r="1.5" fill="currentColor" opacity="0.3"/>
            <circle cx="15" cy="370" r="2" fill="currentColor" opacity="0.3"/>
        </svg>

        <div class="px-10 py-14 md:px-14 md:py-20 text-center relative z-10">
            <p class="font-pinyon text-2xl md:text-3xl text-blush mb-1">~ Detail Acara ~</p>
            <h2 class="font-playfair text-lg md:text-xl font-semibold text-ink tracking-wider uppercase mb-10">Informasi Acara</h2>

            <div class="mb-8">
                <p class="text-[10px] uppercase tracking-[0.2em] text-ink/40 font-medium mb-3">Waktu & Tempat</p>
                <p class="font-playfair text-sm md:text-base text-ink font-medium" data-preview="tanggal_utama">
                    {{ $tanggalUtama ?: '-' }}
                </p>
                <p class="text-xs text-ink/50 mt-1"><span data-preview="jam_utama">{{ $jamUtama ?: '' }}</span></p>
                <p class="text-xs text-ink/50" data-preview="lokasi_utama">{{ $lokasiUtama ?: '' }}</p>
            </div>

            @if($dresscode)
            <div class="w-12 h-px bg-blush/20 mx-auto mb-8"></div>
            <div class="mb-8">
                <p class="text-[10px] uppercase tracking-[0.2em] text-ink/40 font-medium mb-2">Dress Code</p>
                <p class="text-sm text-ink/70" data-preview="dresscode">{{ $dresscode }}</p>
            </div>
            @endif

            @if($catatanTambahan)
            <div class="w-12 h-px bg-blush/20 mx-auto mb-8"></div>
            <div>
                <p class="text-[10px] uppercase tracking-[0.2em] text-ink/40 font-medium mb-2">Catatan</p>
                <p class="text-xs text-ink/50 max-w-xs mx-auto leading-relaxed" data-preview="catatan_tambahan">{{ $catatanTambahan }}</p>
            </div>
            @endif

            <div class="flex items-center justify-center gap-5 mt-10">
                <button onclick="bcGoTo(this, 1)" class="bc-back w-9 h-9 rounded-full border border-ink/15 text-ink/40 hover:bg-ink hover:text-white transition-all duration-200 flex items-center justify-center">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                </button>
                @if($showRsvp)
                <button onclick="bcGoTo(this, 3)" class="bc-next w-9 h-9 rounded-full border border-blush/25 text-blush/60 hover:bg-blush hover:text-white transition-all duration-200 flex items-center justify-center">
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
    <div data-bc-page="3" class="bc-page hidden relative min-h-[480px] overflow-hidden">

        {{-- Top confetti --}}
        <svg class="absolute top-0 left-0 right-0 w-full h-14 text-blush/15 pointer-events-none" viewBox="0 0 400 50" fill="none" preserveAspectRatio="none">
            <path d="M0 35 C60 18, 120 38, 180 22 C240 6, 300 32, 360 16 C380 10, 390 18, 400 12 L400 0 L0 0 Z" fill="currentColor"/>
            <circle cx="50" cy="8" r="2" fill="currentColor" opacity="0.4"/>
            <circle cx="150" cy="4" r="1.5" fill="currentColor" opacity="0.3"/>
            <circle cx="250" cy="10" r="2.5" fill="currentColor" opacity="0.4"/>
            <circle cx="350" cy="5" r="1.5" fill="currentColor" opacity="0.3"/>
        </svg>

        <div class="px-10 py-14 md:px-14 md:py-20 text-center relative z-10">
            <p class="font-pinyon text-2xl md:text-3xl text-blush mb-1">~ Konfirmasi Kehadiran ~</p>
            <h2 class="font-playfair text-lg md:text-xl font-semibold text-ink tracking-wider uppercase mb-2">RSVP</h2>
            <p class="text-xs text-ink/40 mb-8">Mohon konfirmasi kehadiran</p>

            @if ($success)
            <div class="mb-6 p-4 bg-blush/8 text-blush-dark border border-blush/15 text-sm">
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
                    <input type="text" name="nama_tamu" value="{{ old('nama_tamu') }}" placeholder="Tulis namamu..." class="w-full border-blush/15 px-4 py-3 text-sm text-ink placeholder:text-ink/25 focus:border-blush focus:ring-0 rounded-none" required>
                </div>
                <div>
                    <label class="block text-[10px] uppercase tracking-[0.15em] font-medium text-ink/50 mb-2">Konfirmasi Kehadiran</label>
                    <div class="flex gap-3">
                        <label class="flex-1 cursor-pointer">
                            <input type="radio" name="status_hadir" value="hadir" class="sr-only peer" {{ old('status_hadir') == 'hadir' ? 'checked' : '' }} required>
                            <div class="text-center px-4 py-3 border border-blush/15 text-sm text-ink/50 peer-checked:bg-blush peer-checked:text-white peer-checked:border-blush transition-all duration-200 rounded-none">Hadir</div>
                        </label>
                        <label class="flex-1 cursor-pointer">
                            <input type="radio" name="status_hadir" value="tidak_hadir" class="sr-only peer" {{ old('status_hadir') == 'tidak_hadir' ? 'checked' : '' }} required>
                            <div class="text-center px-4 py-3 border border-blush/15 text-sm text-ink/50 peer-checked:bg-ink/70 peer-checked:text-white peer-checked:border-ink/70 transition-all duration-200 rounded-none">Tidak Hadir</div>
                        </label>
                    </div>
                </div>
                <div>
                    <label class="block text-[10px] uppercase tracking-[0.15em] font-medium text-ink/50 mb-1.5">Jumlah Orang <span class="text-ink/25 normal-case">(termasuk kamu)</span></label>
                    <input type="number" name="jumlah_orang" value="{{ old('jumlah_orang', 1) }}" min="1" class="w-full border-blush/15 px-4 py-3 text-sm text-ink focus:border-blush focus:ring-0 rounded-none" required>
                </div>
                <div>
                    <label class="block text-[10px] uppercase tracking-[0.15em] font-medium text-ink/50 mb-1.5">Ucapan & Doa <span class="text-ink/25 normal-case">(opsional)</span></label>
                    <textarea name="ucapan" rows="3" class="w-full border-blush/15 px-4 py-3 text-sm text-ink placeholder:text-ink/25 focus:border-blush focus:ring-0 rounded-none" placeholder="Tulis ucapan selamat...">{{ old('ucapan') }}</textarea>
                </div>
                <button type="submit" class="w-full py-3.5 bg-blush text-white text-sm font-medium tracking-wider uppercase hover:bg-blush-dark transition-colors duration-200 rounded-none">Kirim Konfirmasi</button>
            </form>
            @else
            <form action="{{ route('rsvp.update', $editingRsvp->edit_token) }}" method="POST" class="space-y-5 text-left">
                @csrf
                @method('PUT')
                <p class="text-xs text-ink/40 mb-4 text-center">Edit data RSVP kamu di bawah ini</p>
                <div>
                    <label class="block text-[10px] uppercase tracking-[0.15em] font-medium text-ink/50 mb-1.5">Nama Kamu</label>
                    <input type="text" name="nama_tamu" value="{{ old('nama_tamu', $editingRsvp->nama_tamu) }}" class="w-full border-blush/15 px-4 py-3 text-sm text-ink focus:border-blush focus:ring-0 rounded-none" required>
                </div>
                <div>
                    <label class="block text-[10px] uppercase tracking-[0.15em] font-medium text-ink/50 mb-2">Konfirmasi Kehadiran</label>
                    <div class="flex gap-3">
                        <label class="flex-1 cursor-pointer">
                            <input type="radio" name="status_hadir" value="hadir" class="sr-only peer" {{ old('status_hadir', $editingRsvp->status_hadir) == 'hadir' ? 'checked' : '' }} required>
                            <div class="text-center px-4 py-3 border border-blush/15 text-sm text-ink/50 peer-checked:bg-blush peer-checked:text-white peer-checked:border-blush transition-all duration-200 rounded-none">Hadir</div>
                        </label>
                        <label class="flex-1 cursor-pointer">
                            <input type="radio" name="status_hadir" value="tidak_hadir" class="sr-only peer" {{ old('status_hadir', $editingRsvp->status_hadir) == 'tidak_hadir' ? 'checked' : '' }} required>
                            <div class="text-center px-4 py-3 border border-blush/15 text-sm text-ink/50 peer-checked:bg-ink/70 peer-checked:text-white peer-checked:border-ink/70 transition-all duration-200 rounded-none">Tidak Hadir</div>
                        </label>
                    </div>
                </div>
                <div>
                    <label class="block text-[10px] uppercase tracking-[0.15em] font-medium text-ink/50 mb-1.5">Jumlah Orang <span class="text-ink/25 normal-case">(termasuk kamu)</span></label>
                    <input type="number" name="jumlah_orang" value="{{ old('jumlah_orang', $editingRsvp->jumlah_orang) }}" min="1" class="w-full border-blush/15 px-4 py-3 text-sm text-ink focus:border-blush focus:ring-0 rounded-none" required>
                </div>
                <div>
                    <label class="block text-[10px] uppercase tracking-[0.15em] font-medium text-ink/50 mb-1.5">Ucapan & Doa <span class="text-ink/25 normal-case">(opsional)</span></label>
                    <textarea name="ucapan" rows="3" class="w-full border-blush/15 px-4 py-3 text-sm text-ink placeholder:text-ink/25 focus:border-blush focus:ring-0 rounded-none" placeholder="Tulis ucapan selamat...">{{ old('ucapan', $editingRsvp->ucapan) }}</textarea>
                </div>
                <button type="submit" class="w-full py-3.5 bg-blush text-white text-sm font-medium tracking-wider uppercase hover:bg-blush-dark transition-colors duration-200 rounded-none">Simpan Perubahan</button>
            </form>
            @endif

            <div class="mt-8">
                <button onclick="bcGoTo(this, 2)" class="bc-back w-9 h-9 rounded-full border border-ink/15 text-ink/40 hover:bg-ink hover:text-white transition-all duration-200 flex items-center justify-center mx-auto">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                </button>
            </div>
        </div>

        {{-- Bottom confetti --}}
        <svg class="absolute bottom-0 left-0 right-0 w-full h-14 text-blush/15 pointer-events-none rotate-180" viewBox="0 0 400 50" fill="none" preserveAspectRatio="none">
            <path d="M0 35 C60 18, 120 38, 180 22 C240 6, 300 32, 360 16 C380 10, 390 18, 400 12 L400 0 L0 0 Z" fill="currentColor"/>
            <circle cx="80" cy="6" r="2" fill="currentColor" opacity="0.4"/>
            <circle cx="200" cy="12" r="1.5" fill="currentColor" opacity="0.3"/>
            <circle cx="320" cy="4" r="2.5" fill="currentColor" opacity="0.4"/>
        </svg>
    </div>

    {{-- Wishes --}}
    @if($rsvps->isNotEmpty())
    <div class="border-t border-blush/10">
        <div class="px-10 py-8 md:px-12 text-center">
            <p class="font-pinyon text-lg text-blush mb-1">~ Ucapan & Doa ~</p>
            <h3 class="font-playfair text-xs font-semibold text-ink tracking-wider uppercase mb-5">{{ $rsvps->count() }} Ucapan</h3>
            <div class="space-y-3 max-h-60 overflow-y-auto wishes-scroll pr-1 text-left">
                @foreach ($rsvps as $wish)
                    @if ($wish->ucapan)
                    <div class="pb-3 border-b border-blush/8 last:border-0 last:pb-0">
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
    function bcGoTo(btn, page) {
        var card = btn.closest('.birthday-card');
        if (!card) return;
        card.querySelectorAll('[data-bc-page]').forEach(function(el) {
            var p = parseInt(el.getAttribute('data-bc-page'));
            if (p === page) {
                el.classList.remove('hidden');
                el.classList.remove('bc-page-enter');
                void el.offsetWidth;
                el.classList.add('bc-page-active');
            } else {
                el.classList.remove('bc-page-active');
                el.classList.add('hidden');
            }
        });
    }
</script>
