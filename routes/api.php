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
        Route::group(['prefix' => 'admin', 'namespace' => 'Admin'], function(){

            Route::group(['prefix' => 'master-data', 'namespace' => 'MasterData'], function(){

                /** Master Data Pengujian dan parameter pengujian */
                Route::group(['prefix' => 'master-pengujian'], function(){
                    Route::get('/', 'MasterPengujianController@index')->name('api.admin.master-data.master-pengujian.index');

                    Route::post('/store-jenis-pengujian','MasterPengujianController@storeJenisPengujian')->name('api.admin.master-data.master-pengujian.store-jenis-pengujian');
                    Route::post('/store-parameter','MasterPengujianController@storeParameter')->name('api.admin.master-data.master-pengujian.store-parameter');
                    Route::post('/update-jenis-pengujian','MasterPengujianController@updateJenisPengujian')->name('api.admin.master-data.master-pengujian.update-jenis-pengujian');
                    Route::post('/update-parameter','MasterPengujianController@updateParameter')->name('api.admin.master-data.master-pengujian.update-parameter');
                    Route::post('/delete', 'MasterPengujianController@delete')->name('api.admin.master-data.master-pengujian.delete');
                });

                /** Master Data tahap pengajuan pengujian */
                Route::group(['prefix' => 'tahap-pengajuan-pengujian'], function(){
                    Route::get('/', 'TahapPengajuanPengujianController@index')->name('api.admin.master-data.tahap-pengajuan-pengujian.index');
                    Route::get('/delete/{id}', 'TahapPengajuanPengujianController@delete')->name('api.admin.master-data.tahap-pengajuan-pengujian.delete');

                    Route::post('/store','TahapPengajuanPengujianController@store')->name('api.admin.master-data.tahap-pengajuan-pengujian.store');
                    Route::post('/update','TahapPengajuanPengujianController@update')->name('api.admin.master-data.tahap-pengajuan-pengujian.update');
                });

            });


        });
    });


});