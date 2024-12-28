<?php

use Illuminate\Support\Facades\Route;
use Modules\FarmerInputs\Http\Controllers\FarmerInputsController;
use Modules\FarmerInputs\Http\Controllers\FarmerInputTypesController;

// Group routes with common middleware and prefix
Route::middleware(['web', 'auth'])->group(function () {

    // Farmer Inputs Routes
    Route::prefix('farmer-inputs')->name('farmer-inputs.')->group(function () {
        Route::get('/', [FarmerInputsController::class, 'index'])->name('index');
        Route::get('/create', [FarmerInputsController::class, 'create'])->name('create');
        Route::post('/store', [FarmerInputsController::class, 'store'])->name('store');
        Route::get('/edit/{id}', [FarmerInputsController::class, 'edit'])->name('edit');
        Route::post('/update/{id}', [FarmerInputsController::class, 'update'])->name('update');
        Route::get('/delete/{id}', [FarmerInputsController::class, 'destroy'])->name('delete');
    });

    // Farmer Input Types Routes
    Route::prefix('farmer-input-types')->name('farmer-input-types.')->group(function () {
        Route::get('/', [FarmerInputTypesController::class, 'index'])->name('index');
        Route::get('/create', [FarmerInputTypesController::class, 'create'])->name('create');
        Route::post('/store', [FarmerInputTypesController::class, 'store'])->name('store');
        Route::get('/edit/{id}', [FarmerInputTypesController::class, 'edit'])->name('edit');
        Route::post('/update/{id}', [FarmerInputTypesController::class, 'update'])->name('update');
        Route::get('/delete/{id}', [FarmerInputTypesController::class, 'destroy'])->name('delete');
    });

});
