<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Menu\OptionCategoryController;
use App\Http\Controllers\Menu\UserController;
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
    Route::resource('users', UserController::class)
        ->names([
            'index' => 'users',
            'store' => 'users.store', 
            'update' => 'users.update',
            'destroy' => 'users.destroy'
        ])->parameters(['users' => 'user']);
    Route::resource('categories', OptionCategoryController::class)
        ->names([
            'index' => 'categories',
            'store' => 'categories.store', 
            'update' => 'categories.update',
            'destroy' => 'categories.destroy'
        ])->parameters(['categories' => 'category']);
});
