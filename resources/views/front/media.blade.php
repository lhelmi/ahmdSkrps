@extends('front.layouts.app')
@section('content')
<section class="jumbotron text-center" style="background-color: #fff">
    <div class="container">
        @foreach ($medias as $media)
            <div class="content">
                <h1 class="jumbotron-heading">{{ $media->name }}</h1>
                <img class="rounded mx-auto d-block" src="{{ URL::to('/').'/'.$media->file }}" alt="logo" style="height: 555px; width: 468px;">
                <a href="{{ route('front.media.download', $media->id) }}">Download</a>
            </div>
        @endforeach
    </div>
</section>
@endsection
