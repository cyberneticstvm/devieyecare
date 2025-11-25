<?php

use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\CampController;
use App\Http\Controllers\CampDetailController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware(['web'])->group(function () {
    Route::prefix('')->controller(AuthController::class)->group(function () {
        Route::get('/', 'loginPage')->name('login');
        Route::post('/', 'login')->name('user.login');
    });

    Route::middleware(['web', 'auth', 'auth.session', 'team'])->group(function () {
        Route::prefix('home')->controller(AuthController::class)->group(function () {
            Route::get('/', 'index')->name('index');
            Route::post('update/branch', 'updateBranch')->name('user.branch.update');
        });
    });

    Route::middleware(['web', 'auth', 'auth.session', 'team', 'branch'])->group(function () {
        Route::prefix('')->controller(AuthController::class)->group(function () {
            Route::get('logout', 'logout')->name('logout');
        });

        Route::prefix('branch')->controller(BranchController::class)->group(function () {
            Route::get('', 'index')->name('branch.list');
            Route::get('create', 'create')->name('branch.create');
            Route::post('create', 'store')->name('branch.save');
            Route::get('edit/{id}', 'edit')->name('branch.edit');
            Route::post('edit/{id}', 'update')->name('branch.update');
            Route::get('delete/{id}', 'destroy')->name('branch.delete');
        });

        Route::prefix('role')->controller(RoleController::class)->group(function () {
            Route::get('', 'index')->name('role.list');
            Route::get('create', 'create')->name('role.create');
            Route::post('create', 'store')->name('role.save');
            Route::get('edit/{id}', 'edit')->name('role.edit');
            Route::post('edit/{id}', 'update')->name('role.update');
            Route::get('delete/{id}', 'destroy')->name('role.delete');
        });

        Route::prefix('user')->controller(UserController::class)->group(function () {
            Route::get('', 'index')->name('user.list');
            Route::get('create', 'create')->name('user.create');
            Route::post('create', 'store')->name('user.save');
            Route::get('edit/{id}', 'edit')->name('user.edit');
            Route::post('edit/{id}', 'update')->name('user.update');
            Route::get('delete/{id}', 'destroy')->name('user.delete');
        });

        Route::prefix('doctor')->controller(DoctorController::class)->group(function () {
            Route::get('', 'index')->name('doctor.list');
            Route::get('create', 'create')->name('doctor.create');
            Route::post('create', 'store')->name('doctor.save');
            Route::get('edit/{id}', 'edit')->name('doctor.edit');
            Route::post('edit/{id}', 'update')->name('doctor.update');
            Route::get('delete/{id}', 'destroy')->name('doctor.delete');
        });

        Route::prefix('appointment')->controller(AppointmentController::class)->group(function () {
            Route::get('', 'index')->name('appointment.list');
            Route::get('create', 'create')->name('appointment.create');
            Route::post('create', 'store')->name('appointment.save');
            Route::get('edit/{id}', 'edit')->name('appointment.edit');
            Route::post('edit/{id}', 'update')->name('appointment.update');
            Route::get('delete/{id}', 'destroy')->name('appointment.delete');
        });

        Route::prefix('registration')->controller(RegistrationController::class)->group(function () {
            Route::get('', 'index')->name('registration.list');
            Route::get('create/{rtype}/{typeid}', 'create')->name('registration.create');
            Route::post('create/{rtype}/{typeid}', 'store')->name('registration.save');
            Route::get('edit/{id}', 'edit')->name('registration.edit');
            Route::post('edit/{id}', 'update')->name('registration.update');
            Route::get('delete/{id}', 'destroy')->name('registration.delete');
        });

        Route::prefix('camp')->controller(CampController::class)->group(function () {
            Route::get('', 'index')->name('camp.list');
            Route::get('create/', 'create')->name('camp.create');
            Route::post('create/', 'store')->name('camp.save');
            Route::get('edit/{id}', 'edit')->name('camp.edit');
            Route::post('edit/{id}', 'update')->name('camp.update');
            Route::get('delete/{id}', 'destroy')->name('camp.delete');
        });

        Route::prefix('camp/patient')->controller(CampDetailController::class)->group(function () {
            Route::get('{cid}', 'index')->name('camp.patient.list');
            Route::get('create/', 'create')->name('camp.patient.create');
            Route::post('create/', 'store')->name('camp.patient.save');
            Route::get('edit/{id}', 'edit')->name('camp.patient.edit');
            Route::post('edit/{id}', 'update')->name('camp.patient.update');
            Route::get('delete/{id}', 'destroy')->name('camp.patient.delete');
        });
    });
});
