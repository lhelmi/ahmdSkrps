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
    public $obj = 'Jasa';
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

    private function setKode($name, $type){
        $list = $this->typeList();
        $kode = 'UNL';
        foreach ($list as $key => $value) {
            if($key == $type) $kode = $value;
        }
        $name = trim(str_replace('PEMASANGAN', ' ', strtoupper($name)));
        $nameCode = explode(' ', $name);
        $temp = "";
        for ($i=0; $i < count($nameCode); $i++) {
            if($i < 3) $temp = $temp . substr($nameCode[$i], 0, 1);
        }
        $nameCode = strtoupper(trim($temp));

        $number = $this->getNumber();
        $number = (integer)$number->id + 1;
        $kode = $nameCode.'-'.$kode.'-'.$number;

        return $kode;
    }

    public function index()
    {
        $services = Service::select("*")->orderBy('updated_at', 'desc')->get();
        foreach ($services as $key => $value) {
            $services[$key]->size = json_decode($services[$key]->size);
            $size = '';
            foreach ($services[$key]->size as $key1 => $value1) {
                if($value1 !== '' && $value1 !== null){
                    if($size !== '') $size = $size. " X ";
                    $size = $size . $value1;
                }
            }
            $services[$key]->size = $size;
        }
        return view('admin.service.index', compact('services'));
    }

    public function detail(string $id)
    {
        $data = Service::where('kode', $id)->first();
        $typeList = $this->typeList();

        if($data == null) return redirect()->route('service.index')->with('error', $this->messageTemplate(Constant::NOT_FOUND, $this->obj));
        $data->images = json_decode($data->images);
        $data->size = json_decode($data->size);
        $data->length = $data->size->length;
        $data->width = $data->size->width;
        $data->height = $data->size->height;
        return view('admin.service.detail', compact('data'));
    }

    public function create()
    {
        $typeList = $this->typeList();
        return view('admin.service.create', compact('typeList'));
    }

    public function store(Request $request)
    {
        $validation = [
            // "kode" => ["required", "string", "max:100", "min:1", "unique:services", "regex:/(?!^\d+$)^.+$/"],
            "kode" => ["required", "string", "max:100", "min:1", "unique:services"],
            "kode-name" => ["required", "string", "max:3", "min:1"],
            "kode-type" => ["required", "string", "max:3", "min:1"],
            "kode-number" => ["required", "string", "max:3", "min:1"],

            "name" => ["required", "string", "max:100", "min:1"],
            "length" => ["required", "string", "max:1000", "min:1"],
            "type" => ["required", "string"],
            "description" => ["required", "string", "min:1"],
            "price" => ["required", "numeric", "min:1"],
            "images" => ["required","array","min:1","max:3"],
            "images.*" => ["required", "mimes:png,jpg,jpeg", "max:2048"],
        ];

        $message = [
            // "kode.regex" => "Kode harus mengandung angka dan huruf saja!",
            "kode.unique" => "Kode Produk Sudah digunakan!",
            "kode.max" => "Kode maksimal 100 digit!",
            "kode.min" => "Kode minimal 1 digit!",
            "kode.required" => "Kode harus diisi!",

            "kode-type.max" => "Tipe Kode maksimal 3 digit!",
            "kode-type.min" => "Tipe Kode minimal 1 digit!",
            "kode-type.required" => "Tipe Kode harus diisi!",

            "kode-name.max" => "Nama Kode maksimal 3 digit!",
            "kode-name.min" => "Nama Kode minimal 1 digit!",
            "kode-name.required" => "Nama Kode harus diisi!",

            "kode-number.max" => "Nomor Kode maksimal 3 digit!",
            "kode-number.min" => "Nomor Kode minimal 1 digit!",
            "kode-number.required" => "Nomor Kode harus diisi!",

            "name.max" => "Nama maksimal 100 digit!",
            "length.max" => "Panjang maksimal 1000m!",
            "images.max" => "Gambar maksimal 3!",


            "name.min" => "Nama minimal 1 digit!",
            "length.min" => "Panjang minimal 1m!",
            "description.min" => "Deskripsi minimal 1 digit!",
            "price.min" => "Harga minimal 1!",
            "images.min" => "Gambar minimal 1!",
            "price.numeric" => "Harga harus angka!",


            "name.required" => "Nama harus diisi!",
            "length.required" => "Panjang harus diisi!",
            "type.required" => "Tipe harus diisi!",
            "description.required" => "Deskripsi harus diisi!",
            "price.required" => "Panjang harus diisi!",
            "images.required" => "Gambar harus diisi!",

            'images.*.required' => 'Gambar Harus diisi',
            'images.*.mimes' => 'format gambar yang di perbolehkan adalah jpeg,png dan jpeg',
            'images.*.max' => 'maksimal ukuran gambar adalah 2MB',
        ];
        if($request->height !== null){
            $validation['height'] = ["required", "numeric", "max:100", "min:1"];
            $message['height.required'] = "Tinggi Harus diisi";
            $message['height.max'] = "Tinggi maksimal 100m!";
            $message['height.min'] = "Tinggi minimal 1m!";
        }
        if($request->width !== null){
            $validation['width'] = ["required", "numeric", "max:1000", "min:1"];
            $message['width.required'] = "Panjang Harus diisi";
            $message['width.max'] = "Tinggi maksimal 100m!";
            $message['width.min'] = "Panjang minimal 1m!";
        }
        $validator = Validator::make($request->all(), $validation, $message);
        // dd($validator->errors());
        if ($validator->fails()) {
            return redirect()->route('service.create')->withErrors($validator)->withInput();
        }

        $uploads = $this->moveFile($request->images, $this->path);
        if(count($uploads) == 0) return redirect()->route('service.create')->with('error', $this->messageTemplate(Constant::UPLOAD_FAIL, $this->obj));

        try {
            $data = new Service();
            $data->kode = $request->kode;
            // $data->kode = $this->setKode($request->name, $request->type);
            $data->name = $request->name;
            $size = [
                'length' => $request->length,
                'width' => $request->width,
                'height' => $request->height,
            ];
            $size = json_encode($size);
            $data->size = $size;
            $data->type = $request->type;
            $data->description = $request->description;
            $data->price = $request->price;
            $data->images = json_encode($uploads);
            $data->created_by = Auth::user()->username;
            $data->save();
            return redirect()->route('service.index')->with('success', $this->messageTemplate(Constant::SAVE_SUCCESS, $this->obj));
        } catch (\Throwable $th) {
            $this->errorLog($th->getMessage());
            return redirect()->route('service.create')->with('error', $this->messageTemplate(Constant::SAVE_FAIL, $this->obj));
        }

    }

    public function checkKode(string $kode){
        try {
            $newKode = substr($kode, 0, 6);
            $count = Service::whereRaw("left(kode, 6) = ?", [$newKode])->count();
            return response()->json([ 'status' => 200, 'message' => 'Kode', 'data' => $count ], 200);
        } catch (\Throwable $th) {
            $this->errorLog($th->getMessage());
            // dd($th->getMessage());
            return response()->json([ 'status' => 400, 'message' => 'Error', 'data' => null ], 500);
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
        if($data == null) return redirect()->route('service.index')->with('error', $this->messageTemplate(Constant::NOT_FOUND, $this->obj));
        $typeList = $this->typeList();
        $data->images = json_decode($data->images);
        $data->size = json_decode($data->size);
        $data->length = $data->size->length;
        $data->width = $data->size->width;
        $data->height = $data->size->height;
        $kodeTemp = explode('-', $data->kode);
        $data->kodeName = $kodeTemp[0];
        $data->kodeType = $kodeTemp[1];
        $data->kodeNumber = $kodeTemp[2];
        return view('admin.service.edit', compact('data', 'typeList'));
    }

    public function verify(string $id)
    {
        $data = Service::where('kode', $id)->first();
        if($data == null) return redirect()->route('service.index')->with('error', $this->messageTemplate(Constant::NOT_FOUND, $this->obj));

        try {
            if(strtoupper($data->verify_description) == strtoupper("hapus data")){
                $data->delete();
                return redirect()->route('service.index')->with('success', 'Data Jasa Berhasil Dihapus');
            }
            $data->is_verify = $data->is_verify == '0' ? '1' : '0';
            $data->save();
            return redirect()->route('service.index')->with('success', 'Data Jasa Berhasil Disetujui');
        } catch (\Throwable $th) {
            $this->errorLog($th->getMessage());
            // dd($th->getMessage());
            return redirect()->route('service.edit', $id)->with('error', $this->messageTemplate(Constant::UPDATE_FAIL, $this->obj));
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = Service::where('kode', $id)->first();
        if($data == null) return redirect()->route('service.index')->with('error', $this->messageTemplate(Constant::NOT_FOUND, $this->obj));
        $validation = [
            "name" => ["required", "string", "max:100", "min:1"],
            "type" => ["required", "string", "max:100", "min:1"],
            "description" => ["required", "string", "min:1"],
            "price" => ["required", "numeric", "min:1"],
            "length" => ["required", "string", "max:100", "min:1"],

            "kode-name" => ["required", "string", "max:3", "min:1"],
            "kode-type" => ["required", "string", "max:3", "min:1"],
            "kode-number" => ["required", "string", "max:3", "min:1"],
        ];
        $message = [
            "name.max" => "Nama maksimal 100 digit!",
            "length.max" => "Panjang maksimal 1000m!",
            "images.max" => "Gambar maksimal 3!",

            "name.min" => "Nama minimal 1 digit!",
            "length.min" => "Panjang minimal 1m!",
            "description.min" => "Deskripsi minimal 1 digit!",
            "price.min" => "Harga minimal 1!",
            "images.min" => "Gambar minimal 1!",

            "price.numeric" => "Harga harus angka!",

            "kode.required" => "Kode harus diisi!",
            "name.required" => "Nama harus diisi!",
            "length.required" => "Panjang harus diisi!",
            "description.required" => "Deskripsi harus diisi!",
            "price.required" => "Panjang harus diisi!",

            "kode-type.max" => "Tipe Kode maksimal 3 digit!",
            "kode-type.min" => "Tipe Kode minimal 1 digit!",
            "kode-type.required" => "Tipe Kode harus diisi!",

            "kode-name.max" => "Nama Kode maksimal 3 digit!",
            "kode-name.min" => "Nama Kode minimal 1 digit!",
            "kode-name.required" => "Nama Kode harus diisi!",

            "kode-number.max" => "Nomor Kode maksimal 3 digit!",
            "kode-number.min" => "Nomor Kode minimal 1 digit!",
            "kode-number.required" => "Nomor Kode harus diisi!",
        ];

        if($id !== $request->kode){
            $validation["kode"] = ["required", "string", "max:100", "min:1", "unique:services"];
            $message["kode.regex"] = "Kode harus mengandung angka dan huruf saja!";
            $message["kode.unique"] = "Kode Produk Sudah digunakan!";
            $message["kode.max"] = "Kode maksimal 100 digit!";
            $message["kode.min"] = "Kode minimal 1 digit!";
        }

        if($request->height !== null){
            $validation['height'] = ["required", "numeric", "max:100", "min:1"];
            $message['height.required'] = "Tinggi Harus diisi";
            $message['height.max'] = "Tinggi maksimal 100m!";
            $message['height.min'] = "Tinggi minimal 1m!";
        }

        if($request->width !== null){
            $validation['width'] = ["required", "numeric", "max:1000", "min:1"];
            $message['width.required'] = "Panjang Harus diisi";
            $message['width.max'] = "Tinggi maksimal 100m!";
            $message['width.min'] = "Panjang minimal 1m!";
        }

        $uploadCount = 0;
        if($request->image0 !== null){
            $uploadCount = 1;
            $validation['image0'] = ["required", "mimes:png,jpg,jpeg", "max:2048"];
            $message['image0.required'] = 'Tinggi Harus diisi';
            $message['image0.mimes'] = 'Tinggi maksimal 100m!';
            $message['image0.max'] = 'Tinggi minimal 1m!';
        }

        if($request->image1 !== null){
            $uploadCount = 2;
            $validation['image1'] = ["required", "mimes:png,jpg,jpeg", "max:2048"];
            $message['image1.required'] = 'Tinggi Harus diisi';
            $message['image1.mimes'] = 'Tinggi maksimal 100m!';
            $message['image1.max'] = 'Tinggi minimal 1m!';
        }

        if($request->image2 !== null){
            $uploadCount = 3;
            $validation['image2'] = ["required", "mimes:png,jpg,jpeg", "max:2048"];
            $message['image2.required'] = 'Tinggi Harus diisi';
            $message['image2.mimes'] = 'Tinggi maksimal 100m!';
            $message['image2.max'] = 'Tinggi minimal 1m!';
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
            if($data->name !== $request->name || $data->type !== $request->type){
                // $data->kode = $this->setKode($request->name, $request->type);
                // $data->kode = $request->kode;
            }
            $data->kode = $request->kode;
            $data->name = $request->name;
            $size = [
                'length' => $request->length,
                'width' => $request->width,
                'height' => $request->height,
            ];
            $size = json_encode($size);
            $data->size = $size;
            $data->is_verify = '0';
            $data->verify_description = "ubah data";
            $data->type = $request->type;
            $data->description = $request->description;
            $data->price = $request->price;
            $data->images = json_encode($temp);

            $data->save();
            return redirect()->route('service.index')->with('success', $this->messageTemplate(Constant::UPDATE_SUCCESS, $this->obj));
        } catch (\Throwable $th) {
            // dd($th->getMessage());
            $this->errorLog($th->getMessage());
            return redirect()->route('service.edit', $id)->with('error', $this->messageTemplate(Constant::UPDATE_FAIL, $this->obj));
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = Service::where('kode', $id)->first();
        if($data == null) return redirect()->route('service.index')->with('error', $this->messageTemplate(Constant::NOT_FOUND, $this->obj));

        try {
            if(Auth::user()->role == '0'){
                $data->is_verify = '0';
                $data->verify_description = "hapus data";
                $data->save();
                return redirect()->route('service.index')->with('success', "Data Jasa Berhasil Diubah");
            }
            $data->delete();
            return redirect()->route('service.index')->with('success', $this->messageTemplate(Constant::DESTROY_SUCCESS, $this->obj));
        } catch (\Throwable $th) {
            $this->errorLog($th->getMessage());
            return redirect()->route('service.index')->with('error', $this->messageTemplate(Constant::DESTROY_FAIL, $this->obj));
        }
    }
}
