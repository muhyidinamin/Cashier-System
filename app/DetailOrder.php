<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetailOrder extends Model
{
    protected $table ="details_order";

    public function order(){
        return $this->belongsTo('App\Order');
    }
}
