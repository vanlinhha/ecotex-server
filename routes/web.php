<?php
//Route::post('register', 'UserController@register');
//Route::post('login', 'UserController@authenticate');
//Route::get('open', 'DataController@open');
//
//Route::group(['middleware' => ['jwt.verify']], function() {
//    Route::get('user', 'UserController@getAuthenticatedUser');
//    Route::get('closed', 'DataController@closed');
//});
//
//
////Views
//Route::get('/', 'Controller@index')->name('defaultPageAfterLogin')->middleware(['web', 'auth']);
//Route::get('/login', 'LoginCtrl@index')->name('login')->middleware('guest');
//Route::get('/updateOld', 'Sipas\SipasEvaluationRoundCtrl@updateOld');
//
////Auth::routes();
////Auth
//Route::prefix('auth')->group(function()
//{
//    Route::post('login', 'LoginCtrl@login')->name('Đăng nhập hệ thống');
//    Route::get('logout', 'LoginCtrl@logout')->name('Đăng xuất');
//});
//require 'cores.php';
//require 'sipas.php';



//

//Route::resource('users', 'UsersController');


//Route::resource('users', 'UsersController');

//Route::resource('productGroups', 'ProductGroupsController');

//Route::resource('mainSegmentGroups', 'MainSegmentGroupsController');

//Route::resource('mainExportCountries', 'MainExportCountriesController');



Route::resource('productPosts', 'ProductPostsController');