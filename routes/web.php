<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\FarmerController;
use App\Http\Controllers\FarmerLoanController;
use App\Http\Controllers\FarmerInputController;
use App\Http\Controllers\FarmerInputTypeController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//these are guest routes for unauthenticated users
Route::middleware('guest')->group(function () {
    // All Users login and registration route
    Route::get('/', [HomeController::class, 'index'])->name('index');
    Route::post('/login-post', [App\Http\Controllers\Auth\LoginController::class, 'login'])->name('login-post');
});

Route::middleware(['auth'])->group(function () {

    // Admin login & logout route
    Route::get('/admin', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
    Route::post('/admin-logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');

        // Module Management Routes
    Route::prefix('modules')->middleware(['auth'])->group(function () {
        Route::get('/', [App\Http\Controllers\ModuleController::class, 'index'])->name('modules.index');
        Route::post('/upload', [App\Http\Controllers\ModuleController::class, 'upload'])->name('modules.upload');
        Route::post('/{module}/toggle', [App\Http\Controllers\ModuleController::class, 'toggleStatus'])->name('modules.toggle');
        Route::delete('/{module}', [App\Http\Controllers\ModuleController::class, 'destroy'])->name('modules.destroy');
    });

    //farmer routes
    Route::get('/farmers', [App\Http\Controllers\FarmerController::class, 'index'])->name('farmers.index');
    Route::get('/farmers/create', [App\Http\Controllers\FarmerController::class, 'create'])->name('farmers.create');
    Route::post('/farmers/store', [App\Http\Controllers\FarmerController::class, 'store'])->name('farmers.store');
    Route::get('/farmers/edit/{id}', [App\Http\Controllers\FarmerController::class, 'edit'])->name('farmers.edit');
    Route::post('/farmers/update/{id}', [App\Http\Controllers\FarmerController::class, 'update'])->name('farmers.update');
    Route::delete('/farmers/delete/{id}', [App\Http\Controllers\FarmerController::class, 'destroy'])->name('farmers.delete');
    Route::get('/farmers/{id}', [FarmerController::class, 'show'])->name('farmers.show');

    //farmer loans routes
    // Route::get('/farmer-loans', [App\Http\Controllers\FarmerLoanController::class, 'index'])->name('farmer-loans.index');
    // Route::get('/farmer-loans/create', [App\Http\Controllers\FarmerLoanController::class, 'create'])->name('farmer-loans.create');
    // Route::post('/farmer-loans/store', [App\Http\Controllers\FarmerLoanController::class, 'store'])->name('farmer-loans.store');
    // Route::get('/farmer-loans/edit/{id}', [App\Http\Controllers\FarmerLoanController::class, 'edit'])->name('farmer-loans.edit');
    // Route::put('/farmer-loans/update/{id}', [App\Http\Controllers\FarmerLoanController::class, 'update'])->name('farmer-loans.update');
    // Route::get('/farmer-loans/delete/{id}', [App\Http\Controllers\FarmerLoanController::class, 'destroy'])->name('farmer-loans.delete');
    // //loans status
    // Route::get('/farmer-loans/status/{id}', [App\Http\Controllers\FarmerLoanController::class, 'status'])->name('farmer-loans.status');
    // //mark as paid
    // Route::get('/farmer-loans/paid/{id}', [App\Http\Controllers\FarmerLoanController::class, 'paid'])->name('farmer-loans.paid');

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
    Route::get('/farmer-input-types/delete/{id}', [FarmerInputTypeController::class, 'destroy'])->name('farmer-input-types.delete');




});


