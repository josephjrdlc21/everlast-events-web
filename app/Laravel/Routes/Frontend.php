<?php

Route::group(['as' => "frontend.", 'namespace' => "Frontend", 'middleware' => ["web"]], function() {
    Route::get('/home', ['as' => "home", 'uses' => "MainController@home", 'middleware' => "frontend.guest"]);

    Route::group(['prefix' => "", 'as' => "auth."], function(){
        Route::group(['middleware' => "frontend.guest"], function(){
            Route::get('/login', ['as' => "login", 'uses' => "AuthController@login"]);
            Route::post('/login', ['uses' => "AuthController@authenticate"]);
            Route::get('/register', ['as' => "register", 'uses' => "AuthController@register"]);
            Route::post('/register', ['uses' => "AuthController@store"]);
            Route::get('/forgot-password', ['as' => "forgot_password", 'uses' => "AuthController@forgot_password"]);
            Route::post('/forgot-password', ['uses' => "AuthController@forgot_password_email"]);
            Route::get('/reset-password/{refid?}', ['as' => "reset_password", 'uses' => "AuthController@reset_password"]);
            Route::post('/reset-password/{refid?}', ['uses' => "AuthController@store_password"]);
        });
        Route::get('/logout', ['as' => "logout", 'uses' => "AuthController@logout"]);
    });

    Route::group(['middleware' => "frontend.auth"], function(){
        Route::get('/', ['as' => "index", 'uses' => "MainController@index"]);

        Route::group(['prefix' => "events", 'as' => "events."], function(){
            Route::get('/', ['as' => "index", 'uses' => "EventsController@index"]);
            Route::get('/{id?}', ['as' => "show", 'uses' => "EventsController@show"]);
        });

        Route::group(['prefix' => "bookings", 'as' => "bookings."], function(){
            Route::get('/', ['as' => "index", 'uses' => "BookingsController@index"]);
            Route::get('/show/{id?}', ['as' => "show", 'uses' => "BookingsController@show"]);
            Route::get('/update-status/{id?}', ['as' => "update_status", 'uses' => "BookingsController@update_status"]);
            Route::get('/{id?}', ['as' => "create", 'uses' => "BookingsController@create"]);
            Route::post('/{id?}', ['uses' => "BookingsController@store"]);
        });

        Route::group(['prefix' => "profile", 'as' => "profile."], function(){
            Route::get('/', ['as' => "index", 'uses' => "ProfileController@index"]);
            Route::get('/password', ['as' => "edit_password", 'uses' => "ProfileController@edit_password"]);
            Route::post('/password', ['uses' => "ProfileController@update_password"]);
        });
    });
});