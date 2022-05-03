<?php

use Illuminate\Support\Facades\Route;

Auth::routes();

Route::get('/', 'App\Http\Controllers\WelcomeController');

Route::get('/product/{slug}', 'App\Http\Controllers\Admin\ProductController@show')->name('show-product');

Route::get('checkout', 'App\Http\Controllers\CheckoutController@index')->name('checkout');

Route::get('cart/{id}/remove', 'CartController@removeItem')->name('checkout.cart.remove');

Route::get('category/{category}', 'App\Http\Controllers\HomeController@category')->name('category');

Route::group(['prefix' => 'cart', 'namespace' => 'App\Http\Controllers'], function () {
    Route::post('/', 'CartController@addToCart')->name('cart.add');

    Route::get('/', 'CartController@myCart')->name('my-basket');

    Route::get('empty', 'CartController@empty')->name('clear-cart');

    Route::get('{id}/remove', 'CartController@removeItem')->name('checkout.cart.remove');
});

Route::group(['middleware' => ['auth']], function () {
    Route::get('home', 'App\Http\Controllers\HomeController@index')->name('home');

    Route::get('profile', 'App\Http\Controllers\HomeController@profile')->name('profile');

    Route::post('/product/{slug}/review', 'App\Http\Controllers\Admin\ProductController@review')->name('review-product');

    Route::get('reminders', 'App\Http\Controllers\HomeController@reminders')->name('reminders');

    Route::post('reminders', 'App\Http\Controllers\HomeController@storeReminders')->name('reminders.store');

    Route::post('profile', 'App\Http\Controllers\HomeController@storeProfile')->name('profile.store');

    Route::get('dashboard', 'HomeController@index')->name('dashboard');

    Route::get('payment', 'App\Http\Controllers\CheckoutController@payment')->name('payment');

    Route::get('settings', 'Admin\UserController@settings')->name('settings');

    Route::post('update-account', 'Admin\UserController@update')->name('update-account');

    Route::post('/pay', [App\Http\Controllers\PaymentController::class, 'redirectToGateway'])->name('pay');

    Route::get('/payment/callback', [App\Http\Controllers\PaymentController::class, 'handleGatewayCallback'])->name('payment.callback');

    Route::get('order/{order}', 'App\Http\Controllers\HomeController@order')->name('order');

    Route::post('order/store', 'App\Http\Controllers\HomeController@storeOrder')->name('order.store');

    Route::group(['prefix' => 'paypal'], function () {
        Route::post('/order/create', [\App\Http\Controllers\Front\PaypalPaymentController::class, 'create']);
        Route::post('/order/capture/', [\App\Http\Controllers\Front\PaypalPaymentController::class, 'capture']);
    });


    Route::get('handle-payment', 'App\Http\Controllers\PayPalPaymentController@handlePayment')->name('make.payment');
    Route::get('cancel-payment', 'App\Http\Controllers\PayPalPaymentController@paymentCancel')->name('cancel.payment');
    Route::get('payment-success', 'App\Http\Controllers\PayPalPaymentController@paymentSuccess')->name('success.payment');

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
