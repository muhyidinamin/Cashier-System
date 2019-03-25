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

    public function index(Request $request){
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

    public function create(){
        $today = date("dmY");
    	$foods = \App\Food::where('status', 'READY')->paginate(10);
        $noUrutAkhir = \App\Order::max('id');
        $lastNoUrut = substr($noUrutAkhir, 12, 3);
        $nextNoUrut = $lastNoUrut + 1;
        $kode = 'ERP'.$today.sprintf('-%03s', $nextNoUrut);
    	return view('orders.create', ['foods' => $foods],['kode' => $kode]);
    }

    public function store(Request $request){
        \Validator::make($request->all(), [
            "name" => "required",
            "no" => "required"
        ])->validate();
        
        $orders = new Order;
        $orders->id = $request->id;
        $orders->name_cus = $request->name;
        $orders->no_meja = $request->no;
        $jumlah = 0;
        $total = 0; 
        $orders->created_by = \Auth::user()->id;
        for($i=0;$i<count($request->qty);$i++) {
            $jumlah += $request->qty[$i];
            $total += $request->subtotal[$i];
        }
        $orders->qty = $jumlah;
        $orders->total = $total;
        $orders->status = "OPEN";
        if($orders->save()){
            for($i=0;$i<count($request->qty);$i++) {
                $data = array('order_id' => $orders->id,
                            'food_id' => $request->foodname[$i],
                            'qty' => $request->qty[$i],
                            'subtotal' => $request->subtotal[$i]);
                DetailOrder::insert($data);
            }
        }
        return redirect()->route('orders.index')->with('status', 'Order successfully added');
    }

    public function edit($id){
        $order_to_edit = \App\Order::findOrFail($id);
        $details = \App\DetailOrder::leftJoin('orders', 'orders.id', '=', 'details_order.order_id')->where('order_id', $id);
        $foods = \App\Food::where('status', 'READY')->paginate(10);

        return view('orders.edit', ['foods' => $foods], ['order' => $order_to_edit], ['details' => $details]);
    }

    public function update(Request $request, $id)
    {
    	$name_cus = $request->get('name');
        $no_meja = $request->get('no');
        $status = $request->get('status');
        $jumlah = 0;
        $total = 0; 

        $order = \App\Order::findOrFail($id);

        $order->name_cus = $name_cus;
        $order->no_meja = $no_meja;
        $order->status = $status;
        $order->updated_by = \Auth::user()->id;
        $order->save();

        return redirect()->route('orders.index', ['id' => $id])->with('status', 'Order succesfully update');
    }

    public function show($id)
    {
        $order = DB::table('orders')->where('order_id', $id)
            ->join('details_order', 'orders.id', '=', 'details_order.order_id')
            ->get();

        return view('orders.detail', ['orders' => $order]);
        //return dd($order);
    }

    public function destroy($id)
    {
    	$order = \App\Order::findOrFail($id);
        $order->delete();
        return redirect()->route('orders.index')->with('status', 'Order successfully deleted');
    }

    public function findPrice(Request $request)
    {
       $data=Food::select('price')->where('id', $request->id)->first();
       return response()->json($data);
    }
}
