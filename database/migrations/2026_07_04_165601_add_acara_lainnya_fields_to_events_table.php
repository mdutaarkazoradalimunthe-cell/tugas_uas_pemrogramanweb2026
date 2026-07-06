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
        Schema::table('events', function (Blueprint $table) {
            // Fields untuk acara_lainnya (seminar, workshop, gathering, dll)
            $table->integer('kapasitas_peserta')->nullable()->after('lokasi_resepsi');
            $table->text('nama_pembicara')->nullable()->after('kapasitas_peserta');
            $table->text('topik_agenda')->nullable()->after('nama_pembicara');
            $table->string('dresscode')->nullable()->after('topik_agenda');
            $table->text('catatan_tambahan')->nullable()->after('dresscode');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('events', function (Blueprint $table) {
            $table->dropColumn([
                'kapasitas_peserta',
                'nama_pembicara',
                'topik_agenda',
                'dresscode',
                'catatan_tambahan'
            ]);
        });
    }
};
