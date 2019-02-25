<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use DB;
use App\Http\Controllers\Controller;
use \App\Food;
use \App\Order;
use \App\DetailOrder;

class OrderController extends Controller
{

    public function __construct(){
        $this->middleware('auth');
        $this->middleware(function($request, $next){
            if(Gate::allows('manage-orders')) return $next($request);
            abort(403, 'Anda tidak memiliki cukup hak akses');
        });
    }

    public function index(){
    	$foods = \App\Food::where('status', 'READY')->paginate(10);
    	return view('orders.info', ['foods' => $foods]);
    }

    public function insert(){

    }

    public function edit(){
    	return view('orders.update');
    }

    public function update()
    {
    	
    }
}
