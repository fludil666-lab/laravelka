<?php

use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminOrderController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\BecomeSpecialistController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\SpecialistController;
use App\Http\Controllers\SpecialistProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home.page');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home')->middleware('auth');

Route::get('/specialists', [SpecialistController::class, 'index'])->name('specialists.index');
Route::get('/specialists/{specialist}', [SpecialistController::class, 'show'])->name('specialists.show');

Route::get('/become-specialist', BecomeSpecialistController::class)->name('become-specialist')->middleware('auth');

Route::middleware('auth')->group(function () {
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
    Route::patch('/orders/{order}/cancel', [OrderController::class, 'cancel'])->name('orders.cancel');
    Route::get('/specialist-profile', [SpecialistProfileController::class, 'edit'])->name('specialist-profile.edit');
    Route::put('/specialist-profile', [SpecialistProfileController::class, 'update'])->name('specialist-profile.update');
    Route::post('/specialist-profile/services', [SpecialistProfileController::class, 'storeService'])->name('specialist-profile.services.store');
    Route::post('/specialist-profile/services/{service}/delete', [SpecialistProfileController::class, 'destroyService'])->name('specialist-profile.services.destroy');
});

Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::get('/users', [AdminUserController::class, 'index'])->name('users.index');
    Route::patch('/users/{user}/passport', [AdminUserController::class, 'updateSpecialistPassport'])->name('users.passport.update');
    Route::get('/orders', [AdminOrderController::class, 'index'])->name('orders.index');
    Route::patch('/orders/{order}/status', [AdminOrderController::class, 'updateStatus'])->name('orders.status.update');
    Route::delete('/orders/{order}', [AdminOrderController::class, 'destroy'])->name('orders.destroy');
});
