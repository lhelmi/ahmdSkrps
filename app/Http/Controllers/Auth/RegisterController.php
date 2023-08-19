<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use config\Constant;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\JsonResponse;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    // protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */

    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        event(new Registered($user = $this->create($request->all())));

        // $this->guard()->login($user);

        if ($response = $this->registered($request, $user)) {
            return $response;
        }

        return $request->wantsJson()
                    ? new JsonResponse([], 201)
                    : redirect($this->redirectPath());
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:100', "min:1"],
            'username' => ['required', 'string', 'max:100', 'unique:users', "min:8"],
            'email' => ['required', 'string', 'email', 'max:100', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'birth_date' => ['required', 'string', 'max:100', "min:1"],
            'birth_place' => ['required', 'string', 'max:100', "min:1"],
            'address' => ['required', 'string', 'max:100', "min:1"],
        ],
        [
            "name.required" => "Nama Harus diisi",
            "name.max" => "Nama maksimal 100!",
            "name.min" => "Nama minimal 1 digit!",

            "address.required" => "Alamat Harus diisi",
            "address.max" => "Alamat maksimal 100!",
            "address.min" => "Alamat minimal 1 digit!",

            "username.required" => "Username Harus diisi",
            "username.max" => "Username maksimal 100!",
            "username.min" => "Username minimal 8 digit!",
            "username.unique" => "Username Sudah digunakan!",

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
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        $post = [
            'name' => $data['name'],
            'email' => $data['email'],
            'username' => $data['username'],
            'birth_date' => $data['birth_date'],
            'birth_place' => $data['birth_place'],
            'address' => $data['address'],
            'password' => Hash::make($data['password']),
            'role' => "2",
        ];

        return User::create($post);
    }

    protected function registered(Request $request, $user)
    {
        return redirect()->route('login')->with('success', "Registrasi Berhasil!");
    }
}
