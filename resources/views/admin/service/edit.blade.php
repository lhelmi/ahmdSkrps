@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    {{-- <h1>Tambah Admin</h1> --}}
@stop

@section('content')
    <div class="card">
        <div class="card-header">
        <h3 class="card-title">Ubah Service</h3>
        </div>
        <div class="card-body">
            @if ($message = Session::get('error'))
                <div class="alert alert-danger">{{ $message }}</div>
            @endif
            <form method="POST" action="{{ route('service.update', $data->kode) }}" enctype="multipart/form-data">
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
                        <label>Ukuran</label>
                        <input type="text" class="form-control @error('size') is-invalid @enderror" name="size" id="size" placeholder="Masukan size"
                        value="{{ old('size') == null ? $data->size : old('size') }}">

                        @error('size')
                            <div class="alert alert-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>Jenis</label>
                        <select name="type" class="form-control @error('type') is-invalid @enderror" name="type" >
                            <option value="">Pilih</option>
                            @foreach ($typeList as $key => $list)
                                <option value="{{ $key }}" @if(old('type') == $key)
                                    {{ 'selected' }}
                                @elseif ($key == $data->type)
                                    {{ 'selected' }}
                                @endif >{{ $key }}</option>
                            @endforeach
                        </select>

                        @error('type')
                            <div class="alert alert-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="username">Estimasi Waktu</label>
                        <input type="text" class="form-control @error('estimate') is-invalid @enderror" name="estimate" id="estimate"
                        placeholder="Masukan Estimasi Waktu Pengerjaan" value="{{ old('estimate') == null ? $data->estimate : old('estimate') }}">

                        @error('estimate')
                            <div class="alert alert-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>Price</label>
                        <input type="number" class="form-control @error('price') is-invalid @enderror" name="price" id="price"
                        placeholder="Masukan Stok" value="{{ old('price') == null ? $data->price : old('price') }}">

                        @error('price')
                            <div class="alert alert-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>Deskripsi</label>
                        <textarea name="description" id="description"
                        class="form-control @error('description') is-invalid @enderror" cols="30" rows="10">{{ old('description') == null ? $data->description : old('description') }}</textarea>

                        @error('description')
                            <div class="alert alert-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    @php
                        $no = 0;
                        $sort = 1;
                    @endphp
                    @foreach ($data->images->images as $item)
                        <div class="row">
                            <div class="col-sm-12 col-md-6">
                                <label for="">Gambar {{$sort}}</label>
                                @if ($sort == 1)
                                    @error('image0')
                                        <div class="alert alert-danger mt-1 img0">{{ $message }}</div>
                                    @enderror
                                @elseif ($sort == 2)
                                    @error('image1')
                                        <div class="alert alert-danger mt-1 img1">{{ $message }}</div>
                                    @enderror
                                @elseif ($sort == 3)
                                    @error('image2')
                                        <div class="alert alert-danger mt-1 img2">{{ $message }}</div>
                                    @enderror
                                @endif
                                <div class="form-group">
                                    <img src="{{ URL::to('/').'/'.$data->images->path.$item }}" width="100%" height="100%" id="img_{{$no}}">
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-6">
                                <div class="form-group">
                                    <input type="file" name="image{{$no}}" id="images_{{$no}}">
                                </div>
                            </div>
                        </div>
                        @php
                            $no++;
                            $sort++;
                        @endphp
                    @endforeach
                </div>

                <div class="card-footer">
                    <button type="submit" class="btn btn-success">Ubah</button>
                    <a type="button" href="{{ route('service.index') }}" class="btn btn-default">Batal</a>
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