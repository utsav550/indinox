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
    Schema::create('dispatches', function (Blueprint $table) {
        $table->id();

        $table->foreignId('load_id')->constrained()->cascadeOnDelete();
        $table->foreignId('truck_id')->constrained()->cascadeOnDelete();
        $table->foreignId('driver_id')->constrained()->cascadeOnDelete();

        $table->date('assigned_date')->nullable();

        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dispatches');
    }
};
