@extends('front.layouts.app')
@section('css')

@endsection
@section('content')

<div class="container">
    <div class="py-5 text-center">
        <h2>Garansi Penukaran Produk</h2>
    </div>
    @if ($message = Session::get('error'))
        <div class="alert alert-danger">{{ $message }}</div>
    @endif
    @if ($message = Session::get('success'))
        <div class="alert alert-success">{{ $message }}</div>
    @endif
    <div class="row">
        <div class="col-md-12">
            <form method="POST" action="{{ route('front.warranty.store') }}" enctype="multipart/form-data" >
                @csrf
                <div class="row">
                    <div class="col-md-2 mb-3">
                        <label for="lastName">Nama</label>
                    </div>
                    <div class="col-md-10 mb-3">
                        <div class="form-group">
                            <input type="text" class="form-control"
                            value="{{ Auth::user() !== null ? Auth::user()->name : old('name') }}" name="name"
                            @if (Auth::user() !== null)
                                readonly
                            @endif>
                            @error('name')
                                <div class="alert alert-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-2 mb-3">
                        <label for="lastName">Produk</label>
                    </div>
                    <div class="col-md-10 mb-3">
                        <div class="form-group">
                            <select id="product_id" class="form-control" name="product_id">
                                @foreach ($product as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                            </select>

                            @error('product_id')
                                <div class="alert alert-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-2 mb-3">
                        <label for="lastName">Kontak</label>
                    </div>
                    <div class="col-md-10 mb-3">
                        <div class="form-group">
                            <input type="text" class="form-control"
                            value="{{ old('contact') }}" name="contact">
                            @error('contact')
                                <div class="alert alert-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-2 mb-3">
                        <label for="lastName">Tanggal Pembelian</label>
                    </div>
                    <div class="col-md-10 mb-3">
                        <div class="form-group">
                            <input type="date" class="form-control"
                            value="{{ old('purchase_date') }}" name="purchase_date">
                            @error('purchase_date')
                                <div class="alert alert-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-2 mb-3">
                        <label for="lastName">Persyaratan Pembelian</label>
                    </div>
                    <div class="col-md-10 mb-3">
                        <div class="form-group">
                            <input type="file" class="form-control" name="requirements">
                            @error('requirements')
                                <div class="alert alert-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-2 mb-3">
                        <label for="lastName">Bukti Pembelian</label>
                    </div>
                    <div class="col-md-10 mb-3">
                        <div class="form-group">
                            <input type="file" class="form-control" name="receipt">
                            @error('receipt')
                                <div class="alert alert-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <hr class="mb-4">
                <input class="btn btn-primary btn-lg btn-block" type="submit" value="Kirim" onclick="return confirm('Apakah anda yakin?')">
            </form>
        </div>
    </div>
    <div class="py-5 text-justify">
        <h2>Syarat dan ketentuan :</h2>
        <p>1. Untuk produk hanya bisa di tukar di hari yang sama</p>
        <p>2. Persyaratan & bukti di upload berupa foto Kontak</p>
        <p>3. persyaratan & bukti harus dibawa pada saat penukaran produk</p>
    </div>
  </div>
@endsection
@section('js')

    <script type="module">
            $(document).ready(function(){
                $('#product_id').select2();
            });
    </script>
@endsection
