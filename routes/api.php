<?php

use App\Http\Controllers\Api\ApiAuthController;
use App\Http\Middleware\RequiresJson;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\EstateController;

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


Route::middleware([RequiresJson::class])->post('/login', [ApiAuthController::class, 'login']);

Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('/estates/create', [EstateController::class, 'store']);
    Route::delete('/estates/delete/{idintern}', [EstateController::class, 'destroy']);
});
