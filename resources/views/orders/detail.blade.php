@extends('layouts.global')
@section('title') Detail Order @endsection
@section('content')
    <div class="col-md-8">
        <div class="card">
            <div class="card-body">
                @foreach($orders as $order)
                <b>ID Pesanan :</b> <br/>
                {{$order->order_id}}
                <br><br>
                <b>Nama Pelanggan :</b><br>
                {{$order->name_cus}}
                <br>
                <br>
                <b>Phone number</b><br>
                <ul>
                    <li>{{$order->food_id}}</li>
                </ul>
                <b>Jumlah</b><br>
                {{$order->qty}}
                <br>
                <br>
                <b>Total</b><br>
                {{$order->total}}
                <br>
                <br>
                @endforeach
            </div>
        </div>
    </div>
@endsection
