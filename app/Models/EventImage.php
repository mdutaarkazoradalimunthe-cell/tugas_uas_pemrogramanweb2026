<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventImage extends Model
{
    protected $fillable = [
        'event_id',
        'slot_name',
        'image_path',
        'urutan',
    ];

    // 1 gambar dimiliki oleh 1 event
    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}