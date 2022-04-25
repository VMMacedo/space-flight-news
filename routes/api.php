<?php

use App\Http\Controllers\ArticleController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
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

Route::prefix('v1')->group(function () {

    /**Rota de autenticação */
    Route::prefix('auth')->group(function () {
        Route::controller(AuthController::class)->group(function () {
            Route::post('login', 'login');
            Route::post('register', 'register');
            Route::post('logout', 'logout');
            Route::post('refresh', 'refresh');
            Route::get('me', 'me');
        });
    });

    /**Rota para retorno de status 200 - Space Flight News */
    Route::get('/', function () {
        return "Fullstack Challenge 2021 🏅 - Space Flight News";
    });

    /**Rotas API Contas Gateway */

    Route::apiresource('articles', ArticleController::class, [
        'names' => [
            'store' => 'storeArticlessApi',
            'index' => 'indexArticlesApi',
            'show' => 'showArticlesApi',
            'update' => 'updateArticlesApi',
            'destroy' => 'destroyArticlesApi'

        ]
    ]);
});
