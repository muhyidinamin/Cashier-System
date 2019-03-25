<?php
/**
 * Created by PhpStorm.
 * User: Muhyidin
 * Date: 01/25/2019
 */
?>
@extends('layouts.global')
@section('title') List Makanan @endsection
@section('content')
    <div class="row">
        <div class="col-md-6">
            <form action="{{route('foods.index')}}">
                <div class="row">
                        <div class="col-md-6">
                            <input
                                value="{{Request::get('keyword')}}"
                                name="keyword"
                                class="form-control"
                                type="text"
                                placeholder="Masukan keyword untuk filter..."/>
                        </div>
                        <div class="col-md-6">
                            <input {{Request::get('status') == 'READY' ? 'checked' : ''}}
                                value="READY"
                                name="status"
                                type="radio"
                                class="form-control"
                                id="active">
                            <label for="active">Ready</label>
                            <input {{Request::get('status') == 'SOLD OUT' ? 'checked' : ''}}
                                value="SOLD OUT"
                                name="status"
                                type="radio"
                                class="form-control"
                                id="inactive">
                            <label for="inactive">Sold Out</label>
                            <input
                                type="submit"
                                value="Filter"
                                class="btn btn-primary">
                        </div>
                    </div>
            </form>
        </div>

        <div class="col-md-6">
            <ul class="nav nav-pills card-header-pills">
                <li class="nav-item">
                    <a class="nav-link active" href="{{route('foods.index')}}">Published</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('foods.trash')}}">Trash</a>
                </li>
            </ul>
        </div>
    </div>

    <hr class="my-3">

    <div class="row">
        <div class="col-md-12">
            @if(session('status'))
                <div class="row">
                    <div class="col-md-12">
                        <div class="alert alert-warning">
                            {{session('status')}}
                        </div>
                    </div>
                </div>
            @endif

            <div class="row">
                <div class="col-md-12 text-right">
                    <a href="{{route('foods.create')}}" class="btn btn-primary">Tambah Makanan</a>
                </div>
            </div>
            <br>
            
            <table class="table table-bordered table-stripped">
                <thead>
                <tr>
                    <th><b>Nama Makanan</b></th>
                    <th><b>Kategori</b></th>
                    <th><b>Harga</b></th>
                    <th><b>Status</b></th>
                    <th><b>Actions</b></th>
                </tr>
                </thead>
                <tbody>
                @foreach ($foods as $food)
                    <tr>
                        <td>{{$food->food_name}}</td>
                                                <td>{{$food->name}}</td>
                        <td>{{$food->price}}</td>
                        <td>
                            @if($food->status == "READY")
                                <span class="badge badge-success">
                                {{$food->status}}
                                </span>
                            @else
                                <span class="badge badge-danger">
                                {{$food->status}}
                                </span>
                            @endif
                        </td>
                        <td>
                            <a href="{{route('foods.edit', ['id' => $food->id])}}" class="btn btn-info btn-sm"> Edit </a>
                            <a href="{{route('foods.show', ['id' => $food->id])}}" class="btn btn-primary"> Show </a>
                            <form class="d-inline" action="{{route('foods.destroy', ['id' => $food->id])}}" method="POST"
                                  onsubmit="return confirm('Move food to trash?')">
                                @csrf
                                <input type="hidden" value="DELETE" name="_method">
                                <input type="submit" class="btn btn-danger btn-sm" value="Trash">
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
                <tfoot>
                <tr>
                    <td colSpan="10">
                        {{$foods->appends(Request::all())->links()}}
                    </td>
                </tr>
                </tfoot>
            </table>
        </div>
    </div>
@endsection
