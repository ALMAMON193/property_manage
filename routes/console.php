<?php

use App\Http\Controllers\API\OtpController;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Schedule::call(function () {
    app(OtpController::class)->cleanupExpiredOtps();
})->hourly();

Schedule::command('update:retailers')
    ->everyMinute() // Adjust the interval as needed (e.g., `everyFiveMinutes`, `daily`)
    ->withoutOverlapping(); // Prevent duplicate jobs if the command takes time to execute
