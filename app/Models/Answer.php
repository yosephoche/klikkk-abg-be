<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    protected $fillable = ['qna_id','user_id','parent_id','answer','answertable_id','answertable_type'];
    public function user()
    {
        return $this->belongsTo('app\Models\User','user_id');
    }

    public function reply()
    {
        return $this->hasMany('app\Models\Answer','parent_id');
    }

    
    public function deleteRelatedData(){
        $this->reply()->delete();
        
        $this->reply->each->deleteRelatedData();
    }

}
