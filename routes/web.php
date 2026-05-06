<?php

use Illuminate\Support\Facades\Route;

Route::get('/', [App\Http\Controllers\PrayerController::class, 'index'])->name('prayer.index');
Route::post('/jadwal', [App\Http\Controllers\PrayerController::class, 'show'])->name('prayer.show');
