<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'forum_categories';
    protected $fillable = ['name','description'];
    public function thread(){
        return $this->hasMany('App\Models\Thread');
    }
}
