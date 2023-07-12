<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use config\Constant;
use Illuminate\Support\Facades\Validator;
use App\Http\Traits\Common;
use App\Models\Service;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class ServiceController extends Controller
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

    public string $path = 'admin/images/services';

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    private function getNumber(){
        $data = Service::select('id')->orderBy('id', 'desc')->first();
        if($data == null){
            $temp = [
                'id' => 0
            ];
            $data = (object)$temp;
        }

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
        $services = Service::select("*")->orderBy('updated_at', 'desc')->get();
        return view('admin.service.index', compact('services'));
    }

    public function create()
    {
        $typeList = $this->typeList();
        return view('admin.service.create', compact('typeList'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "kode" => ["required", "string", "max:100", "min:1", "unique:services"],
            "name" => ["required", "string", "max:100", "min:1"],
            "size" => ["required", "string", "max:100", "min:1"],
            "type" => ["required", "string", "max:100", "min:1"],
            "description" => ["required", "string", "max:100", "min:1"],
            "price" => ["required", "numeric", "min:1"],
            "images" => ["required","array","min:1","max:3"],
            "images.*" => ["required", "mimes:png,jpg,jpeg", "max:2048"],
        ],[
            'images.*.required' => 'Please upload an image',
            'images.*.mimes' => 'Only jpeg,png and jpeg images are allowed',
            'images.*.max' => 'Sorry! Maximum allowed size for an image is 2MB',
        ]
    );

        if ($validator->fails()) {
            return redirect()->route('service.create')->withErrors($validator)->withInput();
        }

        $uploads = $this->moveFile($request->images, $this->path);
        if(count($uploads) == 0) return redirect()->route('service.create')->with('error', Constant::UPLOAD_FAIL);

        try {
            $data = new Service();
            $data->kode = $request->kode;
            $data->name = $request->name;
            $data->size = $request->size;
            $data->type = $request->type;
            $data->estimate = $request->estimate;
            $data->description = $request->description;
            $data->price = $request->price;
            $data->images = json_encode($uploads);
            $data->created_by = Auth::user()->username;
            $data->save();
            return redirect()->route('service.index')->with('success', Constant::SAVE_SUCCESS);
        } catch (\Throwable $th) {
            $this->errorLog($th->getMessage());
            return redirect()->route('service.create')->with('error', Constant::SAVE_FAIL);
        }

    }

    private function moveFile($file, $path){
        $result = [
            'path' => $path.'/',
            'images' => [],
        ];
        foreach ($file as $key => $value) {
            $fileName = time().'_'.$key.'_'.$value->getClientOriginalName();
            $move = $value->move($path, $fileName);
            if($move){
                array_push($result['images'], $fileName);
            }else{
                return [];
            }
        }
        return $result;
    }


    public function edit(string $id)
    {
        $data = Service::where('kode', $id)->first();
        $typeList = $this->typeList();
        $data->images = json_decode($data->images);

        if($data == null) return redirect()->route('service.index')->with('error', Constant::NOT_FOUND);
        return view('admin.service.edit', compact('data', 'typeList'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = Service::where('kode', $id)->first();
        if($data == null) return redirect()->route('service.index')->with('error', Constant::NOT_FOUND);
        $validation = [
            "name" => ["required", "string", "max:100", "min:1"],
            "size" => ["required", "string", "max:100", "min:1"],
            "type" => ["required", "string", "max:100", "min:1"],
            "description" => ["required", "string", "max:100", "min:1"],
            "price" => ["required", "numeric", "min:1"]
        ];

        if($id !== $request->kode) $validation["kode"] = ["required", "string", "max:100", "min:1", "unique:services"];

        $message = [];
        $uploadCount = 0;
        if($request->image0 !== null){
            $uploadCount = 1;
            $validation['image0'] = ["required", "mimes:png,jpg,jpeg", "max:2048"];
            $message['image0.required'] = 'Please upload an image';
            $message['image0.mimes'] = 'Only jpeg,png and jpeg images are allowed';
            $message['image0.max'] = 'Sorry! Maximum allowed size for an image is 2MB';
        }

        if($request->image1 !== null){
            $uploadCount = 2;
            $validation['image1'] = ["required", "mimes:png,jpg,jpeg", "max:2048"];
            $message['image1.required'] = 'Please upload an image';
            $message['image1.mimes'] = 'Only jpeg,png and jpeg images are allowed';
            $message['image1.max'] = 'Sorry! Maximum allowed size for an image is 2MB';
        }

        if($request->image2 !== null){
            $uploadCount = 3;
            $validation['image2'] = ["required", "mimes:png,jpg,jpeg", "max:2048"];
            $message['image2.required'] = 'Please upload an image';
            $message['image2.mimes'] = 'Only jpeg,png and jpeg images are allowed';
            $message['image2.max'] = 'Sorry! Maximum allowed size for an image is 2MB';
        }

        $validator = Validator::make($request->all(), $validation, $message);
        // dd($validator->errors());
        if ($validator->fails()) {
            return redirect()->route('service.edit', $id)->withErrors($validator)->withInput();
        }
        $temp = json_decode($data->images);
        for ($i=0; $i < $uploadCount; $i++) {
            $name = 'image'.$i;
            $fileOri = $request->file($name);
            if($fileOri !== null){
                $imgOri = $temp->images[$i];

                $fileName = time().'_'.$i.'_'.$fileOri->getClientOriginalName();
                $move = $fileOri->move($this->path, $fileName);
                if($move){
                    $temp->images[$i] = $fileName;
                    if(File::exists(public_path($this->path.'/'.$imgOri))){
                        File::delete(public_path($this->path.'/'.$imgOri));
                    }
                }
            }
        }

        try {
            $data->kode = $request->kode;
            $data->name = $request->name;
            $data->size = $request->size;
            $data->type = $request->type;
            $data->description = $request->description;
            $data->price = $request->price;
            $data->images = json_encode($temp);

            $data->save();
            return redirect()->route('service.index')->with('success', Constant::UPDATE_SUCCESS);
        } catch (\Throwable $th) {
            $this->errorLog($th->getMessage());
            dd($th->getMessage());
            return redirect()->route('service.edit', $id)->with('error', Constant::UPDATE_FAIL);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = Service::where('kode', $id)->first();
        if($data == null) return redirect()->route('service.index')->with('error', Constant::NOT_FOUND);

        try {
            $data->delete();
            return redirect()->route('service.index')->with('success', Constant::DESTROY_SUCCESS);
        } catch (\Throwable $th) {
            $this->errorLog($th->getMessage());
            return redirect()->route('service.index')->with('error', Constant::DESTROY_FAIL);
        }
    }
}
