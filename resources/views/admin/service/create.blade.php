@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    {{-- <h1>Tambah Admin</h1> --}}
@stop

@section('content')
    <div class="card">
        <div class="card-header">
        <h3 class="card-title">Tambah Jasa</h3>
        </div>
        <div class="card-body">
            @if ($message = Session::get('error'))
                <div class="alert alert-danger">{{ $message }}</div>
            @endif
            <form method="POST" action="{{ route('service.store') }}" enctype="multipart/form-data" >
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label for="name">Kode</label>
                        <input type="text" class="form-control @error('kode') is-invalid @enderror" name="kode" id="kode"
                        value="{{ old('kode') }}" readonly>

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
                                <input type="number" class="form-control @error('length') is-invalid @enderror" name="length" id="length" placeholder="Panjang" value="{{ old('length') }}">
                                @error('length')
                                    <div class="alert alert-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <input type="number" class="form-control @error('width') is-invalid @enderror" name="width" id="width" placeholder="Lebar" value="{{ old('width') }}">
                                @error('width')
                                    <div class="alert alert-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <input type="number" class="form-control @error('height') is-invalid @enderror" name="height" id="height" placeholder="Tinggi" value="{{ old('height') }}">
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
