<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Auth;

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



Route::post("register",[AuthController::class,'registerUser']);
Route::post("login",[AuthController::class,'loginUser']);


Route::group(['middleware' => ['authorization', 'auth:sanctum']], function() {

    Route::get('userdetail', [AuthController::class,'authenticatedUserDetails']);
    Route::put("user/{id}",[AuthController::class,'active_status']);
    Route::put("users/{id}",[AuthController::class,'userdepartment']);
    Route::post("userimage",[AuthController::class,'imagestore']); 

    Route::post("post",[PostController::class,'create_data']);
    Route::put("post/{id}",[PostController::class,'update_data']);
    Route::delete("post/{id}",[PostController::class,'delete_data']);
    Route::get("post/{id}",[PostController::class,'show']);
    Route::get("post",[PostController::class,'index']);


    Route::post("comment",[CommentController::class,'create_comment']);
    Route::get("comment",[CommentController::class,'index']);
    Route::put("comment/{id}",[CommentController::class,'update_comment']);
    Route::delete("comment/{id}",[CommentController::class,'delete_comment']);

});
