<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\RoomController;





Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::post('/customers/insert', [CustomerController::class, 'insertUser']);

Route::post('/login/customers', [CustomerController::class, 'LoginCustomer']);

Route::get('/fetch-option-categories', [RoomController::class, 'fetchRooms']);

Route::get('/fetch-rooms', [RoomController::class, 'fetchRoomsByCategory']);

Route::get('/fetch-room-gallery', [RoomController::class, 'fetchRoomGallery']);
