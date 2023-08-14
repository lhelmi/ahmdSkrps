@extends('adminlte::page')

@section('title', 'Admin')

@section('content_header')
    {{-- <h1>Admin</h1> --}}
@stop

@section('content')
    <div class="card mt-5">
        <div class="card-header">
        <h1 class="card-title">Product</h1>
        </div>
        <div class="card-body">
            <div id="example2_wrapper" class="dataTables_wrapper dt-bootstrap4">
                <div class="row">
                    <div class="col-sm-12 col-md-6">
                        @if (Auth::user()->role == '0')
                            <a class="btn btn-md btn-success" href="{{ route('product.create') }}">Tambah</a>
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
                    <div class="table-responsive">
                        <table id="example2" class="table table-bordered table-hover dataTable dtr-inline" aria-describedby="example2_info">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Kode</th>
                                    <th>Nama</th>
                                    <th>Ukuran</th>
                                    {{-- <th>Jenis</th> --}}
                                    <th>Stok</th>
                                    <th>Harga</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $no = 1;
                                @endphp
                                @foreach ($products as $product)
                                    <tr>
                                        <td>{{ $no++ }}</td>
                                        <td>{{ $product->kode }}</td>
                                        <td>{{ $product->name }}</td>
                                        <td>{{ $product->size}}</td>
                                        {{-- <td>{{ $product->type }}</td> --}}
                                        <td>{{ $product->stock }}</td>
                                        <td>{{ $product->price }}</td>
                                        <td>
                                            {{ $product->verify_description. ' : ' }}
                                            @if ($product->is_verify == '1')
                                                <span class="badge badge-success">Sudah Disetuji</span>
                                            @else
                                                <span class="badge badge-secondary">Belum Disetuji</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if (Auth::user()->role == '1')
                                                <a class="btn btn-sm btn-secondary" href="{{ route('product.detail', [$product->kode]) }}">Detail</a> |
                                                <a onclick="return confirm('Apakah anda yakin?')" class="btn btn-sm btn-{{ $product->is_verify == '0' ? 'success' : 'danger' }}" href="{{ route('product.verify', [$product->kode]) }}">
                                                    {{ $product->is_verify == '0' ? 'Setujui' : 'Batal Disetujui' }}
                                                </a>
                                            @else
                                                <a class="btn btn-sm btn-primary" href="{{ route('product.edit', [$product->kode]) }}">Edit</a> |
                                                <a class="btn btn-sm btn-danger" onclick="return confirm('Apakah anda yakin?')" href="{{ route('product.destroy', [$product->kode]) }}">Hapus</a>
                                            @endif

                                        </td>
                                    </tr>
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
