<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\teste\TesteController;

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

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user-info', [AuthController::class, 'getUse']);    
});

Route::post('login', ['middleware' => 'api', 'uses' => 'AuthController@login',])->name('login');
Route::post('register', ['middleware' => 'api', 'uses' => 'AuthController@register',])->name('register');
Route::get('teste/', ['middleware' => 'api', 'uses' => 'teste\TesteController@index'])->name('teste.index');
Route::post('teste/cadastrar', ['middleware' => 'api', 'uses' => 'teste\TesteController@cadastrar'])->name('teste.cadastrar');
