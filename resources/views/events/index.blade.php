<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-semibold text-ink leading-tight">
            {{ __('Undangan Saya') }}
        </h2>
    </x-slot>

    <div class="py-16">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if (session('success'))
                <div class="mb-6 p-4 bg-evergreen/10 text-evergreen-dark border border-evergreen/20 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden border border-mist/60 rounded-xl">
                <div class="p-10 text-ink">

                    <div class="flex justify-between items-center mb-8">
                        <h3 class="text-2xl font-semibold">Daftar Undangan</h3>
                        <a href="{{ route('events.create') }}" class="px-5 py-2.5 bg-evergreen text-paper rounded-md hover:bg-evergreen-dark transition-colors duration-150">
                            + Buat Undangan Baru
                        </a>
                    </div>

                    @if ($events->isEmpty())
                        <p class="text-ink/50">Kamu belum punya undangan. Yuk buat yang pertama!</p>
                    @else
                        <div class="space-y-6">
                            @foreach ($events as $event)
                                <div class="border border-mist/60 rounded-lg p-6 flex flex-col gap-4 sm:flex-row sm:justify-between sm:items-center">
                                    <div class="flex-1">
                                        <h4 class="font-semibold text-lg">{{ $event->nama_acara }}</h4>
                                        <p class="text-sm text-ink/50 mt-1">
                                            {{ \Carbon\Carbon::parse($event->tanggal_utama)->format('d M Y') }}
                                            • {{ $event->lokasi_utama }}
                                        </p>
                                        <p class="font-mono text-xs text-ink/40 mt-3 break-all">
                                            {{ url('/undangan/' . $event->unique_slug) }}
                                        </p>
                                    </div>

                                    <div class="flex flex-wrap gap-2">
                                        <a href="{{ route('events.show', $event) }}" class="px-4 py-1.5 border border-ink/20 rounded-md text-ink hover:bg-ink/5 transition-colors duration-150">
                                            Detail
                                        </a>
                                        <a href="{{ route('events.edit', $event) }}" class="px-4 py-1.5 border border-ink/20 rounded-md text-ink hover:bg-ink/5 transition-colors duration-150">
                                            Edit
                                        </a>
                                        <form action="{{ route('events.destroy', $event) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus undangan ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="px-4 py-1.5 bg-red-50 text-red-700 rounded-md hover:bg-red-100 transition-colors duration-150">
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
