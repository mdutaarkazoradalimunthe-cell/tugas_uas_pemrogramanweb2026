<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'MESH') }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,500;9..144,600;9..144,700&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased">
    <nav x-data="{ open: false, scrolled: false }"
         x-init="window.addEventListener('scroll', () => { scrolled = window.scrollY > 80 })"
         class="fixed top-0 left-0 right-0 z-50 transition-all duration-300"
         :class="scrolled ? 'bg-white/95 backdrop-blur-lg shadow-sm border-b border-mist/40' : 'bg-transparent'">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16 lg:h-20">

                <div class="shrink-0 flex items-center">
                    <a href="/" class="flex items-center gap-2.5 transition-opacity duration-150 hover:opacity-80">
                        <span :class="scrolled ? 'text-evergreen' : 'text-white'">
                            <x-application-logo class="block h-8 w-8 drop-shadow-sm" />
                        </span>
                        <span :class="scrolled ? 'text-ink' : 'text-white/90'" class="hidden sm:inline font-display text-lg font-semibold tracking-tight">MESH</span>
                    </a>
                </div>

                <div class="hidden md:flex items-center gap-8">
                    <a href="/" :class="scrolled ? 'text-ink/60 hover:text-evergreen' : 'text-white/70 hover:text-white'" class="text-sm font-medium transition-colors duration-200">Beranda</a>
                    <a href="#tentang" :class="scrolled ? 'text-ink/60 hover:text-evergreen' : 'text-white/70 hover:text-white'" class="text-sm font-medium transition-colors duration-200">Tentang</a>
                    <a href="#cara-kerja" :class="scrolled ? 'text-ink/60 hover:text-evergreen' : 'text-white/70 hover:text-white'" class="text-sm font-medium transition-colors duration-200">Cara Kerja</a>
                    <a href="#cta" :class="scrolled ? 'text-ink/60 hover:text-evergreen' : 'text-white/70 hover:text-white'" class="text-sm font-medium transition-colors duration-200">Mulai</a>
                </div>

                <div class="hidden md:flex items-center gap-3">
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}" class="inline-flex items-center px-5 py-2 text-sm font-medium text-white bg-white/10 hover:bg-white/20 rounded-full transition-colors duration-200">Dashboard</a>
                        @else
                            <a href="{{ route('login') }}"
                               :class="scrolled ? 'border-ink/20 text-ink hover:border-ink/40' : 'border-white/30 text-white/80 hover:border-white/60 hover:text-white'"
                               class="inline-flex items-center px-5 py-2 text-sm font-medium border rounded-full transition-colors duration-200">
                                Masuk
                            </a>
                            <a href="{{ route('register') }}"
                               :class="scrolled ? 'bg-evergreen text-paper hover:bg-evergreen-dark shadow-sm' : 'bg-white text-evergreen hover:bg-white/90'"
                               class="inline-flex items-center px-5 py-2 text-sm font-medium rounded-full transition-colors duration-200 shadow-sm">
                                Daftar
                            </a>
                        @endauth
                    @endif
                </div>

                <div class="flex md:hidden items-center">
                    <button @click="open = !open" :class="scrolled ? 'text-ink/60' : 'text-white/80 hover:text-white'" class="inline-flex items-center justify-center p-2 transition-colors duration-200 focus:outline-none">
                        <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                            <path :class="{'hidden': open, 'inline-flex': !open}" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            <path :class="{'hidden': !open, 'inline-flex': open}" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <div x-show="open" @click.outside="open = false" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 -translate-y-2" class="md:hidden bg-white/95 backdrop-blur-lg border-t border-mist/40 shadow-sm">
            <div class="px-4 py-4 space-y-2">
                <a href="/" class="block px-4 py-2.5 text-sm font-medium text-ink/70 hover:text-evergreen hover:bg-evergreen/5 rounded-lg transition-colors">Beranda</a>
                <a href="#tentang" class="block px-4 py-2.5 text-sm font-medium text-ink/70 hover:text-evergreen hover:bg-evergreen/5 rounded-lg transition-colors">Tentang</a>
                <a href="#cara-kerja" class="block px-4 py-2.5 text-sm font-medium text-ink/70 hover:text-evergreen hover:bg-evergreen/5 rounded-lg transition-colors">Cara Kerja</a>
                <a href="#cta" class="block px-4 py-2.5 text-sm font-medium text-ink/70 hover:text-evergreen hover:bg-evergreen/5 rounded-lg transition-colors">Mulai</a>
                <div class="pt-3 border-t border-mist/60 space-y-2">
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}" class="block w-full text-center px-4 py-2.5 text-sm font-medium text-white bg-evergreen hover:bg-evergreen-dark rounded-lg transition-colors">Dashboard</a>
                        @else
                            <a href="{{ route('login') }}" class="block w-full text-center px-4 py-2.5 text-sm font-medium text-ink border border-ink/20 hover:border-ink/40 rounded-lg transition-colors">Masuk</a>
                            <a href="{{ route('register') }}" class="block w-full text-center px-4 py-2.5 text-sm font-medium text-paper bg-evergreen hover:bg-evergreen-dark rounded-lg transition-colors">Daftar</a>
                        @endauth
                    @endif
                </div>
            </div>
        </div>
    </nav>

    {{-- Hero --}}
    <section class="relative min-h-screen flex items-center justify-center overflow-hidden">
        <div class="absolute inset-0">
            <img src="{{ asset('images/gambar-pernikahan.jpg') }}" alt="" class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-gradient-to-b from-black/40 via-black/55 to-black/70"></div>
        </div>

        <div class="relative z-10 text-center px-4 sm:px-6 max-w-4xl mx-auto pt-24 pb-16">
            <h1 class="font-display text-5xl sm:text-6xl lg:text-7xl font-semibold text-white leading-tight tracking-tight">
                Undangan Digitalmu,<br>
                <span class="text-brass-light">Dalam Satu Genggaman</span>
            </h1>
            <p class="mt-6 text-base sm:text-lg lg:text-xl text-white/70 max-w-2xl mx-auto leading-relaxed">
                Buat undangan online yang elegan, bagikan ke tamu dengan mudah, dan pantau konfirmasi kehadiran secara real-time.
            </p>
            <div class="mt-10 flex flex-col sm:flex-row items-center justify-center gap-4">
                <a href="{{ route('register') }}" class="inline-flex items-center px-8 py-3.5 bg-evergreen text-paper font-medium rounded-full hover:bg-evergreen-dark transition-colors duration-200 text-base shadow-lg shadow-black/20">
                    Buat Undangan Gratis
                </a>
                <a href="{{ route('login') }}" class="inline-flex items-center px-6 py-3.5 text-white/70 hover:text-white font-medium transition-colors duration-200 text-base group">
                    Lihat Contoh
                    <svg class="ml-2 w-4 h-4 transition-transform duration-200 group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                    </svg>
                </a>
            </div>
        </div>
    </section>

    {{-- Tentang --}}
    <section id="tentang" class="py-28 lg:py-36 bg-paper">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="max-w-3xl">
                <p class="text-xs uppercase tracking-[0.25em] font-medium text-brass">Tentang</p>
                <h2 class="mt-6 font-display text-5xl lg:text-6xl font-semibold text-ink leading-[1.08] tracking-tight">
                    Merayakan kebersamaan,<br>
                    <span class="text-evergreen">dalam bentuk yang baru.</span>
                </h2>
            </div>

            <div class="mt-16 lg:mt-20 max-w-2xl">
                <p class="text-base lg:text-lg text-ink/60 leading-relaxed">
                    MESH hadir untuk mengubah cara kamu mengundang. 
                    Bukan sekadar mengganti kertas dengan digital — tapi menghadirkan 
                    pengalaman yang lebih dekat, lebih personal, dan lebih teratur.
                </p>
            </div>

            <div class="mt-20 lg:mt-24 border-t border-mist/80"></div>

            <div class="mt-16 grid gap-16 md:grid-cols-3">
                <div>
                    <p class="text-xs uppercase tracking-[0.2em] font-medium text-brass/70">01</p>
                    <h3 class="mt-4 text-2xl font-semibold text-ink">Template Eksklusif</h3>
                    <p class="mt-3 text-sm text-ink/50 leading-relaxed max-w-sm">
                        Setiap template dirancang untuk acara yang berbeda. Pernikahan, ulang tahun, atau 
                        acara lainnya — semuanya punya karakter yang sesuai.
                    </p>
                </div>
                <div>
                    <p class="text-xs uppercase tracking-[0.2em] font-medium text-brass/70">02</p>
                    <h3 class="mt-4 text-2xl font-semibold text-ink">RSVP Real-time</h3>
                    <p class="mt-3 text-sm text-ink/50 leading-relaxed max-w-sm">
                        Tamu konfirmasi lewat satu link. Kamu lihat semua respons, jumlah hadir, 
                        dan ucapan langsung dari dashboard.
                    </p>
                </div>
                <div>
                    <p class="text-xs uppercase tracking-[0.2em] font-medium text-brass/70">03</p>
                    <h3 class="mt-4 text-2xl font-semibold text-ink">100% Gratis</h3>
                    <p class="mt-3 text-sm text-ink/50 leading-relaxed max-w-sm">
                        Tidak ada biaya langganan, tidak ada batasan jumlah undangan. 
                        Buat sebanyak yang kamu butuhkan.
                    </p>
                </div>
            </div>
        </div>
    </section>

    {{-- Cara Kerja --}}
    <section id="cara-kerja" class="py-28 lg:py-36 bg-ink text-white relative overflow-hidden">
        <div class="absolute inset-0 opacity-[0.03]">
            <div class="absolute -top-20 -right-20 h-80 w-80 rounded-full bg-white"></div>
            <div class="absolute -bottom-20 -left-20 h-96 w-96 rounded-full bg-white"></div>
        </div>
        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="max-w-3xl">
                <p class="text-xs uppercase tracking-[0.25em] font-medium text-brass-light">Cara Kerja</p>
                <h2 class="mt-6 font-display text-5xl lg:text-6xl font-semibold leading-[1.08] tracking-tight">
                    Buat. Bagikan.<br>
                    <span class="text-brass-light">Rayakan.</span>
                </h2>
            </div>

            <div class="mt-20 lg:mt-24 grid gap-16 md:grid-cols-3">
                <div>
                    <div class="flex items-baseline gap-4">
                        <span class="font-display text-7xl lg:text-8xl font-semibold text-white/10">01</span>
                        <span class="h-px flex-1 bg-white/10"></span>
                    </div>
                    <h3 class="mt-6 text-2xl font-semibold text-white">Buat Undangan</h3>
                    <p class="mt-3 text-sm text-white/50 leading-relaxed max-w-sm">
                        Pilih template, isi detail acara, dan upload foto. Semuanya bisa 
                        selesai dalam hitungan menit.
                    </p>
                </div>
                <div>
                    <div class="flex items-baseline gap-4">
                        <span class="font-display text-7xl lg:text-8xl font-semibold text-white/10">02</span>
                        <span class="h-px flex-1 bg-white/10"></span>
                    </div>
                    <h3 class="mt-6 text-2xl font-semibold text-white">Bagikan Link</h3>
                    <p class="mt-3 text-sm text-white/50 leading-relaxed max-w-sm">
                        Setiap undangan punya link unik. Salin dan bagikan ke tamu lewat 
                        WhatsApp, email, atau media sosial.
                    </p>
                </div>
                <div>
                    <div class="flex items-baseline gap-4">
                        <span class="font-display text-7xl lg:text-8xl font-semibold text-white/10">03</span>
                        <span class="h-px flex-1 bg-white/10"></span>
                    </div>
                    <h3 class="mt-6 text-2xl font-semibold text-white">Pantau RSVP</h3>
                    <p class="mt-3 text-sm text-white/50 leading-relaxed max-w-sm">
                        Lihat konfirmasi tamu secara langsung. Dari jumlah hadir hingga 
                        ucapan, semua terpantau rapi.
                    </p>
                </div>
            </div>
        </div>
    </section>

    {{-- CTA --}}
    <section id="cta" class="py-24 lg:py-32 bg-white">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 text-center">
            <h2 class="font-display text-5xl lg:text-6xl font-semibold text-ink leading-[1.08] tracking-tight">
                Siap merayakan<br>
                <span class="text-evergreen">dengan cara baru?</span>
            </h2>
            <p class="mt-6 text-base lg:text-lg text-ink/50 max-w-md mx-auto leading-relaxed">
                Mulai buat undangan digital pertamamu sekarang. Gratis, tanpa batasan.
            </p>
            <div class="mt-10 flex flex-col sm:flex-row items-center justify-center gap-4">
                <a href="{{ route('register') }}" class="inline-flex items-center px-8 py-3.5 bg-evergreen text-paper font-semibold rounded-full hover:bg-evergreen-dark transition-colors duration-200 text-base shadow-sm">
                    Buat Undangan Gratis
                </a>
                <a href="{{ route('login') }}" class="inline-flex items-center px-6 py-3.5 text-ink/50 hover:text-ink font-medium transition-colors duration-200 text-base border border-ink/15 hover:border-ink/30 rounded-full">
                    Masuk
                </a>
            </div>
        </div>
    </section>

    {{-- Footer --}}
    <footer class="bg-paper border-t border-mist/60 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row items-center justify-between gap-6">
                <div class="flex items-center gap-3">
                    <x-application-logo class="block h-7 w-7 text-ink/30" />
                    <span class="font-display text-base font-semibold text-ink/40 tracking-tight">MESH</span>
                </div>
                <p class="text-sm text-ink/30 text-center">
                    &copy; {{ date('Y') }} MESH. Semua hak dilindungi.
                </p>
                <div class="flex items-center gap-6">
                    <a href="#" class="text-sm text-ink/30 hover:text-ink/50 transition-colors">Kebijakan Privasi</a>
                    <a href="#" class="text-sm text-ink/30 hover:text-ink/50 transition-colors">Syarat Layanan</a>
                </div>
            </div>
        </div>
    </footer>
</body>
</html>