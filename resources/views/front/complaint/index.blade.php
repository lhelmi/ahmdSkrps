@extends('front.layouts.app')
@section('css')

@endsection
@section('content')

<div class="container">
    <div class="py-5 text-center">
        <h2>Keluhan</h2>
    </div>
    @if ($message = Session::get('error'))
        <div class="alert alert-danger">{{ $message }}</div>
    @endif
    @if ($message = Session::get('success'))
        <div class="alert alert-success">{{ $message }}</div>
    @endif
    <div class="row">
        <div class="col-md-12">
            <form method="POST" action="{{ route('front.complaint.store') }}">
                @csrf
                <div class="mb-3">
                    <label for="username">Keluhan</label>
                    <div class="input-group">
                        <input type="text" class="form-control" name="complaint" value="{{ old('complaint') }}">

                        @error('complaint')
                            <div class="alert alert-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <label for="username">Kritik</label>
                    <div class="input-group">
                        <input type="text" class="form-control" name="criticism" value="{{ old('criticism') }}">

                        @error('criticism')
                            <div class="alert alert-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <label for="username">Saran</label>
                    <div class="input-group">
                        <input type="text" class="form-control" name="suggestions" value="{{ old('suggestions') }}">

                        @error('suggestions')
                            <div class="alert alert-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <hr class="mb-4">
                <input class="btn btn-primary btn-lg btn-block" type="submit" value="Kirim" onclick="return confirm('Apakah anda yakin?')">
            </form>
        </div>
    </div>
  </div>
@endsection
@section('js')
@endsection
