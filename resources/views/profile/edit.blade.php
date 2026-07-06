<x-app-layout>
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-16 lg:py-20">
        <p class="text-xs uppercase tracking-[0.2em] font-medium text-brass">Pengaturan</p>
        <h1 class="mt-3 font-display text-3xl lg:text-4xl font-semibold text-ink leading-[1.08] tracking-tight">
            {{ __('Profile') }}
        </h1>
        <p class="mt-2 text-sm text-ink/50">Kelola informasi akun, kata sandi, dan pengaturan keamanan.</p>

        <div class="mt-12 space-y-16">
            @include('profile.partials.update-profile-information-form')

            @include('profile.partials.update-password-form')

            @include('profile.partials.delete-user-form')
        </div>
    </div>
</x-app-layout>