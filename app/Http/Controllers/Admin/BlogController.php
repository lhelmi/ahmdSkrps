<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use config\Constant;
use Illuminate\Support\Facades\Validator;
use App\Http\Traits\Common;
use App\Models\Blog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class BlogController extends Controller
{
    use Common;
    public $obj = 'Blog';
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public string $path = 'admin/image/blogs';

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function index()
    {
        $blogs = Blog::select("*")->orderBy('updated_at', 'desc')->get();
        return view('admin.blog.index', compact('blogs'));
    }

    public function create()
    {
        return view('admin.blog.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "title" => ["required", "string", "max:100", "min:1", "unique:blogs"],
            "description" => ["required", "string", "min:1"],
            "image" => ["required", "mimes:png,jpg,jpeg", "max:2048"],
        ],
        [
            "title.required" => "Judul Harus diisi",
            "title.max" => "Judul maksimal 100!",
            "title.min" => "Judul minimal 1 digit!",
            "title.unique" => "Judul Sudah digunakan!",

            "description.required" => "Deksripsi Harus diisi",
            "description.min" => "Deksripsi minimal 1 digit!",
            "description.unique" => "Deksripsi Sudah digunakan!",

            'image.required' => 'Gambar harus di upload',
            'image.mimes' => 'format gambar yang di perbolehkan adalah jpeg,png dan jpeg',
            'image.max' => 'maksimal ukuran gambar adalah 2MB',
        ]);

        if ($validator->fails()) {
            return redirect()->route('blog.create')->withErrors($validator)->withInput();
        }
        $uploads = $this->moveFile($request->image, $this->path);
        if($uploads == null) return redirect()->route('blog.create')->with('error', $this->messageTemplate(Constant::UPLOAD_FAIL, $this->obj));

        try {
            $data = new Blog();
            $data->title = trim($request->title);
            $data->slug = str_replace(' ', '-', trim($request->title));
            $data->description = $request->description;
            $data->image = $uploads;
            $data->created_by = Auth::user()->username;
            $data->save();
            return redirect()->route('blog.index')->with('success', $this->messageTemplate(Constant::SAVE_SUCCESS, $this->obj));
        } catch (\Throwable $th) {
            $this->errorLog($th->getMessage());
            return redirect()->route('blog.create')->with('error', $this->messageTemplate(Constant::SAVE_FAIL, $this->obj));
        }

    }

    private function moveFile($file, $path, $oldFile = null){
        $result = null;
        $fileName = time().'_'.$file->getClientOriginalName();
        $move = $file->move($path, $fileName);
        if($move){
            if($oldFile !== null){
                if(File::exists(public_path($path.'/'.$oldFile))){
                    File::delete(public_path($path.'/'.$oldFile));
                }
            }
            $result = $path.'/'.$fileName;
        }
        return $result;
    }


    public function edit(string $id)
    {
        $data = Blog::find($id);

        if($data == null) return redirect()->route('blog.index')->with('error', $this->messageTemplate(Constant::NOT_FOUND, $this->obj));
        return view('admin.blog.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = Blog::find($id);
        if($data == null) return redirect()->route('blog.index')->with('error', $this->messageTemplate(Constant::NOT_FOUND, $this->obj));

        $validation = [
            "description" => ["required", "string", "min:1"]
        ];
        if($data->title !== $request->title){
            $validation['title'] = ["required", "string", "max:100", "min:1", "unique:blogs"];
            $message['title.required'] = 'Judul Harus diisi';
            $message['title.min'] = 'Judul minimal 1 digit!';
            $message['title.max'] = 'Judul maksimal 100!';
            $message['title.unique'] = 'Judul Sudah digunakan!';
        }
        $message = [
            "description.required" => "Deksripsi Harus diisi",
            "description.min" => "Deksripsi minimal 1 digit!",
            "description.unique" => "Deksripsi Sudah digunakan!",
        ];
        if($request->image !== null){
            $validation['image'] = ["required", "mimes:png,jpg,jpeg", "max:2048"];

            $message['image.required'] = 'Gambar harus di upload';
            $message['image.mimes'] = 'format gambar yang di perbolehkan adalah jpeg,png dan jpeg';
            $message['image.max'] = 'maksimal ukuran gambar adalah 2MB';
        }

        $validator = Validator::make($request->all(), $validation, $message);
        if ($validator->fails()) {
            return redirect()->route('blog.edit', $id)->withErrors($validator)->withInput();
        }

        $oldFile = explode('/', $data->image);
        $oldFile = last($oldFile);

        if($request->image !== null){
            $upload = $this->moveFile($request->image, $this->path, $oldFile);
            if($upload == null) return redirect()->route('blog.edit', $id)->with('error', $this->messageTemplate(Constant::UPLOAD_FAIL, $this->obj));
        }

        try {
            $data->title = trim($request->title);
            $data->slug = str_replace(' ', '-', trim($request->title));
            $data->description = $request->description;
            $data->image = $upload;

            $data->save();
            return redirect()->route('blog.index')->with('success', $this->messageTemplate(Constant::UPDATE_SUCCESS, $this->obj));
        } catch (\Throwable $th) {
            $this->errorLog($th->getMessage());
            return redirect()->route('blog.edit', $id)->with('error', $this->messageTemplate(Constant::UPDATE_FAIL, $this->obj));
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = Blog::find($id);
        if($data == null) return redirect()->route('blog.index')->with('error', $this->messageTemplate(Constant::NOT_FOUND, $this->obj));
        try {
            $data->delete();
            return redirect()->route('blog.index')->with('success', $this->messageTemplate(Constant::DESTROY_SUCCESS, $this->obj));
        } catch (\Throwable $th) {
            $this->errorLog($th->getMessage());
            return redirect()->route('blog.index')->with('error', $this->messageTemplate(Constant::DESTROY_FAIL, $this->obj));
        }
    }
}
