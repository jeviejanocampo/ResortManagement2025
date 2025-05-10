<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Availability\RoomAvailabilityController;
use App\Http\Controllers\Availability\VenueAvailabilityController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Menu\OptionCategoryController;
use App\Http\Controllers\Menu\RoomController;
use App\Http\Controllers\Menu\UserController;
use App\Http\Controllers\Menu\VenueController;
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
    Route::resource('rooms', RoomController::class)
        ->names([
            'index' => 'rooms',
            'store' => 'rooms.store', 
            'update' => 'rooms.update',
            'destroy' => 'rooms.destroy'
        ])->parameters(['rooms' => 'room']);
    Route::get('room/{room}/availability', [RoomAvailabilityController::class, 'room'])
        ->name('room.availability');
    Route::post('room/{room}/booking', [RoomAvailabilityController::class, 'roomBooking'])
        ->name('room.booking');
    Route::get('room/{room}/events', [RoomAvailabilityController::class, 'getRoomEvents'])
        ->name('room.events');
    Route::resource('venues', VenueController::class)
        ->names([
            'index' => 'venues',
            'store' => 'venues.store', 
            'update' => 'venues.update',
            'destroy' => 'venues.destroy'
        ])->parameters(['venues' => 'venue']);
    Route::get('venue/{venue}/availability', [VenueAvailabilityController::class, 'venue'])
        ->name('venue.availability');
});
