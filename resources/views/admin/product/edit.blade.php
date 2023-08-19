@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    {{-- <h1>Tambah Admin</h1> --}}
@stop

@section('content')
    <div class="card">
        <div class="card-header">
        <h3 class="card-title">Ubah Product</h3>
        </div>
        <div class="card-body">
            @if ($message = Session::get('error'))
                <div class="alert alert-danger">{{ $message }}</div>
            @endif
            @if ($message = Session::get('success'))
                    <div class="alert alert-success mt-2">{{ $message }}</div>
                @endif
            <form method="POST" action="{{ route('product.update', $data->kode) }}" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label for="name">Kode</label>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="row">
                                    <div class="col-md-3">
                                        <input type="text" class="form-control @error('kode-name') is-invalid @enderror" name="kode-name" id="kode-name" placeholder=""
                                        value="{{ old('kode-name') == null ? $data->kodeName : old('kode-name') }}" maxlength="3"
                                        oninput="this.value=this.value.replace(/[^A-Za-z]+$/,'');">
                                    </div>
                                    <div class="col-md-1">
                                        <h3>-</h3>
                                    </div>
                                    <div class="col-md-3">
                                        <input type="text" class="form-control @error('kode-type') is-invalid @enderror" name="kode-type" id="kode-type" placeholder=""
                                        value="{{ old('kode-type') == null ? $data->kodeType : old('kode-type') }}" readonly>
                                    </div>
                                    <div class="col-md-1">
                                        <h3>-</h3>
                                    </div>
                                    <div class="col-md-3">
                                        <input type="text" class="form-control @error('kode-number') is-invalid @enderror" name="kode-number" id="kode-number" placeholder=""
                                        value="{{ old('kode-number') == null ? $data->kodeNumber : old('kode-number') }}" oninput="this.value=this.value.replace(/[^0-9]/g,'');" maxlength="3">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" class="form-control @error('kode') is-invalid @enderror" name="kode" id="kode"
                        value="{{ old('kode') == null ? $data->kode : old('kode') }}" readonly>

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
                        value="{{ old('name') == null ? $data->name : old('name') }}">

                        @error('name')
                            <div class="alert alert-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="username">Ukuran</label>
                        <div class="row">
                            <div class="col-md-4">
                                <input type="text" class="form-control @error('length') is-invalid @enderror" name="length" id="length" placeholder="Panjang"
                                value="{{ old('length') == null ? $data->length : old('length') }}">

                                @error('length')
                                    <div class="alert alert-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <input type="text" class="form-control @error('width') is-invalid @enderror" name="width" id="width" placeholder="Lebar"
                                value="{{ old('width') == null ? $data->width : old('width') }}">
                                @error('width')
                                    <div class="alert alert-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <input type="text" class="form-control @error('height') is-invalid @enderror" name="height" id="height" placeholder="Tinggi"
                                value="{{ old('height') == null ? $data->height : old('height') }}">
                                @error('height')
                                    <div class="alert alert-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Jenis</label>
                        <select name="type" class="form-control @error('type') is-invalid @enderror" name="type" id="type">
                            <option value="">Pilih</option>
                            @foreach ($typeList as $key => $list)
                                <option data-kode="{{ $list }}" value="{{ $key }}" @if(old('type') == $key)
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
                        <label>Stok</label>
                        <input type="number" class="form-control @error('stock') is-invalid @enderror" name="stock" id="stock"
                        placeholder="Masukan Stok" value="{{ old('stock') == null ? $data->stock : old('stock') }}">

                        @error('stock')
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
                                    @php
                                        $temp = $item;
                                    @endphp
                                    {{-- <a class="btn btn-sm btn-danger" onclick="return confirm('Apakah anda yakin?')" href="{{ route('product.destroy.image', ['kode' => $data->kode, 'img' => $temp]) }}">Hapus</a> --}}
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
