<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Warranty;
use config\Constant;
use Illuminate\Support\Facades\Validator;
use App\Http\Traits\Common;
use Illuminate\Support\Facades\DB;

class WarrantyController extends Controller
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

        return view('admin.warranty.index', compact('warranties'));
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
            return redirect()->route('warranty.index')->with('success', Constant::UPDATE_SUCCESS);
        } catch (\Throwable $th) {
            $this->errorLog($th->getMessage());
            return redirect()->route('warranty.edit', $id)->with('error', Constant::UPDATE_FAIL);
        }
    }
}
