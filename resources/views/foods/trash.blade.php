<?php
/**
 * Created by PhpStorm.
 * User: Muhyidin
 * Date: 01/25/2019
 * Time: 06:11 PM
 */
?>

@extends('layouts.global')
@section('title') Trashed Makanan @endsection
@section('content')
    <div class="row">
        <div class="col-md-6">
            <form action="{{route('foods.index')}}">
                <div class="input-group">
                    <input
                        type="text"
                        class="form-control"
                        placeholder="Filter Nama Makanan"
                        value="{{Request::get('name')}}"
                        name="name">
                    <div class="input-group-append">
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
                    <a class="nav-link" href="
{{route('foods.index')}}">Published</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="
{{route('foods.trash')}}">Trash</a>
                </li>
            </ul>
        </div>
    </div>
    <hr class="my-3">
    <div class="row">
        <div class="col-md-12">
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th><b>Nama Makanan</b></th>
                    <th><b>Harga</b></th>
                    <th><b>Kategori</b></th>
                    <th><b>Status</b></th>
                    <th><b>Actions</b></th>
                </tr>
                </thead>
                <tbody>
                @foreach($foods as $food)
                    <tr>
                    <td>{{$food->food_name}}</td>
                        <td>{{$food->price}}</td>
                        <td>{{$food->name}}</td>
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
                            <a href="{{route('foods.restore', ['id' => $food->id])}}" class="btn btn-success">Restore</a>
                            <form class="d-inline"
                                action="{{route('foods.delete-permanent', ['id' => $food->id])}}"
                                method="POST"
                                onsubmit="return confirm('Delete this Food permanently?')">
                                @csrf
                                <input type="hidden" name="_method" value="DELETE"/>
                                <input type="submit" class="btn btn-danger btn-sm" value="Delete"/>
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
