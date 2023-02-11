<?php

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

Route::get('/', [\App\Http\Controllers\ProductController::class, 'index'])->name('save');

Route::get('/show', [\App\Http\Controllers\ProductController::class, 'getProducts'])->name('getProducts');

Route::post('/save', [\App\Http\Controllers\ProductController::class, 'save']);

Route::post('/delete', [\App\Http\Controllers\ProductController::class, 'delete']);

Route::post('/update', [\App\Http\Controllers\ProductController::class, 'update']);
