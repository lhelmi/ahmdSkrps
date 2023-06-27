<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\MediaController;


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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();
Route::get('/home', [DashboardController::class, 'index'])->name('dashboard.index');

Route::get('/auth/admin', [AdminController::class, 'index'])->name('admin.index');
Route::get('/auth/admin/create', [AdminController::class, 'create'])->name('admin.create');
Route::post('/auth/admin/store', [AdminController::class, 'store'])->name('admin.store');
Route::get('/auth/admin/edit/{id}', [AdminController::class, 'edit'])->name('admin.edit');
Route::post('/auth/admin/update/{id}', [AdminController::class, 'update'])->name('admin.update');
Route::get('/auth/admin/destroy/{id}', [AdminController::class, 'destroy'])->name('admin.destroy');

Route::get('/product', [ProductController::class, 'index'])->name('product.index');
Route::get('/product/create', [ProductController::class, 'create'])->name('product.create');
Route::post('/product/store', [ProductController::class, 'store'])->name('product.store');
Route::get('/product/edit/{kode}', [ProductController::class, 'edit'])->name('product.edit');
Route::post('/product/update/{kode}', [ProductController::class, 'update'])->name('product.update');
Route::get('/product/destroy/{kode}', [ProductController::class, 'destroy'])->name('product.destroy');

Route::get('/service', [ServiceController::class, 'index'])->name('service.index');
Route::get('/service/create', [ServiceController::class, 'create'])->name('service.create');
Route::post('/service/store', [ServiceController::class, 'store'])->name('service.store');
Route::get('/service/edit/{kode}', [ServiceController::class, 'edit'])->name('service.edit');
Route::post('/service/update/{kode}', [ServiceController::class, 'update'])->name('service.update');
Route::get('/service/destroy/{kode}', [ServiceController::class, 'destroy'])->name('service.destroy');

Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
Route::get('/blog/create', [BlogController::class, 'create'])->name('blog.create');
Route::post('/blog/store', [BlogController::class, 'store'])->name('blog.store');
Route::get('/blog/edit/{kode}', [BlogController::class, 'edit'])->name('blog.edit');
Route::post('/blog/update/{kode}', [BlogController::class, 'update'])->name('blog.update');
Route::get('/blog/destroy/{kode}', [BlogController::class, 'destroy'])->name('blog.destroy');

Route::get('/media', [MediaController::class, 'index'])->name('media.index');
Route::get('/media/create', [MediaController::class, 'create'])->name('media.create');
Route::post('/media/store', [MediaController::class, 'store'])->name('media.store');
Route::get('/media/edit/{kode}', [MediaController::class, 'edit'])->name('media.edit');
Route::post('/media/update/{kode}', [MediaController::class, 'update'])->name('media.update');
Route::get('/media/destroy/{kode}', [MediaController::class, 'destroy'])->name('media.destroy');
