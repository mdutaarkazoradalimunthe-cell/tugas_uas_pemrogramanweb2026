<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Undangan Saya') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if (session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-800 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-medium">Daftar Undangan</h3>
                        <a href="{{ route('events.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                            + Buat Undangan Baru
                        </a>
                    </div>

                    @if ($events->isEmpty())
                        <p class="text-gray-500">Kamu belum punya undangan. Yuk buat yang pertama!</p>
                    @else
                        <div class="space-y-4">
                            @foreach ($events as $event)
                                <div class="border rounded-lg p-4 flex justify-between items-center">
                                    <div>
                                        <h4 class="font-semibold text-lg">{{ $event->nama_acara }}</h4>
                                        <p class="text-sm text-gray-600">
                                            {{ \Carbon\Carbon::parse($event->tanggal_utama)->format('d M Y') }}
                                            — {{ $event->lokasi_utama }}
                                        </p>
                                        <p class="text-sm text-blue-600 mt-1">
                                            Link: {{ url('/undangan/' . $event->unique_slug) }}
                                        </p>
                                    </div>

                                    <div class="flex gap-2">
                                        <a href="{{ route('events.show', $event) }}" class="px-3 py-1 bg-gray-100 rounded hover:bg-gray-200">
                                            Detail
                                        </a>
                                        <a href="{{ route('events.edit', $event) }}" class="px-3 py-1 bg-yellow-100 rounded hover:bg-yellow-200">
                                            Edit
                                        </a>
                                        <form action="{{ route('events.destroy', $event) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus undangan ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="px-3 py-1 bg-red-100 text-red-700 rounded hover:bg-red-200">
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