@extends('front.layouts.app')
@section('css')

@endsection
@section('content')

<div class="container">
    <div class="py-5 text-center">
        <h2>Profile</h2>
    </div>
    @if ($message = Session::get('error'))
        <div class="alert alert-danger">{{ $message }}</div>
    @endif
    @if ($message = Session::get('success'))
        <div class="alert alert-success">{{ $message }}</div>
    @endif
    <div class="row">
        <div class="col-md-12">
            <form method="POST" action="{{ route('auth.profile.store') }}" enctype="multipart/form-data" >
                @csrf
                <div class="row">
                    <div class="col-md-2 mb-3">
                        <label for="lastName">Nama</label>
                    </div>
                    <div class="col-md-10 mb-3">
                        <div class="form-group">
                            <input type="text" class="form-control"
                            value="{{ old('name') !== null ? old('name') : $data->name }}" name="name">

                            @error('name')
                                <div class="alert alert-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-2 mb-3">
                        <label for="lastName">Tempat Lahir</label>
                    </div>
                    <div class="col-md-10 mb-3">
                        <div class="form-group">
                            <input type="text" class="form-control"
                            value="{{ $data->birth_place.', '.$data->birth_date }}" name="birth_date" disabled>

                            @error('birth_date')
                                <div class="alert alert-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-2 mb-3">
                        <label for="lastName">Alamat</label>
                    </div>
                    <div class="col-md-10 mb-3">
                        <div class="form-group">
                            <textarea class="form-control"
                            name="address" id="" cols="30" rows="10">{{ old('address') !== null ? old('address') : $data->address }}</textarea>

                            @error('address')
                                <div class="alert alert-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-2 mb-3">
                        <label for="lastName">Email</label>
                    </div>
                    <div class="col-md-10 mb-3">
                        <div class="form-group">
                            <input type="text" class="form-control"
                            value="{{ old('email') !== null ? old('email') : $data->email }}" name="email">

                            @error('email')
                                <div class="alert alert-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-2 mb-3">
                        <label for="lastName">Username</label>
                    </div>
                    <div class="col-md-10 mb-3">
                        <div class="form-group">
                            <input type="text" class="form-control"
                            value="{{ old('username') !== null ? old('username') : $data->username }}" name="username" disabled>

                            @error('username')
                                <div class="alert alert-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-2 mb-3">
                        <label for="lastName">Password</label>
                    </div>
                    <div class="col-md-10 mb-3">
                        <div class="form-group">
                            <input type="password" class="form-control" name="password">

                            @error('password')
                                <div class="alert alert-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-2 mb-3">
                        <label for="lastName">Password Baru</label>
                    </div>
                    <div class="col-md-10 mb-3">
                        <div class="form-group">
                            <input type="password" class="form-control" name="new_password">

                            @error('new_password')
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
