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
Route::post('/sign_up', 'UserController@register');
Route::delete('/log_out', 'UserController@logOut');
Route::post('/login', 'UserController@authenticate');
Route::get('/open', 'DataController@open')->middleware(['jwt.verify', 'permission:delete-profile']);
Route::group(['middleware' => ['jwt.verify']], function() {
    Route::get('/user', 'UserController@getAuthenticatedUser');
    Route::get('/closed', 'DataController@closed');
});

Route::resource('users', 'UsersAPIController');

// Get all roles of system
Route::get('/roles', 'UserController@getAllRoles');
Route::get('/permissions', 'UserController@getAllPermissions');
//Get all inactivated users

Route::get('/inactivated_users', 'UsersAPIController@getInactivatedUser');
Route::get('/all_users', 'UsersAPIController@getAllUser');
Route::put('/verify_users', 'UsersAPIController@verifyUsers');
Route::get('/verify/{user_id}/{activation_code}', 'UsersAPIController@verify');

Route::get('/product_groups/all_parent/', 'ProductGroupsAPIController@showParentProductGroups');
Route::get('/product_groups/parent_with_children/', 'ProductGroupsAPIController@getProductCategoryByParent');

Route::resource('product_groups', 'ProductGroupsAPIController');

Route::resource('main_product_groups', 'MainProductGroupsAPIController')->middleware('jwt.verify');

Route::resource('main_segments', 'MainSegmentsAPIController')->middleware('jwt.verify');

Route::resource('segment_groups', 'SegmentGroupsAPIController');

Route::resource('role_types', 'RoleTypesAPIController');

Route::resource('target_groups', 'TargetGroupsAPIController');

Route::resource('main_targets', 'MainTargetsAPIController')->middleware('jwt.verify');

Route::resource('minimum_order_quantities', 'MinimumOrderQuantityAPIController');

Route::resource('services', 'ServicesAPIController');

Route::resource('countries', 'CountriesAPIController');

Route::put('/users/brands/{id}', 'UserController@updateBrands');

Route::put('/users/main_segments/{id}', 'UserController@updateMainSegments');
