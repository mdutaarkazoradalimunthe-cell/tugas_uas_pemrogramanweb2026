<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Models\Event;
use App\Models\EventImage;
use App\Models\Template;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::where('user_id', auth()->id())->get();

        return view('events.index', compact('events'));
    }

    public function create()
    {
        $templates = Template::all();

        return view('events.create', compact('templates'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'template_id' => 'required|exists:templates,id',
            'layout_type' => 'required|in:foto_atas,foto_samping,tanpa_foto',
            'nama_acara' => 'required|string|max:255',
            'tanggal_utama' => 'required|date',
            'jam_utama' => 'required',
            'lokasi_utama' => 'required|string|max:255',
            'nama_mempelai_pria' => 'nullable|string|max:255',
            'nama_mempelai_wanita' => 'nullable|string|max:255',
            'nama_ortu_pria' => 'nullable|string|max:255',
            'nama_ortu_wanita' => 'nullable|string|max:255',
            'tanggal_resepsi' => 'nullable|date',
            'jam_resepsi' => 'nullable',
            'lokasi_resepsi' => 'nullable|string|max:255',
            'foto_utama' => 'nullable|image|max:2048',
            // Acara lainnya fields
            'kapasitas_peserta' => 'nullable|integer|min:1',
            'nama_pembicara' => 'nullable|string',
            'topik_agenda' => 'nullable|string',
            'dresscode' => 'nullable|string|max:255',
            'catatan_tambahan' => 'nullable|string',
            'musik' => 'nullable|file|mimes:mp3,wav,ogg,aac|max:10240',
            'auto_play' => 'nullable|boolean',
        ]);

        $validated['user_id'] = auth()->id();
        $validated['unique_slug'] = Str::slug($request->nama_acara) . '-' . Str::random(6);
        unset($validated['foto_utama']);

        $event = Event::create($validated);

        if ($request->hasFile('foto_utama')) {
            $path = $request->file('foto_utama')->store('events', 'public');
            EventImage::create([
                'event_id' => $event->id,
                'slot_name' => 'foto_utama',
                'image_path' => $path,
                'urutan' => 0,
            ]);
        }

        if (auth()->user()->isPlus() && $request->hasFile('musik')) {
            $path = $request->file('musik')->store('musics', 'public');
            $event->musics()->create([
                'judul' => $request->file('musik')->getClientOriginalName(),
                'file_path' => $path,
                'auto_play' => $request->boolean('auto_play', true),
                'urutan' => 0,
            ]);
        }

        return redirect()->route('events.index')->with('success', 'Undangan berhasil dibuat!');
    }

    public function show(Event $event)
    {
        if ($event->user_id !== auth()->id()) {
            abort(403);
        }

        return view('events.show', compact('event'));
    }

    public function edit(Event $event)
    {
        if ($event->user_id !== auth()->id()) {
            abort(403);
        }

        $templates = Template::all();

        return view('events.edit', compact('event', 'templates'));
    }

    public function update(Request $request, Event $event)
    {
        if ($event->user_id !== auth()->id()) {
            abort(403);
        }

        $validated = $request->validate([
            'template_id' => 'required|exists:templates,id',
            'layout_type' => 'required|in:foto_atas,foto_samping,tanpa_foto',
            'nama_acara' => 'required|string|max:255',
            'tanggal_utama' => 'required|date',
            'jam_utama' => 'required',
            'lokasi_utama' => 'required|string|max:255',
            'nama_mempelai_pria' => 'nullable|string|max:255',
            'nama_mempelai_wanita' => 'nullable|string|max:255',
            'nama_ortu_pria' => 'nullable|string|max:255',
            'nama_ortu_wanita' => 'nullable|string|max:255',
            'tanggal_resepsi' => 'nullable|date',
            'jam_resepsi' => 'nullable',
            'lokasi_resepsi' => 'nullable|string|max:255',
            'foto_utama' => 'nullable|image|max:2048',
            // Acara lainnya fields
            'kapasitas_peserta' => 'nullable|integer|min:1',
            'nama_pembicara' => 'nullable|string',
            'topik_agenda' => 'nullable|string',
            'dresscode' => 'nullable|string|max:255',
            'catatan_tambahan' => 'nullable|string',
            'musik' => 'nullable|file|mimes:mp3,wav,ogg,aac|max:10240',
            'auto_play' => 'nullable|boolean',
        ]);

        unset($validated['foto_utama']);

        $event->update($validated);

        if ($request->hasFile('foto_utama')) {
            // Hapus foto lama
            EventImage::where('event_id', $event->id)->where('slot_name', 'foto_utama')->delete();

            // Upload foto baru
            $path = $request->file('foto_utama')->store('events', 'public');
            EventImage::create([
                'event_id' => $event->id,
                'slot_name' => 'foto_utama',
                'image_path' => $path,
                'urutan' => 0,
            ]);
        }

        if (auth()->user()->isPlus() && $request->hasFile('musik')) {
            foreach ($event->musics as $m) {
                Storage::disk('public')->delete($m->file_path);
                $m->delete();
            }
            $path = $request->file('musik')->store('musics', 'public');
            $event->musics()->create([
                'judul' => $request->file('musik')->getClientOriginalName(),
                'file_path' => $path,
                'auto_play' => $request->boolean('auto_play', true),
                'urutan' => 0,
            ]);
        }

        return redirect()->route('events.index')->with('success', 'Undangan berhasil diperbarui!');
    }

    public function destroy(Event $event)
    {
        if ($event->user_id !== auth()->id()) {
            abort(403);
        }

        foreach ($event->musics as $m) {
            Storage::disk('public')->delete($m->file_path);
        }

        $event->delete();

        return redirect()->route('events.index')->with('success', 'Undangan berhasil dihapus!');
    }
}
