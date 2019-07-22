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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::group(['prefix' => 'v1','namespace' => 'Api'],function () {
    Route::group(['prefix' => 'admin','namespace' => 'admin'],function () {//namespace is foldername
        Route::get('regions','MainController@regions');
        Route::get('cities','MainController@cities');
        Route::get('settings','MainController@settings');
        Route::get('contacts','MainController@contacts');
        Route::get('resturants','MainController@resturants');
        Route::get('comments','MainController@comments');
        Route::get('payment-method','MainController@paymentMethod');
        Route::get('list-product','Maincontroller@listProduct');
        Route::get('list-offer','Maincontroller@listOffer');
        Route::get('list-notifications','Maincontroller@listNotifications');
    });
    Route::group(['prefix' => 'client','namespace' => 'client'],function () {//namespace is foldername
        Route::post('register','AuthController@register');
        Route::post('login','AuthController@login');
        Route::post('reset-password','AuthController@resetPassword');
        Route::post('new-password','AuthController@newPassword');
        Route::group(['middleware' => 'auth:api_client'],function (){
            Route::post('profile','AuthController@profile');
            Route::post('add-comment','MainController@addComment');
            Route::post('contacts','MainController@contacts');
            Route::post('register-token','AuthController@registerToken');
            Route::post('remove-token','AuthController@removeToken');
            Route::get('notification-count','MainController@notificationCount');
            Route::get('my-orders','MainController@myOrders');
            Route::get('list-order','MainController@listOrder');
            Route::post('new-order','MainController@newOrder');
            Route::post('decline-order','MainController@declineOrder');
            Route::post('confirm-order','MainController@confirmOrder');
        });
    });
    Route::group(['prefix' => 'resturant','namespace' => 'resturant'],function () {
        Route::post('register','AuthController@register');
        Route::post('login','AuthController@login');
        Route::post('reset-password','AuthController@resetPassword');
        Route::post('new-password','AuthController@newPassword');
        Route::group(['middleware' => 'auth:api_resturant'],function (){
            Route::post('profile','AuthController@profile');
            Route::post('contacts','MainController@contacts');
            Route::get('get-resturant-classification','MainController@getResturantClassification');
            Route::post('register-token','AuthController@registerToken');
            Route::post('remove-token','AuthController@removeToken');
            Route::post('add-product','MainController@addProduct');
            Route::post('delete-product','MainController@deleteProduct');
            Route::post('update-product','MainController@updateProduct');
            Route::post('add-offer','MainController@addOffer');
            Route::post('delete-offer','MainController@deleteOffer');
            Route::post('update-offer','MainController@updateOffer');
            Route::post('accept-order','MainController@acceptOrder');
            Route::post('reject-order','MainController@rejectOrder');
            Route::post('confirm-order','MainController@confirmOrder');
            Route::get('my-orders','MainController@myOrders');
            Route::get('list-order','MainController@listOrder');
            Route::get('notification-count','MainController@notificationCount');
            Route::get('list-payments','MainController@listPayments');
        });
    });
});
