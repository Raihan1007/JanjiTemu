<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\UserLoginController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\PetugasController;
use App\Http\Controllers\HistoriImportController;

// ================= LANDING =================
Route::get('/', function () {
    return view('landingpage');
})->name('landing');

// ================= USER BOOKING =================
Route::get('/booking', [BookingController::class, 'create'])
    ->middleware('auth')
    ->name('booking.index');

Route::post('/booking', [BookingController::class, 'store'])
    ->name('booking.store');

Route::get('/booking/confirmation/{id}', function ($id) {
    $booking = \App\Models\Booking::with(['layanan', 'petugas'])->findOrFail($id);
    return view('confirmation', compact('booking'));
})->name('booking.confirmation');

// ================= AUTH USER =================
Route::get('/login-user', function () {
    return view('auth.login-user');
})->name('login.user');

Route::post('/login-user', [UserLoginController::class, 'login'])
    ->name('login.user.submit');

Route::post('/logout', function () {
    auth()->logout();
    return redirect('/');
})->name('logout');

// ================= ADMIN AUTH =================
Route::get('/admin/login', [AdminAuthController::class, 'showLogin'])->name('admin.login');
Route::post('/admin/login', [AdminAuthController::class, 'login'])->name('admin.login.submit');
Route::post('/admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');
Route::post('/admin/booking/{id}/confirm', [BookingController::class, 'confirm'])->name('booking.confirm');
Route::post('/admin/booking/{id}/cancel', [BookingController::class, 'cancel'])->name('booking.cancel');

// ================= AJAX =================
Route::get('/get-petugas/{layanan}', [BookingController::class, 'getPetugas']);
Route::get('/get-booked-slots', [BookingController::class, 'getBookedSlots']);

// ================= ADMIN =================
Route::middleware(['auth:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        //LAYANAN
        Route::get('/layanan', [AdminController::class, 'layanan'])->name('layanan');

        //BOOKING
        Route::get('/bookings', [BookingController::class, 'index'])->name('bookings.index');
        Route::get('/bookings/{booking}', [BookingController::class, 'show'])->name('bookings.show');

        //MULAI-SELESAI
        Route::post('/admin/booking/{id}/mulai', [BookingController::class, 'mulai'])
            ->name('booking.mulai');

        Route::post('/admin/booking/{id}/selesai', [BookingController::class, 'selesai'])
            ->name('booking.selesai');
    });

// ================= SUPER ADMIN =================
Route::middleware(['auth:admin', 'super_admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        // DASHBOARD / LAPORAN
        Route::get('dashboard', [AdminController::class, 'dashboard'])
            ->name('dashboard');
        Route::get('dashboard/export', [AdminController::class, 'export'])
            ->name('dashboard.export');

        //PETUGAS
        Route::get('/petugas', [BookingController::class, 'petugasIndex'])
            ->name('petugas.index');
        Route::post('/petugas', [BookingController::class, 'storePetugas'])
            ->name('petugas.store');

        Route::get('/petugas/{id}', [BookingController::class, 'petugasShow']);
        Route::put('/petugas/{id}', [BookingController::class, 'petugasUpdate']);
        Route::delete('/petugas/{id}', [BookingController::class, 'petugasDelete']);

        //USER
        Route::get('/users', [AdminController::class, 'users'])
            ->name('users.index');

        //RATING
        Route::get('/ratings', [AdminController::class, 'ratings'])
            ->name('ratings');

        // IMPORT HISTORI LAYANAN
        Route::get('/import-histori', [HistoriImportController::class, 'index'])
            ->name('import.index');

        Route::post('/import-histori', [HistoriImportController::class, 'store'])
            ->name('import.store');
        // HISTORI LAYANAN
        Route::get('/histori', [HistoriImportController::class, 'histori'])
            ->name('histori');
    });

    // ================= RATING DARI USER =================
        Route::get('/rating', [BookingController::class, 'ratingForm'])
            ->name('rating.form');

        Route::post('/rating', [BookingController::class, 'storeRating'])
            ->name('rating.store');



// ================= TEST =================
Route::get('/test-model', function () {
    return \App\Models\Layanan::with('petugas')->get();
});