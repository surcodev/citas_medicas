<?php

use App\Http\Controllers\Admin\DoctorController;
use App\Http\Controllers\Admin\PatientController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\AppointmentController;
use App\Http\Controllers\Admin\CalendarController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\RoleController;
use Illuminate\Support\Facades\Route;

Route::get('/', [DashboardController::class,'index'])->name('dashboard'); 

// GESTION
Route::resource('roles', RoleController::class);

Route::resource('users', UserController::class);
Route::resource('patients', PatientController::class)
    ->only(['index', 'edit', 'update']);
Route::resource('doctors', DoctorController::class)
    ->only(['index', 'edit', 'update']);
Route::get('doctors/{doctor}/schedules',[DoctorController::class, 'schedules'])
    ->name('doctors.schedules');
Route::get('appointments/{appointment}/consultation', [AppointmentController::class, 'consultation'])
    ->name('appointments.consultation');
Route::resource('appointments', AppointmentController::class);
Route::get('calendar', [CalendarController::class, 'index'])
    ->name('calendar.index');