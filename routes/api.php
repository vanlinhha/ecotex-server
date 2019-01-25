<?php

use Illuminate\Http\Request;

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

Route::get('/403', function (){
    return response()->json(['errors' => 'Bạn không có quyền thực hiện chức năng này', 'status' => 403], 403);
});
Route::post('register', 'Cores\Rest\UserController@register');
Route::post('login', 'Cores\Rest\UserController@authenticate');
Route::get('open', 'DataController@open')->middleware(['jwt.verify', 'permission:delete-profile']);

Route::group(['middleware' => ['jwt.verify', 'permission:read-profile']], function() {
    Route::get('user', 'Cores\Rest\UserController@getAuthenticatedUser');
    Route::get('closed', 'DataController@closed');
});
