<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use config\Constant;
use Illuminate\Support\Facades\Validator;
use App\Http\Traits\Common;

class AdminController extends Controller
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
    public function index()
    {
        $users = User::where('role', '0')->get();
        return view('admin.admin.index', compact('users'));
    }

    public function create()
    {
        return view('admin.admin.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "name" => ["required", "string", "max:100", "min:1"],
            "username" => ["required", "string", "max:100", "unique:users", "min:8"],
            "email" => ["required", "string", "max:100", "unique:users", "min:1", "email"],
            "password" => ["required", "string", "max:100", "confirmed", "min:8"],
            "password_confirmation" => ["required", "string", "max:100", "min:8"]

        ]);

        if ($validator->fails()) {
            return redirect()->route('admin.create')->withErrors($validator)->withInput();
        }

        try {
            $data = new User();
            $data->name = $request->name;
            $data->username = $request->username;
            $data->email = $request->email;
            $data->password = bcrypt($request->password);
            $data->role = '0';
            $data->save();
            return redirect()->route('admin.index')->with('success', Constant::SAVE_SUCCESS);
        } catch (\Throwable $th) {
            $this->errorLog($th->getMessage());
            return redirect()->route('admin.create')->with('error', Constant::SAVE_FAIL);
        }

    }

    public function edit(string $id)
    {
        $data = User::find($id);
        return view('admin.admin.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = User::find($id);
        $param = [
            "name" => ["required", "string", "max:100", "min:1"],
            "username" => ["required", "string", "max:100", "min:8"],
            "email" => ["required", "string", "max:100","min:1", "email"],
        ];

        if($data->email !== $request->email) array_push($param['email'], "unique:users");
        if($data->username !== $request->username) array_push($param['username'], "unique:users");

        if($request->password) {
            $param['password'] = ["required", "string", "max:100", "confirmed", "min:8"];
            $param['password_confirmation'] = ["required", "string", "max:100", "min:8"];
        }

        $validator = Validator::make($request->all(), $param);

        if ($validator->fails()) {
            return redirect()->route('admin.edit', $id)->withErrors($validator)->withInput();
        }

        try {
            $data->name = $request->name;
            $data->username = $request->username;
            $data->email = $request->email;
            if($request->password !== "" || $request->password !== null) $data->password = bcrypt($request->password);

            $data->save();
            return redirect()->route('admin.index')->with('success', Constant::UPDATE_SUCCESS);
        } catch (\Throwable $th) {
            $this->errorLog($th->getMessage());
            return redirect()->route('admin.edit', $id)->with('error', Constant::UPDATE_FAIL);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = User::find($id);
        if($data == null) return redirect()->route('admin.index')->with('error', Constant::NOT_FOUND);

        try {
            $data->delete();
            return redirect()->route('admin.index')->with('success', Constant::DESTROY_SUCCESS);
        } catch (\Throwable $th) {
            $this->errorLog($th->getMessage());
            return redirect()->route('admin.index')->with('error', Constant::DESTROY_FAIL);
        }
    }
}
