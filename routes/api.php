<?php

use Illuminate\Http\Request;

// 'json.response',
Route::group( ['middleware' => ['json.response'],'namespace' => 'Api'], function(){

    Route::middleware('auth:api')->get('/user', function (Request $request) {
        return $request->user();
    });

    // Public Routes
    Route::post('/login', 'AuthController@login')->name('api.login');
    Route::post('/register', 'AuthController@register')->name('api.register');
    Route::get('/register', 'AuthController@getRegisterData');
    Route::get('/verification/{token}', 'AuthController@verifyUsersEmail')->name('api.verifyUsersEmail');
    /**
     * TODO : reset password
     *
     */

    // Private Route
    Route::group( [ 'middleware' => ['auth:api'] ], function(){
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

                    Route::post('/save-parameter', 'MasterPengujianController@saveParameter')->name('api.admin.master-data.master-pengujian.saveParameter');
                    Route::post('/delete-parameter', 'MasterPengujianController@deleteParameter')->name('api.admin.master-data.master-pengujian.delete-parameter');
                });

                /** Master Data tahap pengajuan pengujian */
                Route::group(['prefix' => 'tahap-pengajuan-pengujian'], function(){
                    Route::get('/', 'TahapPengajuanPengujianController@index')->name('api.admin.master-data.tahap-pengajuan-pengujian.index');
                    Route::get('/delete/{id}', 'TahapPengajuanPengujianController@delete')->name('api.admin.master-data.tahap-pengajuan-pengujian.delete');

                    Route::post('/store','TahapPengajuanPengujianController@store')->name('api.admin.master-data.tahap-pengajuan-pengujian.store');
                    Route::post('/update','TahapPengajuanPengujianController@update')->name('api.admin.master-data.tahap-pengajuan-pengujian.update');
                });

                /** Master Data role user */
                Route::group(['prefix' => 'user-role'], function(){
                    Route::get('/', 'UserRoleController@index')->name('api.admin.master-data.user-role.index');
                    Route::get('/get-list-user', 'UserRoleController@getListUser')->name('api.admin.master-data.user-role.get-list-user');
                    Route::get('/get-list-role', 'UserRoleController@getListRole')->name('api.admin.master-data.role-role.get-list-role');
                    Route::get('/delete/{id}', 'UserRoleController@delete')->name('api.admin.master-data.user-role.delete');


                    Route::post('/attach','UserRoleController@attach')->name('api.admin.master-data.user-role.attach');
                    Route::post('/detach','UserRoleController@detach')->name('api.admin.master-data.user-role.detach');
                });

                Route::group(['prefix' => 'user-management'], function(){
                    Route::get('/', 'UserManagementController@index')->name('api.admin.master-data.user-management.index');
                    Route::get('/add', 'UserManagementController@add')->name('api.admin.master-data.user-management.add');

                    Route::post('/save', 'UserManagementController@save')->name('api.admin.master-data.user-management-save');
                });

            });


        });

        Route::group(['prefix' => 'user', 'namespace' => 'User'], function(){

            Route::group(['prefix' => 'pengajuan' , 'namespace' => 'Pengajuan'], function(){

                Route::group(['prefix' => 'pengujian'], function(){
                    Route::get('/', 'PengujianController@index')->name('api.user.pengajuan.pengujian.index');
                    Route::get('/add', 'PengujianController@add')->name('api.user.pengajuan.pegujian.add');
                    Route::post('/store', 'PengujianController@store')->name('api.user.pengajuan.pengujian.store');
                });

            });

        });
    });


});