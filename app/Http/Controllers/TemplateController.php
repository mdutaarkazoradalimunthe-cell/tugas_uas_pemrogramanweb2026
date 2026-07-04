<?php

namespace App\Http\Controllers;

use App\Models\Template;
use Illuminate\Http\Request;

class TemplateController extends Controller
{
    /**
     * Menampilkan daftar semua template yang tersedia.
     * Dipakai saat pembuat acara mau memilih template untuk event barunya.
     */
    public function index()
    {
        $templates = Template::all();

        return view('templates.index', compact('templates'));
    }

    /**
     * Menampilkan detail 1 template tertentu (opsional, untuk preview).
     */
    public function show(Template $template)
    {
        return view('templates.show', compact('template'));
    }
}