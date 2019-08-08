<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'forum_categories';
    protected $fillable = ['name','description'];

    

    public function subCategory(){
        return $this->hasMany('App\Models\subCategory');
    }
}
