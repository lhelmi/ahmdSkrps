<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Media;
use Illuminate\Support\Facades\Response;

class MediaController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $medias = Media::all();
        return view('front.media', compact('medias'));
    }

    public function download(String $id)
    {
        $media = Media::find($id);
        $path = public_path($media->file);
        $temp = explode('/', $media->file);
        $temp = last($temp);
        $temp = explode('.', $media->file);
        $temp = last($temp);

        $fileName = time().'-'.$media->name.'.'.$temp;

        return Response::download($path, $fileName);
    }
}
