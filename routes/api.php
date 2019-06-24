<?php

use Illuminate\Http\Request;


Route::group(['middleware' => ['json.response'], 'namespace' => 'Api'], function(){

    Route::middleware('auth:api')->get('/user', function (Request $request) {
        return $request->user();
    });

    // Public Routes
    Route::post('/login', 'AuthController@login')->name('api.login');
    Route::post('/register', 'AuthController@register')->name('api.register');
    /**
     * TODO : reset password
     *
     */

    // Private Route
    Route::middleware('auth:api')->group(function(){
        Route::get('/logout', 'AuthController@logout')->name('api.logout');
        // Route::get('/home', 'HomeController@index')->name('api.home');
    });


});