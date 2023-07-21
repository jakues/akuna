<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\productController;

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

Route::get('/products', [productController::class, 'apiProducts']);

Route::post('/products', [productController::class, 'store']);

Route::post('/products/id={id}', [productController::class, 'show']);

Route::put('/products/{id}', [productController::class, 'update']);

Route::delete('/products/{id}', [productController::class, 'destroy']);
