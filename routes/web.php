<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\MediaController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\WarrantyController;
use App\Http\Controllers\Admin\ComplaintController;

use App\Http\Controllers\Front\HomeController;
use App\Http\Controllers\Front\ProductFeController;
use App\Http\Controllers\Front\OrderController;
use App\Http\Controllers\Front\MediaController as FeMediaController;
use App\Http\Controllers\Front\ServiceController as FEServiceController;
use App\Http\Controllers\Front\BlogController as FEBlogController;
use App\Http\Controllers\Front\WarrantyController as FEWarrantyController;
use App\Http\Controllers\Front\ComplaintController as FEComplaintController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [HomeController::class, 'index'])->name('front.index');
Route::get('/home', [HomeController::class, 'index'])->name('front.home');
Route::get('/order', [OrderController::class, 'index'])->name('front.order.index');
Route::get('/product', [ProductFeController::class, 'index'])->name('front.product.index');
Route::get('/product/{id}', [ProductFeController::class, 'show'])->name('front.product.show');
Route::get('/media', [FeMediaController::class, 'index'])->name('front.media.index');
Route::get('/media/{id}', [FeMediaController::class, 'download'])->name('front.media.download');
Route::get('/service', [FEServiceController::class, 'index'])->name('front.service.index');
Route::get('/service/{id}', [FEServiceController::class, 'show'])->name('front.service.show');
Route::get('/blog', [FEBlogController::class, 'index'])->name('front.blog.index');
Route::get('/blog/{slug}', [FEBlogController::class, 'show'])->name('front.blog.show');
Route::get('/warranty', [FEWarrantyController::class, 'index'])->name('front.warranty.index');
Route::post('/warranty', [FEWarrantyController::class, 'store'])->name('front.warranty.store');
Route::get('/complaint', [FEComplaintController::class, 'index'])->name('front.complaint.index');
Route::post('/complaint', [FEComplaintController::class, 'store'])->name('front.complaint.store');

Auth::routes();
Route::get('/admin/home', [DashboardController::class, 'index'])->name('dashboard.index');

Route::get('/admin/administrasi', [AdminController::class, 'index'])->name('admin.index');
Route::get('/admin/administrasi/create', [AdminController::class, 'create'])->name('admin.create');
Route::post('/admin/administrasi/store', [AdminController::class, 'store'])->name('admin.store');
Route::get('/admin/administrasi/edit/{id}', [AdminController::class, 'edit'])->name('admin.edit');
Route::post('/admin/administrasi/update/{id}', [AdminController::class, 'update'])->name('admin.update');
Route::get('/admin/administrasi/destroy/{id}', [AdminController::class, 'destroy'])->name('admin.destroy');

Route::get('/admin/user', [UserController::class, 'index'])->name('user.index');
Route::get('/admin/user/create', [UserController::class, 'create'])->name('user.create');
Route::post('/admin/user/store', [UserController::class, 'store'])->name('user.store');
Route::get('/admin/user/edit/{id}', [UserController::class, 'edit'])->name('user.edit');
Route::post('/admin/user/update/{id}', [UserController::class, 'update'])->name('user.update');
Route::get('/admin/user/destroy/{id}', [UserController::class, 'destroy'])->name('user.destroy');

Route::get('admin/product', [ProductController::class, 'index'])->name('product.index');
Route::get('admin/product/create', [ProductController::class, 'create'])->name('product.create');
Route::post('admin/product/store', [ProductController::class, 'store'])->name('product.store');
Route::get('admin/product/edit/{kode}', [ProductController::class, 'edit'])->name('product.edit');
Route::post('admin/product/update/{kode}', [ProductController::class, 'update'])->name('product.update');
Route::get('admin/product/destroy/{kode}', [ProductController::class, 'destroy'])->name('product.destroy');

Route::get('admin/service', [ServiceController::class, 'index'])->name('service.index');
Route::get('admin/service/create', [ServiceController::class, 'create'])->name('service.create');
Route::post('admin/service/store', [ServiceController::class, 'store'])->name('service.store');
Route::get('admin/service/edit/{kode}', [ServiceController::class, 'edit'])->name('service.edit');
Route::post('admin/service/update/{kode}', [ServiceController::class, 'update'])->name('service.update');
Route::get('admin/service/destroy/{kode}', [ServiceController::class, 'destroy'])->name('service.destroy');

Route::get('admin/blog', [BlogController::class, 'index'])->name('blog.index');
Route::get('admin/blog/create', [BlogController::class, 'create'])->name('blog.create');
Route::post('admin/blog/store', [BlogController::class, 'store'])->name('blog.store');
Route::get('admin/blog/edit/{kode}', [BlogController::class, 'edit'])->name('blog.edit');
Route::post('admin/blog/update/{kode}', [BlogController::class, 'update'])->name('blog.update');
Route::get('admin/blog/destroy/{kode}', [BlogController::class, 'destroy'])->name('blog.destroy');

Route::get('admin/media', [MediaController::class, 'index'])->name('media.index');
Route::get('admin/media/create', [MediaController::class, 'create'])->name('media.create');
Route::post('admin/media/store', [MediaController::class, 'store'])->name('media.store');
Route::get('admin/media/edit/{kode}', [MediaController::class, 'edit'])->name('media.edit');
Route::post('admin/media/update/{kode}', [MediaController::class, 'update'])->name('media.update');
Route::get('admin/media/destroy/{kode}', [MediaController::class, 'destroy'])->name('media.destroy');

Route::get('/admin/warranty', [WarrantyController::class, 'index'])->name('warranty.index');
Route::get('/admin/warranty/edit/{id}', [WarrantyController::class, 'edit'])->name('warranty.edit');
Route::post('/admin/warranty/update/{id}', [WarrantyController::class, 'update'])->name('warranty.update');

Route::get('/admin/complaint', [ComplaintController::class, 'index'])->name('complaint.index');
Route::get('/admin/complaint/create', [ComplaintController::class, 'create'])->name('complaint.create');
Route::post('/admin/complaint/store', [ComplaintController::class, 'store'])->name('complaint.store');
Route::get('/admin/complaint/edit/{id}', [ComplaintController::class, 'edit'])->name('complaint.edit');
Route::post('/admin/complaint/update/{id}', [ComplaintController::class, 'update'])->name('complaint.update');
Route::get('/admin/complaint/destroy/{id}', [ComplaintController::class, 'destroy'])->name('complaint.destroy');
