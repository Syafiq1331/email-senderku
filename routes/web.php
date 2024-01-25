<?php

// use App\Http\Controllers\admin\DashboardControler;
// use App\Http\Controllers\auth\AuthController;
// use Illuminate\Support\Facades\Route;

use App\Http\Controllers\admin\DashboardControler;
use App\Http\Controllers\auth\AuthController;
use App\Http\Controllers\master\AntrianController;
use App\Http\Controllers\master\SenderEmailController;
use App\Http\Controllers\user\DaftarAntrianController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return redirect('/daftar-antrian');
});

Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'authenticate'])->name('authenticate');

Route::get('/register', [AuthController::class, 'create'])->name('register');
Route::post('/register', [AuthController::class, 'store'])->name('store');

Route::get('/daftar-antrian', [DaftarAntrianController::class, 'index'])->name('daftar-antrian');
Route::post('/daftar-antrian', [DaftarAntrianController::class, 'store'])->name('daftar-antrian');

// Grup rute yang memerlukan autentikasi
Route::middleware(['auth'])->group(function () {
    // Rute dashboard
    Route::resource('dashboard', DashboardControler::class)->only(['index', 'destroy']);
    Route::get('/list-antrian', [AntrianController::class, 'index'])->name('listAntrian');
    Route::put('/update-status/{id}', [AntrianController::class, 'updateStatus'])->name('update.status');

    // Rute form email
    Route::get('/email-form', [SenderEmailController::class, 'showForm'])->name('showForm');
    // Rute kirim email
    Route::post('/sender-email', [SenderEmailController::class, 'sendEmail'])->name('send-email');
    // Rute bantuan
    Route::get('/bantuan', [SenderEmailController::class, 'bantuan'])->name('bantuan');
});
