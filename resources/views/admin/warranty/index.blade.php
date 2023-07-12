@extends('adminlte::page')

@section('title', 'Admin')

@section('content_header')
    {{-- <h1>Admin</h1> --}}
@stop

@section('content')
    <div class="card mt-5">
        <div class="card-header">
        <h1 class="card-title">Garansi</h1>
        </div>
        <div class="card-body">
            <div id="example2_wrapper" class="dataTables_wrapper dt-bootstrap4">
                <div class="row">
                    <div class="col-sm-12 col-md-12 mb-3">
                        @if (Auth::user()->role == "1")
                            <a href="{{ route('warranty.pdf') }}" class="btn btn-sm btn-danger float-right">PDF</a>
                        @endif
                    </div>
                </div>
                @if ($message = Session::get('success'))
                    <div class="alert alert-success mt-2">{{ $message }}</div>
                @endif
                @if ($message = Session::get('error'))
                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                @endif
                <div class="row">
                    <div class="col-sm-12">
                        <table id="example2" class="table table-bordered table-hover dataTable dtr-inline" aria-describedby="example2_info">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Produk</th>
                                    <th>Kontak</th>
                                    <th>Tanggal Pembelian</th>
                                    <th>Persyaratan Pembelian</th>
                                    <th>Bukti Pembelian</th>
                                    <th>Keterangan</th>
                                    @if (Auth::user()->role == "1")
                                        <th>Aksi</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $no = 1;
                                @endphp
                                @foreach ($warranties as $warranty)
                                    <tr>
                                        <td>{{ $no++ }}</td>
                                        <td>{{ $warranty->nama_user }}</td>
                                        <td>{{ $warranty->nama_product }}</td>
                                        <td>{{ $warranty->contact }}</td>
                                        <td>{{ $warranty->purchase_date }}</td>
                                        <td>
                                            <img src="{{ URL::to('/').'/'.$warranty->requirements }}" width="150px" height="154px" id="image">
                                        </td>
                                        <td>
                                            <img src="{{ URL::to('/').'/'.$warranty->receipt }}" width="150px" height="154px" id="image">
                                        </td>
                                        <td>
                                            @foreach ($type as $key => $val)
                                                @if ($key == $warranty->status)
                                                    {{ $val }}
                                                @endif
                                            @endforeach
                                        </td>
                                        @if (Auth::user()->role == "1")
                                            <td>
                                                <a class="btn btn-sm btn-primary" href="{{ route('warranty.edit', [$warranty->id]) }}">Edit</a>
                                            </td>
                                        @endif
                                    </tr
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script>


    $(function () {
        $('#example2').DataTable({
          "paging": true,
          "lengthChange": false,
          "searching": true,
          "ordering": true,
          "info": true,
          "autoWidth": false,
          "responsive": true,
        });
    });




    </script>
@stop
