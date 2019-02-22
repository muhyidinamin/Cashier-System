<?php
/**
 * Created by PhpStorm.
 * User: Muhyidin
 * Date: 01/25/2019
 */
?>
@extends('layouts.global')
@section('title') Drink list @endsection
@section('content')
    <div class="row">
        <div class="col-md-6">
            <form action="{{route('drinks.index')}}">

                <div class="input-group">
                    <input
                        type="text"
                        class="form-control"
                        placeholder="Filter by drink name"
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
                    <a class="nav-link active" href="{{route('drinks.index')}}">Published</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('drinks.trash')}}">Trash</a>
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
                    <a href="{{route('drinks.create')}}" class="btn btn-primary">Add
                        Drink</a>
                </div>
            </div>
            <br>
            
            <table class="table table-bordered table-stripped">
                <thead>
                <tr>
                    <th><b>Drink Name</b></th>
                    <th><b>Price</b></th>
                    <th><b>Status</b></th>
                    <th><b>Actions</b></th>
                </tr>
                </thead>
                <tbody>
                @foreach ($drinks as $drink)
                    <tr>
                        <td>{{$drink->drink_name}}</td>
                        <td>{{$drink->price}}</td>
                        <td>
                            @if($drink->status == "READY")
                                <span class="badge badge-success">
                                {{$drink->status}}
                                </span>
                            @else
                                <span class="badge badge-danger">
                                {{$drink->status}}
                                </span>
                            @endif 
                        </td>
                        <td>
                            <a href="{{route('drinks.edit', ['id' => $drink->id])}}" class="btn btn-info btn-sm"> Edit </a>
                            <a href="{{route('drinks.show', ['id' => $drink->id])}}" class="btn btn-primary"> Show </a>
                            <form class="d-inline" action="{{route('drinks.destroy', ['id' => $drink->id])}}" method="POST"
                                  onsubmit="return confirm('Move drink to trash?')">
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
                        {{$drinks->appends(Request::all())->links()}}
                    </td>
                </tr>
                </tfoot>
            </table>
        </div>
    </div>
@endsection
