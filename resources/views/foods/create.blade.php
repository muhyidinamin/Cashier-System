<?php
/**
 * Created by PhpStorm.
 * User: Muhyidin
 * Date: 01/25/2019
 */
?>

@extends('layouts.global')

@section('title') Add Food @endsection

@section('content')
    <div class="col-md-8">
        @if(session('status'))
            <div class="alert alert-success">
                {{session('status')}}
            </div>
        @endif
        <form enctype="multipart/form-data" class="bg-white shadow-sm p-3" action="{{route('foods.store')}}" method="POST">
            @csrf
            <label>Food name</label><br>
            <input type="text" class="form-control" name="name">
            <br>
            <label for="categories">Categories</label><br>
            <select
            name="categories"
            id="categories"
            class="form-control">
            </select>
            <br>
            <label>Price</label><br>
            <input type="text" class="form-control" name="price">
            <br>
            <label>Status</label><br>
            <input value="READY" name="status" type="radio" class="form-control" id="ready">
            <label for="ready">Ready</label>
            <input value="SOLD OUT" name="status" type="radio" class="form-control" id="sold_out">
            <label for="sold_out">Sold Out</label>
            <br>
            <br>
            <input type="submit" class="btn btn-primary" value="Save">
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
