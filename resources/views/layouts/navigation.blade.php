<nav x-data="{ open: false }" class="bg-paper/95 border-b border-mist/30 backdrop-blur-md">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex min-w-0">
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-3 transition-opacity duration-150 hover:opacity-80">
                        <x-application-logo class="block h-7 w-7 text-evergreen" />
                        <span class="hidden md:inline font-display text-lg font-semibold tracking-tight text-ink">MESH</span>
                    </a>
                </div>
            </div>

            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <div class="flex items-center gap-7 bg-transparent">
                    <a href="{{ route('dashboard') }}"
                       class="relative inline-flex h-11 items-center px-0.5 text-[15px] font-medium tracking-tight transition-colors duration-200 {{ request()->routeIs('dashboard') ? 'text-ink after:absolute after:bottom-1 after:left-0 after:h-px after:w-full after:bg-evergreen' : 'text-ink/60 hover:text-evergreen' }}">
                        Dashboard
                    </a>

                    <a href="{{ route('events.index') }}"
                       class="relative inline-flex h-11 items-center px-0.5 text-[15px] font-medium tracking-tight transition-colors duration-200 {{ request()->routeIs('events.*') && ! request()->routeIs('events.create') ? 'text-ink after:absolute after:bottom-1 after:left-0 after:h-px after:w-full after:bg-evergreen' : 'text-ink/60 hover:text-evergreen' }}">
                        Undangan
                    </a>

                    <a href="{{ route('events.create') }}"
                       class="relative inline-flex h-11 items-center px-0.5 text-[15px] font-medium tracking-tight transition-colors duration-200 {{ request()->routeIs('events.create') ? 'text-ink after:absolute after:bottom-1 after:left-0 after:h-px after:w-full after:bg-evergreen' : 'text-ink/60 hover:text-evergreen' }}">
                        Buat Baru
                    </a>

                    <x-dropdown align="right" width="64" contentClasses="py-1.5 bg-white/95 ring-1 ring-ink/[0.06] backdrop-blur-md">
                        <x-slot name="trigger">
                            <button class="group inline-flex h-11 items-center gap-2.5 px-0.5 text-left transition-colors duration-200 hover:text-evergreen focus:outline-none">
                                <span class="flex h-8 w-8 items-center justify-center bg-evergreen/10 text-sm font-semibold text-evergreen transition-colors duration-200 group-hover:bg-evergreen/20">
                                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                </span>
                                <span class="hidden lg:block leading-tight">
                                    <span class="block max-w-36 truncate text-[15px] font-semibold text-ink/80 transition-colors duration-200 group-hover:text-evergreen">{{ Auth::user()->name }}</span>
                                    <span class="block max-w-36 truncate text-xs text-ink/45">{{ Auth::user()->email }}</span>
                                </span>
                                <span class="text-ink/35 transition-colors duration-200 group-hover:text-ink/60">
                                    <svg class="h-3.5 w-3.5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 10.94l3.71-3.71a.75.75 0 111.06 1.06l-4.24 4.25a.75.75 0 01-1.06 0L5.21 8.29a.75.75 0 01.02-1.08z" clip-rule="evenodd" />
                                    </svg>
                                </span>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <div class="px-4 py-3">
                                <p class="text-sm font-semibold text-ink">{{ Auth::user()->name }}</p>
                                <p class="mt-0.5 truncate text-xs text-ink/45">{{ Auth::user()->email }}</p>
                                <div class="mt-2 flex items-center gap-2">
                                    @if (Auth::user()->isPlus())
                                        <span class="inline-flex items-center gap-1 px-2.5 py-1 text-xs font-semibold rounded-full bg-evergreen/10 text-evergreen">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                            Plus
                                        </span>
                                        <form action="{{ route('subscription.downgrade') }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" class="text-xs text-ink/40 hover:text-red-400 transition-colors">Nonaktifkan</button>
                                        </form>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-1 text-xs font-medium rounded-full bg-ink/5 text-ink/50">Free</span>
                                        <form action="{{ route('subscription.upgrade') }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" class="text-xs font-medium text-evergreen hover:text-evergreen-dark transition-colors">⬆ Upgrade ke Plus</button>
                                        </form>
                                    @endif
                                </div>
                            </div>

                            <div class="mx-2 h-px bg-mist/70"></div>

                            <a href="{{ route('profile.edit') }}" class="mx-1.5 block rounded-md px-3 py-2.5 text-sm font-medium text-ink/70 transition-colors duration-150 hover:bg-evergreen/10 hover:text-evergreen">
                                Profil Akun
                            </a>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <a href="{{ route('logout') }}"
                                   onclick="event.preventDefault(); this.closest('form').submit();"
                                   class="mx-1.5 block rounded-md px-3 py-2.5 text-sm font-medium text-ink/70 transition-colors duration-150 hover:bg-ink/[0.06] hover:text-ink">
                                    Keluar
                                </a>
                            </form>
                        </x-slot>
                    </x-dropdown>
                </div>
            </div>

            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center bg-transparent p-2 text-ink/60 transition duration-150 ease-in-out hover:text-evergreen focus:outline-none">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden border-t border-mist/40 bg-white/95 backdrop-blur-md">
        <div class="py-2">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('events.index')" :active="request()->routeIs('events.*') && ! request()->routeIs('events.create')">
                {{ __('Undangan') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('events.create')" :active="request()->routeIs('events.create')">
                {{ __('Buat Baru') }}
            </x-responsive-nav-link>
        </div>

        <div class="border-t border-mist/40 py-3">
            <div class="px-4">
                <div class="font-medium text-base text-ink">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-ink/60">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profil Akun') }}
                </x-responsive-nav-link>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault(); this.closest('form').submit();">
                        {{ __('Keluar') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>