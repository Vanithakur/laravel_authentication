<?php

use App\Http\Controllers\admin\UserController;
use App\Http\Controllers\common\AuthController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();

});
Route::Resource('admin_users',UserController::class);


Route::Resource('login_user',AuthController::class);
Route::post('user/logout', [AuthController::class, 'logout']);