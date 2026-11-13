<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\TopupTypeController;
use App\Http\Controllers\Admin\LeaderController;
use App\Http\Controllers\PbDocumentController;


Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])
        ->name('login');

    Route::post('/login', [AuthController::class, 'login'])
        ->name('login.process');
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [
        PbDocumentController::class,
        'dashboard',
    ])->name('dashboard');

    Route::put('/documents/{document}', [
        PbDocumentController::class,
        'update',
    ])->name('documents.update');

    Route::get('/documents/{document}/download', [
        PbDocumentController::class,
        'download',
    ])->name('documents.download');

    Route::get('/documents/{document}/edit', [
        PbDocumentController::class,
        'edit',
    ])->name('documents.edit');

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


    Route::get('/topup/{topupType:slug}', function (
        Request $request,
        \App\Models\TopupType $topupType
    ) {
        abort_unless($topupType->is_active, 404);

        $pb01 = \App\Models\PbDocument::where('topup_type_id', $topupType->id)
            ->where('created_by', $request->user()->id)
            ->where('is_active', true)
            ->whereNull('generated_at')
            ->whereHas('sections', function ($query) {
                $query->where('section_type', 'pb01');
            })
            ->latest()
            ->first();

        $pb02 = \App\Models\PbDocument::where('topup_type_id', $topupType->id)
            ->where('created_by', $request->user()->id)
            ->where('is_active', true)
            ->whereNull('generated_at')
            ->whereHas('sections', function ($query) {
                $query->where('section_type', 'pb02');
            })
            ->latest()
            ->first();

        return view('topup.show', compact(
            'topupType',
            'pb01',
            'pb02'
        ));
    })->name('topup.show');

    Route::get('/topup/{topupType:slug}/generator/preview', [
        PbDocumentController::class,
        'preview',
    ])->name('topup.generator.preview');

    Route::get('/topup/{topupType:slug}/generator/excel', [
        PbDocumentController::class,
        'generateExcel',
    ])->name('topup.generator.excel');

    Route::get('/topup/{topupType:slug}/generator/excel', [
        PbDocumentController::class,
        'generateExcel',
    ])->name('topup.generator.excel');

    Route::get('/topup/{topupType:slug}/generator/{documentType}', [
        PbDocumentController::class,
        'create',
    ])->name('topup.generator');

    Route::post('/topup/{topupType:slug}/generator/pb01', [
        PbDocumentController::class,
        'storePb01',
    ])->name('topup.generator.pb01.store');

    Route::post('/topup/{topupType:slug}/generator/pb02', [
        PbDocumentController::class,
        'storePb02',
    ])->name('topup.generator.pb02.store');

    Route::get('/leaders', [LeaderController::class, 'index'])
        ->name('leaders.index');

    Route::post('/leaders', [LeaderController::class, 'store'])
        ->name('leaders.store');

    Route::patch('/leaders/{leader}/toggle-status', [LeaderController::class, 'toggleStatus'])
        ->name('leaders.toggle-status');

    Route::delete('/leaders/{leader}', [LeaderController::class, 'destroy'])
        ->name('leaders.destroy');
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
