<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    public $incrementing = false;

    public function detail()
    {
        return $this->hasMany('App\DetailOrder', 'id', 'order_id');
    }
}
