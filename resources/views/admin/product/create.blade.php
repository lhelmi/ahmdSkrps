@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    {{-- <h1>Tambah Admin</h1> --}}
@stop

@section('content')
    <div class="card">
        <div class="card-header">
        <h3 class="card-title">Tambah Product</h3>
        </div>
        <div class="card-body">
            @if ($message = Session::get('error'))
                <div class="alert alert-danger">{{ $message }}</div>
            @endif
            <form method="POST" action="{{ route('product.store') }}" enctype="multipart/form-data" >
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label for="name">Kode</label>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="row">
                                    <div class="col-md-3">
                                        <input type="text" class="form-control @error('kode-name') is-invalid @enderror" name="kode-name" id="kode-name" placeholder="" value="{{ old('kode-name') }}" maxlength="3">
                                    </div>
                                    <div class="col-md-1">
                                        <h3>-</h3>
                                    </div>
                                    <div class="col-md-3">
                                        <input type="text" class="form-control @error('kode-type') is-invalid @enderror" name="kode-type" id="kode-type" placeholder="" value="{{ old('kode-type') }}" readonly>
                                    </div>
                                    <div class="col-md-1">
                                        <h3>-</h3>
                                    </div>
                                    <div class="col-md-3">
                                        <input type="number" class="form-control @error('kode-number') is-invalid @enderror" name="kode-number" id="kode-number" placeholder="" value="{{ old('kode-number') }}" maxlength="3">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" class="form-control @error('kode') is-invalid @enderror" name="kode" id="kode" value="{{ old('kode') }}" readonly>

                        @error('kode-name')
                            <div class="alert alert-danger mt-1">{{ $message }}</div>
                        @enderror
                        @error('kode-type')
                            <div class="alert alert-danger mt-1">{{ $message }}</div>
                        @enderror
                        @error('kode-number')
                            <div class="alert alert-danger mt-1">{{ $message }}</div>
                        @enderror
                        @error('kode')
                            <div class="alert alert-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>

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
                        <div class="row">
                            <div class="col-md-4">
                                <input type="text" class="form-control @error('length') is-invalid @enderror" name="length" id="length" placeholder="Panjang" value="{{ old('length') }}">
                                @error('length')
                                    <div class="alert alert-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <input type="text" class="form-control @error('width') is-invalid @enderror" name="width" id="width" placeholder="Lebar" value="{{ old('width') }}">
                                @error('width')
                                    <div class="alert alert-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <input type="text" class="form-control @error('height') is-invalid @enderror" name="height" id="height" placeholder="Tinggi" value="{{ old('height') }}">
                                @error('height')
                                    <div class="alert alert-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="username">Jenis</label>
                        <select name="type" class="form-control @error('type') is-invalid @enderror" name="type" id="type">
                            <option value="">Pilih</option>
                            @foreach ($typeList as $key => $list)
                                <option data-kode="{{ $list }}" value="{{ $key }}" @if(old('type') == $key) {{ 'selected' }} @endif >{{ $key }}</option>
                            @endforeach
                        </select>

                        @error('type')
                            <div class="alert alert-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="username">Stok</label>
                        <input type="number" class="form-control @error('stock') is-invalid @enderror" name="stock" id="stock"
                        placeholder="Masukan Stok" value="{{ old('stock') }}">

                        @error('stock')
                            <div class="alert alert-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="username">Price</label>
                        <input type="number" class="form-control @error('price') is-invalid @enderror" name="price" id="price"
                        placeholder="Masukan Harga" value="{{ old('price') }}">

                        @error('price')
                            <div class="alert alert-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="exampleInputFile">Foto</label>
                        <div class="input-group">
                            <input type="file" name="images[]" id="images" multiple=true>
                        </div>
                        @error('images')
                            <div class="alert alert-danger mt-1">{{ $message }}</div>
                        @enderror

                        @error('images.0')
                            <div class="alert alert-danger mt-1">{{ $message }}</div>
                        @enderror

                        @error('images.1')
                            <div class="alert alert-danger mt-1">{{ $message }}</div>
                        @enderror

                        @error('images.2')
                            <div class="alert alert-danger mt-1">{{ $message }}</div>
                        @enderror
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
                    <a type="button" href="{{ route('product.index') }}" class="btn btn-default">Batal</a>
                </div>
            </form>
        </div>
    </div>

@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script type="module">
        $(document).ready(function(){
            const APP_URL = {!! json_encode(url('/')) !!}
            let currentName = "";

            function setUrl(target) {
                if (!target.startsWith('/'))
                    target = '/' + target;
                return APP_URL + target;
            }

            function checkKode() {
                let name = $("#name").val();
                name = name.substr(0, 3);
                let type = $("#type :selected").data('kode');
                if ( typeof type === "undefined") type = 'xxx';
                if(currentName !== name || type !== 'xxx'){
                    let type = $("#type :selected").data('kode');
                    if ( typeof type === "undefined") type = 'xxx';
                    let param = name+'-'+type;
                    const kode = $.ajax({
                        url: setUrl(`/admin/product/kode/check/${param}`),
                        type: 'GET',
                        dataType: 'json',
                        // beforeSend: function() {
                        //     showLoader()
                        // },
                        success: function(payload, message, xhr) {
                            currentName = name;
                            if (payload.status != 200) {
                                alert('error : gagal mendapatkan kode!');
                            } else {
                                let number = parseInt(payload.data) + 1;
                                type = type == 'xxx' ? '' : type;
                                let newKode = name+'-'+type+'-'+number;
                                $("#kode").val(newKode.toUpperCase());
                            }
                        },
                        // complete: function(payload, message, xhr) {
                        //     $(this).prop('disabled', false)
                        //     hideLoader()
                        //     enable(button)
                        //     enable(checkbox)
                        // },
                        error: function(xhr, message, error) {
                            let payload = xhr.responseJSON
                            alert(error)
                            // showMessage(error, 'error')
                        }
                    })
                }
            }

            $('#type').on('change', function(){
                let type = $("#type :selected").data('kode');
                $("#kode-type").val(type);
                SetKode();
            });

            $('#kode-name').on('keyup', function(){
                SetKode();
            });

            $('#kode-number').on('keyup', function(){
                SetKode();
            });

            function SetKode() {
                let kode = $("#kode").val()
                let name = $('#kode-name').val();
                if ( typeof name === "undefined") name = '';
                let type = $("#type :selected").data('kode');
                if ( typeof type === "undefined") type = '';
                let number = $('#kode-number').val();
                if ( typeof number === "undefined") number = '';

                let merge = name + '-' + type + '-' + number;
                if(name == '-' && type == '-' && number == '-') merge = ""
                $("#kode").val(merge)
                if(kode == "--") $("#kode").val("");
            }
        })

    </script>
@stop
