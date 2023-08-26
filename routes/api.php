<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\AuthController;

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

Route::prefix('users')->group(function () {
    //Prefijo V1, todo lo que este dentro de este grupo se accedera escribiendo v1 en el navegador, es decir /api/v1/*
    Route::post('login', [AuthController::class, 'authenticate']);
    Route::group(['middleware' => ['auth:api']], function() {
        //Todo lo que este dentro de este grupo requiere verificación de usuario.
        Route::post('logout', [AuthController::class, 'logout']);
        Route::post('create', [UsersController::class, 'create'])->middleware(['admin']);
        Route::get('read/{id?}', [UsersController::class, 'read']);
        Route::post('update', [UsersController::class, 'update'])->middleware(['admin']);
        Route::delete('delete/{id}', [UsersController::class, 'delete'])->middleware(['admin']);
    });
});
/*
Route::group([
    'middleware' => (['auth:api']),
    'prefix' => 'users',
    'controller' => App\Http\Controllers\UsersController::class,
    
], function () {
    Route::post('create', 'create')->middleware(['admin']);
    Route::post('update', 'update')->middleware(['admin']);
    Route::get('read/{id?}', 'read');
    Route::delete('delete/{id}', 'delete')->middleware(['admin']);
});   

Route::group([
    'prefix' => 'users',
    'controller' => App\Http\Controllers\AuthController::class
    
], function () {
    Route::post('login', 'authenticate');
});
*/