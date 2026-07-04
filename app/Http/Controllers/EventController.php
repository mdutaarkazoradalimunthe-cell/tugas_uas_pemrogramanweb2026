<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Event;
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
        ]);

        $validated['user_id'] = auth()->id();
        $validated['unique_slug'] = Str::slug($request->nama_acara) . '-' . Str::random(6);

        $event = Event::create($validated);

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
        ]);

        $event->update($validated);

        return redirect()->route('events.index')->with('success', 'Undangan berhasil diperbarui!');
    }

    public function destroy(Event $event)
    {
        if ($event->user_id !== auth()->id()) {
            abort(403);
        }

        $event->delete();

        return redirect()->route('events.index')->with('success', 'Undangan berhasil dihapus!');
    }
}