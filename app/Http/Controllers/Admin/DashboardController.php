<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Complaint;
use App\Models\Product;
use App\Models\Service;
use App\Models\User;
use App\Models\Warranty;

class DashboardController extends Controller
{
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
        $users = User::where('role', '2')->count();
        $services = Service::count();
        $products = Product::count();
        $administrasi = User::where('role', '1')->count();

        // $warranty = Warranty::count();
        $complaint = Complaint::count();

        return view('admin.dashboard.index', compact('users', 'services', 'products', 'administrasi', 'complaint'));
    }
}
