<?php

namespace App\Http\Controllers\Api\User\Pengajuan;

use Auth;
use App\Models\pengajuanPelatihan;
use App\Models\JenisPelatihan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Traits\forumTrait;
use App\Http\Resources\pelatihanResource;

class pelatihanController extends Controller
{
    use forumTrait;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = pengajuanPelatihan::orderBy('id','desc')->paginate(5);
        $response = pelatihanResource::collection($data);
        return $this->collectionHttpResponse($response,$data);

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
        $data = new pengajuanPelatihan;
        $data->user_id = Auth::user()->id;
        $data->nama_pemohon = $request->nama_pemohon;
        $data->alamat = $request->alamat;
        $data->email = $request->email;
        $data->instansi = $request->instansi;
        $data->telepon = $request->telepon;
        $data->save();
        $data->jenisPelatihan()->sync($request->jenisPelatihan);
        return $this->success();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
