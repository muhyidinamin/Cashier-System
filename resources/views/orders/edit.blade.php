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
        <form
            action="{{route('orders.update', ['id' => $order->id])}}"
            enctype="multipart/form-data"
            method="POST"
            class="bg-white shadow-sm p-3">
            @csrf
            <input
                type="hidden"
                value="PUT"
                name="_method">

            <div class="row">
                <div class="col-lg-6">
                    <div class="form-group">
                        <input type="text" name="id" class="form-control" value="{{$order->id}}" readonly>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-group">
                        <input type="date" name="date" class="form-control" value="{{date("Y-m-j")}}" disabled="">
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-group">
                        <input type="text" name="name" placeholder="Nama Pelanggan" class="form-control" value="{{$order->name_cus}}">
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-group">
                        <input type="text" name="no" placeholder="No. Meja" class="form-control" value="{{$order->no_meja}}">
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-group">
                        <input value="OPEN" name="status" type="radio" class="form-control" id="open" {{$order->status == 'OPEN' ? 'checked' : ''}}>
                        <label for="open">Open</label>
                        <input value="CLOSE" name="status" type="radio" class="form-control" id="close" {{$order->status == 'CLOSE' ? 'checked' : ''}}>
                        <label for="close">Close</label>
                    </div>
                </div>
                <div class="col-lg-2 col-sm-2">
                    <div class="form-group">
                        <input type="submit" name="simpan" value="save" class="btn btn-primary">
                    </div>
                </div>
 <!--                <div class="col-lg-12 col-sm-12">
                    <div class="form-group">
                        <table class="table table-bordered">
                            <thead>
                                <th>Nama Menu Makanan</th>
                                <th>Harga(Rp)</th>
                                <th>jumlah</th>
                                <th>Subtotal(Rp)</th>
                                <th style="text-align: center;background: #eee"><a href="#" class="addRow"><i class="glyphicon glyphicon-plus"></i>+</a></th>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <select class="form-control foodname" name="foodname[]">
                                            <option selected="true" disabled="true">Select Food</option>
                                            @foreach($foods as $food)
                                            <option value="{{$food->id}}">{{$food->food_name}}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td><input type="text" name="price[]" class="form-control price" disabled=""></td>
                                    <td><input type="text" name="qty[]" class="form-control qty"></td>
                                    <td><input type="text" name="subtotal[]" class="form-control subtotal" readonly=""></td>
                                    <td><a href="#" class="btn btn-danger btn-sm remove"><i class="glyphicon glyphicon-remove">x</i></a></td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td style="border: none"></td>
                                    <td style="border: none"><b>Total Belanjaan<b></td>
                                    <td><b class="jumlah"></b></td>                          
                                    <td><b class="total"></b></td>
                                    <td></td>                                        
                                </tr>
                            </tfoot>
                        </table>
                    </div> 
                </div> --> 
            </div>    
        </form>
    </div>
@endsection
@section('footer-scripts')
<script type="text/javascript">
    $('tbody').delegate('.foodname', 'change', function(){
        var tr=$(this).parent().parent();
        var id=tr.find('.foodname').val();
        var dataId =  {'id': id};
        $.ajax({
            type : 'GET', 
            url : '{{URL::route('findPrice')}}',
            dataType : 'json',
            data : dataId,
            success:function(data){
                tr.find('.price').val(data.price);
            } 
        });

        tr.find('.qty').focus();
    });

    $('tbody').delegate('.price, .qty', 'keyup', function(){
        var tr = $(this).parent().parent();
        var qty = tr.find('.qty').val();
        var price = tr.find('.price').val();
        var subtotal = qty*price;
        tr.find('.subtotal').val(subtotal);
        jumlah();
        total();
    });


    $('.addRow').on('click', function(){
        addRow();
    });

    /*findRowNumOnly('.qty');*/

    function total(){
        var total=0;
        $('.subtotal').each(function(i,e){
            var subtotal = $(this).val()-0;
            total += subtotal;
        });
        $('.total').html("Rp. "+ total.formatMoney(2, ".", ","));
    }

    function jumlah(){
        var jumlah=0;
        $('.qty').each(function(i,e){
            var qty = $(this).val()-0;
            jumlah += qty;
        });
        $('.jumlah').html(jumlah);
    }

    Number.prototype.formatMoney = function(decPlaces, thouSeparator, decSeparator){
        var n = this, 
            decPlaces = isNaN(decPlaces = Math.abs(decPlaces))? 2 : decPlaces, 
            decSeparator = decSeparator == undefined ? "." : decSeparator,
            thouSeparator = thouSeparator == undefined ? "," : thouSeparator, 
            sign = n < 0 ? "-" : "", 
            i = parseInt(n = Math.abs(+n || 0).toFixed(decPlaces))+"", 
            j = (j = i.length)>3 ? j %3 : 0;
        return sign + (j? i.substr(0, j)+thouSeparator:"")
        + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + thouSeparator)
        + (decPlaces ? decSeparator + Math.abs(n-i).toFixed(decPlaces).slice(2):"");
    };

    function addRow(){
        var tr='<tr><td>'+
                    '<select class="form-control foodname" name="foodname[]">'+
                    '<option value="0" selected="true" disabled="true">Select Food</option>'+
                    '@foreach($foods as $food)'+
                    '<option value="{{$food->id}}">{{$food->food_name}}</option>'+
                    '@endforeach'+
                    '</select>'+
                    '</td>'+
                    '<td><input type="text" name="price[]" class="form-control price" disabled></td>'+
                    '<td><input type="text" name="qty[]" class="form-control qty"></td>'+
                    '<td><input type="text" name="subtotal[]" class="form-control subtotal" readonly></td>'+
                    '<td><a href="#" class="btn btn-danger btn-sm remove"><i class="glyphicon glyphicon-remove">x</i></a></td></tr>';
        $('tbody').append(tr);
    };

    $('body').delegate('.remove', 'click', function(){
        var l=$('tbody tr').length;
        if(l==1){
            alert("Anda tidak dapat menghapus baris terakhir");
        }else{
            $(this).parent().parent().remove();
            jumlah();
            total();
        }
    });

    /*function findRowNum(input) {
        $('tbody').delegate(input, 'keydown', function(){
            var tr = $(this).parent().parent();
            number(tr.find(input));
        });
    }

    function findRowNumOnly(argument) {
        $('tbody').delegate(input, 'keydown', function(){
            var tr = $(this).parent().parent();
            numberOnly(tr.find(input));
        });
    }

    function number(input) {
        $(input).keypress(function(evt){
            var theEvent = evt || window.event;
            var key = theEvent.keyCode || theEvent.which;
            key = String.fromCharCode(key);
            var regex = /[-\d\.]/;
            var objRegex = /^-?\d*[\.]?\d*$/;
            var val = $(evt.target).val();
            if(!regex.test(key) || !objRegex.test(val+key) || !theEvent.keyCode == 46 || !theEvent.keyCode == 8){
                theEvent.returnValue = false;
                if(theEvent.preventDefault) theEvent.preventDefault();
            };  
        });
    };

    function numberOnly(input){
        $(input).keypress(function(evt){
            var e = event || evt;
            var charCode = e.which || e.keyCode;
            if(charCode > 31 && (charCode < 48 || charCode > 57))
            return false;
            return true;
        });
    }*/
</script>
@endsection
