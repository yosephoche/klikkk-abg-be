<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QnA extends Model
{
    Public function user(){
        return $this->belongsTo('App\Models\User', 'user_id');
    }

    public function answers(){
        return $this->morphMany('App\Models\Answer','answertable')->where('parent_id',0);
    }

    public function deleteRelatedAnswer(){
        $this->answers()->delete();
        
        $this->answers->each->deleteRelatedData();
    }

}
                                                                                                