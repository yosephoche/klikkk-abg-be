<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Galery extends Model
{
    public function user()
    {
        return $this->belongsTo('App\Models\User','user_id');
    }
    
    public function thread()
    {
        return $this->belongsTo('App\Models\Thread','thread_id');
    }

    public function comment()
    {
        return $this->belongsTo('App\Models\Comment','comment_id');
    }
}
