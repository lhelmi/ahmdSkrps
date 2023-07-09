<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Service;
use config\Constant;

class ServiceController extends Controller
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
        $services = Service::paginate(1);
        return view('front.service.index', compact('services'));
    }

    public function show(String $id)
    {
        $data = Service::where('kode', $id)->first();
        if($data == null) return redirect()->route('front.service.index')->with('error', Constant::NOT_FOUND);

        $data->images = json_decode($data->images);
        return view('front.service.show', compact('data'));
    }
}