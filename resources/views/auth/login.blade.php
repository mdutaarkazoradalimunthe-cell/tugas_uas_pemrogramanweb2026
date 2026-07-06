<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Masuk - {{ config('app.name', 'MESH') }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,500;9..144,600;9..144,700&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased">
    <div class="min-h-screen flex">
        {{-- Left --}}
        <div class="hidden lg:flex w-[55%] relative items-center justify-center overflow-hidden">
            <div class="absolute inset-0">
                <img src="{{ asset('images/tampilan-register-2.jpg') }}" alt="" class="w-full h-full object-cover">
                <div class="absolute inset-0 bg-gradient-to-b from-black/30 via-black/50 to-black/70"></div>
            </div>
            <div class="relative z-10 text-center px-12 max-w-lg">
                <div class="w-12 h-px bg-brass-light/60 mx-auto"></div>
                <p class="mt-8 font-display text-4xl lg:text-5xl font-semibold text-white leading-[1.1] tracking-tight">
                    Selamat datang<br>
                    <span class="text-brass-light">kembali.</span>
                </p>
                <p class="mt-6 text-sm text-white/50 leading-relaxed max-w-xs mx-auto">
                    Lanjutkan mengelola undangan dan pantau konfirmasi tamu di satu dashboard.
                </p>
            </div>
        </div>

        {{-- Right: Form --}}
        <div class="w-full lg:w-[45%] flex items-center justify-center px-8 py-16 lg:px-20 bg-white">
            <div class="w-full max-w-sm">
                <a href="/" class="inline-flex items-center gap-2.5 transition-opacity duration-150 hover:opacity-80">
                    <x-application-logo class="h-8 w-8 text-evergreen" />
                    <span class="font-display text-lg font-semibold text-ink tracking-tight">MESH</span>
                </a>

                <div class="mt-16">
                    <h1 class="font-display text-4xl font-semibold text-ink leading-[1.1] tracking-tight">
                        Masuk ke akunmu.
                    </h1>
                    <p class="mt-3 text-sm text-ink/50">
                        Belum punya akun?
                        <a href="{{ route('register') }}" class="font-medium text-evergreen hover:text-evergreen-dark transition-colors">Daftar</a>
                    </p>
                </div>

                <x-auth-session-status class="mt-6" :status="session('status')" />

                <form method="POST" action="{{ route('login') }}" class="mt-8 space-y-6">
                    @csrf

                    <div>
                        <label for="email" class="block text-sm font-medium text-ink/60 mb-1.5">Email</label>
                        <input id="email" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="contoh@email.com"
                            class="block w-full border border-ink/10 rounded-xl px-4 py-3.5 text-sm text-ink placeholder:text-ink/25 focus:border-evergreen focus:ring-1 focus:ring-evergreen transition-colors duration-200">
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium text-ink/60 mb-1.5">Password</label>
                        <input id="password" type="password" name="password" required autocomplete="current-password" placeholder="Masukkan password"
                            class="block w-full border border-ink/10 rounded-xl px-4 py-3.5 text-sm text-ink placeholder:text-ink/25 focus:border-evergreen focus:ring-1 focus:ring-evergreen transition-colors duration-200">
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <div class="flex items-center justify-between">
                        <label for="remember_me" class="inline-flex items-center gap-2">
                            <input id="remember_me" type="checkbox" class="rounded border-ink/15 text-evergreen focus:ring-evergreen shadow-none">
                            <span class="text-sm text-ink/50">Ingat saya</span>
                        </label>

                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="text-sm text-evergreen hover:text-evergreen-dark transition-colors">
                                Lupa password?
                            </a>
                        @endif
                    </div>

                    <button type="submit" class="w-full py-3.5 bg-evergreen text-paper font-semibold rounded-full hover:bg-evergreen-dark focus:outline-none focus:ring-2 focus:ring-evergreen focus:ring-offset-2 transition-colors duration-200 text-sm">
                        Masuk
                    </button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>