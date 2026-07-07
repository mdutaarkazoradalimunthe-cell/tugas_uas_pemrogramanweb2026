<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Template;

class TemplateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $templates = [
            // Pernikahan (3 templates)
            [
                'event_type' => 'pernikahan',
                'nama_template' => 'Elegan Hijau',
                'deskripsi' => 'Template pernikahan dengan nuansa hijau evergreen yang elegan dan formal',
                'preview_thumbnail' => 'gradient-evergreen-1',
            ],
            [
                'event_type' => 'pernikahan',
                'nama_template' => 'Klasik Emas',
                'deskripsi' => 'Template pernikahan dengan sentuhan emas brass yang klasik dan mewah',
                'preview_thumbnail' => 'gradient-emas-1',
            ],
            [
                'event_type' => 'pernikahan',
                'nama_template' => 'Modern Minimalis',
                'deskripsi' => 'Template pernikahan modern dengan desain minimalis dan clean',
                'preview_thumbnail' => 'gradient-slate-1',
            ],

            // Ulang Tahun (3 templates)
            [
                'event_type' => 'ulang_tahun',
                'nama_template' => 'Ceria Pink',
                'deskripsi' => 'Template ulang tahun dengan warna pink blush yang ceria dan hangat',
                'preview_thumbnail' => 'gradient-blush-1',
            ],
            [
                'event_type' => 'ulang_tahun',
                'nama_template' => 'Playful Pastel',
                'deskripsi' => 'Template ulang tahun dengan kombinasi warna pastel yang playful',
                'preview_thumbnail' => 'gradient-blush-2',
            ],
            [
                'event_type' => 'ulang_tahun',
                'nama_template' => 'Fun Celebration',
                'deskripsi' => 'Template ulang tahun dengan desain fun dan meriah untuk segala usia',
                'preview_thumbnail' => 'gradient-blush-1',
            ],

            // Acara Lainnya (2 templates)
            [
                'event_type' => 'acara_lainnya',
                'nama_template' => 'Professional Brass',
                'deskripsi' => 'Template untuk seminar, workshop, dan acara profesional lainnya',
                'preview_thumbnail' => 'gradient-navy-1',
            ],
            [
                'event_type' => 'acara_lainnya',
                'nama_template' => 'Casual Gathering',
                'deskripsi' => 'Template untuk pesta bersama teman, makrab, dan gathering informal',
                'preview_thumbnail' => 'gradient-forest-1',
            ],
        ];

        foreach ($templates as $template) {
            Template::updateOrCreate(
                ['event_type' => $template['event_type'], 'nama_template' => $template['nama_template']],
                $template
            );
        }
    }
}
