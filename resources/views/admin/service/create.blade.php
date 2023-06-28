@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    {{-- <h1>Tambah Admin</h1> --}}
@stop

@section('content')
    <div class="card">
        <div class="card-header">
        <h3 class="card-title">Tambah Service</h3>
        </div>
        <div class="card-body">
            @if ($message = Session::get('error'))
                <div class="alert alert-danger">{{ $message }}</div>
            @endif
            <form method="POST" action="{{ route('service.store') }}" enctype="multipart/form-data" >
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label for="name">Nama</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name" placeholder="Masukan Nama Lengkap"
                        value="{{ old('name') }}">

                        @error('name')
                            <div class="alert alert-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="username">Ukuran</label>
                        <input type="text" class="form-control @error('size') is-invalid @enderror" name="size" id="size" placeholder="Masukan size" value="{{ old('size') }}">

                        @error('size')
                            <div class="alert alert-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="username">Jenis</label>
                        <select name="type" class="form-control @error('type') is-invalid @enderror" name="type" >
                            <option value="">Pilih</option>
                            @foreach ($typeList as $key => $list)
                                <option value="{{ $key }}" @if(old('type') == $key) {{ 'selected' }} @endif >{{ $key }}</option>
                            @endforeach
                        </select>

                        @error('type')
                            <div class="alert alert-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="username">Estimasi Waktu</label>
                        <input type="text" class="form-control @error('estimate') is-invalid @enderror" name="estimate" id="estimate"
                        placeholder="Masukan Estimasi Waktu Pengerjaan" value="{{ old('estimate') }}">

                        @error('estimate')
                            <div class="alert alert-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="username">Price</label>
                        <input type="number" class="form-control @error('price') is-invalid @enderror" name="price" id="price"
                        placeholder="Masukan Stok" value="{{ old('price') }}">

                        @error('price')
                            <div class="alert alert-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="exampleInputFile">Foto</label>
                        <div class="input-group">
                            <input type="file" name="images[]" id="images" multiple=true>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="username">Deskripsi</label>
                        <textarea name="description" id="description"
                        class="form-control @error('description') is-invalid @enderror" cols="30" rows="10">{{ old('description') }}</textarea>

                        @error('description')
                            <div class="alert alert-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                </div>

                <div class="card-footer">
                    <button type="submit" class="btn btn-success">Simpan</button>
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

@stop