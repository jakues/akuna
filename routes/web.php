<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\ProductController;
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
    Route::post('/login', [AuthController::class, 'login'])->name('auth.login');
    Route::get('/', [UserController::class, 'index'])->name('guest.index');
});


Route::middleware(['auth'])->group(function () {
    Route::get('/logout', [AuthController::class, 'logout'])->name('auth.logout');
    Route::get('/manage', [AdminController::class, 'index'])->middleware('userAccess:admin')->name('admin.index');
    Route::get('/manage/tx', [AdminController::class, 'transaction'])->middleware('userAccess:admin')->name('admin.transaction');
    Route::get('/manage/tx/export', [TransactionController::class, 'export'])->middleware('userAccess:admin')->name('admin.transaction.export');
    Route::get('/manage/products', [AdminController::class, 'product'])->middleware('userAccess:admin')->name('admin.product');
    Route::get('/manage/products/export', [ProductController::class, 'export'])->middleware('userAccess:admin')->name('admin.product.export');
    Route::get('home', function () {
        return redirect('/');
    });
});
