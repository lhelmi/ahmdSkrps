@extends('front.layouts.app')
@section('content')
<div class="album py-5 bg-light">
    <div class="container">
        <div class="row">
            @php
                $count = count($data->images->images);
                $div = 12/(integer)$count;
            @endphp
            @foreach ($data->images->images as $product)
                <div class="col-md-{{$div}}">
                    <div class="card mb-{{$div}} box-shadow">
                        <img class="card-img-top" style="height: 225px; width: 100%; display: block;"
                        src="{{ URL::to('/').'/'.$data->images->path.'/'.$product }}" data-holder-rendered="true">
                        <div class="card-body">
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
<section class="jumbotron text-center" style="background-color: #fff">
    <div class="container">
        <table class="table table-bordered">
            <tbody>
                <tr>
                    <td>Nama</td>
                    <td>{{ $data->name }}</td>
                </tr>
                <tr>
                    <td>Kode</td>
                    <td>{{ $data->kode }}</td>
                </tr>
                <tr>
                    <td>Ukuran</td>
                    <td>{{ $data->size }}</td>
                </tr>
                <tr>
                    <td>Jenis</td>
                    <td>{{ $data->type }}</td>
                </tr>
                <tr>
                    <td>Bahan</td>
                    <td>{{ $data->material }}</td>
                </tr>
                <tr>
                    <td>Stok</td>
                    <td>{{ $data->stock }}</td>
                </tr>
                <tr>
                    <td>Harga</td>
                    <td>{{ $data->price }}</td>
                </tr>
                <tr>
                    <td>Deskripsi</td>
                    <td>{{ $data->description }}</td>
                </tr>
            </tbody>
        </table>
    </div>
</section>
@endsection
