<?php
/**
 * Created by PhpStorm.
 * User: Muhyidin
 * Date: 01/25/2019
 */
?>
@extends('layouts.global')
@section('title') List Kategori @endsection
@section('content')
    <div class="row">
        <div class="col-md-6">
            <form action="{{route('categories.index')}}">

                <div class="input-group">
                    <input
                        type="text"
                        class="form-control"
                        placeholder="Filter Nama Kategori"
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
                    <a class="nav-link active" href="{{route('categories.index')}}">Published</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('categories.trash')}}">Trash</a>
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
                    <a href="{{route('categories.create')}}" class="btn btn-primary">Tambah Kategori</a>
                </div>
            </div>
            <br>
            
            <table class="table table-bordered table-stripped">
                <thead>
                <tr>
                    <th><b>Nama Kategori</b></th>
                    <th><b>Actions</b></th>
                </tr>
                </thead>
                <tbody>
                @foreach ($categories as $category)
                    <tr>
                        <td>{{$category->name}}</td>
                        <td>
                            <a href="{{route('categories.edit', ['id' => $category->id])}}" class="btn btn-info btn-sm"> Edit </a>
                            <a href="{{route('categories.show', ['id' => $category->id])}}" class="btn btn-primary"> Show </a>
                            <form class="d-inline" action="{{route('categories.destroy', ['id' => $category->id])}}" method="POST"
                                  onsubmit="return confirm('Move category to trash?')">
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
                        {{$categories->appends(Request::all())->links()}}
                    </td>
                </tr>
                </tfoot>
            </table>
        </div>
    </div>
@endsection
