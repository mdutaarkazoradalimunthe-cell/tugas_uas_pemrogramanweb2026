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
        // Drop the old check constraint
        \DB::statement("ALTER TABLE templates DROP CONSTRAINT IF EXISTS templates_event_type_check");
        
        // PostgreSQL requires dropping and recreating enum type
        \DB::statement("ALTER TABLE templates ALTER COLUMN event_type TYPE VARCHAR(50)");
        \DB::statement("DROP TYPE IF EXISTS templates_event_type");
        \DB::statement("CREATE TYPE templates_event_type AS ENUM ('ulang_tahun', 'pernikahan', 'acara_lainnya')");
        \DB::statement("ALTER TABLE templates ALTER COLUMN event_type TYPE templates_event_type USING event_type::text::templates_event_type");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Remove acara_lainnya enum value
        \DB::statement("DELETE FROM templates WHERE event_type = 'acara_lainnya'");
        \DB::statement("ALTER TABLE templates ALTER COLUMN event_type TYPE VARCHAR(50)");
        \DB::statement("DROP TYPE IF EXISTS templates_event_type");
        \DB::statement("CREATE TYPE templates_event_type AS ENUM ('ulang_tahun', 'pernikahan')");
        \DB::statement("ALTER TABLE templates ALTER COLUMN event_type TYPE templates_event_type USING event_type::text::templates_event_type");
    }
};
