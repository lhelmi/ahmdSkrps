<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Traits\Common;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Carbon\Carbon;
use config\Constant;
use DateTime;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth as AuthSupport;

class ConfirmController extends Controller
{
    use Common;

    public function __construct()
    {
        // $this->middleware('guest')->except('logout');
    }

    public function verifyEmail(String $link)
    {
        $link = base64_decode($link);
        $link = json_decode($link);
        $date1 = new DateTime($link->sended_at);
        $date2 = new DateTime(date('Y-m-d'));
        $diff = $date1->diff($date2);
        if($diff->days > 0) return redirect()->route('login')->with('error', "Token Sudah kadarluasa!");
        $user = User::where('username', $link->username)
        ->where('email', $link->email)
        ->first();
        if(!$user) return redirect()->route('login')->with('error', "User tidak ditemukan!");
        try {
            $user = User::find($user->id);
            $user->email_verified_at = Carbon::now();
            $user->save();
            return redirect()->route('login')->with('error', "Verifikasi Email Berhasil, Silahkan Login");
        } catch (\Throwable $th) {
            $this->errorLog($th->getMessage());
            return redirect()->route('login')->with('error', 'Data '.Constant::SAVE_FAIL);
        }


    }
}
