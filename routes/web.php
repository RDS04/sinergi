<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InvitationController;


Route::controller(InvitationController::class)->group(function () {
    Route::get('/', 'index')->name('invitation.index');
    Route::post('/invitation/store', 'store')->name('invitation.store');
    Route::get('/invitation/{invitation}', 'show')->name('invitation.show');
    Route::get('/scan-qr', 'scanQR')->name('scan-qr');
    Route::get('/kartu', 'kartu')->name('kartu');
    Route::post('/record-presence', 'recordPresence')->name('record-presence');
    Route::delete('/invitation/{id}', 'destroy')->name('invitation.destroy');
    
    Route::get('/undangan', 'undangan')->name('undangan');
});

// API Routes
Route::controller(InvitationController::class)->prefix('api')->group(function () {
    Route::get('/invitation/{invitation}', 'getInvitationData');
    Route::post('/find-by-wa-ortu', 'findByWaOrtu');
});