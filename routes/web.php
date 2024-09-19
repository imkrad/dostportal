<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['2fa','auth','verified'])->group(function () {
    Route::get('/', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');

    Route::resource('/profile', App\Http\Controllers\ProfileController::class);
    Route::resource('/executive', App\Http\Controllers\ExecutiveController::class);
    Route::resource('/hr', App\Http\Controllers\Modules\HrController::class);


    //Support Tickets
    Route::prefix('support-tickets')->group(function () {
        Route::controller(App\Http\Controllers\Modules\SupportTicketController::class)->group(function () {
            Route::get('/','index')->name('support_tickets');
            Route::post('/create','store')->name('support_ticket_store');
            Route::put('/update','update')->name('support_ticket_update');
        });
    });

});

require __DIR__.'/auth.php';
