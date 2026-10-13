<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\TopupTypeController;


Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])
        ->name('login');

    Route::post('/login', [AuthController::class, 'login'])
        ->name('login.process');
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::post('/logout', [AuthController::class, 'logout'])
        ->name('logout');

    Route::get('/topup-types', [TopupTypeController::class, 'index'])
        ->name('topup-types.index');

    Route::post('/topup-types', [TopupTypeController::class, 'store'])
        ->name('topup-types.store');

    Route::put('/topup-types/{topupType}', [TopupTypeController::class, 'update'])
        ->name('topup-types.update');

    Route::patch('/topup-types/{topupType}/toggle-status', [TopupTypeController::class, 'toggleStatus'])
        ->name('topup-types.toggle-status');


    Route::get('/topup/{topupType:slug}', function (\App\Models\TopupType $topupType) {
        abort_unless($topupType->is_active, 404);

        return view('topup.show', compact('topupType'));
    })->name('topup.show');
});

Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/users', [UserController::class, 'index'])
            ->name('users.index');

        Route::post('/users', [UserController::class, 'store'])
            ->name('users.store');

        Route::delete('/users/{user}', [UserController::class, 'destroy'])
            ->name('users.destroy');


        Route::get('/users/{user}/edit', [UserController::class, 'edit'])
            ->name('users.edit');

        Route::put('/users/{user}', [UserController::class, 'update'])
            ->name('users.update');
    });

Route::redirect('/', '/dashboard');
