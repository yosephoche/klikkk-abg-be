<?php

namespace App\Http\Controllers\Api\User\Pengajuan;

use Auth;
use App\Models\User;
use App\Models\pengajuanPelatihan;
use App\Http\Requests\pelatihanRequest;
use App\Models\JenisPelatihan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Traits\forumTrait;
use App\Http\Resources\pelatihanResource;
use Illuminate\Support\Facades\Mail;
use App\Notifications\pelatihanNotification;
use App\Notifications\verifyPelatihan;
use App\Mail\verifikasiPelatihan;
use Illuminate\Support\Facades\Notification;

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
        $data = pengajuanPelatihan::orderBy('id','desc')->where('user_id',Auth::user()->id)->paginate(5);
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
    public function store(pelatihanRequest $request)
    {
        $data = new pengajuanPelatihan;
        $data->user_id = Auth::user()->id;
        $data->nama_pemohon = $request->nama_pemohon;
        $data->alamat = $request->alamat;
        $data->email = $request->email;
        $data->instansi = $request->instansi;
        $data->telepon = $request->telepon;
        $data->komentar = $request->komentar;
        $data->save();
        $data->jenisPelatihan()->sync($request->jenisPelatihan);

        Mail::to($data->email)->queue(new verifikasiPelatihan($data));

        $staff = User::whereHas('roles', function($query){
            $query->where('name','staf_teknis');
        })->get();

        foreach ($staff as $staff) {
            Notification::send($staff, new pelatihanNotification($data,$staff));        
        }

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
        $data = pengajuanPelatihan::find($id);
        
        if(isset($data))
        {
            $response = new pelatihanResource($data);
            return $this->singleHttpResponse($data,$response);
        } else {
            return $this->notFound();
        }
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
    public function update(pelatihanRequest $request, $id)
    {
        $data = pengajuanPelatihan::find($id);
        if(isset($data))
        {
            if($data->user_id == Auth::user()->id)
            {
                $data->nama_pemohon = $request->nama_pemohon;
                $data->alamat = $request->alamat;
                $data->email = $request->email;
                $data->instansi = $request->instansi;
                $data->telepon = $request->telepon;
                $data->komentar = $request->komentar;
                $data->save();
                $data->jenisPelatihan()->sync($request->jenisPelatihan);

                return $this->success();

            } else {
                return $this->unauthorized();
            }
        } else {
            return $this->notFound();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = pengajuanPelatihan::find($id);
        if(isset($data))
        {
            if($data->user_id == Auth::user()->id)
            {
                $data->jenisPelatihan()->detach();

                $data->delete();
                return $this->success;
            } else {
                return $this->unauthorized();
            }
        } else {
            return $this->notFound();
        }        
    }
}
