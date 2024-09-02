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
        });
        Route::get('/logout', ['as' => "logout", 'uses' => "AuthController@logout"]);
    });

    Route::group(['middleware' => "frontend.auth"], function(){
        Route::get('/', ['as' => "index", 'uses' => "MainController@index"]);
    });
});
