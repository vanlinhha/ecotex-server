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
Route::get('/open', 'DataController@open')->middleware(['jwt.verify', 'permission:delete-profile', 'role:administrator']);
Route::group(['middleware' => ['jwt.verify']], function() {
    Route::get('/user', 'UserController@getAuthenticatedUser');
    Route::get('/closed', 'DataController@closed');
});

Route::resource('users', 'UsersAPIController');


Route::get('/inactivated_users', 'UsersAPIController@getInactivatedUser');
//Get all users
Route::get('/all_users', 'UsersAPIController@getAllUser');
//Verify users
Route::put('/verify_users', 'UsersAPIController@verifyUsers');
//Verify user by activation code
Route::get('/verify/{user_id}/{activation_code}', 'UsersAPIController@verify');

Route::get('/product_groups/all_parent/', 'ProductGroupsAPIController@showParentProductGroups');

Route::get('/product_groups/parent_with_children/', 'ProductGroupsAPIController@getProductCategoryByParent');

Route::resource('product_groups', 'ProductGroupsAPIController');

Route::resource('main_product_groups', 'MainProductGroupsAPIController')->middleware('jwt.verify');

Route::resource('main_segment_groups', 'MainSegmentGroupsAPIController')->middleware('jwt.verify');

Route::resource('segment_groups', 'SegmentGroupsAPIController');

Route::resource('role_types', 'RoleTypesAPIController');

Route::resource('target_groups', 'TargetGroupsAPIController');

Route::resource('main_targets', 'MainTargetsAPIController')->middleware('jwt.verify');

Route::resource('minimum_order_quantities', 'MinimumOrderQuantityAPIController');

Route::resource('services', 'ServicesAPIController');

Route::resource('main_services', 'MainServicesAPIController');

Route::resource('countries', 'CountriesAPIController');

Route::resource('material_groups', 'MaterialGroupsAPIController');

Route::put('/users/brands/{id}', 'UserController@updateBrands');

Route::put('/users/main_segment_groups/{id}', 'MainSegmentGroupsAPIController@updateMainSegmentGroups');

Route::put('/users/main_product_groups/{id}', 'MainProductGroupsAPIController@updateMainProductGroups');

Route::put('/users/main_material_groups/{id}', 'MainMaterialGroupsAPIController@updateMainMaterialGroups');

Route::put('/users/main_targets/{id}', 'MainTargetsAPIController@updateMainTargets');

Route::put('/users/main_export_countries/{id}', 'MainExportCountriesAPIController@updateMainExportCountries');

Route::put('/users/main_services/{id}', 'MainServicesAPIController@updateMainServices');

Route::resource('main_export_countries', 'MainExportCountriesAPIController');

//Route::put('/roles/update_permissions', 'UserController@updatePermissions')->middleware(['jwt.verify','role:administrator']);
Route::put('/roles/update_permissions', 'UserController@updatePermissions');
//attach role to user
Route::put('/roles/attach_role_user', 'UserController@attachRoleUser');
//detach role to user
Route::put('/roles/detach_role_user', 'UserController@detachRoleUser');
// Get all roles of system
Route::get('/roles', 'UserController@getAllRoles');
// Get all permissions of role
Route::get('/roles/{id}/permissions', 'UserController@getRolePermissions');
// Get all permissions of system
Route::get('/permissions', 'UserController@getAllPermissions');
//Get all inactivated users

