@extends('front.layouts.app')
@section('content')
<div class="container">
    <div class="col-md-12 blog-main mt-4">
        <div class="blog-post">
            <h2 class="blog-post-title">{{ $blog->title }}</h2>
            <p class="blog-post-meta">{{ $blog->created_at }}
                {{-- by <a href="#">Mark</a> --}}
            </p>
        </div><!-- /.blog-post -->

        <div class="jumbotron p-3 p-md-5 mt-3 text-white rounded">
        <div class="col-md-6 px-0">
            <img src="{{ URL::to('/').'/'.$blog->image }}" class="img-fluid rounded-start" alt="img" style="height: 100%; width: 100%;">
        </div>
        </div>

        <div class="p-3 mb-3 bg-light rounded">
            <h4 class="font-italic">About</h4>
            <p class="mb-0">
                {{ $blog->description }}
            </p>
          </div>
    </div>
@endsection
