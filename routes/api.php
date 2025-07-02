<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AuthController;





Route::group(['middleware' => 'auth:sanctum'], function () {
            Route::post('/logout', [AuthController::class, 'logout']);

       Route::post('/product', [ProductController::class, 'createProduct']);
       Route::put('/product/{id}', [ProductController::class, 'updateProduct']);
       Route::delete('/product/{id}', [ProductController::class, 'deleteProduct']);
      
 });

 Route::post('/signup', [AuthController::class, 'sign_up']);
      Route::post('/login', [AuthController::class, 'login']);

Route::get('/products', [ProductController::class, 'getAllProducts']);
Route::get('/product/{id}',[ProductController::class, 'getProduct']);
Route::get('/productfilter', [ProductController::class, 'filter']);
Route::get('/productsort/{direction}', [ProductController::class, 'sort']);





