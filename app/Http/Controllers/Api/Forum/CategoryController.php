<?php

namespace App\Http\Controllers\Api\Forum;

use Illuminate\Http\Request;
use App\Models\subCategory;
use App\Models\Thread;
use App\Models\Comment;
use App\Models\Category;
use App\Repositories\Traits\forumTrait;
use App\Http\Resources\categoryResource;
use App\Http\Resources\subCategoryResource;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    use forumTrait;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Category::orderBy('id','desc')->paginate(5);
        $response = categoryResource::collection($data);
        return $this->collectionHttpResponse($response,$data);    
    }

    public function subIndex()
    {
        $data = subCategory::orderBy('id','desc')->paginate(5);
        $response = subCategoryResource::collection($data);
        return $this->collectionHttpResponse($response,$data);
    }

    public function categoryList()
    {
        $data = subCategory::orderBy('id','desc')->get();
        $response = subCategoryResource::collection($data);
        return $this->noPaging($response,$data);
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
        $category = $request->all();
        $store = Category::create($category);
        if($store->id)
        {
           return $this->success();
        }
    }

    public function subStore(Request $request)
    {
        $data = new subCategory;
        $data->category_id = $request->category_id;
        $data->name = $request->name;
        $data->save();
        if($data->id)
        {
           return $this->success();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = Category::find($id);
        $response = new categoryResource($data);
        return $this->singleHttpResponse($data,$response);    
    }

    public function subShow($id)
    {
        $data = subCategory::find($id);
        $response = new subCategoryResource($data);
        return $this->singleHttpResponse($data,$response);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
       
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
        $data = Category::find($id);

        if(isset($data))
        {
           $data->name = $request->name;
           $data->description = $request->description;
           $data->save();
           
           return $this->success();
        } else {
            return $this->notFound();
        }
    }

    public function subUpdate(Request $request, $id)
    {
        $data = subCategory::find($id);

        if(isset($data))
        {
            $data->category_id = $request->category_id;
            $data->name = $request->name;
            $data->save();

            return $this->success();
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
        // find the category base on id 
        $data = Category::find($id);
        if(isset($data))
        {
            $subCategory = subCategory::where('category_id',$id)->first();
            if(isset($subCategory))
            {
                // delete all thread that have relationship with this Category
                $threads = Thread::where('category_id',$subCategory->id)->get();
                if($threads->isNotEmpty())
                {
                    foreach($threads as $thread)
                    {
                        $comments = Comment::where('topic_id',$thread->id)->first();
                        foreach($comments as $comment)
                        {
                            $replies = Comment::where('replies_id',$comment->id)->first();
                            foreach($replies as $replie)
                            {
                                $replie->delete();
                            }    
                            $comment->delete();
                        }
                        $thread->delete();
                    }
                }
                $subCategory->delete();
            }
            // deleting the category
            $data->delete();
            return $this->success();
        } else {
            // returning 404 if not found
            return $this->notFound();
        }
    }

    public function subDestroy($id)
    {
        $data = subCategory::find($id);
        if(isset($data))
        {
            // delete all thread that have relationship with this Category
            $threads = Thread::where('category_id',$id)->get();
            foreach($threads as $thread)
            {
                $comments = Comment::where('topic_id',$thread->id)->get();
                foreach($comments as $comment)
                {
                    $replies = Comment::where('replies_id',$comment->id)->get();
                    foreach($replies as $replie)
                    {
                        $replie->delete();
                    }    
                    $comment->delete();
                }
                $thread->delete();
            }

            // deleting the category
            $data->delete();
            return $this->success();
        } else {
            // returning 404 if not found
            return $this->notFound();
        }
    }
}
