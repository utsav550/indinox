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
        Schema::table('trucks', function (Blueprint $table) {
    $table->renameColumn('truck_number', 'truck_code');
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('truck_code', function (Blueprint $table) {
            //
        });
    }
};
