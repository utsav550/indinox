<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Update the enum to include new statuses
        DB::statement("ALTER TABLE drivers MODIFY status ENUM(
            'approved',
            'pending',
            'rejected',
            'on_leave',
            'unavailable',
            'left_company'
        ) NOT NULL DEFAULT 'approved'");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE drivers MODIFY status ENUM(
            'approved',
            'pending',
            'rejected'
        ) NOT NULL DEFAULT 'approved'");
    }
};
