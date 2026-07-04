<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('template_id')->constrained()->onDelete('restrict');
            $table->string('unique_slug')->unique();
            $table->string('nama_acara');
            $table->date('tanggal_utama');
            $table->time('jam_utama');
            $table->string('lokasi_utama');
            $table->string('nama_mempelai_pria')->nullable();
            $table->string('nama_mempelai_wanita')->nullable();
            $table->string('nama_ortu_pria')->nullable();
            $table->string('nama_ortu_wanita')->nullable();
            $table->date('tanggal_resepsi')->nullable();
            $table->time('jam_resepsi')->nullable();
            $table->string('lokasi_resepsi')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};