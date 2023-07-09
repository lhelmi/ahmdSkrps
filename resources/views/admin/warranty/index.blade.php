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
                    <div class="col-sm-12 col-md-6">

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
                                    <th>ID</th>
                                    <th>Nama</th>
                                    <th>Produk</th>
                                    <th>Kontak</th>
                                    <th>Tanggal Pembelian</th>
                                    <th>Persyaratan Pembelian</th>
                                    <th>Bukti Pembelian</th>
                                    <th>Keterangan</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $no = 1;
                                @endphp
                                @foreach ($warranties as $warranty)
                                    <tr>
                                        <td>{{ $no++ }}</td>
                                        <td>{{ $warranty->id }}</td>
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
                                        <td>{{ $warranty->status }}</td>
                                        <td>
                                            <a class="btn btn-sm btn-primary" href="{{ route('warranty.edit', [$warranty->id]) }}">Edit</a>
                                        </td>
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
