<?php

use App\Http\Controllers\BurgerController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/catalogue', [BurgerController::class, 'catalogue'])->name('catalogue.index');
    Route::get('/catalogue/{burger}', [BurgerController::class, 'catalogueShow'])->name('catalogue.show');

    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/create', [OrderController::class, 'create'])->name('orders.create');
    Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');

    Route::middleware('role:gestionnaire')->group(function () {
        Route::resource('burgers', BurgerController::class)->except(['show']);
        Route::patch('/burgers/{burger}/archive', [BurgerController::class, 'archive'])->name('burgers.archive');

        Route::get('/admin/orders', [OrderController::class, 'adminIndex'])->name('orders.admin.index');
        Route::get('/admin/orders/{order}', [OrderController::class, 'adminShow'])->name('orders.admin.show');
        Route::patch('/admin/orders/{order}/status', [OrderController::class, 'updateStatus'])->name('orders.admin.status');
        Route::patch('/admin/orders/{order}/cancel', [OrderController::class, 'cancel'])->name('orders.admin.cancel');
    });

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
