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
        return $this->thread->orderBY('created_at','DESC')->paginate($perPage);
    }

    public function findThread($id)
    {
        return $this->thread->find($id);
    }
}
