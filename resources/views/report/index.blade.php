@extends("layouts.global");
@section("title") Users list @endsection
@section("content")
    <div class="row">
        <div class="col-md-6">
            <b>Nama Pelayan : {{$identity->name}}</b>
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
                href="{{route('report.print')}}"
                class="btn btn-primary">Cetak Laporan</a>
        </div>
    </div>
    <br>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th><b>Kode Pesanan</b></th>
                <th><b>Nama Pelanggan</b></th>
                <th><b>No Meja</b></th>
                <th><b>Qty</b></th>
                <th><b>Total</b></th>
            </tr>
        </thead>
        <tbody>
        @foreach($results as $data)
            <tr>
                <td>{{$data->id}}</td>
                <td>{{$data->name_cus}}</td>
                <td>{{$data->no_meja}}</td>
                <td>{{$data->qty}}</td>
                <td>{{$data->total}}</td>
            </tr>
        @endforeach
        </tbody>
        <tfoot>
        <tr>
            <td colspan=10>
                {{$results->appends(Request::all())->links()}}
            </td>
        </tr>
        </tfoot>
    </table>

@endsection
