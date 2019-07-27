<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect('login');
});

Auth::routes();

Route::group(['middleware'=>['auth','auto-check-permission']],function(){
    Route::get('/home', 'HomeController@index')->name('home');
    Route::resource('city', 'CityController');
    Route::resource('region', 'RegionController');
    Route::resource('resturant', 'ResturantController');
    Route::get('resturants/{id}/activated', 'ResturantController@activated');
    Route::get('resturants/{id}/deactivated', 'ResturantController@deactivated');
    Route::resource('classification', 'ClassificationController');
    Route::resource('offer', 'OfferController');
    Route::resource('product', 'ProductController');
    Route::resource('payment', 'PaymentController');
    Route::resource('client', 'ClientController');
    Route::resource('order', 'OrderController');
    Route::get('clients/{id}/activated', 'ClientController@activated');
    Route::get('clients/{id}/deactivated', 'ClientController@deactivated');
    Route::resource('paymentmethod', 'PaymentMethodController');
    Route::resource('contact', 'ContactController');
    Route::resource('setting', 'SettingController');
    // User reset password
    Route::get('user/change-password','UserController@changePassword');
    Route::post('user/change-password','UserController@changePasswordSave');
    Route::resource('user', 'UserController');
    Route::resource('role', 'RoleController');
    Route::resource('permission', 'PermissionController');
});
Route::get('forgetpassword','UserController@forgetpassword');
Route::post('forgetpassword','UserController@passwordSave')->name('savepassword');