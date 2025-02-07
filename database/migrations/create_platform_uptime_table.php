<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('platform_uptime', function (Blueprint $table) {
            $table->id();
            $table->enum('status', ['up', 'down']);
            $table->timestamp('downtime_start')->nullable();
            $table->timestamp('downtime_end')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('platform_uptime');
    }
};
