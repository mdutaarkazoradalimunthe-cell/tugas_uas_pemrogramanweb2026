<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Template extends Model
{
    protected $fillable = [
        'event_type',
        'nama_template',
        'deskripsi',
        'preview_thumbnail',
    ];

    // 1 template bisa dipakai banyak event
    public function events()
    {
        return $this->hasMany(Event::class);
    }
}