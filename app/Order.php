<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    public $incrementing = false;

    public function details()
    {
        return $this->hasMany('App\DetailOrder', 'id', 'order_id');
    }

    public function user(){
        return $this->belongsTo('App\User');
    }
}
