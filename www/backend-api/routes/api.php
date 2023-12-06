<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\UserListController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::post("/auth", [UserController::class, 'makeAuth']);
Route::post("/registration", [UserController::class, 'makeRegistration']);

Route::group(['middleware' => ['userauth']], function () {
    Route::post("/ping", [UserController::class, 'ping']);
    Route::post("/list", [UserListController::class, 'getList']);
    Route::post("/list/create", [UserListController::class, 'setList']);
    Route::post("/list/update", [UserListController::class, 'updateList']);
    Route::post("/list/delete", [UserListController::class, 'deleteList']);
});
