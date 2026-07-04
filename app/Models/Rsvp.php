<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rsvp extends Model
{
    protected $table = 'rsvp'; // wajib ditulis manual, karena nama tabelnya bukan bentuk plural standar (rsvps)

    protected $fillable = [
        'event_id',
        'edit_token',
        'nama_tamu',
        'status_hadir',
        'jumlah_orang',
        'ucapan',
        'is_hidden',
    ];

    // 1 RSVP dimiliki oleh 1 event
    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}