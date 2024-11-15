<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/leaves', [App\Http\Controllers\leaveController::class, 'leaveApply'])->middleware('auth:api');
Route::post('/apply', [App\Http\Controllers\leaveController::class, 'leaveSave'])->middleware('auth:api');

Route::get('/zones', [App\Http\Controllers\geoFenController::class, 'getAllZone'])->middleware('auth:api');

Route::post('/submit-attendance', [App\Http\Controllers\geoFenController::class, 'store'])->middleware('auth:api');
Route::get('/attendance', [App\Http\Controllers\attendanceController::class, 'attendanceIndex'])->middleware('auth:api');
