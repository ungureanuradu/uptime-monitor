<?php

namespace Rudev\UptimeMonitor\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Rudev\UptimeMonitor\Models\PlatformUptime;
use Carbon\Carbon;

class CheckUptime extends Command
{
    protected $signature = 'uptime:check';
    protected $description = 'Check the uptime of the platform';

    public function handle()
    {
        try {
            $response = Http::timeout(5)->get(config('app.url'));

            if ($response->successful()) {
                PlatformUptime::whereNull('downtime_end')
                    ->update(['downtime_end' => Carbon::now()]);
            } else {
                $this->recordDowntime();
            }
        } catch (\Exception $e) {
            $this->recordDowntime();
        }
    }

    private function recordDowntime()
    {
        if (!PlatformUptime::whereNull('downtime_end')->exists()) {
            PlatformUptime::create(['status' => 'down', 'downtime_start' => Carbon::now()]);
        }
    }
}
