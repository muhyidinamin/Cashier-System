<?php
/**
 * Created by PhpStorm.
 * User: Muhyidin
 * Date: 01/25/2019
 * Time: 05:53 PM
 */
?>

@extends('layouts.global')
@section('title') Detail Kategori @endsection
@section('content')
    <div class="col-md-8">
        <div class="card">
            <div class="card-body">
                <label><b>Nama Kategori</b></label><br>
                {{$category->name}}
                <br><br>
            </div>
        </div>
    </div>
@endsection
