<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\EstimateController;
use App\Http\Controllers\AdminController;

Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/item-box', [ItemController::class, 'getItemBox']);
Route::get('/item-get', [ItemController::class, 'show']);
Route::get('/items-select', [ItemController::class, 'select']);

Route::get('/estimates/create', [EstimateController::class, 'create'])->name('home');
Route::post('/estimates', [EstimateController::class, 'store'])->name('estimate.store');
Route::get('/estimates/{id}', [EstimateController::class, 'show'])->name('estimate.show');
Route::get('/estimates/{id}/version/{version}', [EstimateController::class, 'show'])->name('estimate.show.version');
Route::get('/estimates/{id}/edit', [EstimateController::class, 'edit'])->name('estimate.edit');
Route::put('/estimates/{id}', [EstimateController::class, 'update'])->name('estimate.update');
Route::put('/estimates/{id}/status', [EstimateController::class, 'statusUpdate'])->name('estimate.status.update');
Route::get('/estimate-list', [EstimateController::class, 'index'])->name('estimates.index');
Route::delete('/estimates/{id}', [EstimateController::class, 'destroy'])->name('estimate.destroy');

Route::group(['prefix' => 'admin', 'middleware' => ['auth', 'admin.access']], function () {
    Route::get('/', [App\Http\Controllers\AdminController::class, 'index'])->name('admin.dashboard');
    Route::post('/store', [App\Http\Controllers\AdminController::class, 'store'])->name('admin.store');
    Route::post('/update', [App\Http\Controllers\AdminController::class, 'update'])->name('admin.update');
    Route::resource('/items', ItemController::class);
    Route::resource('/customers', CustomerController::class);
    Route::resource('/users', UserController::class);
});

