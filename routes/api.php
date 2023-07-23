<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\productController;
use App\Http\Controllers\AuthController;

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

Route::middleware('auth:sanctum')->group(function () {
    // Retrieve the authenticated user
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    // Retrieve products
    Route::get('/products', [ProductController::class, 'apiProducts']);

    // Route::prefix('api')->middleware('api')->group(function () {
    //     Route::post('/login', [AuthController::class, 'createApiToken']);
    // });

    // Store a new product
    Route::post('/products', [ProductController::class, 'store']);

    // Show product by ID
    Route::post('/products/id={id}', [ProductController::class, 'show']);

    // Update product by ID
    Route::put('/products/{id}', [ProductController::class, 'update']);

    // Delete product by ID
    Route::delete('/products/{id}', [ProductController::class, 'destroy']);
});

Route::post('/login', [AuthController::class, 'createApiToken']);