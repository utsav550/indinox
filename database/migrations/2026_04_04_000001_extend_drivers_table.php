<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('drivers', function (Blueprint $table) {
            $table->enum('status', ['approved', 'pending', 'rejected'])
                  ->default('approved') // existing drivers stay approved
                  ->after('license_number');

            $table->enum('driver_type', ['fleet_driver', 'owner_operator'])
                  ->default('fleet_driver')
                  ->after('status');

            $table->text('admin_notes')->nullable()->after('driver_type');
            $table->timestamp('applied_at')->nullable()->after('admin_notes');
        });
    }

    public function down(): void
    {
        Schema::table('drivers', function (Blueprint $table) {
            $table->dropColumn(['status', 'driver_type', 'admin_notes', 'applied_at']);
        });
    }
};
