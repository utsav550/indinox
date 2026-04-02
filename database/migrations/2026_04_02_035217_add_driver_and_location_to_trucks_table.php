<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('trucks', function (Blueprint $table) {
            
            // Link driver
            $table->foreignId('driver_id')
                  ->nullable()
                  ->constrained()
                  ->nullOnDelete();

            // Current location
            $table->string('current_location')->nullable();

        });
    }

    public function down(): void
    {
        Schema::table('trucks', function (Blueprint $table) {

            $table->dropForeign(['driver_id']);
            $table->dropColumn(['driver_id', 'current_location']);

        });
    }
};