<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;


Route::group(['middleware' => ['guest', 'prevent_back']], function() {
    Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('/login', [AuthenticatedSessionController::class, 'store']);
});

Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
    ->middleware('auth', 'prevent_back')
    ->name('logout');

Route::middleware(['auth', 'verified', 'role:is_superuser,is_owner,is_staff', 'prevent_back'])->group(function() {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
});
