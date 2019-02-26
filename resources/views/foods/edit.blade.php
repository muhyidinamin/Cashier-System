<?php
/**
 * Created by PhpStorm.
 * User: Muhyidin
 * Date: 01/25/2019
 * Time: 05:38 PM
 */
?>

@extends('layouts.global')
@section('title') Edit Category @endsection
@section('content')
    <div class="col-md-8">
        @if(session('status'))
            <div class="alert alert-success">
                {{session('status')}}
            </div>
        @endif
        <form
            action="{{route('foods.update', ['id' => $food->id])}}"
            enctype="multipart/form-data"
            method="POST"
            class="bg-white shadow-sm p-3">
            @csrf
            <input
                type="hidden"
                value="PUT"
                name="_method">
            <label>Food name</label> <br>
            <input
                type="text"
                class="form-control"
                value="{{$food->food_name}}"
                name="name">
            <br><br>
            <label>Category</label>
            <select
            name="categories"
            id="categories"
            class="form-control" required>
            </select>
            <br>
            <label>Price</label><br>
            <input type="text" class="form-control" name="price" value="{{$food->price}}">
            <br>
            <label>Status</label><br>
            <input value="READY" name="status" type="radio" class="form-control" id="ready" {{$food->status == 'READY' ? 'checked' : ''}}>
            <label for="ready">Ready</label>
            <input value="SOLD OUT" name="status" type="radio" class="form-control" id="sold_out" {{$food->status == 'SOLD OUT' ? 'checked' : ''}}>
            <label for="sold_out">Sold Out</label>
            <br>
            <br>

            <input type="submit" class="btn btn-primary" value="Update">
        </form>
    </div>

@endsection

@section('footer-scripts')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
    <script>
    $('#categories').select2({
        ajax: {
            url: 'http://sistem-kasir.test/ajax/categories/search',
            processResults: function(data){
                return {
                    results: data.map(function(item){return {id: item.id, text:item.name} })
                }
            }
        }
    });
    </script>
    
@endsection