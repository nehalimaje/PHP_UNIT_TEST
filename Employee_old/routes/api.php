<?php

use App\Http\Controllers\EmployeeController;
use App\Http\Middleware\AuthToken;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware([AuthToken::class])->group(function () {
    Route::post('employee', [EmployeeController::class, 'store']);
    Route::get('employee', [EmployeeController::class, 'index']);
    Route::get('employee/{id}', [EmployeeController::class, 'show']);
    Route::put('employee/{id}', [EmployeeController::class, 'update']);
    Route::delete('employee/{id}', [EmployeeController::class, 'delete']);
});

// Route::post('employee', [EmployeeController::class, 'store']);
// Route::get('employee', [EmployeeController::class, 'index']);
// Route::get('employee/{id}', [EmployeeController::class, 'show']);
// Route::put('employee/{id}', [EmployeeController::class, 'update']);
// Route::delete('employee/{id}', [EmployeeController::class, 'delete']);
