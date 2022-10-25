<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
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


Route::get('/detalle/{id}', [ProductController::class, 'index']);
Route::get('/cart/detail', [CartController::class, 'detail']);
Route::get('/cart/delete/{id}', [CartController::class, 'deleteItem']);
Route::get('/', [HomeController::class, 'index']);
Route::get('/{id}', [HomeController::class, 'getAllProductsByCategoryId']);
Route::get('/cart/add/{id}', [CartController::class, 'add']);
Route::get('/cart/addquantity/{id}', [CartController::class, 'addQuantity']);
Route::post('/cart/update', [CartController::class, 'update']);



