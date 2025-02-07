<?php

namespace Rudev\UptimeMonitor\Commands;

use Illuminate\Console\Command;
use Rudev\UptimeMonitor\Models\Vendor;
use Rudev\UptimeMonitor\Models\PlatformUptime;
use Carbon\Carbon;

class AdjustVendorSubscriptions extends Command
{
    protected $signature = 'vendors:adjust-subscriptions';
    protected $description = 'Extends vendor subscriptions based on downtime';

    public function handle()
    {
        $downtimeMinutes = PlatformUptime::calculateTotalDowntime();

        Vendor::all()->each(function ($vendor) use ($downtimeMinutes) {
            $vendor->subscription_end = Carbon::parse($vendor->subscription_end)->addMinutes($downtimeMinutes);
            $vendor->save();
        });

        $this->info("Subscriptions extended by {$downtimeMinutes} minutes.");
    }
}
