<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('products', [\App\Http\Controllers\ProductController::class, 'getProducts'])->name('products');
Route::get('products/{id}', [\App\Http\Controllers\ProductController::class, 'getProductById'])->name('product_by_id');
Route::post('products', [\App\Http\Controllers\ProductController::class, 'createProduct'])->name('product_create');
Route::put('products/{id}', [\App\Http\Controllers\ProductController::class, 'updateProduct'])->name('product_update');
Route::delete('products/{id}', [\App\Http\Controllers\ProductController::class, 'deleteProduct'])->name('product_delete');
//
Route::post('categories', [\App\Http\Controllers\CategoryController::class, 'createCategory'])->name('category_create');
Route::delete('categories/{id}', [\App\Http\Controllers\CategoryController::class, 'deleteCategory'])->name('category_delete');

