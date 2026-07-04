<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-semibold text-ink leading-tight">
            {{ __('Edit Undangan') }}
        </h2>
    </x-slot>

    <div class="py-16">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden border border-mist/60 rounded-xl p-10">

                @if ($errors->any())
                    <div class="mb-4 p-4 bg-red-50 text-red-700 border border-red-100 rounded-lg">
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('events.update', $event) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-ink/70 mb-1">Pilih Template</label>
                        <select name="template_id" id="template_id" class="w-full border-mist rounded-lg focus:border-evergreen focus:ring-evergreen" required onchange="toggleFields()">
                            @foreach ($templates as $template)
                                <option value="{{ $template->id }}" data-type="{{ $template->event_type }}"
                                    {{ old('template_id', $event->template_id) == $template->id ? 'selected' : '' }}>
                                    {{ $template->nama_template }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-ink/70 mb-1">Nama Acara</label>
                        <input type="text" name="nama_acara" value="{{ old('nama_acara', $event->nama_acara) }}" class="w-full border-mist rounded-lg focus:border-evergreen focus:ring-evergreen" required>
                    </div>

                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block text-sm font-medium text-ink/70 mb-1">Tanggal Acara</label>
                            <input type="date" name="tanggal_utama" value="{{ old('tanggal_utama', $event->tanggal_utama) }}" class="w-full border-mist rounded-lg focus:border-evergreen focus:ring-evergreen" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-ink/70 mb-1">Jam Acara</label>
                            <input type="time" name="jam_utama" value="{{ old('jam_utama', \Carbon\Carbon::parse($event->jam_utama)->format('H:i')) }}" class="w-full border-mist rounded-lg focus:border-evergreen focus:ring-evergreen" required>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-ink/70 mb-1">Lokasi Acara</label>
                        <input type="text" name="lokasi_utama" value="{{ old('lokasi_utama', $event->lokasi_utama) }}" class="w-full border-mist rounded-lg focus:border-evergreen focus:ring-evergreen" required>
                    </div>

                    <div id="pernikahan-fields" style="display: none;">
                        <hr class="border-t border-mist/60 my-8">
                        <h3 class="text-xl font-semibold mb-4">Detail Pernikahan</h3>

                        <div class="grid grid-cols-2 gap-4 mb-4">
                            <div>
                                <label class="block text-sm font-medium text-ink/70 mb-1">Nama Mempelai Pria</label>
                                <input type="text" name="nama_mempelai_pria" value="{{ old('nama_mempelai_pria', $event->nama_mempelai_pria) }}" class="w-full border-mist rounded-lg focus:border-evergreen focus:ring-evergreen">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-ink/70 mb-1">Nama Mempelai Wanita</label>
                                <input type="text" name="nama_mempelai_wanita" value="{{ old('nama_mempelai_wanita', $event->nama_mempelai_wanita) }}" class="w-full border-mist rounded-lg focus:border-evergreen focus:ring-evergreen">
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4 mb-4">
                            <div>
                                <label class="block text-sm font-medium text-ink/70 mb-1">Nama Orang Tua Pria</label>
                                <input type="text" name="nama_ortu_pria" value="{{ old('nama_ortu_pria', $event->nama_ortu_pria) }}" class="w-full border-mist rounded-lg focus:border-evergreen focus:ring-evergreen">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-ink/70 mb-1">Nama Orang Tua Wanita</label>
                                <input type="text" name="nama_ortu_wanita" value="{{ old('nama_ortu_wanita', $event->nama_ortu_wanita) }}" class="w-full border-mist rounded-lg focus:border-evergreen focus:ring-evergreen">
                            </div>
                        </div>

                        <h4 class="font-semibold mb-2">Detail Resepsi</h4>
                        <div class="grid grid-cols-2 gap-4 mb-4">
                            <div>
                                <label class="block text-sm font-medium text-ink/70 mb-1">Tanggal Resepsi</label>
                                <input type="date" name="tanggal_resepsi" value="{{ old('tanggal_resepsi', $event->tanggal_resepsi) }}" class="w-full border-mist rounded-lg focus:border-evergreen focus:ring-evergreen">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-ink/70 mb-1">Jam Resepsi</label>
                                <input type="time" name="jam_resepsi" value="{{ old('jam_resepsi', $event->jam_resepsi ? \Carbon\Carbon::parse($event->jam_resepsi)->format('H:i') : '') }}" class="w-full border-mist rounded-lg focus:border-evergreen focus:ring-evergreen">
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-medium text-ink/70 mb-1">Lokasi Resepsi</label>
                            <input type="text" name="lokasi_resepsi" value="{{ old('lokasi_resepsi', $event->lokasi_resepsi) }}" class="w-full border-mist rounded-lg focus:border-evergreen focus:ring-evergreen">
                        </div>
                    </div>

                    <div class="flex gap-3 mt-8">
                        <button type="submit" class="px-5 py-2.5 bg-evergreen text-paper rounded-md hover:bg-evergreen-dark transition-colors duration-150">
                            Simpan Perubahan
                        </button>
                        <a href="{{ route('events.show', $event) }}" class="px-5 py-2.5 border border-ink/20 text-ink rounded-md hover:bg-ink/5 transition-colors duration-150">
                            Batal
                        </a>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <script>
        function toggleFields() {
            const select = document.getElementById('template_id');
            const selectedOption = select.options[select.selectedIndex];
            const eventType = selectedOption.getAttribute('data-type');
            const pernikahanFields = document.getElementById('pernikahan-fields');

            if (eventType === 'pernikahan') {
                pernikahanFields.style.display = 'block';
            } else {
                pernikahanFields.style.display = 'none';
            }
        }

        // Jalankan sekali saat halaman dimuat, supaya field pernikahan otomatis muncul kalau memang template-nya pernikahan
        document.addEventListener('DOMContentLoaded', toggleFields);
    </script>
</x-app-layout>
