<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $table = 'forum_replies';
    protected $fillable = ['topic_id','replies_id','user','commentable_id','commentable_type','created_at','updated_at'];

    public function user()
    {
        return $this->belongsTo('app\Models\User','user_id');
    }

    public function replies()
    {
        return $this->hasMany('app\Models\Comment','replies_id');
    }
}
