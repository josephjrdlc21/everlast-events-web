<?php

Route::group(['prefix' => "portal", 'as' => "portal.", 'namespace' => "Portal", 'middleware' => ["web"]], function() {
    Route::group(['prefix' => "", 'as' => "auth."], function(){
        Route::group(['middleware' => "portal.guest"], function(){
            Route::get('/login/{uri?}', ['as' => "login", 'uses' => "AuthController@login"]);
            Route::post('/login/{uri?}', ['uses' => "AuthController@authenticate"]);
            Route::get('/register', ['as' => "register", 'uses' => "AuthController@register"]);
            Route::post('/register', ['uses' => "AuthController@store"]);
        });
        Route::get('/logout', ['as' => "logout", 'uses' => "AuthController@logout"]);
    });

    Route::group(['middleware' => "portal.auth"], function(){
        Route::get('/', ['as' => "index", 'uses' => "MainController@index"]);

        Route::group(['prefix' => "users", 'as' => "users."], function(){
            Route::get('/', ['as' => "index", 'uses' => "UsersController@index", 'middleware' => "portal.permission:portal.users.index"]);
            Route::get('/create', ['as' => "create", 'uses' => "UsersController@create", 'middleware' => "portal.permission:portal.users.create"]);
            Route::post('/create', ['uses' => "UsersController@store", 'middleware' => "portal.permission:portal.users.create"]);
            Route::get('/edit/{id?}', ['as' => "edit", 'uses' => "UsersController@edit", 'middleware' => "portal.permission:portal.users.update"]);
            Route::post('/edit/{id?}', ['uses' => "UsersController@update", 'middleware' => "portal.permission:portal.users.update"]);
            Route::get('/edit-password/{id?}', ['as' => "edit_password", 'uses' => "UsersController@edit_password", 'middleware' => "portal.permission:portal.users.edit_password"]);
            Route::post('/edit-password/{id?}', ['uses' => "UsersController@update_password", 'middleware' => "portal.permission:portal.users.edit_password"]);
            Route::get('/update-status/{id?}', ['as' => "update_status", 'uses' => "UsersController@update_status", 'middleware' => "portal.permission:portal.users.update_status"]);
            Route::get('/show/{id?}', ['as' => "show", 'uses' => "UsersController@show", 'middleware' => "portal.permission:portal.users.view"]);
        });

        Route::group(['prefix' => "events", 'as' => "events."], function(){
            Route::get('/', ['as' => "index", 'uses' => "EventsController@index", 'middleware' => "portal.permission:portal.events.index"]);
            Route::get('/create', ['as' => "create", 'uses' => "EventsController@create", 'middleware' => "portal.permission:portal.events.create"]);
            Route::post('/create', ['uses' => "EventsController@store", 'middleware' => "portal.permission:portal.events.create"]);
            Route::get('/edit/{id?}', ['as' => "edit", 'uses' => "EventsController@edit", 'middleware' => "portal.permission:portal.events.update"]);
            Route::post('/edit/{id?}', ['uses' => "EventsController@update", 'middleware' => "portal.permission:portal.events.update"]);
            Route::get('/update-is-cancelled/{id?}', ['as' => "update_is_cancelled", 'uses' => "EventsController@update_is_cancelled", 'middleware' => "portal.permission:portal.events.update_is_cancelled"]);
            Route::get('/show/{id?}', ['as' => "show", 'uses' => "EventsController@show", 'middleware' => "portal.permission:portal.events.view"]);
        });

        Route::group(['prefix' => "users-kyc", 'as' => "users_kyc."], function(){
            Route::get('/', ['as' => "index", 'uses' => "UsersKYCController@index", 'middleware' => "portal.permission:portal.users_kyc.index"]);
            Route::get('/approved', ['as' => "approved", 'uses' => "UsersKYCController@approved", 'middleware' => "portal.permission:portal.users_kyc.index"]);
            Route::get('/rejected', ['as' => "rejected", 'uses' => "UsersKYCController@rejected", 'middleware' => "portal.permission:portal.users_kyc.index"]);
            Route::get('/show/{id?}', ['as' => "show", 'uses' => "UsersKYCController@show", 'middleware' => "portal.permission:portal.users_kyc.view"]);
            Route::get('/update-status/{id?}/{status?}', ['as' => "update_status", 'uses' => "UsersKYCController@update_status", 'middleware' => "portal.permission:portal.users_kyc.update_status"]);
        });

        Route::group(['prefix' => "members", 'as' => "members."], function(){
            Route::get('/', ['as' => "index", 'uses' => "MembersController@index", 'middleware' => "portal.permission:portal.members.index"]);
            Route::get('/show/{id?}', ['as' => "show", 'uses' => "MembersController@show", 'middleware' => "portal.permission:portal.members.view"]);
            Route::get('/edit-password/{id?}', ['as' => "edit_password", 'uses' => "MembersController@edit_password", 'middleware' => "portal.permission:portal.members.edit_password"]);
            Route::post('/edit-password/{id?}', ['uses' => "MembersController@update_password", 'middleware' => "portal.permission:portal.members.edit_password"]);
            Route::get('/update-status/{id?}', ['as' => "update_status", 'uses' => "MembersController@update_status", 'middleware' => "portal.permission:portal.members.update_status"]);
        });

        Route::group(['prefix' => "cms", 'as' => "cms."], function(){
            Route::group(['prefix' => "roles", 'as' => "roles."], function(){
                Route::get('/', ['as' => "index", 'uses' => "RolesController@index", 'middleware' => "portal.permission:portal.cms.roles.index"]);
                Route::get('/create', ['as' => "create", 'uses' => "RolesController@create", 'middleware' => "portal.permission:portal.cms.roles.create"]);
                Route::post('/create', ['uses' => "RolesController@store", 'middleware' => "portal.permission:portal.cms.roles.create"]);
                Route::get('/edit/{id?}', ['as' => "edit", 'uses' => "RolesController@edit", 'middleware' => "portal.permission:portal.cms.roles.update"]);
                Route::post('/edit/{id?}', ['uses' => "RolesController@update", 'middleware' => "portal.permission:portal.cms.roles.update"]);
            });

            Route::group(['prefix' => "permissions", 'as' => "permissions."], function(){
                Route::get('/', ['as' => "index", 'uses' => "PermissionsController@index", 'middleware' => "portal.permission:portal.cms.permissions.index"]);
            });

            Route::group(['prefix' => "category", 'as' => "category."], function(){
                Route::get('/', ['as' => "index", 'uses' => "CategoryController@index", 'middleware' => "portal.permission:portal.cms.category.index"]);
                Route::get('/create', ['as' => "create", 'uses' => "CategoryController@create", 'middleware' => "portal.permission:portal.cms.category.create"]);
                Route::post('/create', ['uses' => "CategoryController@store", 'middleware' => "portal.permission:portal.cms.category.create"]);
                Route::get('/edit/{id?}', ['as' => "edit", 'uses' => "CategoryController@edit", 'middleware' => "portal.permission:portal.cms.category.update"]);
                Route::post('/edit/{id?}', ['uses' => "CategoryController@update", 'middleware' => "portal.permission:portal.cms.category.update"]);
                Route::get('/update-status/{id?}',['as' => "update_status", 'uses' => "CategoryController@update_status", 'middleware' => "portal.permission:portal.cms.category.update_status"]);
                Route::get('/show/{id?}', ['as' => "show", 'uses' => "CategoryController@show", 'middleware' => "portal.permission:portal.cms.category.view"]);
                Route::any('/delete/{id?}', ['as' => "delete", 'uses' => "CategoryController@destroy", 'middleware' => "portal.permission:portal.cms.category.delete"]);
            });

            Route::group(['prefix' => "sponsors", 'as' => "sponsors."], function(){
                Route::get('/', ['as' => "index", 'uses' => "SponsorsController@index", 'middleware' => "portal.permission:portal.cms.sponsors.index"]);
                Route::get('/create', ['as' => "create", 'uses' => "SponsorsController@create", 'middleware' => "portal.permission:portal.cms.sponsors.create"]);
                Route::post('/create', ['uses' => "SponsorsController@store", 'middleware' => "portal.permission:portal.cms.sponsors.create"]);
                Route::get('/edit/{id?}', ['as' => "edit", 'uses' => "SponsorsController@edit", 'middleware' => "portal.permission:portal.cms.sponsors.update"]);
                Route::post('/edit/{id?}', ['uses' => "SponsorsController@update", 'middleware' => "portal.permission:portal.cms.sponsors.update"]);
                Route::get('/show/{id?}', ['as' => "show", 'uses' => "SponsorsController@show", 'middleware' => "portal.permission:portal.cms.sponsors.view"]);
                Route::any('/delete/{id?}', ['as' => "delete", 'uses' => "SponsorsController@destroy", 'middleware' => "portal.permission:portal.cms.sponsors.delete"]);
            });

            Route::group(['prefix' => "pages", 'as' => "pages."], function(){
                Route::get('/', ['as' => "index", 'uses' => "PagesController@index", 'middleware' => "portal.permission:portal.cms.pages.index"]);
                Route::get('/create', ['as' => "create", 'uses' => "PagesController@create", 'middleware' => "portal.permission:portal.cms.pages.create"]);
                Route::post('/create', ['uses' => "PagesController@store", 'middleware' => "portal.permission:portal.cms.pages.create"]);
                Route::get('/edit/{id?}', ['as' => "edit", 'uses' => "PagesController@edit", 'middleware' => "portal.permission:portal.cms.pages.update"]);
                Route::post('/edit/{id?}', ['uses' => "PagesController@update", 'middleware' => "portal.permission:portal.cms.pages.update"]);
                Route::get('/show/{id?}', ['as' => "show", 'uses' => "PagesController@show", 'middleware' => "portal.permission:portal.cms.pages.view"]);
                Route::any('/delete/{id?}', ['as' => "delete", 'uses' => "PagesController@destroy", 'middleware' => "portal.permission:portal.cms.pages.delete"]);
            });

            Route::group(['prefix' => "faq", 'as' => "faq."], function(){
                Route::get('/', ['as' => "index", 'uses' => "FAQController@index", 'middleware' => "portal.permission:portal.cms.faq.index"]);
                Route::get('/create', ['as' => "create", 'uses' => "FAQController@create", 'middleware' => "portal.permission:portal.cms.faq.create"]);
                Route::post('/create', ['uses' => "FAQController@store", 'middleware' => "portal.permission:portal.cms.faq.create"]);
                Route::get('/edit/{id?}', ['as' => "edit", 'uses' => "FAQController@edit", 'middleware' => "portal.permission:portal.cms.faq.update"]);
                Route::post('/edit/{id?}', ['uses' => "FAQController@update", 'middleware' => "portal.permission:portal.cms.faq.update"]);
                Route::get('/update-status/{id?}', ['as' => "update_status", 'uses' => "FAQController@update_status", 'middleware' => "portal.permission:portal.cms.faq.update_status"]);
                Route::get('/show/{id?}', ['as' => "show", 'uses' => "FAQController@show", 'middleware' => "portal.permission:portal.cms.faq.view"]);
                Route::any('/delete/{id?}', ['as' => "delete", 'uses' => "FAQController@destroy", 'middleware' => "portal.permission:portal.cms.faq.delete"]);
            });
        });

        Route::group(['prefix' => "profile", 'as' => "profile."], function(){
            Route::get('/', ['as' => "index", 'uses' => "ProfileController@index"]);
            Route::get('/password', ['as' => "edit_password", 'uses' => "ProfileController@edit_password"]);
            Route::post('/password', ['uses' => "ProfileController@update_password"]);
        });
    });
});
