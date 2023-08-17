@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    {{-- <h1>Tambah Admin</h1> --}}
@stop

@section('content')
    <div class="card">
        <div class="card-header">
        <h3 class="card-title">Detail Jasa</h3>
        </div>
        <div class="card-body">
            @if ($message = Session::get('error'))
                <div class="alert alert-danger">{{ $message }}</div>
            @endif
            @if (Auth::user()->role == "1")
                <div class="card-body">
                    <div class="form-group">
                        <label>Kode</label>
                        <input type="text" class="form-control @error('kode') is-invalid @enderror" name="kode" id="kode" placeholder="Masukan Kode"
                        value="{{ old('kode') == null ? $data->kode : old('kode') }}" readonly>
                    </div>

                    <div class="form-group">
                        <label for="name">Nama</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name" placeholder="Masukan Nama Lengkap"
                        value="{{ old('name') == null ? $data->name : old('name') }}" readonly>
                    </div>

                    <div class="form-group">
                        <label for="username">Ukuran</label>
                        <div class="row">
                            <div class="col-md-4">
                                <input type="text" class="form-control @error('length') is-invalid @enderror" name="length" id="length" placeholder="Panjang"
                                value="{{ old('length') == null ? $data->length : old('length') }}" readonly>
                            </div>
                            <div class="col-md-4">
                                <input type="text" class="form-control @error('width') is-invalid @enderror" name="width" id="width" placeholder="Lebar"
                                value="{{ old('width') == null ? $data->width : old('width') }}" readonly>
                            </div>
                            <div class="col-md-4">
                                <input type="text" class="form-control @error('height') is-invalid @enderror" name="height" id="height" placeholder="Tinggi"
                                value="{{ old('height') == null ? $data->height : old('height') }}" readonly>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Jenis</label>
                        <select name="type" class="form-control @error('type') is-invalid @enderror" name="type" disabled>
                            <option value="">Pilih</option>
                            @foreach ($typeList as $key => $list)
                                <option value="{{ $key }}" @if(old('type') == $key)
                                    {{ 'selected' }}
                                @elseif ($key == $data->type)
                                    {{ 'selected' }}
                                @endif >{{ $key }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Price</label>
                        <input type="number" class="form-control @error('price') is-invalid @enderror" name="price" id="price"
                        placeholder="Masukan Stok" value="{{ old('price') == null ? $data->price : old('price') }}" readonly>
                    </div>

                    <div class="form-group">
                        <label>Deskripsi</label>
                        <textarea name="description" id="description" readonly
                        class="form-control @error('description') is-invalid @enderror" cols="30" rows="10">{{ old('description') == null ? $data->description : old('description') }}</textarea>
                    </div>
                    @php
                        $no = 0;
                        $sort = 1;
                    @endphp
                    @foreach ($data->images->images as $item)
                        <div class="row">
                            <div class="col-sm-12 col-md-6">
                                <label for="">Gambar {{$sort}}</label>
                                <div class="form-group">
                                    <img src="{{ URL::to('/').'/'.$data->images->path.$item }}" width="100%" height="100%" id="img_{{$no}}">
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-6">
                                <div class="form-group">

                                </div>
                            </div>
                        </div>
                        @php
                            $no++;
                            $sort++;
                        @endphp
                    @endforeach
                </div>
            @endif
            <form method="POST" action="{{ route('service.detail.update', $data->kode) }}" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label>Note</label>
                    <textarea name="note" id="note"
                    @if (Auth::user()->role == "0") @disabled(true) @endif
                    class="form-control @error('note') is-invalid @enderror" cols="30" rows="10">{{ old('note') == null ? $data->note : old('note') }}</textarea>

                    @error('note')
                        <div class="alert alert-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>
                <div class="card-footer">
                    @if (Auth::user()->role == "1")
                        <button type="submit" class="btn btn-success" name="approve" value="0">Setujui</button>
                        <button type="submit" class="btn btn-danger" name="reject" value="1">Tolak</button>
                    @endif
                    <a type="button" href="{{ route('service.index') }}" class="btn btn-default">Kembali</a>
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
