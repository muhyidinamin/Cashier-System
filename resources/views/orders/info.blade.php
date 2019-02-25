<?php
/**
 * Created by PhpStorm.
 * User: Muhyidin
 * Date: 01/25/2019
 */
?>
@extends('layouts.global')
@section('title') Order Page @endsection
@section('content')
    <div class="col-md-12">
        @if(session('status'))
            <div class="alert alert-success">
                {{session('status')}}
            </div>
        @endif
        <form route="null" id="frmsave" method="post">
            @csrf
            <div class="row">
                <div class="col-lg-6">
                    <div class="form-group">
                        <input type="text" name="id" placeholder="Kode pesanan" class="form-control">
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-group">
                        <input type="text" name="date" placeholder="Tgl transaksi" class="form-control">
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-group">
                        <input type="text" name="name" placeholder="Nama Pelanggan" class="form-control">
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-group">
                        <input type="text" name="no" placeholder="No. Meja" class="form-control">
                    </div>
                </div>
                <div class="col-lg-12 col-sm-12">
                    <div class="form-group">
                        <table class="table table-bordered">
                            <thead>
                                <th>No</th>
                                <th>Nama Menu Makanan</th>
                                <th>Harga(Rp)</th>
                                <th>jumlah</th>
                                <th>Subtotal(Rp)</th>
                                <th style="text-align: center;background: #eee"><a href="#" class="add"><i class="glyphicon glyphicon-plus"></i>+</a></th>
                            </thead>
                            <tbody>
                                <tr>
                                    <td></td>
                                    <td>
                                        <select class="form-control foodname" name="foodname" id="foodname">
                                            <option value="0" selected="true" disabled="true">Select Food</option>
                                            @foreach($foods as $food)
                                            <option value="{{$food->id}}">{{$food->food_name}}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td><input type="text" name="price[]" class="form-control price"></td>
                                    <td><input type="text" name="qty[]" class="form-control qty"></td>
                                    <td><input type="text" name="subtotal[]" class="form-control subtotal"></td>
                                    <td><a href="#" class="btn btn-danger btn-sm remove"><i class="glyphicon glyphicon-remove"></i></a></td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td style="border: none"></td>
                                    <td style="border: none"></td>
                                    <td style="border: none"><b>Total Belanjaan<b></td>
                                    <td><b></b></td>                          
                                    <td><b></b></td>
                                    <td></td>                                         
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>    
        </form>
    </div>
@endsection