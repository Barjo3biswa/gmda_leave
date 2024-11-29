<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });


Route::get('/invalidate-token', [App\Http\Controllers\Auth\TokenController::class, 'invalidateToken'])->name('invalidate-token');

Route::group(['middleware' => 'auth.jwt'], function () {
    // Route::get('/', function () {
    //     return view('welcome');
    // });
    Route::get('/', [App\Http\Controllers\homeController::class, 'index'])->name('leave.holyday-index');
    Route::get('/graph-data', [App\Http\Controllers\homeController::class, 'graphData'])->name('leave.graph-data');

    Route::get('/holyday-index', [App\Http\Controllers\holydayController::class, 'holydayIndex'])->name('leave.holyday-index');
    Route::post('/holyday-save', [App\Http\Controllers\holydayController::class, 'holydaySave'])->name('leave.holyday-save');
    Route::post('/holyday-import', [App\Http\Controllers\holydayController::class, 'holydayImport'])->name('leave.holyday-import');
    Route::get('/holyday-delete', [App\Http\Controllers\holydayController::class, 'holydayDelete'])->name('leave.holyday-delete');
    Route::get('/sample-holyday', [App\Http\Controllers\holydayController::class, 'sampleHolyday'])->name('leave.sample-holyday');

    Route::get('/leave-type', [App\Http\Controllers\leaveController::class, 'leaveType'])->name('leave.leave-type');
    Route::post('/leave-type-save', [App\Http\Controllers\leaveController::class, 'leaveTypeSave'])->name('leave.leave-type-save');
    Route::get('/apply', [App\Http\Controllers\leaveController::class, 'leaveApply'])->name('leave.apply');
    Route::post('/apply-save', [App\Http\Controllers\leaveController::class, 'leaveSave'])->name('leave.apply-save');
    Route::get('/trans', [App\Http\Controllers\leaveController::class, 'leaveTrans'])->name('leave.trans');
    Route::get('/employee-details', [App\Http\Controllers\leaveController::class, 'empDetails'])->name('leave.employee-details');
    Route::get('/leave-inbox', [App\Http\Controllers\leaveController::class, 'leaveInbox'])->name('leave.leave-inbox');
    Route::get('/leave-update/{id}', [App\Http\Controllers\leaveController::class, 'leaveUpdate'])->name('leave.leave-update');
    Route::post('/update-store/{id}', [App\Http\Controllers\leaveController::class, 'storeUpdate'])->name('leave.update-store');

    Route::get('/punch-data', [App\Http\Controllers\attendanceController::class, 'punchIndex'])->name('leave.punch-data');
    Route::get('/sample-punch', [App\Http\Controllers\attendanceController::class, 'samplePunch'])->name('leave.sample-punch');
    Route::post('/punch-upload', [App\Http\Controllers\attendanceController::class, 'uploadPunch'])->name('leave.punch-upload');
    Route::get('/attendance-view', [App\Http\Controllers\attendanceController::class, 'attendanceIndex'])->name('leave.attendance-view');
    Route::post('/attendance-update', [App\Http\Controllers\attendanceController::class, 'attendanceUpdate'])->name('leave.attendance-update');

    Route::get('/shift-master', [App\Http\Controllers\shiftController::class, 'shiftMaster'])->name('leave.shift-master');
    Route::post('/shift-type-save', [App\Http\Controllers\shiftController::class, 'shiftMasterStore'])->name('leave.shift-type-save');
    Route::get('/shift-roaster', [App\Http\Controllers\shiftController::class, 'roasterIndex'])->name('leave.shift-roaster');
    Route::post('/roaster-save', [App\Http\Controllers\shiftController::class, 'roasterSave'])->name('leave.roaster-save');
    Route::post('/roster-change/{id}', [App\Http\Controllers\shiftController::class, 'roasterChange'])->name('leave.roster-change');


});
