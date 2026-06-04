<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InvitationController;
use App\Http\Controllers\AuthController;


// Auth Routes
Route::controller(AuthController::class)->prefix('sinergi')->group(function () {
    Route::get('/login', 'showLogin')->name('login');
    Route::get('/register', 'showRegister')->name('register');
    Route::post('/login', 'login')->name('login.store');
    Route::post('/register', 'register')->name('register.store');
    Route::post('/logout', 'logout')->name('logout');
    Route::get('/daftar-hadir', 'daftarHadir')->name('daftar-hadir');
    Route::get('/dashboard', 'dashboard')->name('dashboard');
    Route::post('/invitation/{id}/mark-attendance', 'markAttendanceManual')->name('mark-attendance');
});


// Invitation Routes
Route::controller(InvitationController::class)->prefix('sinergi')->group(function () {
    // Sinergi Invitation Routes (dengan prefix /sinergi)
    Route::get('/', 'index')->name('invitation.index');
    Route::post('/store', 'store')->name('invitation.store');
    Route::get('/scan-qr', 'scanQR')->name('scan-qr');
    Route::post('/record-presence', 'recordPresence')->name('record-presence');
    Route::post('/api/find-by-wa-mhs', 'findByWaOrtu')->name('find-by-wa-mhs');
    Route::post('/api/find-by-wa-ortu', 'findByWaOrtu')->name('find-by-wa-ortu');
    Route::get('/kartu', 'kartu')->name('kartu');
});

// Other invitation routes (tanpa prefix)
Route::controller(InvitationController::class)->group(function () {
    Route::get('/invitation/{invitation}', 'show')->name('invitation.show');
    Route::get('/scan-qr', 'scanQR');
    Route::post('/record-presence', 'recordPresence');
    Route::delete('/invitation/{id}', 'destroy')->name('invitation.destroy');
    Route::get('/undangan', 'undangan')->name('undangan');
    Route::get('/export-undangan', 'exportExcel')->name('export-undangan');
    Route::get('/export-kehadiran', 'exportPresenceExcel')->name('export-kehadiran');

    
});


// API Routes
Route::controller(InvitationController::class)->prefix('api')->group(function () {
    Route::get('/invitation/{invitation}', 'getInvitationData');
    Route::post('/find-by-wa-mhs', 'findByWaOrtu')->name('scan.find-by-wa-mhs');
    Route::post('/find-by-wa-ortu', 'findByWaOrtu')->name('scan.find-by-wa-ortu');
});

Route::controller(InvitationController::class)->prefix('sinergi/api')->group(function () {
    Route::post('/find-by-wa-mhs', 'findByWaOrtu');
    Route::post('/find-by-wa-ortu', 'findByWaOrtu');
});
