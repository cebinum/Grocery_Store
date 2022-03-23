<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', 'App\Http\Controllers\WelcomeController');

Auth::routes();

Route::group(['middleware' => ['auth', 'verified']], function () {
    Route::get('home', 'App\Http\Controllers\HomeController@index')->name('home');

    Route::get('dashboard', 'HomeController@index')->name('dashboard');

    Route::get('checkout', 'App\Http\Controllers\CheckoutController@index')->name('checkout');

    Route::get('settings', 'Admin\UserController@settings')->name('settings');

    Route::post('update-account', 'Admin\UserController@update')->name('update-account');

    Route::get('order/{order}', 'HomeController@order')->name('order');


    Route::group(['prefix' => 'admin', 'middleware' => 'admin', 'namespace' => 'App\Http\Controllers\Admin'], function () {

        Route::resource('categories', 'CategoryController');

        Route::resource('products', 'ProductController');

        Route::resource('orders', 'OrderController');

        Route::resource('users', 'UserController');

        Route::get('dashboard', 'DashboardController')->name('admin.dashboard');

        Route::get('products/live/{product}', 'ProductController@live')->name('products.live');
        Route::get('order-received/{order}', 'OrderController@received')->name('order.received');
        Route::get('order-in-progress/{order}', 'OrderController@inProcess')->name('order.progress');
        Route::get('delivery-in-progress/{order}', 'OrderController@deliveryInProgress')->name('delivery.progress');
        Route::get('delivered/{order}', 'OrderController@delivered')->name('delivered');
    });
});

Route::group(['prefix' => 'cart', 'namespace' => 'App\Http\Controllers'], function () {
    Route::post('/', 'CartController@addToCart')->name('cart.add');

    Route::get('/', 'CartController@myCart')->name('my-basket');

    Route::get('empty', 'CartController@empty')->name('clear-cart');

    Route::get('{id}/remove', 'CartController@removeItem')->name('checkout.cart.remove');
});

Route::get('/product/{slug}', 'App\Http\Controllers\Admin\ProductController@show')->name('show-product');
