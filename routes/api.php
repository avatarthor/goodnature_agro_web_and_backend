<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\FarmerApiController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::post('/login', [AuthController::class, 'login'])->name('api.login');

// Route::post('/register', [AuthController::class, 'register']);


// Route::prefix('farmers')->group(function () {
//     Route::get('/get-all', [FarmerApiController::class, 'index']); // Fetch all farmers
//     Route::post('/add-new', [FarmerApiController::class, 'store']); // Create a new farmer
//     Route::put('/{id}', [FarmerApiController::class, 'update']); // Update a farmer
//     Route::delete('/{id}', [FarmerApiController::class, 'destroy']); // Delete a farmer
// });

Route::middleware(['endpoint.security'])->group(function () {
Route::prefix('farmers')->group(function () {
    Route::get('/get-all', [FarmerApiController::class, 'index']); // Fetch all farmers
    Route::post('/add-new', [FarmerApiController::class, 'store']); // Create a new farmer
    Route::put('/{id}', [FarmerApiController::class, 'update']); // Update a farmer
    Route::delete('/{id}', [FarmerApiController::class, 'destroy']); // Delete a farmer
});
});

Route::middleware('auth:sanctum')
    ->get('/user', function (Request $request) {
        return $request->user();
    })
    ->name('api.user');
