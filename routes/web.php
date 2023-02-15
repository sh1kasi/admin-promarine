<?php

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\OvertimeController;
use App\Http\Controllers\PresenceController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LoginController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect()->route('dashboard.index');
});

// Login
Route::get('/login', [LoginController::class, 'index'])->name('login.index');
Route::post('/login/store', [LoginController::class, 'store'])->name('login.store');
Route::post('logout', [LoginController::class, 'logout'])->name('user.logout');

Route::group(['middleware' => ['auth']], function() {
    // Home
    Route::get('/home', [Controller::class, 'index'])->name('home.index');

     // Presence
     Route::get('/kehadiran', [PresenceController::class, 'index'])->name('presence.index');
     Route::get('/kehadiran/json', [PresenceController::class, 'data'])->name('presence.json');
     Route::post('/kehadiran/store', [PresenceController::class, 'store'])->name('presence.store');
     Route::post('/kehadiran/detail', [PresenceController::class, 'detail'])->name('presence.detail');

     // Lemburan 
     Route::post('/lemburan/store', [OvertimeController::class, 'store'])->name('overtime.store');
     Route::get('/lemburan/absen', [OvertimeController::class, 'presence_index'])->name('overtime.presence');
     Route::post('/lemburan/presence/store', [OvertimeController::class, 'presence_store'])->name('overtime.presence.store');
     Route::get('/lemburan/absen/json', [OvertimeController::class, 'presence_data'])->name('overtime.presence.json');
});

Route::group(['middleware' => ['auth', 'cekLevel:admin']], function() {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
    
    // Employee
    Route::get('/pegawai', [EmployeeController::class, 'index'])->name('employee.index');
    Route::get('/pegawai/json', [EmployeeController::class, 'data'])->name('employee.json');
    Route::post('/pegawai/store', [EmployeeController::class, 'store'])->name('employee.store');
    Route::post('/pegawai/update/{id}', [EmployeeController::class, 'update'])->name('employee.edit');
    
    
    // Overtime
    Route::get('/lemburan', [OvertimeController::class, 'index'])->name('overtime.index');
    Route::get('/lemburan/json', [OvertimeController::class, 'data'])->name('overtime.json');
});



