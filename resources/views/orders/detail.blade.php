@extends('layouts.global')
@section('title') Detail Order @endsection
@section('content')
    <div class="col-md-8">
        <div class="card">
            <div class="card-body">
                @foreach($orders as $order)
                <b>ID Pesanan :</b> 
                {{$order->order_id}}
                <br><br>
                <b>Nama Pelanggan :</b>
                {{$order->name_cus}}
                <br>
                <br>
                <b>Nama Makanan</b>
                <ul>
                    <li>{{$order->food_name}}</li>
                </ul>
                <b>Jumlah</b>
                {{$order->qty}}
                <br>
                <br>
                <b>Total</b>
                {{$order->total}}
                <br>
                <br>
                @endforeach
            </div>
        </div>
    </div>
@endsection
