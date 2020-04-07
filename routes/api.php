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

Route::get('/catalogs/{id}', 'CatalogController@catalogs');
Route::get('/catalog/completed/{id}', 'CatalogController@completed');
Route::get('/catalog/not-completed/{id}', 'CatalogController@notCompleted');
Route::get('/catalog/searching/{id}/{value}', 'CatalogController@searching');
Route::post('/catalog/create/{id}', 'CatalogController@create');
Route::post('/catalog/update/{id}', 'CatalogController@update');
Route::put('/catalog/done/{id}', 'CatalogController@done');
Route::put('/catalog/not-done/{id}', 'CatalogController@notDone');
Route::post('/catalog/delete/{id}', 'CatalogController@delete');

