<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 lg:py-20">
        @if ($errors->any())
            <div class="mb-8 p-4 bg-red-50 text-red-700 border border-red-100 rounded-lg text-sm">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <p class="text-xs uppercase tracking-[0.2em] font-medium text-brass">Edit Undangan</p>
        <h1 class="mt-3 font-display text-3xl lg:text-4xl font-semibold text-ink leading-[1.08] tracking-tight">
            Edit Undangan
        </h1>
        <p class="mt-2 text-sm text-ink/50">Ubah detail, ganti template, atau sesuaikan tata letak undangan.</p>

        <form action="{{ route('events.update', $event) }}" method="POST" enctype="multipart/form-data" class="mt-12">
            @csrf
            @method('PUT')

            <input type="hidden" name="template_id" id="template_id" value="{{ old('template_id', $event->template_id) }}" required>
            <input type="hidden" name="layout_type" id="layout_type" value="{{ old('layout_type', $event->layout_type) }}" required>

            {{-- Step 1: Template Selection --}}
            <div id="section-template" class="hidden">
                <div class="mb-8">
                    <button type="button" onclick="goToSection('form')" class="inline-flex items-center gap-1 text-sm text-ink/40 hover:text-ink transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                        Kembali ke form
                    </button>
                </div>
                <div class="text-center mb-10">
                    <span class="inline-block text-xs uppercase tracking-[0.2em] font-medium text-ink/30">Ganti Template</span>
                    <h2 class="mt-3 font-display text-2xl lg:text-3xl font-semibold text-ink tracking-tight">Ganti Template Undangan</h2>
                    <p class="mt-2 text-sm text-ink/50">Pilih template baru jika ingin mengubah jenis/tampilan undangan.</p>
                </div>

                <div class="flex justify-center gap-3 mb-10">
                    <button type="button" onclick="filterTemplates('pernikahan')" id="tab-pernikahan" class="tab-category px-6 py-2.5 rounded-full text-sm font-medium transition-colors border-2 bg-evergreen text-paper border-evergreen">
                        Pernikahan ({{ $templates->where('event_type', 'pernikahan')->count() }})
                    </button>
                    <button type="button" onclick="filterTemplates('ulang_tahun')" id="tab-ulang_tahun" class="tab-category px-6 py-2.5 rounded-full text-sm font-medium transition-colors border-2 border-mist/60 text-ink/60 hover:border-ink/40">
                        Ulang Tahun ({{ $templates->where('event_type', 'ulang_tahun')->count() }})
                    </button>
                    <button type="button" onclick="filterTemplates('acara_lainnya')" id="tab-acara_lainnya" class="tab-category px-6 py-2.5 rounded-full text-sm font-medium transition-colors border-2 border-mist/60 text-ink/60 hover:border-ink/40">
                        Acara Lainnya ({{ $templates->where('event_type', 'acara_lainnya')->count() }})
                    </button>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($templates as $template)
                        @php
                            $isWeddingTemplate = $template->event_type === 'pernikahan';
                            $isBirthdayTemplate = $template->event_type === 'ulang_tahun';
                            $isOtherTemplate = $template->event_type === 'acara_lainnya';
                            $isSelectedTemplate = old('template_id', $event->template_id) == $template->id;
                            $tName = $template->nama_template;
                            $tLower = strtolower($tName);
                            $isElegan = $isWeddingTemplate && str_contains($tLower, 'elegan');
                            $isKlasik = $isWeddingTemplate && (str_contains($tLower, 'klasik') || str_contains($tLower, 'emas'));
                            $isModern = $isWeddingTemplate && (str_contains($tLower, 'modern') || str_contains($tLower, 'minimalis'));
                            $isCeria = $isBirthdayTemplate && str_contains($tLower, 'ceria');
                            $isPlayful = $isBirthdayTemplate && str_contains($tLower, 'playful');
                            $isFun = $isBirthdayTemplate && str_contains($tLower, 'fun');
                            $isProf = !$isWeddingTemplate && !$isBirthdayTemplate && (str_contains($tLower, 'professional') || str_contains($tLower, 'brass'));
                            $isCasual = !$isWeddingTemplate && !$isBirthdayTemplate && (str_contains($tLower, 'casual') || str_contains($tLower, 'gathering'));

                            $gradientClass = match ($template->preview_thumbnail) {
                                'gradient-evergreen-1' => 'bg-gradient-to-tr from-paper via-stone-200 to-brass-light',
                                'gradient-evergreen-2' => 'bg-gradient-to-bl from-emerald-800 via-evergreen-dark to-brass',
                                'gradient-brass-1' => 'bg-gradient-to-br from-brass-light via-brass to-amber-700',
                                'gradient-brass-2' => 'bg-gradient-to-tr from-brass via-amber-600 to-stone-700',
                                'gradient-blush-1' => 'bg-gradient-to-br from-blush via-rose-700 to-blush-dark',
                                'gradient-blush-2' => 'bg-gradient-to-tr from-violet-700 via-violet-800 to-slate-900',
                                'gradient-navy-1' => 'bg-gradient-to-br from-blue-800 via-indigo-800 to-slate-900',
                                'gradient-forest-1' => 'bg-gradient-to-tr from-teal-700 via-teal-800 to-evergreen',
                                'gradient-slate-1' => 'bg-gradient-to-br from-slate-600 via-slate-700 to-ink',
                                'gradient-emas-1' => 'bg-gradient-to-bl from-amber-600 via-amber-700 to-stone-800',
                                default => $isWeddingTemplate ? 'bg-gradient-to-br from-evergreen to-brass' : ($isBirthdayTemplate ? 'bg-gradient-to-br from-blush to-brass' : 'bg-gradient-to-br from-brass to-brass-light'),
                            };

                            $labelText = $isWeddingTemplate ? 'Pernikahan' : ($isBirthdayTemplate ? 'Ulang Tahun' : ($isProf ? 'Seminar' : 'Makrab'));
                            $shadowEffect = $isElegan ? 'hover:-translate-y-1 hover:shadow-lg hover:shadow-brass/15' : ($isKlasik ? 'hover:-translate-y-1 hover:shadow-lg hover:shadow-amber-700/20' : ($isModern ? 'hover:-translate-y-1 hover:shadow-lg hover:shadow-slate-700/15' : ($isCeria || $isPlayful || $isFun ? 'hover:-translate-y-1 hover:shadow-lg hover:shadow-blush/20' : ($isProf ? 'hover:-translate-y-1 hover:shadow-lg hover:shadow-blue-800/20' : ($isCasual ? 'hover:-translate-y-1 hover:shadow-lg hover:shadow-evergreen/20' : 'hover:-translate-y-1 hover:shadow-lg')))));
                            $buttonClass = $isWeddingTemplate ? 'bg-evergreen text-paper hover:bg-evergreen-dark' : ($isBirthdayTemplate ? 'bg-blush text-white hover:bg-blush-dark' : 'bg-brass text-white hover:bg-brass');

                            if ($isElegan) {
                                $iconSvg = '<svg class="w-12 h-12 text-white/80" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg>';
                            } elseif ($isKlasik) {
                                $iconSvg = '<svg class="w-12 h-12 text-white/80" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M19 3H5L2 9l10 12L22 9l-3-6zM9.62 8l1.5-3h1.76l1.5 3H9.62zM11 10v6.68L5.44 10H11zm2 0h5.56L13 16.68V10zm-2-2H6.27l1.5-3H11v3zm2-3h3.23l1.5 3H13V5z"/></svg>';
                            } elseif ($isModern) {
                                $iconSvg = '<svg class="w-12 h-12 text-white/80" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true"><circle cx="9.5" cy="12" r="5"/><circle cx="14.5" cy="12" r="5"/><path d="M12 7v10"/></svg>';
                            } elseif ($isCeria) {
                                $iconSvg = '<svg class="w-12 h-12 text-white/80" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M20 6h-2.18c.11-.31.18-.65.18-1 0-1.66-1.34-3-3-3-1.05 0-1.96.54-2.5 1.35l-.5.67-.5-.68C10.96 2.54 10.05 2 9 2 7.34 2 6 3.34 6 5c0 .35.07.69.18 1H4c-1.11 0-2 .89-2 2v2c0 .55.45 1 1 1h1v7c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2v-7h1c.55 0 1-.45 1-1V8c0-1.11-.89-2-2-2zm-8-1c.55 0 1 .45 1 1s-.45 1-1 1-1-.45-1-1 .45-1 1-1zM9 4c.55 0 1 .45 1 1s-.45 1-1 1-1-.45-1-1 .45-1 1-1zm-5 4h7v2H4V8zm2 4h5v7H6v-7zm8 7v-7h5v7h-5z"/></svg>';
                            } elseif ($isPlayful) {
                                $iconSvg = '<svg class="w-12 h-12 text-white/80" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M12 2C7.58 2 4 5.58 4 10c0 3.31 2.69 6 6 6v3h4v-3c3.31 0 6-2.69 6-6 0-4.42-3.58-8-8-8z"/><path d="M10 19h4v1c0 .55-.45 1-1 1h-2c-.55 0-1-.45-1-1v-1z"/></svg>';
                            } elseif ($isFun) {
                                $iconSvg = '<svg class="w-12 h-12 text-white/80" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>';
                            } elseif ($isProf) {
                                $iconSvg = '<svg class="w-12 h-12 text-white/80" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M12 3L1 9l11 6 9-4.91V17h2V9L12 3zm0 11.5l-7.5-4.09L12 9.5l7.5 1.91L12 14.5z"/></svg>';
                            } else {
                                $iconSvg = '<svg class="w-12 h-12 text-white/80" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5c-1.66 0-3 1.34-3 3s1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5C6.34 5 5 6.34 5 8s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5zm8 0c-.29 0-.62.02-.97.05 1.16.84 1.97 1.97 1.97 3.45V19h6v-2.5c0-2.33-4.67-3.5-7-3.5z"/></svg>';
                            }
                        @endphp
                        <div class="border {{ $isSelectedTemplate ? 'border-evergreen' : 'border-mist/60' }} rounded-2xl overflow-hidden transition-all duration-300 {{ $shadowEffect }}" data-template-category="{{ $template->event_type }}">
                            <div class="h-40 {{ $gradientClass }} flex items-center justify-center">
                                {!! $iconSvg !!}
                            </div>
                            <div class="p-5">
                                <p class="text-xs uppercase tracking-[0.12em] font-medium text-ink/40 mb-1">{{ $labelText }}</p>
                                <h4 class="font-semibold text-ink mb-1">{{ $template->nama_template }}</h4>
                                <p class="text-xs text-ink/50 mb-5">{{ $template->deskripsi }}</p>
                                <div class="space-y-2.5">
                                    <button type="button" class="w-full px-4 py-2.5 rounded-full text-sm font-medium transition-colors border-2 border-ink/20 text-ink hover:bg-ink/5" onclick="showTemplatePreview('{{ $template->event_type }}', '{{ $template->nama_template }}', {{ $template->id }})">
                                        Lihat Preview
                                    </button>
                                    <button type="button" class="w-full px-4 py-2.5 rounded-full text-sm font-medium transition-colors {{ $buttonClass }}" onclick="selectTemplate({{ $template->id }}, '{{ $template->event_type }}', '{{ $template->nama_template }}')">
                                        {{ $isSelectedTemplate ? 'Template Terpilih' : 'Pilih Template Ini' }}
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Step 2: Layout Selection --}}
            <div id="section-layout" class="hidden">
                <div class="mb-8">
                    <button type="button" onclick="goToSection('form')" class="inline-flex items-center gap-1 text-sm text-ink/40 hover:text-ink transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                        Kembali ke form
                    </button>
                </div>
                <div class="text-center mb-10">
                    <span class="inline-block text-xs uppercase tracking-[0.2em] font-medium text-ink/30">Ganti Layout</span>
                    <h2 class="mt-3 font-display text-2xl lg:text-3xl font-semibold text-ink tracking-tight">Ganti Tata Letak</h2>
                    <p class="mt-2 text-sm text-ink/50">Pilih layout baru untuk undangan ini.</p>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 max-w-4xl mx-auto">
                    <button type="button" class="layout-card group text-left border-2 rounded-2xl p-6 hover:border-evergreen/40 transition-all duration-200" data-layout-card="foto_atas" onclick="selectLayout('foto_atas')"><div class="aspect-[3/4] bg-mist/30 rounded-xl mb-4 overflow-hidden"><div class="h-2/5 bg-ink/10"></div><div class="h-3/5 p-4 flex flex-col items-center justify-center"><div class="w-3/4 h-2 bg-ink/20 rounded mb-2"></div><div class="w-1/2 h-2 bg-ink/20 rounded mb-4"></div><div class="w-full h-1 bg-ink/10 rounded mb-1"></div><div class="w-full h-1 bg-ink/10 rounded"></div></div></div><h4 class="font-display text-lg font-semibold text-ink text-center mb-1">Foto di Atas</h4><p class="text-xs text-ink/50 text-center">Foto penuh lebar, teks di bawah.</p></button>
                    <button type="button" class="layout-card group text-left border-2 rounded-2xl p-6 hover:border-evergreen/40 transition-all duration-200" data-layout-card="foto_samping" onclick="selectLayout('foto_samping')"><div class="aspect-[3/4] bg-mist/30 rounded-xl mb-4 overflow-hidden flex"><div class="w-2/5 bg-ink/10"></div><div class="w-3/5 p-3 flex flex-col justify-center"><div class="w-full h-2 bg-ink/20 rounded mb-2"></div><div class="w-3/4 h-2 bg-ink/20 rounded mb-3"></div><div class="w-full h-1 bg-ink/10 rounded mb-1"></div><div class="w-full h-1 bg-ink/10 rounded"></div></div></div><h4 class="font-display text-lg font-semibold text-ink text-center mb-1">Foto di Samping</h4><p class="text-xs text-ink/50 text-center">Foto kiri, teks kanan.</p></button>
                    <button type="button" class="layout-card group text-left border-2 rounded-2xl p-6 hover:border-evergreen/40 transition-all duration-200" data-layout-card="tanpa_foto" onclick="selectLayout('tanpa_foto')"><div class="aspect-[3/4] bg-mist/30 rounded-xl mb-4 overflow-hidden p-4 flex flex-col items-center justify-center"><svg viewBox="0 0 40 40" fill="currentColor" class="w-8 h-8 mb-3 text-ink/20"><path d="M20 5 L25 15 L35 15 L27 22 L30 32 L20 26 L10 32 L13 22 L5 15 L15 15 Z"/></svg><div class="w-3/4 h-2 bg-ink/20 rounded mb-2"></div><div class="w-1/2 h-2 bg-ink/20 rounded mb-4"></div><div class="w-full h-1 bg-ink/10 rounded mb-1"></div><div class="w-full h-1 bg-ink/10 rounded"></div></div><h4 class="font-display text-lg font-semibold text-ink text-center mb-1">Tanpa Foto</h4><p class="text-xs text-ink/50 text-center">Fokus pada teks dan ornamen.</p></button>
                </div>
            </div>

            {{-- Step 3: Form + Preview --}}
            <div id="section-form">
                <div class="flex items-center justify-between mb-8">
                    <p class="text-sm text-ink/50">Edit detail acara dan lihat preview secara langsung.</p>
                    <div class="flex gap-3 text-sm">
                        <button type="button" onclick="goToSection('template')" class="text-ink/40 hover:text-ink transition-colors underline underline-offset-2">Ganti Template</button>
                        <button type="button" onclick="goToSection('layout')" class="text-ink/40 hover:text-ink transition-colors underline underline-offset-2">Ganti Layout</button>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-10">
                    <div>
                        <div class="space-y-5">
                            <div>
                                <x-input-label for="nama_acara" value="Nama Acara" />
                                <x-text-input id="nama_acara" name="nama_acara" type="text" class="mt-1.5 block w-full" value="{{ old('nama_acara', $event->nama_acara) }}" data-sync="nama_acara" required />
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <x-input-label for="tanggal_utama" value="Tanggal Acara" />
                                    <x-text-input id="tanggal_utama" name="tanggal_utama" type="date" class="mt-1.5 block w-full" value="{{ old('tanggal_utama', $event->tanggal_utama) }}" data-sync="tanggal_utama" required />
                                </div>
                                <div>
                                    <x-input-label for="jam_utama" value="Jam Acara" />
                                    <x-text-input id="jam_utama" name="jam_utama" type="time" class="mt-1.5 block w-full" value="{{ old('jam_utama', \Carbon\Carbon::parse($event->jam_utama)->format('H:i')) }}" data-sync="jam_utama" required />
                                </div>
                            </div>
                            <div>
                                <x-input-label for="lokasi_utama" value="Lokasi Acara" />
                                <x-text-input id="lokasi_utama" name="lokasi_utama" type="text" class="mt-1.5 block w-full" value="{{ old('lokasi_utama', $event->lokasi_utama) }}" data-sync="lokasi_utama" required />
                            </div>
                            <div>
                                <x-input-label for="foto_utama" value="Upload Foto Baru" />
                                <input type="file" name="foto_utama" id="foto_utama" accept="image/*" class="mt-1.5 block w-full text-sm file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-medium file:bg-evergreen file:text-paper hover:file:bg-evergreen-dark" />
                                <p class="mt-1 text-xs text-ink/50">Opsional. Kosongkan jika tidak ingin mengubah foto. Max 2MB.</p>
                                @if($event->foto_utama_url)
                                    <p class="mt-1 text-xs text-evergreen">Foto saat ini sudah ada.</p>
                                @endif
                            </div>

                            <div id="pernikahan-fields" class="{{ old('template_id', $event->template_id) && $event->template->event_type === 'pernikahan' ? '' : 'hidden' }} pt-4 border-t border-mist/60">
                                <h4 class="font-display text-lg font-semibold text-ink mb-4">Detail Pernikahan</h4>
                                <div class="space-y-5">
                                    <div class="grid grid-cols-2 gap-4">
                                        <div>
                                            <x-input-label for="nama_mempelai_pria" value="Mempelai Pria" />
                                            <x-text-input id="nama_mempelai_pria" name="nama_mempelai_pria" type="text" class="mt-1.5 block w-full" value="{{ old('nama_mempelai_pria', $event->nama_mempelai_pria) }}" data-sync="nama_mempelai_pria" />
                                        </div>
                                        <div>
                                            <x-input-label for="nama_mempelai_wanita" value="Mempelai Wanita" />
                                            <x-text-input id="nama_mempelai_wanita" name="nama_mempelai_wanita" type="text" class="mt-1.5 block w-full" value="{{ old('nama_mempelai_wanita', $event->nama_mempelai_wanita) }}" data-sync="nama_mempelai_wanita" />
                                        </div>
                                    </div>
                                    <div class="grid grid-cols-2 gap-4">
                                        <div>
                                            <x-input-label for="nama_ortu_pria" value="Orang Tua Pria" />
                                            <x-text-input id="nama_ortu_pria" name="nama_ortu_pria" type="text" class="mt-1.5 block w-full" value="{{ old('nama_ortu_pria', $event->nama_ortu_pria) }}" data-sync="nama_ortu_pria" />
                                        </div>
                                        <div>
                                            <x-input-label for="nama_ortu_wanita" value="Orang Tua Wanita" />
                                            <x-text-input id="nama_ortu_wanita" name="nama_ortu_wanita" type="text" class="mt-1.5 block w-full" value="{{ old('nama_ortu_wanita', $event->nama_ortu_wanita) }}" data-sync="nama_ortu_wanita" />
                                        </div>
                                    </div>
                                    <div class="pt-2">
                                        <p class="text-sm font-medium text-ink/70 mb-3">Detail Resepsi</p>
                                        <div class="grid grid-cols-2 gap-4 mb-4">
                                            <div>
                                                <x-input-label for="tanggal_resepsi" value="Tanggal Resepsi" />
                                                <x-text-input id="tanggal_resepsi" name="tanggal_resepsi" type="date" class="mt-1.5 block w-full" value="{{ old('tanggal_resepsi', $event->tanggal_resepsi) }}" data-sync="tanggal_resepsi" />
                                            </div>
                                            <div>
                                                <x-input-label for="jam_resepsi" value="Jam Resepsi" />
                                                <x-text-input id="jam_resepsi" name="jam_resepsi" type="time" class="mt-1.5 block w-full" value="{{ old('jam_resepsi', $event->jam_resepsi ? \Carbon\Carbon::parse($event->jam_resepsi)->format('H:i') : '') }}" data-sync="jam_resepsi" />
                                            </div>
                                        </div>
                                        <div>
                                            <x-input-label for="lokasi_resepsi" value="Lokasi Resepsi" />
                                            <x-text-input id="lokasi_resepsi" name="lokasi_resepsi" type="text" class="mt-1.5 block w-full" value="{{ old('lokasi_resepsi', $event->lokasi_resepsi) }}" data-sync="lokasi_resepsi" />
                                        </div>
                                    </div>
                                </div>
                            </div>

                            @php
                                $tmplName = $event->template->nama_template ?? '';
                                $isSeminarTmpl = str_contains(strtolower($tmplName), 'professional') || str_contains(strtolower($tmplName), 'brass');
                                $isMakrabTmpl = str_contains(strtolower($tmplName), 'casual') || str_contains(strtolower($tmplName), 'gathering');
                                $showSeminar = old('template_id', $event->template_id) && $event->template->event_type === 'acara_lainnya' && $isSeminarTmpl;
                                $showMakrab = old('template_id', $event->template_id) && $event->template->event_type === 'acara_lainnya' && $isMakrabTmpl;
                            @endphp
                            <div id="seminar-fields" class="{{ $showSeminar ? '' : 'hidden' }} pt-4 border-t border-mist/60">
                                <h4 class="font-display text-lg font-semibold text-ink mb-4">Detail Seminar</h4>
                                <div class="space-y-5">
                                    <div>
                                        <x-input-label for="nama_pembicara" value="Nama Pembicara" />
                                        <textarea id="nama_pembicara" name="nama_pembicara" rows="2" class="mt-1.5 block w-full border-mist rounded-lg focus:border-blue-800 focus:ring-blue-800" placeholder="Contoh: Dr. John Doe, Jane Smith">{{ old('nama_pembicara', $event->nama_pembicara) }}</textarea>
                                        <p class="mt-1 text-xs text-ink/50">Pisahkan dengan koma jika lebih dari satu</p>
                                    </div>
                                    <div>
                                        <x-input-label for="topik_agenda" value="Topik / Agenda" />
                                        <textarea id="topik_agenda" name="topik_agenda" rows="3" class="mt-1.5 block w-full border-mist rounded-lg focus:border-blue-800 focus:ring-blue-800" placeholder="Contoh: Pembahasan strategi marketing digital 2026">{{ old('topik_agenda', $event->topik_agenda) }}</textarea>
                                        <p class="mt-1 text-xs text-ink/50">Deskripsi singkat tentang topik acara</p>
                                    </div>
                                    <div>
                                        <x-input-label for="kapasitas_peserta" value="Kapasitas Peserta" />
                                        <x-text-input id="kapasitas_peserta" name="kapasitas_peserta" type="number" class="mt-1.5 block w-full" value="{{ old('kapasitas_peserta', $event->kapasitas_peserta) }}" placeholder="Contoh: 50" />
                                        <p class="mt-1 text-xs text-ink/50">Jumlah maksimal peserta</p>
                                    </div>
                                    <div>
                                        <x-input-label for="dresscode" value="Dress Code" />
                                        <select id="dresscode" name="dresscode" class="mt-1.5 block w-full border-mist rounded-lg focus:border-blue-800 focus:ring-blue-800">
                                            <option value="">-- Pilih Dress Code --</option>
                                            <option value="Formal" {{ old('dresscode', $event->dresscode) == 'Formal' ? 'selected' : '' }}>Formal</option>
                                            <option value="Business Casual" {{ old('dresscode', $event->dresscode) == 'Business Casual' ? 'selected' : '' }}>Business Casual</option>
                                            <option value="Smart Casual" {{ old('dresscode', $event->dresscode) == 'Smart Casual' ? 'selected' : '' }}>Smart Casual</option>
                                        </select>
                                    </div>
                                    <div>
                                        <x-input-label for="catatan_tambahan" value="Catatan Tambahan" />
                                        <textarea id="catatan_tambahan" name="catatan_tambahan" rows="3" class="mt-1.5 block w-full border-mist rounded-lg focus:border-blue-800 focus:ring-blue-800" placeholder="Contoh: Mohon membawa laptop, sertifikat akan diberikan di akhir acara">{{ old('catatan_tambahan', $event->catatan_tambahan) }}</textarea>
                                        <p class="mt-1 text-xs text-ink/50">Informasi tambahan untuk peserta</p>
                                    </div>
                                </div>
                            </div>

                            <div id="makrab-fields" class="{{ $showMakrab ? '' : 'hidden' }} pt-4 border-t border-mist/60">
                                <h4 class="font-display text-lg font-semibold text-ink mb-4">Detail Makrab</h4>
                                <div class="space-y-5">
                                    <div>
                                        <x-input-label for="kapasitas_peserta" value="Perkiraan Jumlah Peserta" />
                                        <x-text-input id="kapasitas_peserta" name="kapasitas_peserta" type="number" class="mt-1.5 block w-full" value="{{ old('kapasitas_peserta', $event->kapasitas_peserta) }}" placeholder="Contoh: 30" />
                                        <p class="mt-1 text-xs text-ink/50">Perkiraan jumlah teman yang hadir</p>
                                    </div>
                                    <div>
                                        <x-input-label for="dresscode" value="Dress Code" />
                                        <select id="dresscode" name="dresscode" class="mt-1.5 block w-full border-mist rounded-lg focus:border-evergreen focus:ring-evergreen">
                                            <option value="">-- Pilih Dress Code --</option>
                                            <option value="Casual" {{ old('dresscode', $event->dresscode) == 'Casual' ? 'selected' : '' }}>Casual</option>
                                            <option value="Bebas" {{ old('dresscode', $event->dresscode) == 'Bebas' ? 'selected' : '' }}>Bebas / Santai</option>
                                            <option value="Tematik" {{ old('dresscode', $event->dresscode) == 'Tematik' ? 'selected' : '' }}>Tematik</option>
                                        </select>
                                    </div>
                                    <div>
                                        <x-input-label for="catatan_tambahan" value="Catatan Tambahan" />
                                        <textarea id="catatan_tambahan" name="catatan_tambahan" rows="3" class="mt-1.5 block w-full border-mist rounded-lg focus:border-evergreen focus:ring-evergreen" placeholder="Contoh: Bawa baju ganti, jaga kebersihan, dan bawa semangat!">{{ old('catatan_tambahan', $event->catatan_tambahan) }}</textarea>
                                        <p class="mt-1 text-xs text-ink/50">Informasi tambahan untuk peserta makrab</p>
                                    </div>
                                </div>
                            </div>

                            {{-- Musik Latar --}}
                            <div class="pt-4 border-t border-mist/60">
                                @if (auth()->user()->isPlus())
                                    <h4 class="font-display text-lg font-semibold text-ink mb-4 flex items-center gap-2">
                                        <svg class="w-5 h-5 text-evergreen" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"/></svg>
                                        Musik Latar
                                    </h4>
                                    <div class="space-y-4">
                                        @if ($event->musics->isNotEmpty())
                                            <div class="flex items-center gap-3 p-3 bg-evergreen/5 border border-evergreen/15 rounded-lg">
                                                <svg class="w-5 h-5 text-evergreen shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2z"/></svg>
                                                <span class="text-sm text-ink/70 flex-1 truncate">{{ $event->musics->first()->judul ?? 'Musik terpasang' }}</span>
                                                <span class="text-xs text-ink/40">Terpasang</span>
                                            </div>
                                        @endif
                                        <div>
                                            <x-input-label for="musik" value="{{ $event->musics->isNotEmpty() ? 'Ganti Musik' : 'Upload Musik' }}" />
                                            <input type="file" name="musik" id="musik" accept="audio/*" class="mt-1.5 block w-full text-sm file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-medium file:bg-evergreen file:text-paper hover:file:bg-evergreen-dark" />
                                            <p class="mt-1 text-xs text-ink/50">MP3, WAV, OGG, AAC. Max 10MB. Upload ulang untuk mengganti musik.</p>
                                        </div>
                                        <div class="flex items-center gap-2">
                                            <input type="checkbox" name="auto_play" id="auto_play" value="1" {{ $event->musics->first()->auto_play ?? true ? 'checked' : '' }} class="rounded border-mist/60 text-evergreen focus:ring-evergreen" />
                                            <label for="auto_play" class="text-sm text-ink/70">Putar otomatis saat halaman undangan dibuka</label>
                                        </div>
                                    </div>
                                @else
                                    <div class="bg-ink/5 rounded-xl p-5 text-center">
                                        <svg class="w-8 h-8 mx-auto text-ink/20 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"/></svg>
                                        <p class="text-sm font-medium text-ink/40 mb-1">🎵 Musik Latar</p>
                                        <p class="text-xs text-ink/30 mb-4">Tambahkan lagu favorit ke undanganmu. Fitur eksklusif untuk pengguna Plus.</p>
                                        <form action="{{ route('subscription.upgrade') }}" method="POST">
                                            @csrf
                                            <button type="submit" class="inline-flex items-center gap-1.5 px-5 py-2 bg-evergreen text-paper text-sm font-medium rounded-full hover:bg-evergreen-dark transition-colors">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                                                Aktifkan Plus — Gratis
                                            </button>
                                        </form>
                                    </div>
                                @endif
                            </div>

                            <div class="flex gap-3 pt-6 border-t border-mist/60">
                                <button type="submit" class="flex-1 px-6 py-3 bg-evergreen text-paper font-medium rounded-full hover:bg-evergreen-dark transition-colors duration-200 text-sm shadow-sm">Simpan Perubahan</button>
                                <a href="{{ route('events.show', $event) }}" class="px-6 py-3 text-ink/70 hover:text-ink font-medium rounded-full border border-ink/15 hover:border-ink/30 transition-colors duration-200 text-sm">Batal</a>
                            </div>
                        </div>
                    </div>

                    <div class="lg:sticky lg:top-24 h-fit">
                        <div class="bg-paper border border-mist/60 rounded-2xl p-6">
                            <p class="text-xs tracking-[0.12em] font-medium text-ink/40 uppercase text-center mb-4">Preview Undangan</p>
                            <div id="live-preview-wrapper">
                                @foreach(['foto_atas', 'foto_samping', 'tanpa_foto'] as $previewLayoutType)
                                    <div class="preview-variant hidden" data-preview-event-type="ulang_tahun" data-preview-layout-type="{{ $previewLayoutType }}">
                                        <x-invitation-birthday-card
                                            layoutType="{{ $previewLayoutType }}"
                                            :namaAcara="$event->nama_acara"
                                            :tanggalUtama="$event->tanggal_utama ? \Carbon\Carbon::parse($event->tanggal_utama)->translatedFormat('d F Y') : ''"
                                            :jamUtama="$event->jam_utama ? \Carbon\Carbon::parse($event->jam_utama)->format('H:i').' WIB' : ''"
                                            :lokasiUtama="$event->lokasi_utama"
                                            :dresscode="$event->dresscode"
                                            :catatanTambahan="$event->catatan_tambahan"
                                            :fotoUrl="$event->foto_utama_url"
                                            :showRsvp="false"
                                        />
                                    </div>
                                @endforeach
                                @foreach(['foto_atas', 'foto_samping', 'tanpa_foto'] as $previewLayoutType)
                                    <div class="preview-variant hidden" data-preview-event-type="acara_lainnya" data-preview-layout-type="{{ $previewLayoutType }}">
                                        <x-invitation-event-card
                                            layoutType="{{ $previewLayoutType }}"
                                            :namaAcara="$event->nama_acara"
                                            :tanggalUtama="$event->tanggal_utama ? \Carbon\Carbon::parse($event->tanggal_utama)->translatedFormat('d F Y') : ''"
                                            :jamUtama="$event->jam_utama ? \Carbon\Carbon::parse($event->jam_utama)->format('H:i').' WIB' : ''"
                                            :lokasiUtama="$event->lokasi_utama"
                                            :namaPembicara="$event->nama_pembicara"
                                            :kapasitasPeserta="$event->kapasitas_peserta"
                                            :topikAgenda="$event->topik_agenda"
                                            :dresscode="$event->dresscode"
                                            :catatanTambahan="$event->catatan_tambahan"
                                            :fotoUrl="$event->foto_utama_url"
                                            :showRsvp="false"
                                            :templateName="$event->template->nama_template"
                                        />
                                    </div>
                                @endforeach
                                @foreach(['foto_atas', 'foto_samping', 'tanpa_foto'] as $previewLayoutType)
                                    <div class="preview-variant hidden" data-preview-event-type="pernikahan" data-preview-layout-type="{{ $previewLayoutType }}">
                                        <x-invitation-wedding-card
                                            layoutType="{{ $previewLayoutType }}"
                                            :namaMempelaiWanita="$event->nama_mempelai_wanita"
                                            :namaMempelaiPria="$event->nama_mempelai_pria"
                                            :namaOrtuWanita="$event->nama_ortu_wanita"
                                            :namaOrtuPria="$event->nama_ortu_pria"
                                            :tanggalUtama="$event->tanggal_utama ? \Carbon\Carbon::parse($event->tanggal_utama)->translatedFormat('l, d F Y') : ''"
                                            :jamUtama="$event->jam_utama ? \Carbon\Carbon::parse($event->jam_utama)->format('H:i').' WIB' : ''"
                                            :lokasiUtama="$event->lokasi_utama"
                                            :tanggalResepsi="$event->tanggal_resepsi ? \Carbon\Carbon::parse($event->tanggal_resepsi)->translatedFormat('l, d F Y') : ''"
                                            :jamResepsi="$event->jam_resepsi ? \Carbon\Carbon::parse($event->jam_resepsi)->format('H:i').' WIB' : ''"
                                            :lokasiResepsi="$event->lokasi_resepsi"
                                            :dresscode="$event->dresscode"
                                            :catatanTambahan="$event->catatan_tambahan"
                                            :fotoUrl="$event->foto_utama_url"
                                            :showRsvp="false"
                                            :templateName="$event->template->nama_template"
                                        />
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>

        {{-- Preview Modal --}}
        <x-preview-modal id="template-preview-modal" />
        <div class="hidden" id="template-preview-source">
            @foreach($templates as $template)
                @foreach(['foto_atas', 'foto_samping', 'tanpa_foto'] as $previewLayoutType)
                    <div data-modal-template-id="{{ $template->id }}" data-modal-layout-type="{{ $previewLayoutType }}">
                        <x-invitation-card
                            :eventType="$template->event_type"
                            :layoutType="$previewLayoutType"
                            :templateName="$template->nama_template"
                            namaAcara="{{ $template->event_type === 'acara_lainnya' ? 'Workshop Digital Marketing' : ($template->event_type === 'ulang_tahun' ? 'Ulang Tahun ke-25' : 'Pernikahan Kami') }}"
                            tanggalUtama="15 Agustus 2026"
                            jamUtama="10:00"
                            lokasiUtama="Grand Ballroom, Jakarta"
                            namaMempelaiPria="Ahmad"
                            namaMempelaiWanita="Sarah"
                            namaOrtuPria="Bapak Hasan & Ibu Aminah"
                            namaOrtuWanita="Bapak Budi & Ibu Sari"
                        />
                    </div>
                @endforeach
            @endforeach
        </div>
    </div>

    @push('scripts')
        <script>
            let activeCategory = 'pernikahan';
            let selectedEventType = '{{ $event->template->event_type }}';
            let selectedLayoutType = '{{ old('layout_type', $event->layout_type) }}';

            function showTemplatePreview(eventType, templateName, templateId) {
                const modalContent = document.getElementById('template-preview-modal-content');
                let previewHTML = '<div class="space-y-6">';
                previewHTML += '<p class="text-sm text-ink/60">Preview live template <strong>' + templateName + '</strong> dengan data contoh. Setiap layout memakai gaya visual template yang sama.</p>';

                ['foto_atas', 'foto_samping', 'tanpa_foto'].forEach(layout => {
                    const layoutLabel = layout === 'foto_atas' ? 'Foto di Atas' : (layout === 'foto_samping' ? 'Foto di Samping' : 'Tanpa Foto');
                    const source = document.querySelector('[data-modal-template-id="' + templateId + '"][data-modal-layout-type="' + layout + '"]');
                    previewHTML += '<div><h4 class="text-sm font-semibold text-ink mb-3 uppercase tracking-wider">Layout: ' + layoutLabel + '</h4>';
                    previewHTML += source ? source.innerHTML : '<p class="text-sm text-red-600">Preview tidak tersedia.</p>';
                    previewHTML += '</div>';
                });

                previewHTML += '</div>';
                modalContent.innerHTML = previewHTML;
                openModal('template-preview-modal');
            }

            function filterTemplates(category) {
                activeCategory = category;

                document.querySelectorAll('.tab-category').forEach(tab => {
                    const isActive = tab.id === 'tab-' + category;
                    if (isActive) {
                        if (category === 'pernikahan') {
                            tab.className = 'tab-category px-6 py-2.5 rounded-full text-sm font-medium transition-colors border-2 bg-evergreen text-paper border-evergreen';
                        } else if (category === 'ulang_tahun') {
                            tab.className = 'tab-category px-6 py-2.5 rounded-full text-sm font-medium transition-colors border-2 bg-blush text-white border-blush';
                        } else if (category === 'acara_lainnya') {
                            tab.className = 'tab-category px-6 py-2.5 rounded-full text-sm font-medium transition-colors border-2 bg-brass text-white border-brass';
                        }
                    } else {
                        tab.className = 'tab-category px-6 py-2.5 rounded-full text-sm font-medium transition-colors border-2 border-mist/60 text-ink/60 hover:border-ink/40';
                    }
                });

                document.querySelectorAll('[data-template-category]').forEach(card => {
                    if (card.dataset.templateCategory === category) {
                        card.classList.remove('hidden');
                    } else {
                        card.classList.add('hidden');
                    }
                });
            }

            function goToSection(section) {
                document.getElementById('section-template').classList.toggle('hidden', section !== 'template');
                document.getElementById('section-layout').classList.toggle('hidden', section !== 'layout');
                document.getElementById('section-form').classList.toggle('hidden', section !== 'form');
            }

            function selectTemplate(templateId, eventType, templateName) {
                document.getElementById('template_id').value = templateId;
                selectedEventType = eventType;

                document.getElementById('pernikahan-fields').classList.toggle('hidden', eventType !== 'pernikahan');
                document.getElementById('seminar-fields').classList.toggle('hidden', eventType !== 'acara_lainnya' || !templateName || !templateName.includes('Professional'));
                document.getElementById('makrab-fields').classList.toggle('hidden', eventType !== 'acara_lainnya' || !templateName || !templateName.includes('Casual'));

                updatePreviewVisibility();
                syncAllFields();
                goToSection('form');
            }

            function selectLayout(layoutType) {
                document.getElementById('layout_type').value = layoutType;
                selectedLayoutType = layoutType;
                updateLayoutCards();
                updatePreviewVisibility();
                syncAllFields();
                goToSection('form');
            }

            function updateLayoutCards() {
                document.querySelectorAll('[data-layout-card]').forEach(card => {
                    card.classList.toggle('border-evergreen', card.dataset.layoutCard === selectedLayoutType);
                    card.classList.toggle('border-mist/60', card.dataset.layoutCard !== selectedLayoutType);
                });
            }

            function updatePreviewVisibility() {
                document.querySelectorAll('.preview-variant').forEach(variant => {
                    variant.classList.toggle('hidden', variant.dataset.previewEventType !== selectedEventType || variant.dataset.previewLayoutType !== selectedLayoutType);
                });
            }

            function formatDate(value) {
                if (!value) return '-';
                const date = new Date(value + 'T00:00:00');
                return date.toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' });
            }

            function syncField(input) {
                const value = input.type === 'date' ? formatDate(input.value) : (input.value || '-');
                document.querySelectorAll('[data-preview="' + input.dataset.sync + '"]').forEach(target => {
                    target.textContent = value;
                });
            }

            function syncAllFields() {
                document.querySelectorAll('[data-sync]').forEach(syncField);
            }

            document.addEventListener('DOMContentLoaded', () => {
                filterTemplates('pernikahan');
                updateLayoutCards();
                updatePreviewVisibility();
                syncAllFields();

                document.querySelectorAll('[data-sync]').forEach(input => {
                    input.addEventListener('input', () => syncField(input));
                    input.addEventListener('change', () => syncField(input));
                });

                document.getElementById('foto_utama').addEventListener('change', event => {
                    const file = event.target.files && event.target.files[0];
                    if (!file) return;
                    const url = URL.createObjectURL(file);
                    document.querySelectorAll('[data-preview-img="foto_utama"]').forEach(element => {
                        if (element.tagName === 'IMG') {
                            element.src = url;
                        } else {
                            element.innerHTML = '<img src="' + url + '" alt="Foto Acara" class="w-full h-full object-cover">';
                        }
                    });
                });
            });
        </script>
    @endpush
</x-app-layout>