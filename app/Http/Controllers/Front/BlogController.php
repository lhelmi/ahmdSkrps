<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Blog;
use config\Constant;
use Illuminate\Support\Facades\Auth;

class BlogController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        if(Auth::user()){
            $this->middleware('verified')->only([
                'index',
                'show'
            ]);
        }
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $blogs = Blog::paginate(3);
        return view('front.blog.index', compact('blogs'));
    }

    public function show(string $slug)
    {
        $blog = Blog::where('slug', $slug)->first();
        if(!$blog) abort(404);

        return view('front.blog.show', compact('blog'));
    }
}
