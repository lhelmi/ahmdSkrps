<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use config\Constant;
use Illuminate\Support\Facades\Validator;
use App\Http\Traits\Common;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\RegisterEmail;

use Illuminate\Support\Facades\Hash;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\VerifiesEmails;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\Events\Verified;

class ProfileController extends Controller
{
    use Common;
    use VerifiesEmails;
    public $obj = 'Profile';
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    // public string $path = 'admin/image/blogs';

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function index()
    {
        $data = User::find(Auth::user()->id);
        return view('auth.profile', compact('data'));
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $data = User::find(Auth::user()->id);
        if($data == null) return redirect()->route('auth.profile.index')->with('error', $this->messageTemplate(Constant::NOT_FOUND, $this->obj));

        $validation = [
            "name" => ["required", "string", "max:100", "min:1"],
            "address" => ["required", "string", "max:100", "min:8"],
        ];

        $message = [
            "name.required" => "Nama Harus diisi",
            "name.max" => "Nama maksimal 100!",
            "name.min" => "Nama minimal 1 digit!",

            "address.required" => "Alamat Harus diisi",
            "address.max" => "Alamat maksimal 100!",
            "address.min" => "Alamat minimal 8 digit!",
        ];
        if($data->email !== $request->email){
            $validation['email'] = ["required", "string", "max:100", "unique:users", "min:8", "email"];

            $message['email.required'] = "email Harus diisi";
            $message['email.max'] = "email maksimal 100!";
            $message['email.min'] = "email minimal 8 digit!";
            $message['email.unique'] = "email sudah digunakan!";
        }

        if($request->password !== null || $request->new_password !== null){
            $validation['password'] = ["required", "string", "max:100", "min:8"];
            $validation['new_password'] = ["required", "string", "max:100", "min:8"];

            $message['password.required'] = "Password Harus diisi";
            $message['password.max'] = "Password maksimal 100!";
            $message['password.min'] = "Password minimal 8 digit!";

            $message['new_password.required'] = "Password Baru Harus diisi";
            $message['new_password.max'] = "Password Baru maksimal 100!";
            $message['new_password.min'] = "Password Baru minimal 8 digit!";
        }

        $validator = Validator::make($request->all(), $validation, $message);
        if ($validator->fails()) {
            return redirect()->route('auth.profile.index')->withErrors($validator)->withInput();
        }

        if($request->password !== null && $request->new_password !== null){
            if(!Hash::check($request->password, $data->password)){
                return redirect()->route('auth.profile.index')->with('error', "Password lama salah!");
            }
        }

        try {
            $data->name = $request->name;
            $data->address = $request->address;
            if($request->password !== null && $request->new_password !== null){
                $data->password = bcrypt($request->new_password);
            }
            if($data->email !== $request->email){
                $data->email_verified_at = null;
                $data->remember_token = null;
                $data->email = $request->email;
            }

            $data->save();
            if($request->password !== null && $request->new_password !== null){
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
            }

            return redirect()->route('auth.profile.index')->with('success', $this->messageTemplate(Constant::UPDATE_SUCCESS, $this->obj));
        } catch (\Throwable $th) {
            $this->errorLog($th->getMessage());
            return redirect()->route('auth.profile.index')->with('error', $this->messageTemplate(Constant::UPDATE_FAIL, $this->obj));
        }
    }

    // public function verify(Request $request)
    // {
    //     if (! hash_equals((string) $request->route('id'), (string) $request->user()->getKey())) {
    //         throw new AuthorizationException;
    //     }

    //     if (! hash_equals((string) $request->route('hash'), sha1($request->user()->getEmailForVerification()))) {
    //         throw new AuthorizationException;
    //     }

    //     if ($request->user()->hasVerifiedEmail()) {
    //         $request->user()->hasVerifiedEmail();
    //     }

    //     if ($request->user()->markEmailAsVerified()) {
    //         event(new Verified($request->user()));
    //     }

    //     if ($this->verified($request)) {
    //         $this->verified($request);
    //     }
    // }
}
