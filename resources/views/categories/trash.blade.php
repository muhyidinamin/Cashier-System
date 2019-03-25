<?php
/**
 * Created by PhpStorm.
 * User: Muhyidin
 * Date: 01/25/2019
 * Time: 06:11 PM
 */
?>

@extends('layouts.global')
@section('title') Trashed Kategori @endsection
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
                    <a class="nav-link" href="
{{route('categories.index')}}">Published</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="
{{route('categories.trash')}}">Trash</a>
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
                    <th><b>Nama Kategori</b></th>
                    <th><b>Actions</b></th>
                </tr>
                </thead>
                <tbody>
                @foreach($categories as $category)
                    <tr>
                        <td>{{$category->name}}</td>
                        <td>
                            <a href="{{route('categories.restore', ['id' => $category->id])}}" class="btn btn-success">Restore</a>
                            <form class="d-inline"
                                action="{{route('categories.delete-permanent', ['id' => $category->id])}}"
                                method="POST"
                                onsubmit="return confirm('Delete this category permanently?')">
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
                        {{$categories->appends(Request::all())->links()}}
                    </td>
                </tr>
                </tfoot>
            </table>
        </div>
    </div>
@endsection
