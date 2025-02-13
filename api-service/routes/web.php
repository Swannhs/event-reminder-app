<?php

use App\Http\Controllers\Api\EventReminderController;
use Illuminate\Support\Facades\Route;
//
//Route::get('/', function () {
//    return view('welcome');
//});

Route::prefix('api')->group(function () {
    Route::prefix('event-reminders')->group(function () {
        Route::get('/', [EventReminderController::class, 'index']);
        Route::post('/', [EventReminderController::class, 'store']);
        Route::get('/{id}', [EventReminderController::class, 'show']);
        Route::put('/{id}', [EventReminderController::class, 'update']);
        Route::delete('/{id}', [EventReminderController::class, 'destroy']);
    });
});
