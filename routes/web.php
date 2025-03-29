<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ResidentController;
use App\Http\Controllers\BookingController;

Route::get('/', function () {
    return view('main');
});

Route::post('/check-resident', [ResidentController::class, 'checkResident']);
Route::post('/register-resident', [ResidentController::class, 'registerResident']);
Route::get('/bookings', [BookingController::class, 'getBookings']);
Route::get('/areas', [BookingController::class, 'getAreas']);
Route::post('/create-booking', [BookingController::class, 'createBooking']);
