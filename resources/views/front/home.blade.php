@extends('front.layouts.app')
@section('content')

@if ($message = Session::get('success'))
    <div class="alert alert-success mt-2">{{ $message }}</div>
@endif
@if ($message = Session::get('error'))
    <div class="alert alert-danger mt-2">{{ $message }}</div>
@endif

<section class="jumbotron text-center">
    <div class="container">
        <div class="content-1">
            <img src="{{ asset('front/images/logo.png') }}" alt="logo" height="534px" width="538px">
            <h1 class="jumbotron-heading">Siapa Kita</h1>
            <p class="lead text-muted">Supri Group merupakan badan usaha milik perseorangan yang berasas kekeluargaan. Usaha kami memiliki komitmen bertanggung jawab, pekerja keras, melayani dengan sepenuh hati.</p>
        </div>
        {{-- <p>
        <a href="#" class="btn btn-primary my-2">Main call to action</a>
        <a href="#" class="btn btn-secondary my-2">Secondary action</a>
        </p> --}}
    </div>
</section>
<section class="jumbotron text-center" style="background-color: #fff">
    <div class="container">
        <div class="content-1">
            <h1 class="jumbotron-heading">Visi dan Misi</h1>
            <h4>The Confort of Your Home is Our Priority</h5>
            <p class="lead text-muted">Kenyamanan Rumah Anda Adalah Proritas Kami</p>
        </div>
    </div>
</section>
<div class="album py-5 bg-light">
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <div class="card mb-4 box-shadow">
                    <img src="{{ asset('front/images/1.jpg') }}" alt="logo" style="height: 300px; width: 340px">
                    <div class="card-body">
                        <p class="card-text">Kendaraan perusahaan untuk mengantarkan produk ke tempat konsumen.</p>

                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card mb-4 box-shadow">
                    <img src="{{ asset('front/images/2.jpg') }}" alt="logo" style="height: 300px; width: 340px">
                    <div class="card-body">
                        <p class="card-text">Tempat penyimpanan beberapa produk yang disediakan di perusahaan.</p>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card mb-4 box-shadow">
                    <img src="{{ asset('front/images/3.jpg') }}" alt="logo" style="height: 300px; width: 340px">
                    <div class="card-body">
                        <p class="card-text">Plang perusahaan CV. Supri group terdapat alamat dan no telepon.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
