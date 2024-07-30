<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\EstimateController;

Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/estimates/create', [EstimateController::class, 'create'])->name('home');
Route::post('/estimates', [EstimateController::class, 'store'])->name('estimate.store');
Route::get('/estimates/{id}', [EstimateController::class, 'show'])->name('estimate.show');
Route::get('/item-box', [ItemController::class, 'getItemBox']);
Route::get('/item-get', [ItemController::class, 'show']);
Route::get('/items-select', [ItemController::class, 'select']);

Route::prefix('admin')->group(function() {
    Route::get('/login', [App\Http\Controllers\Auth\AdminLoginController::class, 'showLoginForm'])->name('admin.login');
    Route::post('/login', [App\Http\Controllers\Auth\AdminLoginController::class, 'login'])->name('admin.login.submit');
    Route::post('/logout', [App\Http\Controllers\Auth\AdminLoginController::class, 'logout'])->name('admin.logout');
    Route::get('/', [App\Http\Controllers\AdminController::class, 'index'])->name('admin.dashboard');
    Route::post('/store', [App\Http\Controllers\AdminController::class, 'store'])->name('admin.store');
    Route::post('/update', [App\Http\Controllers\AdminController::class, 'update'])->name('admin.update');
    Route::resource('/items', ItemController::class);
    Route::resource('/customers', CustomerController::class);
    Route::resource('/users', UserController::class);
});

