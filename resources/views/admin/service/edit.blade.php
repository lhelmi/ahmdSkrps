@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    {{-- <h1>Tambah Admin</h1> --}}
@stop

@section('content')
    <div class="card">
        <div class="card-header">
        <h3 class="card-title">Ubah Jasa</h3>
        </div>
        <div class="card-body">
            @if ($message = Session::get('error'))
                <div class="alert alert-danger">{{ $message }}</div>
            @endif
            <form method="POST" action="{{ route('service.update', $data->kode) }}" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label>Kode</label>
                        <input type="text" class="form-control @error('kode') is-invalid @enderror" name="kode" id="kode"
                        value="{{ old('kode') == null ? $data->kode : old('kode') }}" readonly>

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
                                <input type="number" class="form-control @error('length') is-invalid @enderror" name="length" id="length" placeholder="Panjang"
                                value="{{ old('length') == null ? $data->length : old('length') }}">

                                @error('length')
                                    <div class="alert alert-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <input type="number" class="form-control @error('width') is-invalid @enderror" name="width" id="width" placeholder="Lebar"
                                value="{{ old('width') == null ? $data->width : old('width') }}">
                                @error('width')
                                    <div class="alert alert-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <input type="number" class="form-control @error('height') is-invalid @enderror" name="height" id="height" placeholder="Tinggi"
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
                        <label>Price</label>
                        <input type="number" class="form-control @error('price') is-invalid @enderror" name="price" id="price"
                        placeholder="Masukan Harga" value="{{ old('price') == null ? $data->price : old('price') }}">

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
                    url: setUrl(`/admin/service/kode/check/${param}`),
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
            checkKode();
        });

        $('#name').on('keyup', function(){
            checkKode();
        });
    })

</script>
@stop
