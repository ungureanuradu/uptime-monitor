<?php

namespace Rudev\UptimeMonitor\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class PlatformUptime extends Model
{
    protected $fillable = ['status', 'downtime_start', 'downtime_end'];

    public static function calculateTotalDowntime()
    {
        return self::whereNotNull('downtime_end')
            ->sum(\DB::raw("TIMESTAMPDIFF(MINUTE, downtime_start, downtime_end)"));
    }
}
