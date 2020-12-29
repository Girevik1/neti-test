<?php

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

Route::post('login', 'API\UserController@login');
Route::post('register', 'API\UserController@register');

Route::group(['middleware' => 'auth:api'], function () {
    Route::post('user/details', 'API\UserController@details');
    // Orders
    Route::get('order/list', 'API\OrderController@getOrders');
    Route::get('order/{id}', 'API\OrderController@getById');
    Route::post('order/create', 'API\OrderController@create');
    Route::put('order/{id}/completed', 'API\OrderController@makeCompleted');
    Route::put('order/{id}/cancel', 'API\OrderController@makeCancel');
    // Applications
    Route::post('application/create/by-order-id/{id}', 'API\ApplicationController@create');
    Route::put('application/accept/{id}', 'API\ApplicationController@acceptApplication');
});
