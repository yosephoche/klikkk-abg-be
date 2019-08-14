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
        return $this->belongsTo('App\Models\User','created_by');
    }

    public function subCategory(){
        return $this->belongsTo('App\Models\subCategory','category_id');
    }

    public function galery(){
        return $this->hasMany('App\Models\Galery');
    }

    public function comments()
    {
        return $this->morphMany('App\Models\Comment','commentable')->whereNull('replies_id');
    }
}
