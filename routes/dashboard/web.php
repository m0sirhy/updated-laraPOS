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

            //client routes
            Route::resource('clients', 'ClientController')->except(['show']);
            Route::resource('clients.orders', 'Client\OrderController')->except(['show']);

            //supplier routes
            Route::resource('suppliers', 'SupplierController')->except(['show']);
            Route::resource('suppliers.purchase', 'Client\OrderController')->except(['show']);

            //order routes
            Route::resource('orders', 'OrderController');
            Route::get('/orders/{order}/products', 'OrderController@products')->name('orders.products');


            //user routes
            Route::resource('users', 'UserController')->except(['show']);
        }); //end of dashboard routes
    }
);
