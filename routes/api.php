<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\TodoController;
use App\Http\Controllers\AuthController;

Route::group(['middleware' => 'auth:sanctum'], function () {
       Route::get('/profile', [AuthController::class, 'profile']);
       Route::get('/todos', [TodoController::class, 'getAllTodos']);
       Route::post('/todo', [TodoController::class, 'createTodo']);
       Route::put('/todo/{id}', [TodoController::class, 'updateTodo']);
       Route::delete('/todo/{id}', [TodoController::class, 'deleteTodo']);
       Route::post('/logout', [AuthController::class, 'logout']);

      
 });

 Route::post('/signup', [AuthController::class, 'sign_up']);
 Route::post('/login', [AuthController::class, 'login']);





