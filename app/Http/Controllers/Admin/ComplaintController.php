<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Traits\Common;
use Illuminate\Support\Facades\DB;
use PDF;

class ComplaintController extends Controller
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
        $complaints = DB::table('complaints as a')
        ->select(
            "a.*",
            "b.name as users_name"
        )
        ->join('users as b', 'a.user_id', '=', 'b.id')->get();

        return view('admin.complaint.index', compact('complaints'));
    }

    public function pdf(){
        $data = DB::table('complaints as a')
        ->select(
            "a.*",
            "b.name as users_name"
        )
        ->join('users as b', 'a.user_id', '=', 'b.id')->get();

        $pdf = PDF::loadView('admin.complaint.pdf', compact('data'));
	    return $pdf->download('Keluhan.pdf');
    }
}
