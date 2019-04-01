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


//                   MODULE AUTHENTICATE

Route::post('/sign_up', 'UserController@register');
Route::post('/login', 'UserController@authenticate');
Route::delete('/log_out', 'UserController@logOut');
Route::get('/403', function () {
    return response()->json(['errors' => 'Bạn không có quyền thực hiện chức năng này', 'status' => 403, 'data' => []], 403);
});

//                  MODULE TEST

Route::get('/test_role', 'UserController@testRole');
Route::get('/open', 'DataController@open')->middleware(['jwt.verify', 'permission:delete-profile', 'role:administrator']);
Route::group(['middleware' => ['jwt.verify']], function () {
    Route::get('/user', 'UserController@getAuthenticatedUser');
});


//Route::resource('main_product_groups', 'MainProductGroupsAPIController');
//
//Route::resource('main_segment_groups', 'MainSegmentGroupsAPIController');
//
//Route::resource('main_targets', 'MainTargetsAPIController')->middleware('jwt.verify');
//
//Route::resource('main_services', 'MainServicesAPIController');
//
//Route::resource('main_export_countries', 'MainExportCountriesAPIController');

Route::get('/product_groups/all_parent/', 'ProductGroupsAPIController@showParentProductGroups');

Route::get('/product_groups/parent_with_children/', 'ProductGroupsAPIController@getProductCategoryByParent');

Route::resource('product_groups', 'ProductGroupsAPIController');

Route::resource('segment_groups', 'SegmentGroupsAPIController');

Route::resource('role_types', 'RoleTypesAPIController');

Route::resource('target_groups', 'TargetGroupsAPIController');

Route::resource('minimum_order_quantities', 'MinimumOrderQuantityAPIController');

Route::resource('services', 'ServicesAPIController');

Route::resource('countries', 'CountriesAPIController');

Route::resource('material_groups', 'MaterialGroupsAPIController');

Route::resource('bookmarks', 'BookmarksAPIController');

Route::resource('product_posts', 'ProductPostsAPIController');

Route::get('response_user', 'ResponsesAPIController@getUserResponses')->middleware(['jwt.verify']);

Route::resource('responses', 'ResponsesAPIController');






//                         MODULE USERS

Route::group(['middleware' => ['jwt.verify', 'ability:administrator,manage-users|read-profile']], function () {

    Route::resource('users', 'UsersAPIController');
//Get all inactivated users
    Route::get('/inactivated_users', 'UsersAPIController@getInactivatedUser');
//Get all users
    Route::get('/all_users', 'UsersAPIController@getAllUser');
//Verify users
    Route::put('/verify_users', 'UsersAPIController@verifyUsers');
//Verify user by activation code
});

Route::put('/verify/{user_id}/{activation_code}', 'UsersAPIController@verify');


//                         MODULE PROFILE

//Update user profile
Route::group(['middleware' => ['jwt.verify', 'ability:,update-profile']], function () {
    Route::get('/bookmarks/user/{user_id}/', 'BookmarksAPIController@index');

    Route::put('/users/brands/{id}', 'UserController@updateBrands');

    Route::put('/users/main_segment_groups/{id}', 'MainSegmentGroupsAPIController@updateMainSegmentGroups');

    Route::put('/users/main_product_groups/{id}', 'MainProductGroupsAPIController@updateMainProductGroups');

    Route::put('/users/main_material_groups/{id}', 'MainMaterialGroupsAPIController@updateMainMaterialGroups');

    Route::put('/users/main_target_groups/{id}', 'MainTargetsAPIController@updateMainTargets');

    Route::put('/users/main_export_countries/{id}', 'MainExportCountriesAPIController@updateMainExportCountries');

    Route::put('/users/main_services/{id}', 'MainServicesAPIController@updateMainServices');


});

Route::get('/roles', 'UserController@getAllRoles');


//                               MODULE ACL

Route::group(['middleware' => ['jwt.verify', 'permission:manage-acl']], function () {
// update permissions of role
    Route::put('/roles/update_permissions', 'UserController@updatePermissions');
//sync role to user
    Route::put('/roles/sync_role_user', 'UserController@syncRoleUser');
// Get all roles of system
// Get all permissions of role
    Route::get('/roles/{id}/permissions', 'UserController@getRolePermissions');
// Get all permissions of system
    Route::get('/permissions', 'UserController@getAllPermissions');
// Get all roles and its permissions
    Route::get('/all_roles_and_permissions', 'UserController@getAllRolesAndPermissions');
});


Route::post('/uploads', 'UserController@upload');

Route::post('/uploads_test', 'UserController@uploads_test');





Route::get('/product_posts/get_own_posts/{user_id}', 'ProductPostsAPIController@getOwnPosts');

//Route::resource('attached_files', 'AttachedFilesAPIController');
//
//Route::resource('attached_images', 'AttachedImagesAPIController');

Route::resource('products', 'ProductsAPIController');
Route::get('/product_user/{user_id}', 'ProductsAPIController@product_user');




Route::resource('locations', 'LocationsAPIController');