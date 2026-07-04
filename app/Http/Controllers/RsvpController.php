<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Event;
use App\Models\Rsvp;

class RsvpController extends Controller
{
    /**
     * Menampilkan halaman undangan publik + form RSVP.
     * Diakses tamu lewat link: /undangan/{slug}
     */
    public function show(string $slug)
    {
        $event = Event::where('unique_slug', $slug)->firstOrFail();

        // Ambil ucapan yang tidak disembunyikan, untuk ditampilkan di halaman
        $rsvps = Rsvp::where('event_id', $event->id)
            ->where('is_hidden', false)
            ->latest()
            ->get();

        return view('rsvp.show', compact('event', 'rsvps'));
    }

    /**
     * Memproses submit RSVP baru dari tamu.
     */
    public function store(Request $request, string $slug)
    {
        $event = Event::where('unique_slug', $slug)->firstOrFail();

        $validated = $request->validate([
            'nama_tamu' => 'required|string|max:255',
            'status_hadir' => 'required|in:hadir,tidak_hadir',
            'jumlah_orang' => 'required|integer|min:1',
            'ucapan' => 'nullable|string',
        ]);

        $validated['event_id'] = $event->id;
        $validated['edit_token'] = Str::random(32);

        $rsvp = Rsvp::create($validated);

        return redirect()
            ->route('rsvp.edit', $rsvp->edit_token)
            ->with('success', 'Terima kasih! RSVP kamu sudah tersimpan. Simpan link ini untuk mengedit RSVP nanti.');
    }

    /**
     * Menampilkan form edit RSVP, diakses lewat link token pribadi tamu.
     */
    public function edit(string $token)
    {
        $rsvp = Rsvp::where('edit_token', $token)->firstOrFail();

        return view('rsvp.edit', compact('rsvp'));
    }

    /**
     * Memproses perubahan RSVP dari tamu.
     */
    public function update(Request $request, string $token)
    {
        $rsvp = Rsvp::where('edit_token', $token)->firstOrFail();

        $validated = $request->validate([
            'nama_tamu' => 'required|string|max:255',
            'status_hadir' => 'required|in:hadir,tidak_hadir',
            'jumlah_orang' => 'required|integer|min:1',
            'ucapan' => 'nullable|string',
        ]);

        $rsvp->update($validated);

        return redirect()
            ->route('rsvp.edit', $rsvp->edit_token)
            ->with('success', 'RSVP kamu berhasil diperbarui!');
    }
}