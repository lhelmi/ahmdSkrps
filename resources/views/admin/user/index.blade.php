@extends('adminlte::page')

@section('title', 'Admin')

@section('content_header')
    {{-- <h1>Admin</h1> --}}
@stop

@section('content')
    <div class="card mt-5">
        <div class="card-header">
        <h1 class="card-title">User</h1>
        </div>
        <div class="card-body">
            <div id="example2_wrapper" class="dataTables_wrapper dt-bootstrap4">
                <div class="row">
                    <div class="col-sm-12 col-md-6">
                        <a class="btn btn-md btn-success" href="{{ route('user.create') }}">Tambah</a>
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
                                    <th>Nama</th>
                                    <th>Tempat Tanggal Lahir</th>
                                    <th>Alamat</th>
                                    <th>Email</th>
                                    <th>Username</th>
                                    <th>Password</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $no = 1;
                                @endphp
                                @foreach ($users as $user)
                                    <tr>
                                        <td>{{ $no++ }}</td>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->birth_place.', '.$user->birth_date }}</td>
                                        <td>{{ $user->address }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $user->username }}</td>
                                        <td>{{ $user->password }}</td>
                                        <td>
                                            <a class="btn btn-sm btn-primary" href="{{ route('user.edit', [$user->id]) }}">Edit</a> |
                                            <a class="btn btn-sm btn-danger" onclick="return confirm('Apakah anda yakin?')" href="{{ route('user.destroy', [$user->id]) }}">Hapus</a>
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
