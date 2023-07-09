<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use config\Constant;
use Illuminate\Support\Facades\Validator;
use App\Http\Traits\Common;

class UserController extends Controller
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
        $users = User::where('role', '2')->get();
        return view('admin.user.index', compact('users'));
    }

    public function create()
    {
        return view('admin.user.create');
    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            "name" => ["required", "string", "max:100", "min:1"],
            "username" => ["required", "string", "max:100", "unique:users", "min:8"],
            "email" => ["required", "string", "max:100", "unique:users", "min:1", "email"],
            "birth_date" => ["required", "string", "max:100", "min:6"],
            "birth_place" => ["required", "string", "max:100", "min:3"],
            "address" => ["required", "string", "max:100", "min:8"],

            "password" => ["required", "string", "max:100", "confirmed", "min:8"],
            "password_confirmation" => ["required", "string", "max:100", "min:8"]

        ]);

        if ($validator->fails()) {
            return redirect()->route('user.create')->withErrors($validator)->withInput();
        }

        try {
            $data = new User();
            $data->name = $request->name;
            $data->username = $request->username;
            $data->email = $request->email;
            $data->password = bcrypt($request->password);
            $data->birth_date = $request->birth_date;
            $data->birth_place = $request->birth_place;
            $data->address = $request->address;
            $data->role = '2';
            $data->save();
            return redirect()->route('user.index')->with('success', Constant::SAVE_SUCCESS);
        } catch (\Throwable $th) {
            $this->errorLog($th->getMessage());
            return redirect()->route('user.create')->with('error', Constant::SAVE_FAIL);
        }

    }

    public function edit(string $id)
    {
        $data = User::find($id);
        return view('admin.user.edit', compact('data'));
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
            "birth_date" => ["required", "string", "max:100", "min:6"],
            "birth_place" => ["required", "string", "max:100", "min:3"],
            "address" => ["required", "string", "max:100", "min:8"],
        ];

        if($data->email !== $request->email) array_push($param['email'], "unique:users");
        if($data->username !== $request->username) array_push($param['username'], "unique:users");

        if($request->password) {
            $param['password'] = ["required", "string", "max:100", "confirmed", "min:8"];
            $param['password_confirmation'] = ["required", "string", "max:100", "min:8"];
        }

        $validator = Validator::make($request->all(), $param);

        if ($validator->fails()) {
            return redirect()->route('user.edit', $id)->withErrors($validator)->withInput();
        }

        try {
            $data->name = $request->name;
            $data->username = $request->username;
            $data->email = $request->email;
            $data->birth_date = $request->birth_date;
            $data->birth_place = $request->birth_place;
            $data->address = $request->address;
            if($request->password !== "" || $request->password !== null) $data->password = bcrypt($request->password);

            $data->save();
            return redirect()->route('user.index')->with('success', Constant::UPDATE_SUCCESS);
        } catch (\Throwable $th) {
            $this->errorLog($th->getMessage());
            return redirect()->route('user.edit', $id)->with('error', Constant::UPDATE_FAIL);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = User::find($id);
        if($data == null) return redirect()->route('user.index')->with('error', Constant::NOT_FOUND);

        try {
            $data->delete();
            return redirect()->route('user.index')->with('success', Constant::DESTROY_SUCCESS);
        } catch (\Throwable $th) {
            $this->errorLog($th->getMessage());
            return redirect()->route('user.index')->with('error', Constant::DESTROY_FAIL);
        }
    }
}
