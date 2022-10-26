<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\TransBankController;
use Illuminate\Support\Facades\Route;

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


Route::get('/payment', [TransBankController::class, 'index']);
Route::get('/payment_confirm', [TransBankController::class, 'initWebPayTransaction'])->name('payment_confirm');
Route::get('/checkout', [CheckoutController::class, 'index']);
Route::get('/detalle/{id}', [ProductController::class, 'index']);
Route::get('/cart/detail', [CartController::class, 'detail']);
Route::get('/cart/delete/{id}', [CartController::class, 'deleteItem']);
Route::get('/', [HomeController::class, 'index']);
Route::get('/{id}', [HomeController::class, 'getAllProductsByCategoryId']);
Route::get('/cart/add/{id}', [CartController::class, 'add']);
Route::get('/cart/addquantity/{id}', [CartController::class, 'addQuantity']);
Route::post('/cart/update', [CartController::class, 'update']);




