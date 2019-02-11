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
    return response()->json(['errors' => 'Bạn không có quyền thực hiện chức năng này', 'status' => 403, 'data' => []], 403);
});
Route::post('register', 'UserController@register');
Route::post('login', 'UserController@authenticate');
Route::get('open', 'DataController@open')->middleware(['jwt.verify', 'permission:delete-profile']);

Route::group(['middleware' => ['jwt.verify']], function() {
    Route::get('user', 'UserController@getAuthenticatedUser');
    Route::get('closed', 'DataController@closed');
});


Route::resource('users', 'usersAPIController');


Route::resource('product_groups', 'ProductGroupsAPIController');

Route::resource('main_product_groups', 'MainProductGroupsAPIController');