<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InvitationController;
use App\Http\Controllers\AuthController;
use App\Models\Invitation;
use App\Models\Presence;


// Auth Routes


Route::controller(AuthController::class)->prefix('auth')->group(function () {
    Route::get('/login', 'showLogin')->name('login');
    Route::get('/register', 'showRegister')->name('register');
    Route::post('/login', 'login');
    Route::post('/register', 'register');
    Route::post('/logout', 'logout')->name('logout');


});

// Dashboard Route (Protected)
Route::middleware('auth')->group(function () {
    
    // Daftar Kehadiran (scan / attendance list)
    Route::get('/daftar-hadir', [InvitationController::class, 'daftarHadir'])->name('daftar-hadir');
});

// Invitation Routes
Route::controller(InvitationController::class)->prefix('sinergi')->group(function () {
    Route::get('/', 'index')->name('invitation.index');
    Route::post('/invitation/store', 'store')->name('invitation.store');
    Route::get('/invitation/{invitation}', 'show')->name('invitation.show');
    Route::get('/scan-qr', 'scanQR')->name('scan-qr');
    Route::get('/kartu', 'kartu')->name('kartu');
    Route::post('/record-presence', 'recordPresence')->name('record-presence');
    Route::delete('/invitation/{id}', 'destroy')->name('invitation.destroy');

    Route::get('/undangan', 'undangan')->name('undangan');

    Route::get('/export-undangan', 'exportExcel')->name('export-undangan');
    Route::get('/export-kehadiran', 'exportPresenceExcel')->name('export-kehadiran');

    Route::get('/dashboard', function () {

        $totalInvitations = Invitation::count();
        $presencesCount = Presence::count();
        $mahasiswaCount = Invitation::where('status', 'mahasiswa')->count();
        $alumniCount = Invitation::where('status', 'alumni')->count();
        $ortuCount = Invitation::where('status', 'ortu')->count();
        $todayInvitations = Invitation::whereDate('created_at', today())->count();
        $todayPresences = Presence::whereDate('created_at', today())->count();
        $latestInvitations = Invitation::latest()->limit(15)->get();

        return view('auth.dashboard.dashboard', compact(
            'totalInvitations',
            'presencesCount',
            'mahasiswaCount',
            'alumniCount',
            'ortuCount',
            'todayInvitations',
            'todayPresences',
            'latestInvitations'
        ));
    })->name('dashboard');
    Route::post('/invitation/{id}/mark-attendance', 'markAttendanceManual')->name('mark-attendance');
});

// API Routes
Route::controller(InvitationController::class)->prefix('api')->group(function () {
    Route::get('/invitation/{invitation}', 'getInvitationData');
    Route::post('/find-by-wa-ortu', 'findByWaOrtu');
});