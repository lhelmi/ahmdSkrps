<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Warranty;
use config\Constant;
use Illuminate\Support\Facades\Validator;
use App\Http\Traits\Common;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use PDF;

class WarrantyController extends Controller
{
    use Common;
    public $obj = 'Garansi';
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
        $warranties = DB::table('warranties as a')
        ->select(
            'a.id',
            'c.name as nama_user',
            'a.user_id',
            'a.product_id',
            'b.name as nama_product',
            'a.contact',
            'a.purchase_date',
            'a.requirements',
            'a.receipt',
            'a.status',
        )
        ->join('products as b', 'a.product_id', '=', 'b.id')
        ->join('users as c', 'a.user_id', '=', 'c.id')->get();
        $type = $this->warrantiesType();

        return view('admin.warranty.index', compact('warranties', 'type'));
    }

    public function edit(string $id)
    {
        $data = DB::table('warranties as a')
        ->select(
            'a.id',
            'c.name as nama_user',
            'a.user_id',
            'a.product_id',
            'b.name as nama_product',
            'a.contact',
            'a.purchase_date',
            'a.requirements',
            'a.receipt',
            'a.status',
        )
        ->join('products as b', 'a.product_id', '=', 'b.id')
        ->join('users as c', 'a.user_id', '=', 'c.id')
        ->where('a.id', $id)
        ->first();

        $type = $this->warrantiesType();
        return view('admin.warranty.edit', compact('data', 'type'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = Warranty::find($id);
        $param = [
            "status" => ["required", "in:process,finish"]
        ];

        $validator = Validator::make($request->all(), $param);
        if ($validator->fails()) {
            return redirect()->route('warranty.edit', $id)->withErrors($validator)->withInput();
        }

        try {
            $data->status = $request->status;
            $data->save();
            return redirect()->route('warranty.index')->with('success', $this->messageTemplate(Constant::UPDATE_SUCCESS, $this->obj));
        } catch (\Throwable $th) {
            $this->errorLog($th->getMessage());
            return redirect()->route('warranty.edit', $id)->with('error', $this->messageTemplate(Constant::UPDATE_FAIL, $this->obj));
        }
    }

    public function pdf(){
        $temp = DB::table('warranties as a')
        ->select(
            'a.id',
            'c.name as nama_user',
            'a.user_id',
            'a.product_id',
            'b.name as nama_product',
            'a.contact',
            'a.purchase_date',
            'a.requirements',
            'a.receipt',
            'a.status',
        )
        ->join('products as b', 'a.product_id', '=', 'b.id')
        ->join('users as c', 'a.user_id', '=', 'c.id')->get();
        $type = $this->warrantiesType();
        $data = $temp;
        foreach ($temp as $key => $value) {

            $tmp1 = public_path().'/'.$data[$key]->requirements;
            $type1 = pathinfo($tmp1, PATHINFO_EXTENSION);
            $file1 = file_get_contents($tmp1);
            $file1 = base64_encode($file1);
            $base641 = 'data:image/' . $type1 . ';base64,' . $file1;
            $data[$key]->requirements = $base641;

            $tmp2 = public_path().'/'.$data[$key]->receipt;
            $type2 = pathinfo($tmp2, PATHINFO_EXTENSION);
            $file2 = file_get_contents($tmp2);
            $file2 = base64_encode($file2);
            $base642 = 'data:image/' . $type2 . ';base64,' . $file2;
            $data[$key]->receipt = $base642;
        }
        // dd($data);
        // return view('admin.warranty.pdf', compact('data'));
        $pdf = PDF::loadView('admin.warranty.pdf', compact('data', 'type'));
        $pdf->setPaper('A4', 'landscape');
	    return $pdf->download('garansi.pdf');
    }

    public function destroy(string $id)
    {
        $data = Warranty::find($id);
        if($data == null) return redirect()->route('warranty.index')->with('error', $this->messageTemplate(Constant::NOT_FOUND, $this->obj));
        try {
            $data->delete();
            return redirect()->route('warranty.index')->with('success', $this->messageTemplate(Constant::DESTROY_SUCCESS, $this->obj));
        } catch (\Throwable $th) {
            $this->errorLog($th->getMessage());
            return redirect()->route('warranty.index')->with('error', $this->messageTemplate(Constant::DESTROY_FAIL, $this->obj));
        }
    }
}
