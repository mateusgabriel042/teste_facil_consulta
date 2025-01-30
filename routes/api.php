<?php

use App\Http\Controllers\Admin\Consultation\ConsultationController;
use App\Http\Controllers\Admin\Core\UserController;
use App\Http\Controllers\Admin\Doctor\DoctorController;
use App\Http\Controllers\Admin\Location\CityController;
use App\Http\Controllers\Admin\Patient\PatientController;
use App\Http\Middleware\JwtMiddleware;
use App\Http\Controllers\Auth\AuthController;
use Illuminate\Support\Facades\Route;

Route::middleware([JwtMiddleware::class])->group(function () {
    Route::group(['prefix' => 'user', 'middleware' => 'throttle:user'], function () {
        Route::get('/', [UserController::class, 'index'])->name('user.index');
    });

    Route::group(['prefix' => 'medicos', 'middleware' => 'throttle:doctor'], function () {
        Route::get('/', [DoctorController::class, 'index'])->name('doctor.index');
        Route::post('/', [DoctorController::class, 'store'])->name('doctor.store');
        Route::post('/consulta', [DoctorController::class, 'storeConsultation'])->name('doctor.store_consultation');
        Route::get('/{id_medico}/pacientes', [DoctorController::class, 'patients'])->name('doctor.patients');
    });

    Route::group(['prefix' => 'pacientes', 'middleware' => 'throttle:patient'], function () {
        Route::post('/', [PatientController::class, 'store'])->name('patient.store');
        Route::put('/{id_paciente}', [PatientController::class, 'update'])->name('patient.update');
    });
});

Route::group(['prefix' => 'cidades', 'middleware' => 'throttle:city'], function () {
    Route::get('/', [CityController::class, 'index'])->name('city.index');
    Route::get('/{id_cidade}/medicos', [CityController::class, 'doctors'])->name('city.doctors');
});

Route::group(['prefix' => 'auth', 'middleware' => 'throttle:auth'], function () {
    Route::post('/login', [AuthController::class, 'login'])->name('auth.login');
});