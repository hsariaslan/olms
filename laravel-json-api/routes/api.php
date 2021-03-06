<?php

use Illuminate\Support\Facades\Route;
use CloudCreativity\LaravelJsonApi\Facades\JsonApi;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------web artisan------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::namespace('Api\V1\Auth')->prefix('api/v1')->middleware('json.api')->group(function () {
    Route::post('/login', 'LoginController');
    Route::post('/register', 'RegisterController');
    Route::post('/logout', 'LogoutController')->middleware('auth:api');
    Route::post('/password-forgot', 'ForgotPasswordController');
    Route::post('/password-reset', 'ResetPasswordController');
});

JsonApi::register('v1')->middleware('auth:api')->routes(function ($api) {
    $api->get('me', 'Api\V1\MeController@readProfile');
    $api->patch('me', 'Api\V1\MeController@updateProfile');

    $api->get('get-user-role', 'Api\V1\UserRolePermissionController@getUserRole');

    $api->resource('users')->relationships(function ($relations) {
        $relations->hasMany('user-roles');
    });
    $api->resource('books');
    $api->resource('authors');
    $api->resource('genres');
    $api->resource('publishers');
    $api->resource('languages');
    $api->resource('members');
    $api->resource('member-types');
    $api->resource('punishments');
    $api->resource('roles')->relationships(function ($relations) {
        $relations->hasOne('user');
    });
    $api->resource('permissions');

});
