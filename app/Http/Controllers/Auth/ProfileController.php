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
        if($data == null) return redirect()->route('auth.profile.index')->with('error', Constant::NOT_FOUND);

        $validation = [
            "name" => ["required", "string", "max:100", "min:1"],
            "address" => ["required", "string", "max:100", "min:8"],
        ];
        if($data->email !== $request->email) $validation['email'] = ["required", "string", "max:100", "unique:users", "min:1", "email"];

        if($request->password !== null || $request->new_password !== null){
            $validation['password'] = ["required", "string", "max:100", "min:8"];
            $validation['new_password'] = ["required", "string", "max:100", "min:8"];
        }

        $validator = Validator::make($request->all(), $validation);
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
            return redirect()->route('auth.profile.index')->with('success', Constant::UPDATE_SUCCESS);
        } catch (\Throwable $th) {
            $this->errorLog($th->getMessage());
            return redirect()->route('auth.profile.index')->with('error', Constant::UPDATE_FAIL);
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
