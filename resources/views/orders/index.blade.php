@extends("layouts.global");
@section("title") Orders list @endsection
@section("content")
    <div class="row">
        <div class="col-md-6">
            <form action="{{route('orders.view')}}">
                <div class="row">
                    <div class="col-md-6">
                        <input
                            value="{{Request::get('keyword')}}"
                            name="keyword"
                            class="form-control"
                            type="text"
                            placeholder="Masukan kode untuk filter..."/>
                    </div>
                    <div class="col-md-6">
                        <input {{Request::get('status') == 'OPEN' ? 'checked' : ''}}
                               value="OPEN"
                               name="status"
                               type="radio"
                               class="form-control"
                               id="open">
                        <label for="open">Open</label>
                        <input {{Request::get('status') == 'CLOSE' ? 'checked' : ''}}
                               value="CLOSE"
                               name="status"
                               type="radio"
                               class="form-control"
                               id="close">
                        <label for="close">Close</label>
                        <input
                            type="submit"
                            value="Filter"
                            class="btn btn-primary">
                    </div>
                </div>
            </form>
        </div>
    </div>
    <br>
    @if(session('status'))
        <div class="alert alert-success">
            {{session('status')}}
        </div>
    @endif
    <div class="row">
        <div class="col-md-12 text-right">
            <a
                href="{{route('orders')}}"
                class="btn btn-primary">Add Order</a>
        </div>
    </div>
    <br>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th><b>Kode Pesanan</b></th>
                <th><b>Nama Pelanggan</b></th>
                <th><b>Jumlah</b></th>
                <th><b>Total</b></th>
                <th><b>Status</b></th>
                <th><b>Action</b></th>
            </tr>
        </thead>
        <tbody>
        @foreach($orders as $order)
            <tr>
                <td>{{$order->id}}</td>
                <td>{{$order->name_cus}}</td>
                <td>{{$order->qty}}</td>
                <td>{{$order->total}}</td>
                <td>
                    @if($order->status == "OPEN")
                        <span class="badge badge-success">
                        {{$order->status}}
                        </span>
                    @else
                        <span class="badge badge-danger">
                        {{$order->status}}
                        </span>
                    @endif
                </td>
                <td>
                    <a class="btn btn-info text-white btn-sm" href="{{route('orders.edit',['id'=>$order->id])}}">Edit</a>
                    @if(session('status'))
                        <div class="alert alert-success">
                            {{session('status')}}
                        </div>
                    @endif
                    <form
                        onsubmit="return confirm('Delete this user permanently?')"
                        class="d-inline"
                        action="#"
                        method="POST">
                        @csrf
                        <input
                            type="hidden"
                            name="_method"
                            value="DELETE">
                        <input
                            type="submit"
                            value="Delete"
                            class="btn btn-danger btn-sm">
                    </form>
                    <a
                        href="{{route('orders.show', ['id' => $order->id])}}"
                        class="btn btn-primary btn-sm">Detail</a>
                </td>
            </tr>
        @endforeach
        </tbody>
        <tfoot>
        <tr>
            <td colspan=10>
                {{$orders->appends(Request::all())->links()}}
            </td>
        </tr>
        </tfoot>
    </table>

@endsection
