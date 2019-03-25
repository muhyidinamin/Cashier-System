<?php
/**
 * Created by PhpStorm.
 * User: Muhyidin
 * Date: 01/25/2019
 * Time: 05:38 PM
 */
?>

@extends('layouts.global')
@section('title') Edit Kategori @endsection
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
            <label>Nama Kategori</label> <br>
            <input
                type="text"
                class="form-control {{$errors->first('name') ? "is-invalid" : ""}}"
                value="{{old('name') ? old('name') : $category->name}}"
                name="name">
            <div class="invalid-feedback">
            {{$errors->first('name')}}
            </div>
            <br><br>
            <input type="submit" class="btn btn-primary" value="Update">
        </form>
    </div>

@endsection

