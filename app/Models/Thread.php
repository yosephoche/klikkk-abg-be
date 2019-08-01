<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use CyrildeWit\EloquentViewable\Viewable;
use Cog\Likeable\Traits\Likeable;
use Cog\Likeable\Contracts\Likeable as LikeableContract;
use CyrildeWit\EloquentViewable\Contracts\Viewable as ViewableContract;

class Thread extends Model implements ViewableContract,LikeableContract
{
    use Likeable;
    use Viewable;

    protected $table = 'forum_topic';
    protected $fillable = ['subject','created_by','category_id'];

    public function user(){
        return $this->belongsTo('app\Models\User','created_by');
    }

    public function category(){
        return $this->belongsTo('App\Models\Category','category_id');
    }

    public function thread(){
        return $this->belongsTo('app\Models\Category','category_id');
    }

    public function comments()
    {
        return $this->morphMany('App\Models\Comment','commentable')->whereNull('replies_id');
    }
}
