<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Service;
use App\Models\User;
use config\Constant;

class ProductFeController extends Controller
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
        $products = Product::paginate(9);
        // foreach ($products as $key => $value) {
        //     dd($value->images);
        // }
        return view('front.product.index', compact('products'));
    }

    public function show(String $id)
    {
        $data = Product::where('kode', $id)->first();
        if($data == null) return redirect()->route('front.product.index')->with('error', Constant::NOT_FOUND);

        $data->images = json_decode($data->images);
        return view('front.product.show', compact('data'));
    }
}
