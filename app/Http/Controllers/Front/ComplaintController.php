<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Traits\Common;
use Illuminate\Support\Facades\Validator;
use App\Models\Product;
use App\Models\Complaint;
use config\Constant;
use Illuminate\Support\Facades\Auth;

class ComplaintController extends Controller
{
    use Common;
    /**
     *
     * Create a new controller instance.
     *
     * @return void
     */
    public $obj = 'Keluhan';
    public function __construct()
    {
        $this->middleware('auth');
    }


    public string $path = 'admin/image/warranties';

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('front.complaint.index');
    }

    public function store(Request $request)
    {
        if(!Auth::user()) return redirect()->route('front.complaint.index')->with('error', "Anda Harus Login Terlebih Dahulu!");

        $validator = Validator::make($request->all(), [
            "criticism" => ["regex:/(?!^\d+$)^.+$/"],
            "complaint" => ["regex:/(?!^\d+$)^.+$/"],
            "suggestions" => ["regex:/(?!^\d+$)^.+$/"],
        ],[
            "complaint.regex" => "Komplain tidak boleh mengandung angka saja!",
            "suggestions.regex" => "Saran tidak boleh mengandung angka saja!",
            "criticism.regex" => "Kritik tidak boleh mengandung angka saja!"
        ]
    );

        if ($validator->fails()) {
            return redirect()->route('front.complaint.index')->withErrors($validator)->withInput();
        }

        if($request->criticism == null && $request->complaint == null && $request->suggestions == null){
            return redirect()->route('front.complaint.index')->with('error', "Form Tidak Boleh Kosong Semua!");
        }

        try {
            $data = new Complaint();
            $data->user_id = Auth::user()->id;
            $data->criticism = $request->criticism;
            $data->complaint = $request->complaint;
            $data->suggestions = $request->suggestions;

            $data->save();
            return redirect()->route('front.complaint.index')->with('success', $this->messageTemplate(Constant::SAVE_SUCCESS, $this->obj));
        } catch (\Throwable $th) {
            $this->errorLog($th->getMessage());
            return redirect()->route('front.complaint.index')->with('error', $this->messageTemplate(Constant::SAVE_FAIL, $this->obj));
        }
    }
}
