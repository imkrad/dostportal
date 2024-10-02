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

    // //FAIMS
    // Route::prefix('faims')->group(function () {
    //     Route::controller(App\Http\Controllers\Modules\FAIMS\Procurement\PurchaseRequestController::class)->group(function () {

    //         // Route::get('/purchase-request','index')->name('purchase_request_index');
    //         // Route::get('/purchase-request/create/index','show')->name('show');
    //         // Route::get('/unit_type','index');
    //         // Route::get('/sections','index');
    //         // Route::post('/purchase-request/create','store');
          
    //         // For Printing
    //         Route::get('/print','print');
    //     });
    // });

    Route::prefix('faims')->group(function () {
        Route::resource('/purchase-request', App\Http\Controllers\Modules\FAIMS\Procurement\PurchaseRequestController::class)->names([
            'index' => 'purchase_request.index',
            'show' => 'purchase_request.show',
            'store' => 'purchase_request.store',
        ]);
    });


});

require __DIR__.'/auth.php';
