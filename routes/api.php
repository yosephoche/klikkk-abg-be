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
                    Route::get('/edit/{uuid}', 'UserManagementController@edit')->name('api.admin.master-data.user-data.user-management.edit');
                    Route::post('/save', 'UserManagementController@save')->name('api.admin.master-data.user-management.save');
                    Route::post('/update', 'UserManagementController@update')->name('api.admin.master-data.user-management.update');
                });

                Route::group(['prefix' => 'master-pelatihan'], function(){
                    Route::get('/', 'MasterPelatihanController@index')->name('api.admin.master-data.master-pelatihan.index');
                    Route::get('/edit/{uuid}', 'MasterPelatihanController@edit')->name('api.admin.master-data.master-pelatihan.edit');

                    Route::post('/store', 'MasterPelatihanController@store')->name('api.admin.master-data.master-pelatihan.store');
                    Route::post('/update', 'MasterPelatihanController@update')->name('api.admin.master-data.master-pelatihan.update');
                    Route::post('/delete', 'MasterPelatihanController@delete')->name('api.admin.master-data.master-pelatihan.delete');
                });

            });

            Route::group(['prefix' => 'kepala-balai'], function(){
                Route::get('/', 'KepalaBalaiController@index')->name('api.admin.kepala-balai.index');
                Route::get('/show/{regId}', 'KepalaBalaiController@show')->name('api.admin.kepala-balai.index');
            });

            Route::group(['prefix' => 'staf-teknis'], function(){
                Route::get('/', 'StafTeknisController@index')->name('api.admin.staf-teknis.index');
                Route::get('/show/{regId}', 'StafTeknisController@show')->name('api.admin.staf-teknis.show');
                Route::post('/{regId}/store-biaya-tambahan', 'StafTeknisController@storeBiayaTambahan')->name('api.admin.staf-teknis.store-biaya-tambahan');
            });

            Route::group(['prefix' => 'kepala-bagian'], function(){
                Route::get('/', 'KepalaBagianController@index')->name('api.admin.kepala-bagian.index');
            });


        });

        Route::group(['prefix' => 'user', 'namespace' => 'User'], function(){

            Route::group(['prefix' => 'pengajuan' , 'namespace' => 'Pengajuan'], function(){

                Route::group(['prefix' => 'pengujian'], function(){
                    Route::get('/get-jenis-pengujian', 'PengujianController@getJenisPengujian')->name('api.user.pengajuan.pengujian.get-jenis-pengujian');

                    Route::get('/get-parameter-pengujian', 'PengujianController@getParameterPengujian')->name('api.user.pengajuan.pengujian.get-parameter-pengujian');

                    Route::get('/', 'PengujianController@index')->name('api.user.pengajuan.pengujian.index');
                    Route::get('/add', 'PengujianController@add')->name('api.user.pengajuan.pegujian.add');
                    Route::post('/store', 'PengujianController@store')->name('api.user.pengajuan.pengujian.store');
                });
            });

            Route::group(['prefix' => 'tracking'], function(){
                Route::get('/{regId}', 'TrackingController@index')->name('api.user.tracking.index');
            });
        });
        // Route FOr Forum
        Route::group(['prefix' => 'forum', 'namespace' => 'Forum'], function(){
            Route::group(['prefix'=>'threads'], function(){
                Route::get('/','threadController@index')->name('thread_index');
                Route::get('/{id}','threadController@show')->name('thread_detail');
                Route::post('like/{id}','threadController@like')->name('thread.like');
                Route::post('dislike/{id}','threadController@dislike')->name('thread.dislike');
                Route::put('/update/{id}','threadController@update')->name('thread_edit');
                Route::post('/post','threadController@store')->name('thread_post');
                Route::delete('/delete/{id}','threadController@destroy')->name('delete_thread');
                Route::get('/popular','threadController@popular')->name('popular.thread');
            });

            Route::group(['prefix'=>'comment'], function(){
                Route::post('/post','CommentController@store')->name('comment.store');
                Route::put('/edit/{id}','CommentController@edit')->name('comment.update');
                Route::delete('/delete/{id}','CommentController@destroy')->name('comment.delete');
            });

            Route::group(['prefix'=>'replies'],function(){
                Route::post('/post/{id}','CommentController@replyStore')->name('reply.store');
                Route::put('/edit/{id}','CommentController@edit')->name('comment.update');
                Route::delete('/delete/{id}','CommentController@destroy')->name('comment.delete');
            });

            Route::group(['prefix'=>'category'],function(){
                Route::get('/','CategoryController@index')->name('category.index');
                Route::post('/','CategoryController@store')->name('category.store');
                Route::put('/edit/{id}','CategoryController@update')->name('category.update');
                Route::delete('/delete/{id}','CategoryController@destroy')->name('category.delete');
            });
        });
    });



});