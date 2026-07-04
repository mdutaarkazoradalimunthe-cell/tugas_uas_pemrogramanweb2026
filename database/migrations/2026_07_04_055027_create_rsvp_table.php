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
        Schema::create('rsvp', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained()->onDelete('cascade');
            $table->string('edit_token')->unique();
            $table->string('nama_tamu');
            $table->enum('status_hadir', ['hadir', 'tidak_hadir']);
            $table->integer('jumlah_orang')->default(1);
            $table->text('ucapan')->nullable();
            $table->boolean('is_hidden')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rsvp');
    }
};