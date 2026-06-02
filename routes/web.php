<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InvitationController;
use App\Http\Controllers\AuthController;
use App\Models\Invitation;
use App\Models\Presence;


// Auth Routes
Route::middleware('guest')->prefix('auth')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');
});


// Dashboard Route (Protected)
Route::middleware('auth')->group(function () {
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
    // Daftar Kehadiran (scan / attendance list)
    Route::get('/daftar-hadir', [InvitationController::class, 'daftarHadir'])->name('daftar-hadir');
    
    // Export routes
    Route::get('/export-undangan', [InvitationController::class, 'exportExcel'])->name('export-undangan');
    Route::get('/export-kehadiran', [InvitationController::class, 'exportPresenceExcel'])->name('export-kehadiran');
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
});

// Manual Mark Attendance Route (Protected)
Route::middleware('auth')->controller(InvitationController::class)->group(function () {
    Route::post('/invitation/{id}/mark-attendance', 'markAttendanceManual')->name('mark-attendance');
});

// API Routes
Route::controller(InvitationController::class)->prefix('api')->group(function () {
    Route::get('/invitation/{invitation}', 'getInvitationData');
    Route::post('/find-by-wa-ortu', 'findByWaOrtu');
});