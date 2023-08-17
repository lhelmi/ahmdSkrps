@extends('front.layouts.app')
@section('content')
<div class="album py-5 bg-light">
    <div class="container">
        <div class="row">
            @php
                $count = count($data->images->images);
                $div = 12/(integer)$count;
            @endphp
            @foreach ($data->images->images as $service)
                @if ($count == 1)
                <div class="col-md-4 offset-md-4">
                    <div class="card mb-auto box-shadow">
                @elseif ($count == 2)
                <div class="col-md-4 offset-md-1">
                    <div class="card mb-{{$div}} box-shadow">
                @else
                <div class="col-md-{{$div}}">
                    <div class="card mb-{{$div}} box-shadow">
                @endif
                        <img class="card-img-top" style="height: 225px; width: 100%; display: block;"
                        src="{{ URL::to('/').'/'.$data->images->path.'/'.$service }}" data-holder-rendered="true">
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
        <div class="table-responsive">
            <table class="table table-bordered lead text-justify">
                <tbody>
                    <tr>
                        <td>Nama</td>
                        <td>{{ $data->name }}</td>
                    </tr>
                    <tr>
                        <td>Ukuran</td>
                        <td>
                            @if ($data->length !== null)
                                <li >
                                    {{ 'Panjang : '.  $data->length }}
                                </li>
                            @endif

                            @if ($data->width !== null)
                                <li >
                                    {{ 'Lebar : '.  $data->width }}
                                </li>
                            @endif

                            @if ($data->height !== null)
                                <li >
                                    {{ 'Tinggi : '.  $data->height }}
                                </li>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td>Harga</td>
                        <td>{{ $data->price }}</td>
                    </tr>
                    <tr>
                        <td>Deskripsi</td>
                        <td><p >{{ $data->description }}</p></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</section>
@endsection
