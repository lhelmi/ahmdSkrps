<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use config\Constant;
use Illuminate\Support\Facades\Validator;
use App\Http\Traits\Common;
use App\Models\Media;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class MediaController extends Controller
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

    public string $path = 'admin/image/medias';

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function index()
    {
        $medias = Media::select("*")->orderBy('updated_at', 'desc')->get();
        return view('admin.media.index', compact('medias'));
    }

    public function create()
    {
        return view('admin.media.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "name" => ["required", "string", "max:100", "min:1"],
            "file" => ["required", "mimes:png,jpg,jpeg", "max:2048"],
        ],
        [
            'file.required' => 'Please upload an image',
            'file.mimes' => 'Only jpeg,png and jpeg image are allowed',
            'file.max' => 'Sorry! Maximum allowed size for an image is 2MB',
        ]);

        if ($validator->fails()) {
            return redirect()->route('media.create')->withErrors($validator)->withInput();
        }
        $uploads = $this->moveFile($request->file, $this->path);
        if($uploads == null) return redirect()->route('media.create')->with('error', Constant::UPLOAD_FAIL);

        try {
            $data = new Media();
            $data->name = $request->name;
            $data->file = $uploads;
            $data->created_by = Auth::user()->username;
            $data->save();
            return redirect()->route('media.index')->with('success', Constant::SAVE_SUCCESS);
        } catch (\Throwable $th) {
            $this->errorLog($th->getMessage());
            return redirect()->route('media.create')->with('error', Constant::SAVE_FAIL);
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
        $data = Media::find($id);
        if($data == null) return redirect()->route('media.index')->with('error', Constant::NOT_FOUND);
        return view('admin.media.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = Media::find($id);
        if($data == null) return redirect()->route('media.index')->with('error', Constant::NOT_FOUND);
        $validation = [
            "name" => ["required", "string", "max:100", "min:1"],
        ];

        $message = [];
        if($request->file !== null){
            $validation['file'] = ["required", "mimes:png,jpg,jpeg", "max:2048"];
            $message['file.required'] = 'Please upload an image';
            $message['file.mimes'] = 'Only jpeg,png and jpeg image are allowed';
            $message['file.max'] = 'Sorry! Maximum allowed size for an image is 2MB';
        }

        $validator = Validator::make($request->all(), $validation, $message);

        if ($validator->fails()) {
            return redirect()->route('media.edit', $id)->withErrors($validator)->withInput();
        }

        $oldFile = explode('/', $data->file);
        $oldFile = last($oldFile);

        if($request->file !== null){
            $upload = $this->moveFile($request->file, $this->path, $oldFile);
            if($upload == null) return redirect()->route('media.edit', $id)->with('error', Constant::UPLOAD_FAIL);
        }

        try {
            $data->name = $request->name;
            $data->file = $upload;

            $data->save();
            return redirect()->route('media.index')->with('success', Constant::UPDATE_SUCCESS);
        } catch (\Throwable $th) {
            $this->errorLog($th->getMessage());
            return redirect()->route('media.edit', $id)->with('error', Constant::UPDATE_FAIL);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = Media::find($id);
        if($data == null) return redirect()->route('media.index')->with('error', Constant::NOT_FOUND);
        try {
            $data->delete();
            return redirect()->route('media.index')->with('success', Constant::DESTROY_SUCCESS);
        } catch (\Throwable $th) {
            $this->errorLog($th->getMessage());
            return redirect()->route('media.index')->with('error', Constant::DESTROY_FAIL);
        }
    }
}
