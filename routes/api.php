<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UserController;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BoardController;

Route::group(["middleware"=>"auth:api"],function () {
    Route::post("/board/add",[BoardController::class,"add"]);
    Route::post("/boards",[BoardController::class,"boards"]);
    Route::post("/task/add",[BoardController::class,"task"]);
    Route::post("/task/board/update",[BoardController::class,"taskUpdate"]);
});




Route::post("/login",[AuthController::class,"login"]);
Route::post("/register",[AuthController::class,"register"]);

