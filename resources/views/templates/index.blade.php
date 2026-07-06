<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 lg:py-20">
        <div class="flex items-end justify-between">
            <div>
                <p class="text-xs uppercase tracking-[0.2em] font-medium text-brass">Template</p>
                <h1 class="mt-3 font-display text-3xl lg:text-4xl font-semibold text-ink leading-[1.08] tracking-tight">
                    Semua Template
                </h1>
                <p class="mt-2 text-sm text-ink/50">Pilih template undangan untuk acara kamu.</p>
            </div>
            <a href="{{ route('events.create') }}" class="inline-flex items-center px-6 py-3 bg-evergreen text-paper font-medium rounded-full hover:bg-evergreen-dark transition-colors duration-200 text-sm shadow-sm">
                + Buat Undangan
            </a>
        </div>

        @if ($templates->isEmpty())
            <div class="mt-16 text-center py-16">
                <p class="text-2xl font-semibold text-ink">Belum ada template</p>
            </div>
        @else
            <div class="mt-12 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($templates as $template)
                    @php
                        $isWedding = $template->event_type === 'pernikahan';
                        $isBirthday = $template->event_type === 'ulang_tahun';
                        $tName = $template->nama_template;
                        $tLower = strtolower($tName);
                        $isElegan = $isWedding && str_contains($tLower, 'elegan');
                        $isKlasik = $isWedding && (str_contains($tLower, 'klasik') || str_contains($tLower, 'emas'));
                        $isModern = $isWedding && (str_contains($tLower, 'modern') || str_contains($tLower, 'minimalis'));
                        $isCeria = $isBirthday && str_contains($tLower, 'ceria');
                        $isPlayful = $isBirthday && str_contains($tLower, 'playful');
                        $isFun = $isBirthday && str_contains($tLower, 'fun');
                        $isProf = !$isWedding && !$isBirthday && (str_contains($tLower, 'professional') || str_contains($tLower, 'brass'));
                        $isCasual = !$isWedding && !$isBirthday && (str_contains($tLower, 'casual') || str_contains($tLower, 'gathering'));

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
                            default => $isWedding ? 'bg-gradient-to-br from-evergreen to-brass' : ($isBirthday ? 'bg-gradient-to-br from-blush to-brass' : 'bg-gradient-to-br from-brass to-brass-light'),
                        };
                        $labelText = $isWedding ? 'Pernikahan' : ($isBirthday ? 'Ulang Tahun' : ($isProf ? 'Seminar' : 'Makrab'));
                        $shadowEffect = $isElegan ? 'hover:-translate-y-1 hover:shadow-lg hover:shadow-brass/15' : ($isKlasik ? 'hover:-translate-y-1 hover:shadow-lg hover:shadow-amber-700/20' : ($isModern ? 'hover:-translate-y-1 hover:shadow-lg hover:shadow-slate-700/15' : ($isCeria || $isPlayful || $isFun ? 'hover:-translate-y-1 hover:shadow-lg hover:shadow-blush/20' : ($isProf ? 'hover:-translate-y-1 hover:shadow-lg hover:shadow-blue-800/20' : ($isCasual ? 'hover:-translate-y-1 hover:shadow-lg hover:shadow-evergreen/20' : 'hover:-translate-y-1 hover:shadow-lg')))));
                        $buttonClass = $isWedding ? 'bg-evergreen text-paper hover:bg-evergreen-dark' : ($isBirthday ? 'bg-blush text-white hover:bg-blush-dark' : 'bg-brass text-white hover:bg-brass');

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
                    <div class="border border-mist/60 rounded-2xl overflow-hidden transition-all duration-300 {{ $shadowEffect }} group">
                        <div class="h-40 {{ $gradientClass }} flex items-center justify-center">
                            {!! $iconSvg !!}
                        </div>
                        <div class="p-5">
                            <p class="text-xs uppercase tracking-[0.12em] font-medium text-ink/40 mb-1">{{ $labelText }}</p>
                            <h4 class="font-semibold text-ink mb-1 group-hover:text-ink/80 transition-colors">{{ $template->nama_template }}</h4>
                            <p class="text-xs text-ink/50 mb-5">{{ $template->deskripsi }}</p>
                            <div class="space-y-2.5">
                                <a href="{{ route('templates.show', $template) }}" class="block w-full text-center px-4 py-2.5 rounded-full text-sm font-medium transition-colors border-2 border-ink/20 text-ink hover:bg-ink/5">
                                    Lihat Detail
                                </a>
                                <a href="{{ route('events.create') }}?template={{ $template->id }}" class="block w-full text-center px-4 py-2.5 rounded-full text-sm font-medium transition-colors {{ $buttonClass }}">
                                    Gunakan Template
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</x-app-layout>