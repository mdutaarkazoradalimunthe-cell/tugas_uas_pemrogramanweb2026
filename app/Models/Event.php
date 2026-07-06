<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = [
        'user_id',
        'template_id',
        'layout_type',
        'unique_slug',
        'nama_acara',
        'tanggal_utama',
        'jam_utama',
        'lokasi_utama',
        'nama_mempelai_pria',
        'nama_mempelai_wanita',
        'nama_ortu_pria',
        'nama_ortu_wanita',
        'tanggal_resepsi',
        'jam_resepsi',
        'lokasi_resepsi',
        // Fields untuk acara_lainnya
        'kapasitas_peserta',
        'nama_pembicara',
        'topik_agenda',
        'dresscode',
        'catatan_tambahan',
    ];

    // 1 event dimiliki oleh 1 user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // 1 event pakai 1 template
    public function template()
    {
        return $this->belongsTo(Template::class);
    }

    // 1 event bisa punya banyak gambar
    public function images()
    {
        return $this->hasMany(EventImage::class);
    }

    // 1 event bisa punya banyak RSVP
    public function rsvps()
    {
        return $this->hasMany(Rsvp::class);
    }

    // 1 event bisa punya musik latar
    public function musics()
    {
        return $this->hasMany(EventMusic::class);
    }

    // Accessor untuk foto utama
    public function getFotoUtamaUrlAttribute()
    {
        $image = $this->images()->where('slot_name', 'foto_utama')->first();
        return $image ? asset('storage/' . $image->image_path) : null;
    }
}