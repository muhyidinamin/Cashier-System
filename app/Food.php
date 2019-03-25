<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Food extends Model
{
    protected $fillable = ['food_name', 'category', 'price', 'status'];
    use SoftDeletes;
    
    public function category(){
        return $this->belongsTo('App\Category');
    }
}
