<?php

namespace App\Http\Controllers\Api\Forum;

// use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Repositories\Traits\forumTrait;
use App\Models\Thread;
use App\Models\User;
use App\Models\Galery;
use App\Http\Requests\commentRequest;
use Auth;
use App\Notifications\threadMailNotification;
use App\Notifications\commentNotification;
use Illuminate\Support\Facades\Mail;
use App\Mail\commentMail;
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

        
        $thread = Thread::find($request->topic_id);
        $thread['status'] = 'Comment';

        $user =  User::find($thread->created_by);
        $user->email = $thread->user->email;
        $user->notify(new commentNotification($user,$thread,$comment));
        $thread->comments()->save($comment);

        if($request->hasFile('images'))
        {
            foreach ($request->images as $image) {
                $galery = new Galery;
                $uploadFile = $image;
                $filename = time()."."."images".".".$uploadFile->getClientOriginalExtension();
                $destination = 'upload/images';
                $uploadFile->move(public_path($destination),$filename);
                $galery->file = $filename;
                $galery->user_id = Auth::user()->id;
                $galery->comment_id = $comment->id;
                $galery->type = "image";
                $galery->save();
            }
        }

        if($request->hasFile('videos'))
        {
            foreach ($request->videos as $video) {
                $galery = new Galery;
                $uploadFile = $video;
                $filename = time()."video".".".$uploadFile->getClientOriginalExtension();
                $destination = 'upload/videos';
                $uploadFile->move(public_path($destination),$filename);
                $galery->file = $filename;
                $galery->user_id = Auth::user()->id;
                $galery->comment_id = $comment->id;
                $galery->type = "video";
                $galery->save();
            }
        }

        return $this->success();
    }



    // like comment
    public function like($id)
    {
        // find the Comment or Reply
        $data = Comment::find($id);
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
        $data = Comment::find($id);
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

    // Function for replly the comments of a thread

    public function replyStore(commentRequest $request,$id)
    {
        $reply = new Comment;
        $reply->comment = $request->comment;  
        $reply->user()->associate(Auth::user()->id);
        $reply->replies_id = $id;
        
        $thread = Thread::find($request->topic_id);
        $thread['status'] = "Reply";
        $comment = Comment::where('id',$reply->replies_id)->first();
        // sending notificaation
        $user = User::find($comment->user_id);
        $user->email = $comment->user->email;
        $user->notify(new threadMailNotification($thread,$user,$comment,$reply));
        
        $thread->comments()->save($comment);

        $thread->comments()->save($reply);

        if($request->hasFile('images'))
        {
            foreach ($request->images as $image) {
                $galery = new Galery;
                $uploadFile = $image;
                $filename = time()."."."images".".".$uploadFile->getClientOriginalExtension();
                $destination = 'upload/images';
                $uploadFile->move(public_path($destination),$filename);
                $galery->file = $filename;
                $galery->user_id = Auth::user()->id;
                $galery->comment_id = $reply->id;
                $galery->type = "image";
                $galery->save();
            }
        }

        if($request->hasFile('videos'))
        {
            foreach ($request->videos as $video) {
                $galery = new Galery;
                $uploadFile = $video;
                $filename = time()."video".".".$uploadFile->getClientOriginalExtension();
                $destination = 'upload/videos';
                $uploadFile->move(public_path($destination),$filename);
                $galery->file = $filename;
                $galery->user_id = Auth::user()->id;
                $galery->comment_id = $reply->id;
                $galery->type = "video";
                $galery->save();
            }
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
                return $this->success();
            }
        } else {
            $this->notFound();
        }
    }
}
