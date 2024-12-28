<?php

use Illuminate\Support\Facades\Route;
use Modules\FarmerLoans\Http\Controllers\FarmerLoanController;

Route::middleware(['web', 'auth'])->group(function () {
    Route::prefix('farmer-loans')->group(function () {
        Route::get('/', [FarmerLoanController::class, 'index'])->name('farmer-loans.index');
        Route::get('/create', [FarmerLoanController::class, 'create'])->name('farmer-loans.create');
        Route::post('/store', [FarmerLoanController::class, 'store'])->name('farmer-loans.store');
        Route::get('/edit/{id}', [FarmerLoanController::class, 'edit'])->name('farmer-loans.edit');
        Route::post('/update/{id}', [FarmerLoanController::class, 'update'])->name('farmer-loans.update');
        Route::get('/delete/{id}', [FarmerLoanController::class, 'destroy'])->name('farmer-loans.delete');
        Route::get('/status/{id}', [FarmerLoanController::class, 'status'])->name('farmer-loans.status');
        Route::get('/paid/{id}', [FarmerLoanController::class, 'paid'])->name('farmer-loans.paid');
    });
});
