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

Route::get('/open', 'DataController@open')->middleware(['jwt.verify', 'permission:delete-profile', 'role:administrator']);
Route::group(['middleware' => ['jwt.verify']], function () {
    Route::get('/user', 'UserController@getAuthenticatedUser');
});

Route::resource('minimum_order_quantities', 'MinimumOrderQuantityAPIController');

Route::resource('countries', 'CountriesAPIController');

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
    //Create user
    Route::post('/create_user', 'UserController@createUser');

});

Route::put('/verify/{user_id}/{activation_code}', 'UsersAPIController@verify');


//                         MODULE PROFILE

Route::get('/categories/all_parent', 'CategoryAPIController@showParentCategories');

Route::get('/categories/parent_with_children', 'CategoryAPIController@getCategoriesByParent');


Route::resource('categories', 'CategoryAPIController');

//Route::resource('main_categories', 'MainCategoryAPIController');



//Update user profile
Route::group(['middleware' => ['jwt.verify', 'ability:,update-profile']], function () {
    Route::get('/bookmarks/user/{user_id}/', 'BookmarksAPIController@index');

    Route::put('/users/brands/{id}', 'UserController@updateBrands');

    Route::put('/users/main_categories/{id}', 'UsersAPIController@updateMainCategories');



    Route::post('/upload_avatar', 'UsersAPIController@uploadAvatar');
});

Route::get('/roles', 'UserController@getAllRoles');

//                               MODULE ACL
Route::group(['middleware' => ['jwt.verify', 'permission:manage-acl']], function () {
// update permissions of role
    Route::put('/roles/update_permissions', 'UserController@updatePermissions');
//sync role to user
    Route::put('/roles/sync_role_user', 'UserController@syncRoleUser');
// Get all permissions of role
    Route::get('/roles/{id}/permissions', 'UserController@getRolePermissions');
// Get all permissions of system
    Route::get('/permissions', 'UserController@getAllPermissions');
// Get all roles and its permissions
    Route::get('/all_roles_and_permissions', 'UserController@getAllRolesAndPermissions');
});

Route::group(['middleware' => ['jwt.verify']], function () {
    Route::get('/test', 'MessageAPIController@test');
    Route::get('/get_inbox', 'MessageAPIController@getInbox');
    Route::get('/get_conversation/{id}', 'MessageAPIController@getConversationsById');
    Route::get('/get_conversation_by_user/{user_id}', 'MessageAPIController@getConversationsByUserId');
    Route::post('/send', 'MessageAPIController@sendMessage');
    Route::put('/make_seen/{message_id}', 'MessageAPIController@makeSeen');
    Route::post('/chat_history/{user_id}', 'MessageAPIController@chatHistory');
    Route::delete('/delete_message/{id}', 'MessageAPIController@deleteMessage');
});

Route::get('/product_posts/get_own_posts/{user_id}', 'ProductPostsAPIController@getOwnPosts');

Route::resource('products', 'ProductsAPIController');
Route::get('/product_user/{user_id}', 'ProductsAPIController@product_user');

Route::resource('locations', 'LocationsAPIController');



Route::resource('job_posts', 'JobPostsAPIController');

Route::resource('apply_cv', 'AppliedCVAPIController');

Route::get('/cvs/job_post/{job_post_id}', 'AppliedCVAPIController@getAllCVInAPost');
