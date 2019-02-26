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
            action="{{route('categories.update', ['id' => $category->id])}}"
            enctype="multipart/form-data"
            method="POST"
            class="bg-white shadow-sm p-3">
            @csrf
            <input
                type="hidden"
                value="PUT"
                name="_method">
            <label>Category name</label> <br>
            <input
                type="text"
                class="form-control"
                value="{{$category->name}}"
                name="name">
            <br><br>
            <input type="submit" class="btn btn-primary" value="Update">
        </form>
    </div>

@endsection

