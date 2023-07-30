<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\DashboardController;

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

    ///////////////
    // statistic //
    //////////////

    // Count product and tx
    Route::get('/statistic', [DashboardController::class, 'getDashboardData']);

    // Retrive ig followers
    Route::get('/statistic/ig', [DashboardController::class, 'getFollowers']);

    ////////////////////
    // data pembelian //
    ////////////////////
    // Retrive data pembelian
    Route::get('/tx', [TransactionController::class, 'api']);

    // Show tx by ID
    Route::post('/tx/id={id}', [TransactionController::class, 'show']);

    // Store new tx
    Route::post('/tx', [TransactionController::class, 'store']);

    // Update tx data
    Route::put('/tx/{id}', [TransactionController::class, 'update']);

    // Delete tx data
    Route::delete('/tx/{id}', [TransactionController::class, 'destroy']);

    /////////////
    // product //
    /////////////
    // Retrieve products
    Route::get('/products', [ProductController::class, 'api']);

    // Search products
    Route::get('/product', [ProductController::class, 'index']);

    // Store a new product
    Route::post('/products', [ProductController::class, 'store']);

    // Show product by ID
    Route::post('/products/id={id}', [ProductController::class, 'show']);

    // Update product by ID
    Route::put('/products/{id}', [ProductController::class, 'update']);

    // Delete product by ID
    Route::delete('/products/{id}', [ProductController::class, 'destroy']);

    // Route::prefix('api')->middleware('api')->group(function () {
    //     Route::post('/login', [AuthController::class, 'createApiToken']);
    // });
});

Route::post('/login', [AuthController::class, 'createApiToken']);
