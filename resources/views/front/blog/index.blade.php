@extends('front.layouts.app')
@section('content')
<section class="jumbotron text-center" style="background-color: #fff">
    <div class="container">
        @foreach ($blogs as $blog)
            <div class="content">
                <div class="card mb-3">
                    <a href="{{ route('front.blog.show', $blog->slug) }}" class="text-decoration-none text-reset">
                        <div class="row g-0 p-4">
                            <div class="col-md-4">
                                <img src="{{ URL::to('/').'/'.$blog->image }}" class="img-fluid rounded-start" alt="img" style="height: 255px; width: 468px;">
                            </div>
                            <div class="col-md-8">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $blog->title }}</h5>
                                    <p class="card-text text-justify">{{ substr_replace($blog->description, "...", 150) }}</p>
                                    <p class="card-text"><small class="text-muted">{{ $blog->created_at }}</small></p>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        @endforeach
        {!! $blogs->withQueryString()->links('pagination::bootstrap-4') !!}
    </div>
</section>
@endsection
