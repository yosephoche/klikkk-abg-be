<?php

namespace App\Repositories;

use App\Models\Thread;
use App\Models\User;



class threadRepository
{
    protected $thread;

    public function __construct(Thread $thread)
    {
        $this->thread = $thread;
    }


    public function getAllThread($perPage)
    {
        return $this->thread->orderBy('created_at','DESC')->paginate($perPage);
    }

    public function searchThread($key)
    {
        return $this->thread->where('subject','like',"%$key%")->orderBy('created_at','DESC')->paginate(10);
    }

    public function findBySlug($slug)
    {
        return $this->thread->where('slug',$slug)->first();
    }
    public function findThread($id)
    {
        return $this->thread->find($id);
    }
}
