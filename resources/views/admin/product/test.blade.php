@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    {{-- <h1>Tambah Admin</h1> --}}
@stop

@section('content')
    <br>
    <div class="card">
        <div class="card-header">
        <h3 class="card-title">Detail Product</h3>
        </div>
        <div class="card-body">
            @if ($message = Session::get('error'))
                <div class="alert alert-danger">{{ $message }}</div>
            @endif
            @if ($message = Session::get('success'))
                    <div class="alert alert-success mt-2">{{ $message }}</div>
            @endif
                <div class="card-body">
                    <div class="form-group">
                        <textarea name="" id="" cols="30" rows="10" class="form-control">
                            Dibatalkan karena blablablabla
                        </textarea>
                    </div>

                </div>

                <div class="card-footer">
                    <a type="button" href="{{ route('product.index') }}" class="btn btn-default">Kembali</a>
                </div>

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
