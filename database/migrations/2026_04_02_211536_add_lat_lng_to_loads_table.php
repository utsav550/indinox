<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('loads', function (Blueprint $table) {

            $table->string('pickup_address')->nullable();
            $table->decimal('pickup_lat', 10, 7)->nullable();
            $table->decimal('pickup_lng', 10, 7)->nullable();

            $table->string('delivery_address')->nullable();
            $table->decimal('delivery_lat', 10, 7)->nullable();
            $table->decimal('delivery_lng', 10, 7)->nullable();

        });
    }

    public function down(): void
    {
        Schema::table('loads', function (Blueprint $table) {

            $table->dropColumn([
                'pickup_address',
                'pickup_lat',
                'pickup_lng',
                'delivery_address',
                'delivery_lat',
                'delivery_lng'
            ]);

        });
    }
};