<?php

use App\Http\Controllers\AjaxController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\CampController;
use App\Http\Controllers\CampDetailController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\HeadController;
use App\Http\Controllers\HelperController;
use App\Http\Controllers\IncomeExpenseController;
use App\Http\Controllers\ManufacturerSupplierController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PharmacyController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\TransferController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\VehiclePaymentController;
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
            Route::get('force/logout', 'forceLogout')->name('force.logout');
            Route::post('force/logout', 'forceLogoutAll')->name('force.logout.all');
            Route::get('logout', 'logout')->name('logout');
        });

        Route::prefix('ajax')->controller(AjaxController::class)->group(function () {
            Route::get('product', 'getProductById')->name('ajax.get.product.by.id');
            Route::get('batch', 'getBatch')->name('ajax.get.batch');
            Route::get('order/details', 'getOrderDetails')->name('ajax.get.order.details');
            Route::get('expense/details', 'getExpenseDetails')->name('ajax.get.expense.details');
            Route::get('vpayment/details', 'getVPaymentDetails')->name('ajax.get.vpayment.details');
            Route::get('batch/price', 'getBatchPrice')->name('ajax.get.batch.price');
            Route::get('chart/regorder', 'getRegOrder')->name('ajax.chart.reg.order');
        });

        Route::prefix('helper')->controller(HelperController::class)->group(function () {
            Route::get('inventory', 'inventory')->name('inventory');
            Route::post('inventory', 'getInventory')->name('get.inventory');
            Route::get('registration', 'searchRegistration')->name('search.registration');
            Route::post('registration', 'searchRegistrationShow')->name('search.registration.show');
            Route::post('store/order/status/update', 'storeOrderStatusUpdate')->name('store.order.status.update');
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

        Route::prefix('vehicle')->controller(VehicleController::class)->group(function () {
            Route::get('', 'index')->name('vehicle.list');
            Route::get('create/', 'create')->name('vehicle.create');
            Route::post('create/', 'store')->name('vehicle.save');
            Route::get('edit/{id}', 'edit')->name('vehicle.edit');
            Route::post('edit/{id}', 'update')->name('vehicle.update');
            Route::get('delete/{id}', 'destroy')->name('vehicle.delete');
        });

        Route::prefix('vehicle/payment')->controller(VehiclePaymentController::class)->group(function () {
            Route::get('{vid}', 'index')->name('vehicle.payment.list');
            Route::get('create/', 'create')->name('vehicle.payment.create');
            Route::post('create/', 'store')->name('vehicle.payment.save');
            Route::get('edit/{id}', 'edit')->name('vehicle.payment.edit');
            Route::post('edit/{id}', 'update')->name('vehicle.payment.update');
            Route::get('delete/{id}', 'destroy')->name('vehicle.payment.delete');
        });

        Route::prefix('head')->controller(HeadController::class)->group(function () {
            Route::get('', 'index')->name('head.list');
            Route::get('create/', 'create')->name('head.create');
            Route::post('create/', 'store')->name('head.save');
            Route::get('edit/{id}', 'edit')->name('head.edit');
            Route::post('edit/{id}', 'update')->name('head.update');
            Route::get('delete/{id}', 'destroy')->name('head.delete');
        });

        Route::prefix('ie')->controller(IncomeExpenseController::class)->group(function () {
            Route::get('{category}', 'index')->name('ie.list');
            Route::get('create/{category}', 'create')->name('ie.create');
            Route::post('create/{category}', 'store')->name('ie.save');
            Route::get('edit/{category}/{id}', 'edit')->name('ie.edit');
            Route::post('edit/{category}/{id}', 'update')->name('ie.update');
            Route::get('delete/{category}/{id}', 'destroy')->name('ie.delete');
        });

        Route::prefix('ms')->controller(ManufacturerSupplierController::class)->group(function () {
            Route::get('{category}', 'index')->name('ms.list');
            Route::get('create/{category}', 'create')->name('ms.create');
            Route::post('create/{category}', 'store')->name('ms.save');
            Route::get('edit/{category}/{id}', 'edit')->name('ms.edit');
            Route::post('edit/{category}/{id}', 'update')->name('ms.update');
            Route::get('delete/{category}/{id}', 'destroy')->name('ms.delete');
        });

        Route::prefix('product')->controller(ProductController::class)->group(function () {
            Route::get('', 'index')->name('product.list');
            Route::get('create/', 'create')->name('product.create');
            Route::post('create/', 'store')->name('product.save');
            Route::get('edit/{id}', 'edit')->name('product.edit');
            Route::post('edit/{id}', 'update')->name('product.update');
            Route::get('delete/{id}', 'destroy')->name('product.delete');
        });

        Route::prefix('payment')->controller(PaymentController::class)->group(function () {
            Route::get('', 'index')->name('payment.list');
            Route::get('create/', 'create')->name('payment.create');
            Route::post('create/', 'store')->name('payment.save');
            Route::get('edit/{id}', 'edit')->name('payment.edit');
            Route::post('edit/{id}', 'update')->name('payment.update');
            Route::get('delete/{id}', 'destroy')->name('payment.delete');
        });

        Route::prefix('order')->controller(OrderController::class)->group(function () {
            Route::get('', 'index')->name('store.order.list');
            Route::get('edit/{rid}/{source}', 'edit')->name('store.order.edit');
            Route::post('edit/{rid}', 'update')->name('store.order.update');
            Route::get('delete/{id}', 'destroy')->name('store.order.delete');
        });

        Route::prefix('pharmacy')->controller(PharmacyController::class)->group(function () {
            Route::get('', 'index')->name('pharmacy.order.list');
            Route::get('create/{rid}', 'create')->name('pharmacy.order.create');
            Route::post('create/{rid}', 'store')->name('pharmacy.order.save');
            Route::get('edit/{id}', 'edit')->name('pharmacy.order.edit');
            Route::post('edit/{id}', 'update')->name('pharmacy.order.update');
            Route::get('delete/{id}', 'destroy')->name('pharmacy.order.delete');
        });

        Route::prefix('purchase')->controller(PurchaseController::class)->group(function () {
            Route::get('', 'index')->name('purchase.list');
            Route::get('create/', 'create')->name('purchase.create');
            Route::post('create/', 'store')->name('purchase.save');
            Route::get('edit/{id}', 'edit')->name('purchase.edit');
            Route::post('edit/{id}', 'update')->name('purchase.update');
            Route::get('delete/{id}', 'destroy')->name('purchase.delete');
        });

        Route::prefix('transfer')->controller(TransferController::class)->group(function () {
            Route::get('', 'index')->name('transfer.list');
            Route::get('create/', 'create')->name('transfer.create');
            Route::post('create/', 'store')->name('transfer.save');
            Route::get('edit/{id}', 'edit')->name('transfer.edit');
            Route::post('edit/{id}', 'update')->name('transfer.update');
            Route::get('delete/{id}', 'destroy')->name('transfer.delete');
        });

        Route::prefix('report')->controller(ReportController::class)->group(function () {
            Route::get('sales', 'sales')->name('report.sales');
            Route::post('sales', 'salesFetch')->name('report.sales.fetch');
            Route::get('pharmacy', 'pharmacy')->name('report.pharmacy');
            Route::post('pharmacy', 'pharmacyFetch')->name('report.pharmacy.fetch');
            Route::get('registration', 'registration')->name('report.registration');
            Route::post('registration', 'registrationFetch')->name('report.registration.fetch');
            Route::get('daybook', 'daybook')->name('report.daybook');
            Route::post('daybook', 'daybookFetch')->name('report.daybook.fetch');
            Route::get('expense', 'expense')->name('report.expense');
            Route::post('expense', 'expenseFetch')->name('report.expense.fetch');
        });
    });
});
