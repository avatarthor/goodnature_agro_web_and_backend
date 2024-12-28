<?php

use Illuminate\Support\Facades\Route;
use Modules\FarmerInputs\Http\Controllers\FarmerInputsController;
use Modules\FarmerInputs\Http\Controllers\FarmerInputTypesController;

//farmer inputs routes
Route::get('/farmer-inputs', [App\Http\Controllers\FarmerInputController::class, 'index'])->name('farmer-inputs.index');
Route::get('/farmer-inputs/create', [App\Http\Controllers\FarmerInputController::class, 'create'])->name('farmer-inputs.create');
Route::post('/farmer-inputs/store', [App\Http\Controllers\FarmerInputController::class, 'store'])->name('farmer-inputs.store');
Route::get('/farmer-inputs/edit/{id}', [App\Http\Controllers\FarmerInputController::class, 'edit'])->name('farmer-inputs.edit');
Route::post('/farmer-inputs/update/{id}', [App\Http\Controllers\FarmerInputController::class, 'update'])->name('farmer-inputs.update');
Route::get('/farmer-inputs/delete/{id}', [App\Http\Controllers\FarmerInputController::class, 'destroy'])->name('farmer-inputs.delete');

//farmer input types routes
Route::get('/farmer-input-types', [App\Http\Controllers\FarmerInputTypeController::class, 'index'])->name('farmer-input-types.index');
Route::get('/farmer-input-types/create', [App\Http\Controllers\FarmerInputTypeController::class, 'create'])->name('farmer-input-types.create');
Route::post('/farmer-input-types/store', [App\Http\Controllers\FarmerInputTypeController::class, 'store'])->name('farmer-input-types.store');
Route::get('/farmer-input-types/edit/{id}', [App\Http\Controllers\FarmerInputTypeController::class, 'edit'])->name('farmer-input-types.edit');
Route::post('/farmer-input-types/update/{id}', [App\Http\Controllers\FarmerInputTypeController::class, 'update'])->name('farmer-input-types.update');
Route::get('/farmer-input-types/delete/{id}', [App\Http\Controllers\FarmerInputTypeController::class, 'destroy'])->name('farmer-input-types.delete');



