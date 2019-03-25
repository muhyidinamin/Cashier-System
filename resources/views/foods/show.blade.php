<?php
/**
 * Created by PhpStorm.
 * User: Muhyidin
 * Date: 01/25/2019
 * Time: 05:53 PM
 */
?>

@extends('layouts.global')
@section('title') Detail Makanan @endsection
@section('content')
    <div class="col-md-8">
        <div class="card">
            <div class="card-body">
                <label><b>Nama Makanan</b></label><br>
                {{$food->food_name}}
                <br><br>
                <label><b>Nama Kategori</b></label><br>
                {{$food->name}}
                <br><br>
                <label><b>Harga</b></label><br>
                {{$food->price}}
                <br><br>
                <label><b>Status</b></label><br>
                {{$food->status}}
                <br><br>
            </div>
        </div>
    </div>
@endsection
