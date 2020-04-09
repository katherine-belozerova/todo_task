<?php

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('user/login', 'AuthController@authenticate');
Route::post('user/register', 'RegisterController@register');

Route::middleware(['jwt.auth'])->group(function ()
{
    Route::get('/catalogs/{id}', 'CatalogController@catalogs');
    Route::get('/catalog/completed/{id}', 'CatalogController@completed');
    Route::get('/catalog/not-completed/{id}', 'CatalogController@notCompleted');
    Route::get('/catalog/searching/{id}/{value}', 'CatalogController@searching');
    Route::get('/catalog/sorting-by-completed/{id}/{field}', 'CatalogController@sortingByCompleted');
    Route::get('/catalog/sorting-by-not-completed/{id}/{field}', 'CatalogController@sortingByNotCompleted');
    Route::post('/catalog/create/{id}', 'CatalogController@create');
    Route::post('/catalog/update/{id}', 'CatalogController@update');
    Route::put('/catalog/done/{id}', 'CatalogController@done');
    Route::put('/catalog/not-done/{id}', 'CatalogController@notDone');
    Route::post('/catalog/delete/{id}', 'CatalogController@delete');

    Route::get('/tasks/{id}', 'TaskController@tasks');
    Route::get('/task/searching/{id}/{value}', 'TaskController@searching');
    Route::get('/task/sorting/{id}/{field}', 'TaskController@sorting');
    Route::post('/task/create/{id}', 'TaskController@create');
    Route::post('/task/update/{id}', 'TaskController@update');
    Route::put('/task/done/{id}', 'TaskController@done');
    Route::put('/task/not-done/{id}', 'TaskController@notDone');
    Route::post('/task/delete/{id}', 'TaskController@delete');
});

Route::post('/test/{id}', 'TestController@test');





