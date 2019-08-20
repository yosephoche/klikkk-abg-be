<?php

namespace App\Http\Controllers\Api\Admin\MasterData;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\JenisAkun;

class JenisAkunController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $jenisAkun = JenisAkun::all();

        return dtcApiResponse(200, $jenisAkun);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $jenisAkun = new JenisAkun();
        $jenisAkun->nama = $request->nama;
        $jenisAkun->save();

        return dtcApiResponse(200, $jenisAkun, 'Jenis akun berhasil di simpan');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $jenisAkun = JenisAkun::findOrFail($id);

        return dtcApiResponse(200, $jenisAkun);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $jenisAkun = JenisAkun::findOrFail($id);

        return dtcApiResponse(200, $jenisAkun);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $jenisAkun = JenisAkun::findOrFail($id);
        $jenisAkun->nama = $request->nama;
        $jenisAkun->save();

        return dtcApiResponse(200, $jenisAkun, 'Jenis akun berhasi di update');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $jenisAkun = JenisAkun::findOrFail($id);
        $jenisAkun->delete();

        return dtcApiResponse(200, null,'Jenis akun berhasil di hapus');
    }
}
