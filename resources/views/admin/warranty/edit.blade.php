@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    {{-- <h1>Tambah Admin</h1> --}}
@stop

@section('content')
    <div class="card">
        <div class="card-header">
        <h3 class="card-title">Garansi</h3>
        </div>
        <div class="card-body">
            @if ($message = Session::get('error'))
                <div class="alert alert-danger">{{ $message }}</div>
            @endif
            <form method="POST" action="{{ route('warranty.update', $data->id) }}" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label for="name">Nama</label>
                        <input type="text" class="form-control @error('nama_user') is-invalid @enderror" name="nama_user" id="nama_user" placeholder="Masukan Nama"
                        value="{{ old('nama_user') == null ? $data->nama_user : old('nama_user') }}" disabled>

                        @error('nama_user')
                            <div class="alert alert-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="name">Produk</label>
                        <input type="text" class="form-control @error('nama_product') is-invalid @enderror" name="nama_product" id="nama_product"
                        value="{{ old('nama_product') == null ? $data->nama_product : old('nama_product') }}" disabled>

                        @error('nama_product')
                            <div class="alert alert-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="name">Kontak</label>
                        <input type="text" class="form-control @error('contact') is-invalid @enderror" name="contact" id="contact"
                        value="{{ old('contact') == null ? $data->contact : old('contact') }}" disabled>

                        @error('contact')
                            <div class="alert alert-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="name">Tanggal Pembelian</label>
                        <input type="text" class="form-control @error('purchase_date') is-invalid @enderror" name="purchase_date" id="purchase_date"
                        value="{{ old('purchase_date') == null ? $data->purchase_date : old('purchase_date') }}" disabled>

                        @error('purchase_date')
                            <div class="alert alert-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-sm-12 col-md-6">
                            <label for="">Persyaratan Pembelian</label>
                            @error('image')
                                <div class="alert alert-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-sm-12 col-md-6">
                            <div class="form-group">
                                <img src="{{ URL::to('/').'/'.$data->requirements }}" width="100%" height="100%" id="image">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12 col-md-6">
                            <label for="">Bukti Pembelian</label>
                            @error('image')
                                <div class="alert alert-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-sm-12 col-md-6">
                            <div class="form-group">
                                <img src="{{ URL::to('/').'/'.$data->receipt }}" width="100%" height="100%" id="image">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="name">Keterangan</label>
                        <select name="status" id="status"
                        class="form-control @error('status') is-invalid @enderror"
                        name="status">
                            <option value="">Pilih</option>
                            @foreach ($type as $key => $list)
                                <option value="{{ $key }}" @if(old('type') == $key)
                                    {{ 'selected' }}
                                @elseif ($key == $data->status)
                                    {{ 'selected' }}
                                @endif >{{ $list }}</option>
                            @endforeach
                        </select>
                        @error('status')
                            <div class="alert alert-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="card-footer">
                    <button type="submit" class="btn btn-success">Ubah</button>
                    <a type="button" href="{{ route('warranty.index') }}" class="btn btn-default">Batal</a>
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
