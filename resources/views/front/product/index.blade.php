@extends('front.layouts.app')
@section('content')
<section class="jumbotron text-center" style="background-color: #fff">
    <div class="container">
        <div class="content-1">
            <h1 class="jumbotron-heading">Produk</h1>
        </div>
    </div>
</section>
<div class="album py-5 bg-light">
    <div class="container">
        <div class="row">
            @foreach ($products as $product)
            @php
                $product->images = json_decode($product->images);
            @endphp
                <div class="col-md-4">
                    <div class="card mb-4 box-shadow">
                        <img class="card-img-top" style="height: 225px; width: 100%; display: block;"
                        src="{{ URL::to('/').'/'.$product->images->path.'/'.$product->images->images[0] }}" data-holder-rendered="true">
                        <div class="card-body">
                            <h5 class="card-link"><a href="{{ route('front.product.show', $product->kode )}}"> {{ $product->name }}</a></h5>
                            <div class="d-flex justify-content-between align-items-center">
                                Rp. {{ number_format($product->price,2,',','.') }}
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        {!! $products->withQueryString()->links('pagination::bootstrap-4') !!}
    </div>
</div>
@endsection
