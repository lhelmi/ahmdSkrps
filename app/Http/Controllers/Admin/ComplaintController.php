<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Traits\Common;
use App\Models\Complaint;
use config\Constant;
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

    public function destroy(string $id)
    {
        $data = Complaint::find($id);
        if($data == null) return redirect()->route('complaint.index')->with('error', Constant::NOT_FOUND);
        try {
            $data->delete();
            return redirect()->route('complaint.index')->with('success', Constant::DESTROY_SUCCESS);
        } catch (\Throwable $th) {
            $this->errorLog($th->getMessage());
            return redirect()->route('complaint.index')->with('error', Constant::DESTROY_FAIL);
        }
    }
}
