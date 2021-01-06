<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\TodoListController;
use App\Http\Controllers\TodoItemController;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResource('todoLists', TodoListController::class);

Route::apiResource('todoLists.todoItems', TodoItemController::class)->shallow();

Route::get('/todoItems/{todoItem}/toggle', [TodoItemController::class, 'toggle']);

Route::prefix('todoLists/{todoList}/todoItems')->group(function () {
    Route::prefix('/completed')->group(function () {
        Route::get('/', [TodoListController::class, 'completed']);
        Route::delete('/', [TodoListController::class, 'deleteCompleted']);
    });

    Route::prefix('/incomplete')->group(function () {
        Route::get('/', [TodoListController::class, 'incomplete']);
        Route::delete('/', [TodoListController::class, 'deleteIncomplete']);
    });
});

