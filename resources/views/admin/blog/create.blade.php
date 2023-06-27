@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    {{-- <h1>Tambah Admin</h1> --}}
@stop

@section('content')
    <div class="card">
        <div class="card-header">
        <h3 class="card-title">Tambah Pengenalan</h3>
        </div>
        <div class="card-body">
            @if ($message = Session::get('error'))
                <div class="alert alert-danger">{{ $message }}</div>
            @endif
            <form method="POST" action="{{ route('blog.store') }}" enctype="multipart/form-data" >
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label for="title">Judul</label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror" name="title" id="title" placeholder="Masukan Judul"
                        value="{{ old('title') }}">

                        @error('title')
                            <div class="alert alert-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="username">Deskripsi</label>
                        <textarea name="description" id="description" cols="30" rows="10"
                        class="form-control @error('description') is-invalid @enderror">{{ old('description') }}</textarea>


                        @error('description')
                            <div class="alert alert-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="exampleInputFile">Foto</label>
                        <div class="input-group">
                            <input type="file" name="image" id="image">
                        </div>
                        @error('image')
                            <div class="alert alert-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                </div>

                <div class="card-footer">
                    <button type="submit" class="btn btn-success">Simpan</button>
                    <a type="button" href="{{ route('blog.index') }}" class="btn btn-default">Batal</a>
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
