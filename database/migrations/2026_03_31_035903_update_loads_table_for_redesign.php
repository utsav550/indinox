<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
{
    Schema::table('loads', function (Blueprint $table) {

        // remove old columns
        $table->dropForeign(['driver_id']);
        $table->dropForeign(['truck_id']);
        $table->dropColumn(['driver_id', 'truck_id']);

        // add new columns
        $table->foreignId('truck_type_required_id')->nullable()->constrained('truck_types');
        $table->string('priority')->default('normal');
        $table->integer('trip_days')->default(1);
        $table->text('notes')->nullable();
    });
}

public function down(): void
{
    Schema::table('loads', function (Blueprint $table) {

        // rollback new fields
        $table->dropForeign(['truck_type_required_id']);
        $table->dropColumn(['truck_type_required_id', 'priority', 'trip_days', 'notes']);

        // restore old fields
        $table->foreignId('driver_id')->nullable()->constrained();
        $table->foreignId('truck_id')->nullable()->constrained();
    });
}
};
