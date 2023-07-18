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
            @for ($i = 0; $i < 3; $i++)
                <div class="col-md-4">
                    <div class="card mb-4 box-shadow">
                        <img class="card-img-top" data-src="holder.js/100px225?theme=thumb&amp;bg=55595c&amp;fg=eceeef&amp;text=Thumbnail" alt="Thumbnail [100%x225]" style="height: 225px; width: 100%; display: block;" src="data:image/svg+xml;charset=UTF-8,%3Csvg%20width%3D%22348%22%20height%3D%22225%22%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20viewBox%3D%220%200%20348%20225%22%20preserveAspectRatio%3D%22none%22%3E%3Cdefs%3E%3Cstyle%20type%3D%22text%2Fcss%22%3E%23holder_189004bdc08%20text%20%7B%20fill%3A%23eceeef%3Bfont-weight%3Abold%3Bfont-family%3AArial%2C%20Helvetica%2C%20Open%20Sans%2C%20sans-serif%2C%20monospace%3Bfont-size%3A17pt%20%7D%20%3C%2Fstyle%3E%3C%2Fdefs%3E%3Cg%20id%3D%22holder_189004bdc08%22%3E%3Crect%20width%3D%22348%22%20height%3D%22225%22%20fill%3D%22%2355595c%22%3E%3C%2Frect%3E%3Cg%3E%3Ctext%20x%3D%22116.71875%22%20y%3D%22120.3%22%3EThumbnail%3C%2Ftext%3E%3C%2Fg%3E%3C%2Fg%3E%3C%2Fsvg%3E" data-holder-rendered="true">
                        <div class="card-body">
                            <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
                            {{-- <div class="d-flex justify-content-between align-items-center">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-sm btn-outline-secondary">View</button>
                                    <button type="button" class="btn btn-sm btn-outline-secondary">Edit</button>
                                </div>
                                <small class="text-muted">9 mins</small>
                            </div> --}}
                        </div>
                    </div>
                </div>
            @endfor
        </div>
    </div>
</div>

@endsection
