<?php

use App\Http\Controllers\API\Auth\AuthController;
use App\Http\Controllers\API\EntryController;
use App\Http\Controllers\API\ReportController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    Route::get('/profile', [AuthController::class, 'profile']);
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::prefix('entries')->group(function () {
        Route::get('/', [EntryController::class, 'index']);
        Route::post('/', [EntryController::class, 'store']);
        Route::get('/incomes', [EntryController::class, 'getMyIncomes']);
        Route::get('/expenses', [EntryController::class, 'getMyExpenses']);
        Route::get('/{id}', [EntryController::class, 'show']);
        Route::put('/{id}', [EntryController::class, 'update']);
        Route::delete('/{id}', [EntryController::class, 'destroy']);
    });

    Route::prefix('reports')->group(function () {
        Route::get('/', [ReportController::class, 'index']);
        Route::post('/', [ReportController::class, 'store']);
        Route::get('/{id}', [ReportController::class, 'show']);
        Route::put('/{id}', [ReportController::class, 'update']);
        Route::delete('/{id}', [ReportController::class, 'destroy']);
    });
});