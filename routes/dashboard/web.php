<?php

Route::group(
    ['prefix' => LaravelLocalization::setLocale(), 'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath']],
    function () {

        Route::prefix('dashboard')->name('dashboard.')->middleware(['auth'])->group(function () {

            Route::get('/', 'WelcomeController@index')->name('welcome');

            //category routes
            Route::resource('categories', 'CategoryController')->except(['show']);

            //product routes
            Route::resource('products', 'ProductController')->except(['show']);

            //outlay routes
            Route::resource('outlays', 'OutlayController')->except(['show']);
             //payment routes
             Route::resource('payments', 'PaymentController')->except(['show']);

            //client routes
            Route::resource('clients', 'ClientController')->except(['show']);
            Route::resource('clients.orders', 'Client\OrderController')->except(['show']);

            //order routes
            Route::resource('orders', 'OrderController');
            Route::get('/orders/{order}/products', 'OrderController@products')->name('orders.products');


            //supplier routes
            Route::resource('suppliers', 'SupplierController')->except(['show']);
            Route::resource('suppliers.purchaces', 'Supplier\PurchaceController')->except(['show']);

            //purchaces routes
            Route::resource('purchaces', 'PurchaceController');
            Route::get('/purchaces/{purchace}/products', 'PurchaceController@products')->name('purchaces.products');



            //user routes
            Route::resource('users', 'UserController')->except(['show']);
        }); //end of dashboard routes
    }
);
