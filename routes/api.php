<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\YogaController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('/yoga', [YogaController::class, 'getData']);
Route::post('/yoga', [YogaController::class, 'store']);
Route::post('/book', [YogaController::class, 'book']);
Route::get('/bookings', [YogaController::class, 'getBooking']);