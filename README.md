# Uptime Monitor for Laravel

## 🚀 Introduction
This package provides automated uptime monitoring for Laravel applications and extends vendor subscriptions based on recorded downtime. It is designed to ensure transparency by tracking platform availability and automatically compensating vendors for any service disruptions.

## 📦 Installation

You can install this package via Composer:
```sh
composer require rudev/uptime-monitor
```

After installation, publish the configuration file:
```sh
php artisan vendor:publish --provider="Rudev\UptimeMonitor\UptimeMonitorServiceProvider"
```

Run database migrations:
```sh
php artisan migrate

```

## 🔧 Configuration
The package configuration can be found in `config/uptime-monitor.php`. You can adjust the settings as needed:
```php
return [
    'check_interval' => 5, // Frequency of uptime checks in minutes
    'notify_admins' => true,
    'notify_vendors' => true,
];
```

## 🛠 Usage
### Running Uptime Checks
To manually check uptime, run:
```sh
php artisan uptime:check
```

### Adjust Vendor Subscriptions Based on Downtime
To extend vendor subscriptions based on downtime, run:
```sh
php artisan vendors:adjust-subscriptions
```

### Scheduling Automatic Checks
To automate uptime monitoring, add the following command to your `app/Console/Kernel.php`:
```php
protected function schedule(Schedule $schedule)
{
    $schedule->command('uptime:check')->everyFiveMinutes();
    $schedule->command('vendors:adjust-subscriptions')->daily();
}
```

## 📊 Database Structure
This package creates a `platform_uptime` table to track uptime status:
```php
Schema::create('platform_uptime', function (Blueprint $table) {
    $table->id();
    $table->enum('status', ['up', 'down']);
    $table->timestamp('downtime_start')->nullable();
    $table->timestamp('downtime_end')->nullable();
    $table->timestamps();
});
```

## 🤝 Contribution
If you want to contribute to this project, feel free to fork the repository, make improvements, and submit a pull request.

## 📄 License
This package is released under the MIT License.

## 📝 Author
Developed by **Radu Ungureanu**.
For support or suggestions, feel free to open an issue on [GitHub](https://github.com/rudev/uptime-monitor).

