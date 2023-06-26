<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use config\Constant;
use Illuminate\Support\Facades\Validator;
use App\Http\Traits\Common;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    use Common;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    private function getNumber(){
        $data = Product::select('id')->orderBy('id', 'desc')->first();
        if($data == null) $data = 1;
        return $data;
    }

    private function setKode($type){
        $list = $this->typeList();
        $kode = 'UNLIST';
        foreach ($list as $key => $value) {
            if($key == $type) $kode = $value;
        }
        $number = $this->getNumber();
        $number = (integer)$number->id + 1;
        $kode = $kode.$number;
        return $kode;
    }

    public function index()
    {
        $products = Product::select("*")->orderBy('updated_at', 'desc')->get();
        return view('admin.product.index', compact('products'));
    }

    public function create()
    {
        $typeList = $this->typeList();
        return view('admin.product.create', compact('typeList'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "name" => ["required", "string", "max:100", "min:1"],
            "size" => ["required", "string", "max:100", "min:1"],
            "type" => ["required", "string", "max:100", "min:1"],
            "material" => ["required", "string", "max:100", "min:1"],
            "stock" => ["required", "numeric", "min:1"],
            "description" => ["required", "string", "max:100", "min:1"],
            "price" => ["required", "numeric", "min:1"],
        ]);

        if ($validator->fails()) {
            return redirect()->route('product.create')->withErrors($validator)->withInput();
        }

        try {
            $data = new Product();
            $data->kode = $this->setKode($request->type);
            $data->name = $request->name;
            $data->size = $request->size;
            $data->type = $request->type;
            $data->material = $request->material;
            $data->stock = $request->stock;
            $data->description = $request->description;
            $data->price = $request->price;
            $data->created_by = Auth::user()->username;
            $data->save();
            return redirect()->route('product.index')->with('success', Constant::SAVE_SUCCESS);
        } catch (\Throwable $th) {
            $this->errorLog($th->getMessage());
            return redirect()->route('product.create')->with('error', Constant::SAVE_FAIL);
        }

    }

    public function edit(string $id)
    {
        $data = Product::where('kode', $id)->first();
        $typeList = $this->typeList();
        if($data == null) return redirect()->route('product.index')->with('error', Constant::NOT_FOUND);
        return view('admin.product.edit', compact('data', 'typeList'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = Product::where('kode', $id)->first();

        if($data == null) return redirect()->route('product.index')->with('error', Constant::NOT_FOUND);
        $validator = Validator::make($request->all(), [
            "name" => ["required", "string", "max:100", "min:1"],
            "size" => ["required", "string", "max:100", "min:1"],
            "type" => ["required", "string", "max:100", "min:1"],
            "material" => ["required", "string", "max:100", "min:1"],
            "stock" => ["required", "numeric", "min:1"],
            "description" => ["required", "string", "max:100", "min:1"],
            "price" => ["required", "numeric", "min:1"],
        ]);

        if ($validator->fails()) {
            return redirect()->route('product.edit', $id)->withErrors($validator)->withInput();
        }

        try {
            $data->name = $request->name;
            $data->size = $request->size;
            $data->type = $request->type;
            $data->material = $request->material;
            $data->stock = $request->stock;
            $data->description = $request->description;
            $data->price = $request->price;

            $data->save();
            return redirect()->route('product.index')->with('success', Constant::UPDATE_SUCCESS);
        } catch (\Throwable $th) {
            $this->errorLog($th->getMessage());
            return redirect()->route('product.edit', $id)->with('error', Constant::UPDATE_FAIL);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = Product::where('kode', $id)->first();
        if($data == null) return redirect()->route('product.index')->with('error', Constant::NOT_FOUND);

        try {
            $data->delete();
            return redirect()->route('product.index')->with('success', Constant::DESTROY_SUCCESS);
        } catch (\Throwable $th) {
            $this->errorLog($th->getMessage());
            return redirect()->route('product.index')->with('error', Constant::DESTROY_FAIL);
        }
    }
}
