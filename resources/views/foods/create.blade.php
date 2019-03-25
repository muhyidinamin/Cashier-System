<?php
/**
 * Created by PhpStorm.
 * User: Muhyidin
 * Date: 01/25/2019
 */
?>

@extends('layouts.global')

@section('title') Tambah Makanan @endsection

@section('content')
    <div class="col-md-8">
        @if(session('status'))
            <div class="alert alert-success">
                {{session('status')}}
            </div>
        @endif
        <form enctype="multipart/form-data" class="bg-white shadow-sm p-3" action="{{route('foods.store')}}" method="POST">
            @csrf
            <label>Nama Makanan</label><br>
            <input value="{{old('name')}}" type="text" class="form-control {{$errors->first('name') ? "is-invalid" : ""}}" name="name">
            <div class="invalid-feedback">
            {{$errors->first('name')}}
            </div>
            <br>

            <label for="categories">Kategori</label><br>
            <select
            name="categories"
            id="categories"
            class="form-control {{$errors->first('categories') ? "is-invalid" : ""}}" required>
            </select>
            <div class="invalid-feedback">
            {{$errors->first('categories')}}
            </div>
            <br>

            <label>Harga</label><br>
            <input value="{{old('price')}}" type="text" class="form-control {{$errors->first('price') ? "is-invalid" : ""}}" name="price">
            <div class="invalid-feedback">
            {{$errors->first('price')}}
            </div>
            <br>

            <label>Status</label><br>
            <input value="READY" name="status" type="radio" class="form-control {{$errors->first('price') ? "is-invalid" : ""}}" id="ready" checked>
            <label for="ready">Ready</label>
            <input value="SOLD OUT" name="status" type="radio" class="form-control {{$errors->first('price') ? "is-invalid" : ""}}" id="sold_out">
            <label for="sold_out">Sold Out</label>
            <div class="invalid-feedback">
            {{$errors->first('status')}}
            </div>
            <br>
            <br>
            <input type="submit" class="btn btn-primary" value="Save" require>
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
