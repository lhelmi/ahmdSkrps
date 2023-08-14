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
    public $obj = 'User';
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

        ],
        [
            "name.required" => "Nama Harus diisi",
            "name.max" => "Nama maksimal 100!",
            "name.min" => "Nama minimal 1 digit!",

            "address.required" => "Alamat Harus diisi",
            "address.max" => "Alamat maksimal 100!",
            "address.min" => "Alamat minimal 1 digit!",

            "username.required" => "Nama Harus diisi",
            "username.max" => "Nama maksimal 100!",
            "username.min" => "Nama minimal 8 digit!",
            "username.unique" => "Nama Sudah digunakan!",

            "email.required" => "email Harus diisi",
            "email.max" => "email maksimal 100!",
            "email.min" => "email minimal 6 digit!",
            "email.unique" => "email Sudah digunakan!",

            "birth_date.required" => "Tanggal Lahir Harus diisi",
            "birth_date.max" => "Tanggal Lahir maksimal 100!",
            "birth_date.min" => "Tanggal Lahir minimal 6 digit!",

            "birth_place.required" => "Tempat Lahir Harus diisi",
            "birth_place.max" => "Tempat Lahir maksimal 100!",
            "birth_place.min" => "Tempat Lahir minimal 6 digit!",
            "birth_place.unique" => "Tempat Lahir Sudah digunakan!",

            "password.required" => "Password Harus diisi",
            "password.max" => "Password maksimal 100!",
            "password.min" => "Password minimal 8 digit!",
            "password.confirmed" => "Password Tidak Sama Dengan Konfirm Password!",

            "password_confirmation.required" => "Password Harus diisi",
            "password_confirmation.max" => "Password maksimal 100!",
            "password_confirmation.min" => "Password minimal 8 digit!",

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
            return redirect()->route('user.index')->with('success', $this->messageTemplate(Constant::SAVE_SUCCESS, $this->obj));
        } catch (\Throwable $th) {
            $this->errorLog($th->getMessage());
            return redirect()->route('user.create')->with('error', $this->messageTemplate(Constant::SAVE_FAIL, $this->obj));
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

        $message = [
            "name.required" => "Nama Harus diisi",
            "name.max" => "Nama maksimal 100!",
            "name.min" => "Nama minimal 1 digit!",

            "address.required" => "Alamat Harus diisi",
            "address.max" => "Alamat maksimal 100!",
            "address.min" => "Alamat minimal 1 digit!",

            "username.required" => "Nama Harus diisi",
            "username.max" => "Nama maksimal 100!",
            "username.min" => "Nama minimal 8 digit!",
            "username.unique" => "Nama Sudah digunakan!",

            "email.required" => "email Harus diisi",
            "email.max" => "email maksimal 100!",
            "email.min" => "email minimal 6 digit!",
            "email.unique" => "email Sudah digunakan!",

            "birth_date.required" => "Tanggal Lahir Harus diisi",
            "birth_date.max" => "Tanggal Lahir maksimal 100!",
            "birth_date.min" => "Tanggal Lahir minimal 6 digit!",

            "birth_place.required" => "Tempat Lahir Harus diisi",
            "birth_place.max" => "Tempat Lahir maksimal 100!",
            "birth_place.min" => "Tempat Lahir minimal 6 digit!",
            "birth_place.unique" => "Tempat Lahir Sudah digunakan!"
        ];

        if($data->email !== $request->email) array_push($param['email'], "unique:users");
        if($data->username !== $request->username) array_push($param['username'], "unique:users");

        if($request->password) {
            $param['password'] = ["required", "string", "max:100", "confirmed", "min:8"];
            $param['password_confirmation'] = ["required", "string", "max:100", "min:8"];

            $message['password.required'] = "Password Harus diisi";
            $message['password.max'] = "Password maksimal 100!";
            $message['password.min'] = "Password minimal 8 digit!";
            $message['password.confirmed'] = "Password Tidak Sama Dengan Konfirm Password!";

            $message['password_confirmation.required'] = "Password Harus diisi";
            $message['password_confirmation.max'] = "Password maksimal 100!";
            $message['password_confirmation.min'] = "Password minimal 8 digit!";
            $message['password_confirmation.confirmed'] = "Password Tidak Sama Dengan Konfirm Password!";
        }

        $validator = Validator::make($request->all(), $param, $message);

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
            return redirect()->route('user.index')->with('success', $this->messageTemplate(Constant::UPDATE_SUCCESS, $this->obj));
        } catch (\Throwable $th) {
            $this->errorLog($th->getMessage());
            return redirect()->route('user.edit', $id)->with('error', $this->messageTemplate(Constant::UPDATE_FAIL, $this->obj));
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = User::find($id);
        if($data == null) return redirect()->route('user.index')->with('error', $this->messageTemplate(Constant::NOT_FOUND, $this->obj));

        try {
            $data->delete();
            return redirect()->route('user.index')->with('success', $this->messageTemplate(Constant::DESTROY_SUCCESS, $this->obj));
        } catch (\Throwable $th) {
            $this->errorLog($th->getMessage());
            return redirect()->route('user.index')->with('error', $this->messageTemplate(Constant::DESTROY_FAIL, $this->obj));
        }
    }
}
