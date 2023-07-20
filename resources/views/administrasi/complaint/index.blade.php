@extends('adminlte::page')

@section('title', 'Admin')

@section('content_header')
    {{-- <h1>Admin</h1> --}}
@stop

@section('content')
    <div class="card mt-5">
        <div class="card-header">
        <h1 class="card-title">Keluhan</h1>
        </div>
        <div class="card-body">
            <div id="example2_wrapper" class="dataTables_wrapper dt-bootstrap4">
                <div class="row">
                    <div class="col-sm-12 col-md-12 mb-3">
                        @if (Auth::user()->role == "1")
                            <a href="{{ route('complaint.pdf') }}" class="btn btn-sm btn-danger float-right">PDF</a>
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
                                    <th>Keluhan</th>
                                    <th>Kritik</th>
                                    <th>Saran</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $no = 1;
                                @endphp
                                @foreach ($complaints as $complaint)
                                    <tr>
                                        <td>{{ $no++ }}</td>
                                        <td>{{ $complaint->users_name }}</td>
                                        <td>{{ $complaint->complaint }}</td>
                                        <td>{{ $complaint->criticism }}</td>
                                        <td>{{ $complaint->suggestions }}</td>
                                        <td>
                                            <a class="btn btn-sm btn-danger" onclick="return confirm('Apakah anda yakin?')" href="{{ route('complaint.destroy', [$complaint->id]) }}">Hapus</a>
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
