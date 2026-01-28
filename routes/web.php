<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AssetController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\Auth\LoginController;

// Authentication routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.submit');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Protected routes - require authentication
Route::middleware(['auth'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Asset routes
    $assetTypes = ['laptop', 'cpu', 'mac', 'monitor', 'keyboard', 'mouse', 'other'];

    foreach ($assetTypes as $type) {
        Route::prefix('assets/' . $type)->name('assets.' . $type . '.')->group(function () use ($type) {
            Route::get('/list', function() use ($type) {
                return app(AssetController::class)->index(request(), $type);
            })->name('list');
            Route::get('/assign-history', function() use ($type) {
                return app(AssetController::class)->assignHistory($type);
            })->name('assign-history');
            Route::get('/unassign-history', function() use ($type) {
                return app(AssetController::class)->unassignHistory($type);
            })->name('unassign-history');
            Route::get('/export', function() use ($type) {
                return app(AssetController::class)->export($type);
            })->name('export');
        });
    }

    Route::prefix('api/assets')->name('api.assets.')->group(function () {
        Route::post('/', [AssetController::class, 'store'])->name('store');
        Route::get('/{id}', [AssetController::class, 'show'])->name('show');
        Route::put('/{id}', [AssetController::class, 'update'])->name('update');
        Route::delete('/{id}', [AssetController::class, 'destroy'])->name('destroy');
        Route::post('/{id}/toggle-status', [AssetController::class, 'toggleStatus'])->name('toggle-status');
        Route::post('/{id}/assign', [AssetController::class, 'assign'])->name('assign');
        Route::post('/{id}/unassign', [AssetController::class, 'unassign'])->name('unassign');
    });

    // Employee routes
    Route::get('/employees', [EmployeeController::class, 'index'])->name('employees.index');

    Route::prefix('api/employees')->name('api.employees.')->group(function () {
        Route::post('/', [EmployeeController::class, 'store'])->name('store');
        Route::get('/{id}', [EmployeeController::class, 'show'])->name('show');
        Route::put('/{id}', [EmployeeController::class, 'update'])->name('update');
        Route::delete('/{id}', [EmployeeController::class, 'destroy'])->name('destroy');
        Route::post('/{id}/toggle-status', [EmployeeController::class, 'toggleStatus'])->name('toggle-status');
        Route::get('/{id}/assets', [EmployeeController::class, 'getAssets'])->name('assets');
    });
});
