@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Dashboard</h1>
@stop

@section('content')
<div class="row">
    <div class="col-lg-3 col-6">
        <div class="small-box bg-success">
            <div class="inner">
                <h3>{{ $products }}</h3>
                <p>Produk</p>
            </div>
            <div class="icon">
                <i class="fa fa-shopping-bag"></i>
            </div>
            {{-- <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a> --}}
        </div>
    </div>

    <div class="col-lg-3 col-6">
        <div class="small-box bg-warning">
            <div class="inner">
                <h3>{{ $services }}</h3>
                <p>Jasa</p>
            </div>
            <div class="icon">
                <i class="fa fa-briefcase"></i>
            </div>
            {{-- <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a> --}}
        </div>
    </div>
    @if (Auth::user()->role == "0")
    <div class="col-lg-3 col-6">
        <div class="small-box bg-info">
            <div class="inner">
                <h3>{{ $users }}</h3>
                <p>User</p>
            </div>
            <div class="icon">
                <i class="fa fa-user"></i>
            </div>
            {{-- <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a> --}}
        </div>
    </div>

    <div class="col-lg-3 col-6">
        <div class="small-box bg-danger">
            <div class="inner">
                <h3>{{ $administrasi }}</h3>
                <p>Administrasi</p>
            </div>
            <div class="icon">
                <i class="fa fa-user"></i>
            </div>
            {{-- <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a> --}}
        </div>
    </div>
    @endif

    @if (Auth::user()->role == "1")
        {{-- <div class="col-lg-3 col-6">
            <div class="small-box bg-primary">
                <div class="inner">
                    <h3>{{ $warranty }}</h3>
                    <p>Garansi</p>
                </div>
                <div class="icon">
                    <i class="fa fa-file"></i>
                </div>

            </div>
        </div> --}}

        <div class="col-lg-3 col-6">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{ $complaint }}</h3>
                    <p>Keluhan</p>
                </div>
                <div class="icon">
                    <i class="fa fa-tasks"></i>
                </div>
                {{-- <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a> --}}
            </div>
        </div>
    @endif
</div>

@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script> console.log('Hi!'); </script>
@stop

