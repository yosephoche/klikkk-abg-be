<?php

namespace App\Http\Controllers\Api\Forum;

// use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Repositories\Traits\forumTrait;
use App\Models\Thread;
use App\Http\Requests\commentRequest;
use Auth;
class CommentController extends Controller
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
    public function store(commentRequest $request)
    {
        $comment = new Comment;
        $comment->comment = $request->comment;  
        $comment->user()->associate(Auth::user()->id);
        $comment->topic_id = $request->topic_id;
        
        $thread = Thread::find($request->topic_id  );
        $thread->comments()->save($comment);

        return $this->success();
    }

    // Function for replly the comments of a thread

    public function replyStore(commentRequest $request,$id)
    {
        $reply = new Comment;
        $reply->comment = $request->comment;  
        $reply->user()->associate(Auth::user()->id);
        $reply->replies_id = $id;
        
        $thread = Thread::find($request->topic_id);

        $thread->comments()->save($reply);

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
    public function edit(commentRequest $request,$id)
    {
        $comment = Comment::find($id);
       
        if(isset($comment))
        {
            $comment->comment = $request->comment;
            $comment->save();

            return $this->success();
        } else {
            $this->notFound();
        }
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
        $data = Comment::find($id);
        
        if(isset($data))
        {
            $replies = Comment::where('replies_id',$data->id)->get();
            if($replies->isNotEmpty())
            {
                foreach($replies as $reply)
                {
                    $reply->delete();
                }
                $data->delete();
                return $this->success();
            } else {
                $data->delete();
                return$this->success();
            }
        } else {
            $this->notFound();
        }
    }
}
