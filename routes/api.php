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

Route::get('/lists/{user_id}', 'ListsController@lists');
Route::post('/lists/create/{user_id}', 'ListsController@create');
Route::post('/lists/update/{list_id}', 'ListsController@update');
Route::put('/lists/done/{list_id}', 'ListsController@done');
Route::put('/lists/not-done/{list_id}', 'ListsController@notDone');
Route::post('/lists/delete/{list_id}', 'ListsController@delete');

