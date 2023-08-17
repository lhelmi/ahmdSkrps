@extends('adminlte::page')

@section('title', 'Admin')

@section('content_header')
    {{-- <h1>Admin</h1> --}}
@stop

@section('content')
    <div class="card mt-5">
        <div class="card-header">
        <h1 class="card-title">Jasa</h1>
        </div>
        <div class="card-body">
            <div id="example2_wrapper" class="dataTables_wrapper dt-bootstrap4">
                <div class="row">
                    <div class="col-sm-12 col-md-6">
                        <a class="btn btn-md btn-success" href="{{ route('service.create') }}">Tambah</a>
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
                                    <th>Harga</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $no = 1;
                                @endphp
                                @foreach ($services as $service)
                                    <tr>
                                        <td>{{ $no++ }}</td>
                                        <td>{{ $service->kode }}</td>
                                        <td>{{ $service->name }}</td>
                                        <td>{{ $service->size }}</td>
                                        {{-- <td>{{ $service->type }}</td> --}}
                                        <td>{{ $service->price }}</td>
                                        <td>
                                            {{ $service->verify_description. ' : ' }}
                                            @if ($service->is_verify == '1')
                                                <span class="badge badge-success">Sudah Disetuji</span>
                                            @elseif ($service->is_verify == '2')
                                                <span class="badge badge-danger">Ditolak</span>
                                            @elseif ($service->is_verify == '3')
                                                <span class="badge badge-primary">Sudah Diperbaiki</span>
                                            @else
                                                <span class="badge badge-secondary">Belum Disetuji</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if (Auth::user()->role == '1')
                                                <a class="btn btn-sm btn-secondary" href="{{ route('service.detail', [$service->kode]) }}">Detail</a>
                                                {{-- <a onclick="return confirm('Apakah anda yakin?')" class="btn btn-sm btn-{{ $service->is_verify == '0' ? 'success' : 'danger' }}" href="{{ route('service.verify', [$service->kode]) }}">
                                                    {{ $service->is_verify == '0' ? 'Setujui' : 'Batal Disetujui' }}
                                                </a> --}}
                                            @else
                                                @if ($service->is_verify == "2")
                                                    <a class="btn btn-sm btn-secondary" href="{{ route('service.detail', [$service->kode]) }}">Detail</a> |
                                                @endif
                                                <a class="btn btn-sm btn-primary" href="{{ route('service.edit', [$service->kode]) }}">Edit</a> |
                                                <a class="btn btn-sm btn-danger" onclick="return confirm('Apakah anda yakin?')" href="{{ route('service.destroy', [$service->kode]) }}">Hapus</a>
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
