<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Web\Backend\AdminController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified', 'user'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});




/*============ LOG CLEAR ROUTE ==========*/
Route::get('/log-clear/rh', function () {
    file_put_contents(storage_path('logs/laravel.log'), '');
    return 'Log file cleared!';
});

Route::get('/log/rh', function () {
    $path = storage_path('logs/laravel.log');

    if (!File::exists($path)) {
        return response('Log file does not exist.', 404);
    }

    $logContent = File::get($path);

    return response("<pre>{$logContent}</pre>");
})->name('logs.view');







require __DIR__.'/auth.php';
require __DIR__.'/backend.php';
