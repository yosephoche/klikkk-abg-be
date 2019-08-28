<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/a', function () {
//     return view('welcome');
// });

use App\Repositories\PengajuanPengujian;


Route::get('/verification/{token}', 'Api\AuthController@verifyUsersEmail')->name('verifyUsersEmail');

Route::get('/cetak', function(){
    $pengajuan = collect(PengajuanPengujian::getOne('1565277151'));

    $groupPengujian = [];

    foreach ($pengajuan['data_pengujian'] as $key => $value) {
        $_groupPengujian = explode('-',$value['group']);
        if (collect($groupPengujian)->has($_groupPengujian[0]) == false) {
            $groupPengujian[] = $_groupPengujian[0];
        }
    }

    $groupPengujian = array_unique($groupPengujian);

    $bulan = namaBulan(date('m', strtotime($pengajuan['data_pemohon']['created_at'])));
    $tahun = date('Y', strtotime($pengajuan['data_pemohon']['created_at']));

    $pdf = PDF::loadView('berkas.proposal',compact('pengajuan','groupPengujian', 'bulan', 'tahun'));
    $berkas = $pdf->save('storage/uploads/berkas/_'.$pengajuan['data_pemohon']['regId'].'.pdf');

    return asset('storage/uploads/berkas/_'.$pengajuan['data_pemohon']['regId'].'.pdf');

});
