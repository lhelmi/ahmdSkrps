@extends('adminlte::auth.auth-page', ['auth_type' => 'login'])

@section('auth_header', "Akun anda memerlukan verifikasi")

@section('auth_body')

    @if(session('resent'))
        <div class="alert alert-success" role="alert">
            Tautan verifikasi baru telah dikirim ke alamat email Anda.
        </div>
    @endif

    Sebelum melanjutkan, periksa email Anda untuk tautan verifikasi.
    Jika Anda tidak menerima email tersebut,

    <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
        @csrf
        <button type="submit" class="btn btn-link p-0 m-0 align-baseline">
            klik di sini untuk mengirim permintaan lain
        </button>.
    </form>
    <br>
    <br>
    <div>
        <a href="{{ route('front.home') }}">
            <i class="fa fa-backward" aria-hidden="true"></i>
            Kembali ke halaman depan
        </a>
    </div>


@stop
