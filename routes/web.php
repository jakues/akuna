<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::middleware(['guest'])->group(function () {
    Route::get('/login', [AuthController::class, 'index'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/', [UserController::class, 'index']);
});


Route::middleware(['auth'])->group(function () {
    Route::get('/logout', [AuthController::class, 'logout']);
    Route::get('/manage', [AdminController::class, 'index'])->middleware('userAccess:admin');
    Route::get('/manage/dashboard', [AdminController::class, 'dashboard'])->middleware('userAccess:admin');
    Route::get('/manage/products', [AdminController::class, 'product'])->middleware('userAccess:admin');
    //Route::get('home', [AdminController::class, 'index']);
    Route::get('home', function () {
        return redirect('/');
    });
});
