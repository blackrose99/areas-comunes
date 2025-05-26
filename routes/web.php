<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ResidentController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\AuthController;


Route::get('/', function () {
    return view('main');
});

Route::post('/check-resident', [ResidentController::class, 'checkResident']);
Route::post('/register-resident', [ResidentController::class, 'registerResident']);
Route::get('/areas', [BookingController::class, 'getAreas']);
Route::post('/create-booking', [BookingController::class, 'createBooking']);
Route::get('/time-ranges', [BookingController::class, 'getTimeRanges']);
Route::post('/bookings', [BookingController::class, 'createBooking']);
//Route::get('/bookings', [BookingController::class, 'getBookings']);
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::post('/bookings/{id}/approve', [BookingController::class, 'approveBooking']);
Route::post('/bookings/{id}/reject', [BookingController::class, 'rejectBooking']);
Route::get('/bookings/list', [BookingController::class, 'renderBookingsList'])->name('bookings.index');
