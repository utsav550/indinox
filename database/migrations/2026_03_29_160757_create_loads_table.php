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
        Schema::create('loads', function (Blueprint $table) {
    $table->id();

    $table->foreignId('customer_id')->constrained()->onDelete('cascade');

    $table->string('pickup_location');
    $table->string('delivery_location');

    $table->string('material')->nullable();
    $table->float('weight')->nullable();

    $table->date('pickup_date')->nullable();

    $table->decimal('price', 10, 2)->nullable();

    $table->enum('status', [
        'pending',
        'assigned',
        'picked',
        'in_transit',
        'delivered'
    ])->default('pending');

    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loads');
    }
};
