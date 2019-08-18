<?php

namespace App\Http\Controllers\Api\Forum;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Traits\forumTrait;
use App\Models\Galery;
use Auth;
use File;

class galleryController extends Controller
{
    use forumTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        
        if($request->hasFile('images'))
        {
                $galery = new Galery;
                $uploadFile = $request->images;
                $filename = time()."images".".".$uploadFile->getClientOriginalExtension();
                $destination = 'upload/images';
                $uploadFile->move(public_path($destination),$filename);
                $galery->file = $filename;
                $galery->user_id = Auth::user()->id;
                $galery->thread_id = $request->thread_id;
                $galery->comment_id = $request->comment_id;
                $galery->type = "image";
                $galery->save();
        }

        if($request->hasFile('videos'))
        {
                $galery = new Galery;
                $uploadFile = $request->videos;
                $filename = time()."video".".".$uploadFile->getClientOriginalExtension();
                $destination = 'upload/videos';
                $uploadFile->move(public_path($destination),$filename);
                $galery->file = $filename;
                $galery->user_id = Auth::user()->id;
                $galery->thread_id = $request->thread_id;
                $galery->comment_id = $request->comment_id;
                $galery->type = "video";
                $galery->save();
        }

        return $this->successGalery($filename);
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
        $data = Galery::find($id);
        if(isset($data))
        {
            if($data->type == 'image')
            {
                $path = public_path("/upload/images/".$data->file);
               
                if(File::exists($path))
                {
                    FIle::delete($path);
                    $data->delete();
                }
            }

            if($data->type == 'video')
            {
                $path = public_path("/upload/videos/".$data->file);
                if(File::exists($path))
                {
                    FIle::delete($path);
                    $data->delete();
                }
            }
            return $this->success();
        }
    }
}
