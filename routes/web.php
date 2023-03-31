<?php

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\KasbonController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\OvertimeController;
use App\Http\Controllers\PresenceController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\DashboardController;

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

// Register
Route::get('/register', [RegisterController::class, 'index'])->name('register.index');
Route::post('/register/post', [RegisterController::class, 'post'])->name('register.post');

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
     Route::post('/kehadiran/update/{id}', [PresenceController::class, 'update'])->name('presence.update');
     Route::post('/kehadiran/detail', [PresenceController::class, 'detail'])->name('presence.detail');

     // Lemburan 
     Route::post('/lemburan/store', [OvertimeController::class, 'store'])->name('overtime.store');
     Route::get('/lemburan/absen', [OvertimeController::class, 'presence_index'])->name('overtime.presence');
     Route::post('/lemburan/presence/store', [OvertimeController::class, 'presence_store'])->name('overtime.presence.store');
     Route::post('/lemburan/presence/update/{id}', [OvertimeController::class, 'presence_update'])->name('overtime.presence.update');
     Route::get('/lemburan/absen/json', [OvertimeController::class, 'presence_data'])->name('overtime.presence.json');

    // Kasbon
    Route::get('/kasbon/cetak', [KasbonController::class, 'kasbon_detail_pdf'])->name('kasbon.detail.pdf');


});

Route::group(['middleware' => ['auth', 'cekLevel:user']], function() {
    // Kasbon
    Route::get('/kasbon', [KasbonController::class, 'user_index'])->name('kasbon.user.index');
    Route::get('/kasbon/input', [KasbonController::class, 'input_index'])->name('kasbon.input.index');
    Route::get('/kasbon/user/json', [KasbonController::class, 'user_data'])->name('kasbon.user.json');
    Route::post('/kasbon/user/post', [KasbonController::class, 'store'])->name('kasbon.store');

});

Route::group(['middleware' => ['auth', 'cekLevel:admin']], function() {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
    
    // Employee
    Route::get('/pegawai', [EmployeeController::class, 'index'])->name('employee.index');
    Route::get('/pegawai/json', [EmployeeController::class, 'data'])->name('employee.json');
    Route::get('pegawai/detail/{id}', [EmployeeController::class, 'employee_detail'])->name('employee.detail');
    Route::get('/pegawai/harian/detail/json/{id}', [EmployeeController::class, 'data_detail_harian'])->name('employee.harian.json.detail');
    Route::get('/pegawai/bulanan/detail/json/{id}', [EmployeeController::class, 'data_detail_bulanan'])->name('employee.bulanan.json.detail');
    Route::get('/pegawai/cetak', [EmployeeController::class, 'employee_detail_pdf'])->name('employee.detail.pdf');
    Route::post('/pegawai/store', [EmployeeController::class, 'store'])->name('employee.store');
    Route::post('/pegawai/edit/{id}', [EmployeeController::class, 'edit'])->name('employee.edit');
    Route::post('/pegawai/update/{id}', [EmployeeController::class, 'update'])->name('employee.update');
    Route::get('/pegawai/delete/{id}', [EmployeeController::class, 'delete'])->name('employee.delete');
    
    
    // Overtime
    Route::get('/lemburan', [OvertimeController::class, 'index'])->name('overtime.index');
    Route::get('/lemburan/json', [OvertimeController::class, 'data'])->name('overtime.json');
    Route::get('/lemburan/absen/admin/json', [OvertimeController::class, 'data_presence_admin'])->name('overtime.admin.json');
    Route::get('/lemburan/detail/json', [OvertimeController::class, 'data_overtime_detail'])->name('overtime.detail.json');
    Route::post('/lemburan/update/{id}', [OvertimeController::class, 'update'])->name('oovertime.update');
    Route::get('/lemburan/delete/{id}', [OvertimeController::class, 'delete'])->name('overtime.delete');

    // Kasbon
    Route::get('/kasbon/admin', [KasbonController::class, 'index'])->name('kasbon.admin.index');
    Route::get('/kasbon/admin/json', [KasbonController::class, 'data'])->name('kasbon.admin.json');
    Route::post('/kasbon/complete/{id}', [KasbonController::class, 'complete'])->name('kasbon.complete');
    Route::post('/kasbon/reject/{id}', [KasbonController::class, 'reject'])->name('kasbon.reject');
    Route::post('/kasbon-count', [KasbonController::class, 'count'])->name('kasbon.count');
});



