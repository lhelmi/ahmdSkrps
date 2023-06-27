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
            "title" => ["required", "string", "max:100", "min:1"],
            "description" => ["required", "string", "max:100", "min:1"],
            "image" => ["required", "mimes:png,jpg,jpeg", "max:2048"],
        ],
        [
            'image.required' => 'Please upload an image',
            'image.mimes' => 'Only jpeg,png and jpeg image are allowed',
            'image.max' => 'Sorry! Maximum allowed size for an image is 2MB',
        ]);

        if ($validator->fails()) {
            return redirect()->route('blog.create')->withErrors($validator)->withInput();
        }
        $uploads = $this->moveFile($request->image, $this->path);
        if($uploads == null) return redirect()->route('blog.create')->with('error', Constant::UPLOAD_FAIL);

        try {
            $data = new Blog();
            $data->title = $request->title;
            $data->description = $request->description;
            $data->image = $uploads;
            $data->created_by = Auth::user()->username;
            $data->save();
            return redirect()->route('blog.index')->with('success', Constant::SAVE_SUCCESS);
        } catch (\Throwable $th) {
            $this->errorLog($th->getMessage());
            return redirect()->route('blog.create')->with('error', Constant::SAVE_FAIL);
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

        if($data == null) return redirect()->route('blog.index')->with('error', Constant::NOT_FOUND);
        return view('admin.blog.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = Blog::find($id);
        if($data == null) return redirect()->route('blog.index')->with('error', Constant::NOT_FOUND);
        $validation = [
            "title" => ["required", "string", "max:100", "min:1"],
            "description" => ["required", "string", "max:100", "min:1"]
        ];

        $message = [];
        if($request->image !== null){
            $validation['image'] = ["required", "mimes:png,jpg,jpeg", "max:2048"];
            $message['image.required'] = 'Please upload an image';
            $message['image.mimes'] = 'Only jpeg,png and jpeg image are allowed';
            $message['image.max'] = 'Sorry! Maximum allowed size for an image is 2MB';
        }

        $validator = Validator::make($request->all(), $validation, $message);
        if ($validator->fails()) {
            return redirect()->route('blog.edit', $id)->withErrors($validator)->withInput();
        }

        $oldFile = explode('/', $data->image);
        $oldFile = last($oldFile);

        if($request->image !== null){
            $upload = $this->moveFile($request->image, $this->path, $oldFile);
            if($upload == null) return redirect()->route('blog.edit', $id)->with('error', Constant::UPLOAD_FAIL);
        }

        try {
            $data->title = $request->title;
            $data->description = $request->description;
            $data->image = $upload;

            $data->save();
            return redirect()->route('blog.index')->with('success', Constant::UPDATE_SUCCESS);
        } catch (\Throwable $th) {
            $this->errorLog($th->getMessage());
            return redirect()->route('blog.edit', $id)->with('error', Constant::UPDATE_FAIL);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = Blog::find($id);
        if($data == null) return redirect()->route('blog.index')->with('error', Constant::NOT_FOUND);
        try {
            $data->delete();
            return redirect()->route('blog.index')->with('success', Constant::DESTROY_SUCCESS);
        } catch (\Throwable $th) {
            $this->errorLog($th->getMessage());
            return redirect()->route('blog.index')->with('error', Constant::DESTROY_FAIL);
        }
    }
}
