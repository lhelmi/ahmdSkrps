@extends('front.layouts.app')
@section('content')
<section class="jumbotron text-center" style="background-color: #fff">
    <div class="container">
        @foreach ($blogs as $blog)
            <div class="content">

                <h1 class="jumbotron-heading">{{ $blog->title }}</h1>
                <img class="rounded mx-auto d-block" src="{{ URL::to('/').'/'.$blog->image }}" alt="logo" style="height: 555px; width: 468px;">
                <p>{{ $blog->description }}</p>
            </div>
        @endforeach
        {!! $blogs->withQueryString()->links('pagination::bootstrap-4') !!}
    </div>
</section>
@endsection
