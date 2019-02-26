<?php
/**
 * Created by PhpStorm.
 * User: Muhyidin
 * Date: 01/25/2019
 * Time: 05:53 PM
 */
?>

@extends('layouts.global')
@section('title') Detail Category @endsection
@section('content')
    <div class="col-md-8">
        <div class="card">
            <div class="card-body">
                <label><b>Category name</b></label><br>
                {{$category->name}}
                <br><br>
            </div>
        </div>
    </div>
@endsection
