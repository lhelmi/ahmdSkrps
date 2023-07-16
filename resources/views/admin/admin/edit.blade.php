@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    {{-- <h1>Tambah Admin</h1> --}}
@stop

@section('content')
    <div class="card">
        <div class="card-header">
        <h3 class="card-title">Ubah Administrasi</h3>
        </div>
        <div class="card-body">
            @if ($message = Session::get('error'))
                <div class="alert alert-danger">{{ $message }}</div>
            @endif
            <form action="{{ route('admin.update', $data->id) }}" method="POST">
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label for="name">Nama</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name" placeholder="Masukan Nama Lengkap"
                        value="{{ old('name') == null ? $data->name : old('name') }}">

                        @error('name')
                            <div class="alert alert-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" class="form-control @error('username') is-invalid @enderror" name="username" id="username" placeholder="Masukan Username"
                        value="{{ old('username') == null ? $data->username : old('username') }}">

                        @error('username')
                            <div class="alert alert-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" id="email" placeholder="Masukan Email"
                        value="{{ old('email') == null ? $data->email : old('email') }}">

                        @error('email')
                            <div class="alert alert-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="row">
                        <div class="col-sm-12 col-md-6">
                            <div class="form-group">
                                <label for="exampleInputPassword1">Password</label>
                                <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" id="password" placeholder="Masukan Password">

                                @error('password')
                                    <div class="alert alert-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-6">
                            <div class="form-group">
                                <label for="exampleInputPassword1">Konfirmasi Password</label>
                                <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" name="password_confirmation" id="password_confirmation" placeholder="Masukan Kembali Password">

                                @error('password_confirmation')
                                    <div class="alert alert-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                </div>

                <div class="card-footer">
                    <button type="submit" class="btn btn-success">Ubah</button>
                    <a type="button" href="{{ route('admin.index') }}" class="btn btn-default">Batal</a>
                </div>
            </form>
        </div>
    </div>

@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script>
    </script>
@stop
