<?php

use App\Http\Controllers\Api\CsvEventReminderController;
use App\Http\Controllers\Api\EventReminderController;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Support\Facades\Route;

Route::prefix('api')->group(function () {
    Route::prefix('event-reminders')->group(function () {
        Route::get('/', [EventReminderController::class, 'index']);
        Route::post('/', [EventReminderController::class, 'store']);
        Route::get('/{id}', [EventReminderController::class, 'show']);
        Route::put('/{id}', [EventReminderController::class, 'update']);
        Route::delete('/{id}', [EventReminderController::class, 'destroy']);

        Route::withoutMiddleware([VerifyCsrfToken::class])
            ->post('/import', [CsvEventReminderController::class, 'importCsv']);
    });
});
