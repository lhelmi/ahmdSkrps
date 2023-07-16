<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Traits\Common;
use Illuminate\Support\Facades\Validator;
use App\Models\Product;
use App\Models\Warranty;
use config\Constant;
use Illuminate\Support\Facades\Auth;

class WarrantyController extends Controller
{
    use Common;
    public $obj = 'Garansi';
    /**
     *
     * Create a new controller instance.
     *
     * @return void
     */
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
        $product = Product::all();
        return view('front.warranty.index', compact('product'));
    }

    public function store(Request $request)
    {
        if(!Auth::user()) return redirect()->route('front.warranty.index')->with('error', "Anda Harus Login Terlebih Dahulu!");
        $validator = Validator::make($request->all(), [
            "name" => ["required", "string", "max:100", "min:1"],
            "product_id" => ["required", "string", "max:100", "min:1"],
            "contact" => ["required", "string", "max:100", "min:1"],
            "purchase_date" => ["required", "string", "max:100", "min:1"],
            "requirements" => ["required", "mimes:png,jpg,jpeg", "max:2048"],
            "receipt" => ["required", "mimes:png,jpg,jpeg", "max:2048"],
        ]);

        if ($validator->fails()) {
            return redirect()->route('front.warranty.index')->withErrors($validator)->withInput();
        }

        $requirementsName = time().'_'.$request->requirements->getClientOriginalName();
        $requirements = $request->file('requirements')->move($this->path, $requirementsName);
        if(!$requirements) return redirect()->route('front.warranty.index')->with('error', Constant::UPLOAD_FAIL);

        $receiptName = time().'_'.$request->requirements->getClientOriginalName();
        $receipt = $request->file('receipt')->move($this->path, $receiptName);
        if(!$receipt) return redirect()->route('front.warranty.index')->with('error', Constant::UPLOAD_FAIL);

        try {
            $data = new Warranty();
            $data->user_id = Auth::user()->id;
            $data->product_id = $request->product_id;
            $data->contact = $request->contact;
            $data->purchase_date = $request->purchase_date;
            $data->requirements = $this->path.'/'.$requirementsName;
            $data->receipt = $this->path.'/'.$receiptName;
            $data->save();
            return redirect()->route('front.warranty.index')->with('success', $this->messageTemplate(Constant::SAVE_SUCCESS, $this->obj));
        } catch (\Throwable $th) {
            $this->errorLog($th->getMessage());
            return redirect()->route('front.warranty.index')->with('error', $this->messageTemplate(Constant::SAVE_FAIL, $this->obj));
        }
    }
}
