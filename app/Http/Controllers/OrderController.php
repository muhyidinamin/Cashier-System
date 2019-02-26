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

    public function insert(Request $request){
        $orders = new Order;
        $orders->id = $request->id;
        $orders->name_cus = $request->name;
        $orders->no_meja = $request->no;
        $orders->created_by = \Auth::user()->id;
        $orders->qty = 5;
        $orders->total = 80000;
        $orders->status = "OPEN";
        if($orders->save()){
            for($i=0;$i<count($request->qty);$i++) {
                $data = array('order_id' => $request->id,
                            'food_id' => $request->foodname[$i],
                            'qty' => $request->qty[$i],
                            'subtotal' => $request->subtotal[$i]);
                DetailOrder::insert($data);
            }
        }
        return back();
    }

    public function edit(){
    	return view('orders.update');
    }

    public function update()
    {
    	
    }

    public function view(Request $request){
        $orders = \App\Order::paginate(10);

        $filterKeyword = $request->get('keyword');

        $status = $request->get('status');
        if($status){
            $orders = \App\Order::where('status', $status)->paginate(10);
        } else {
            $orders = \App\Order::paginate(10);
        }

        if($filterKeyword){
            if($status){
                $orders = \App\Order::where('id', 'LIKE', "%$filterKeyword%")
                    ->where('status', $status)
                    ->paginate(10);
            } else {
                $orders = \App\Order::where('id', 'LIKE', "%$filterKeyword%")
                    ->paginate(10);
            }
        }

        return view('orders.index', ['orders' => $orders]);
    }

    public function findPrice(Request $request)
    {
       $data=Food::select('price')->where('id', $request->id)->first();
       return response()->json($data);
    }
}
