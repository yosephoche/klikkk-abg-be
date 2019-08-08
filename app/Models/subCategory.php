<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class subCategory extends Model
{
    protected $table = 'sub_categories';

    protected $fillable = ['name','category_id'];

    public function thread()
    {
        return $this->hasMany('App\Models\Thread','category_id');
    }

    public function category()
    {
        return $this->belongsTo('App\Models\Category');
    }
}
