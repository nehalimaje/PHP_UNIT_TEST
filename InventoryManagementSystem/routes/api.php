<?php

use App\Http\Controllers\Category\CategoryController;
use App\Http\Controllers\Item\ItemController;
use App\Http\Controllers\User\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\AuthMiddleware;


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
Route::get('/hello', function () {
  return "Hello World!";
});

//AUTHORISED ROUTE DETAILS.
Route::middleware([AuthMiddleware::class])->group(function () {
  Route::get('/category', [CategoryController::class, 'index'])->name('view');
  Route::post('/category', [CategoryController::class, 'store'])->name('category');
  Route::put('/category/{id}', [CategoryController::class, 'update']);
  Route::delete('/category/{id}', [CategoryController::class, 'delete']);
  Route::get('/getCategoryDetails/{id}',[CategoryController::class, 'getCategory']);

  Route::post('/items', [ItemController::class, 'store']);
  Route::get('/items', [ItemController::class, 'index']);
  Route::put('/items/{id}', [ItemController::class, 'update']);
  Route::delete('/items/{id}', [ItemController::class, 'delete']);
  Route::get('/getItemDetails/{id}',[ItemController::class, 'getItemDetails']);
});


