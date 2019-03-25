<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use PDF;

class ReportController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
        $this->middleware(function($request, $next){
            if(Gate::allows('print-report')) return $next($request);
            abort(403, 'Anda tidak memiliki cukup hak akses');
        });
    }

    public function index()
    {
        $user = \Auth::user()->id;
        $results = $this->getData();
        $identity = \App\User::findOrFail($user);

        return view('report.index', ['results' => $results], ['identity' => $identity]);
    }

    public function getData(){
        $user = \Auth::user()->id;
        
        $results = \App\Order::leftJoin('users', 'orders.created_by', '=', 'users.id')
                ->where("orders.created_by", "=", $user)
                ->select('users.id as user', 'orders.*', 'users.name')
                ->paginate(10);
        return $results;
    }

    public function print(){
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($this->convert_data_to_pdf());
        return $pdf->stream();
    }

    public function convert_data_to_pdf(){
        $user = \Auth::user()->id;
        $identity = \App\User::findOrFail($user);

        $results = $this->getData();
        $output = '
            <h3 align="center">Data Pesanan oleh '.$identity->name.'</h3>
            <table width="100%" style="border-collapse:collapse; border:1px;">
            <thead>
                <tr>
                    <th style="border: 1px; solid; padding:12px; width:25%"><b>Kode Pesanan</b></th>
                    <th style="border: 1px; solid; padding:12px; width:30%"><b>Nama Pelanggan</b></th>
                    <th style="border: 1px; solid; padding:12px; width:15%"><b>No Meja</b></th>
                    <th style="border: 1px; solid; padding:12px; width:15%"><b>Qty</b></th>
                    <th style="border: 1px; solid; padding:12px; width:15%"><b>Total</b></th>
                </tr>
            </thead>
            <tbody> ';
            foreach($results as $data){
                $output .= '
                <tr>
                    <td style="border: 1px; solid; padding:12px;">'.$data->id.'</td>
                    <td style="border: 1px; solid; padding:12px;">'.$data->name_cus.'</td>
                    <td style="border: 1px; solid; padding:12px;">'.$data->no_meja.'</td>
                    <td style="border: 1px; solid; padding:12px;">'.$data->qty.'</td>
                    <td style="border: 1px; solid; padding:12px;">'.$data->total.'</td>
                </tr>
                ';
            }
            $output .= '
            </tbody>
        </table>';
        return $output;
    }
}
