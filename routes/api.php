<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ToDoController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/verify/{code}', [AuthController::class,'verify']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout']);

// Route::middleware('auth:api')->group(function () {
    Route::get('todos', [ToDoController::class, 'index']);
    Route::post('todos', [ToDoController::class, 'store']);
    Route::get('todos/{id}', [ToDoController::class, 'show']);
    Route::put('todos/{id}', [ToDoController::class, 'update']);
    Route::delete('todos/{id}', [ToDoController::class, 'destroy']);
// });


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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
