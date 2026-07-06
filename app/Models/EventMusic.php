<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class EventMusic extends Model
{
    protected $table = 'event_musics';

    protected $fillable = [
        'event_id',
        'judul',
        'file_path',
        'auto_play',
        'urutan',
    ];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function getAudioUrlAttribute()
    {
        return $this->file_path ? asset('storage/' . $this->file_path) : null;
    }
}
