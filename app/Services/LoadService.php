<?php
namespace App\Services;

use App\Models\Load;
use Carbon\Carbon;

class LoadService
{
    public static function updateExpired()
    {
        $today = Carbon::today();

        Load::where('status', 'pending')
            ->whereDate('pickup_date', '<', $today)
            ->update([
                'status' => 'expired'
            ]);
    }
}