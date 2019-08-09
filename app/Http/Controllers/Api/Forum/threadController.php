<?php

namespace App\Http\Controllers\Api\Forum;

use Auth;
use App\Models\Thread;
// use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\threadRepository;
use App\Repositories\Traits\forumTrait;
use App\Http\Resources\threadResource;
use App\Http\Requests\threadStoreRequest;


class threadController extends Controller
{
    use forumTrait;

    protected $thread;

    public function __construct(threadRepository $thread)
    {
        $this->thread = $thread;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = $this->thread->getAllThread(10);
        $response = threadResource::collection($data);
        return $this->collectionHttpResponse($response,$data);
    }

    
    public function popular()
    {
        $data = Thread::orderByUniqueViews()->paginate(10);
        $response = threadResource::collection($data);
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
    public function store(threadStoreRequest $request)
    {
        $thread = new Thread;
        $thread->subject = $request->subject;
        $thread->slug = str_slug($thread->subject);
        $thread->description = $request->description;
        $thread->category_id = $request->category_id;
        $thread->created_by = Auth::user()->id;
        $thread->save();
        if(isset($thread->id))
        {
            return $this->success();
        } else {
            return $this->serverError();
        }
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
           
        $data = Thread::where('slug',$slug)->first();
        views($data)->record();
        $response = new threadResource($data);

        return $this->singleHttpResponse($data,$response);
    }

    // thread like function
    public function like($id)
    {
        // find the thread
        $data = $this->thread->findThread($id);

        /*
        * checking if thread exist if not return 404
        * if it exist give like to thread based by current user 
        */ 
        if(isset($data))
        {
            $data->like();
            return $this->success();
        } else {
            return $this->notFound();
        }

    }

     // thread dislike function
     public function dislike($id)
     {
         // find the thread
         $data = $this->thread->findThread($id);
 
         /*
         * checking if thread exist if not return 404
         * if it exist give dislike to thread based by current user 
         */ 
         if(isset($data))
         {
             $data->dislike();
             return $this->success();
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
    public function update(threadStoreRequest $request, $id)
    {
        $thread = $this->thread->findThread($id);
        if(isset($thread))
        {
            if(Auth::user()->id == $thread->created_by)
            {
                $thread->subject = $request->subject;
                $thread->slug = str_slug($thread->subject);
                $thread->description = $request->description;
                $thread->category_id = $request->category_id;
                $thread->created_by = Auth::user()->id;
                $thread->save();
                if(isset($thread->id))
                {
                    return $this->success();
                } else {
                    return $this->serverError();
                }   
            } else {
                return $this->unprocessable();
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
        $thread = $this->thread->findThread($id);

        if(isset($thread))
        {
            if(Auth::user()->id == $thread->created_by)
            {
                $thread->delete();
                return $this->success();
            } else {
                return $this->unprocessable();
            }
        } else {
            return $this->notFound();
        }
    }
}
