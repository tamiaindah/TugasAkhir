<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Route;

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
    return view('auth.login');
});

//bikin perfix admin buat nambahin kata admin di url
Route::prefix('admin') -> group(function () {

    //route auth bisa diakses kalo udh autentikasi sama login
    Route::group(['middleware' => 'auth'], function () {
    
        //route buat dashboard, filenya beda biar gampang dipanggil soalnya template nya beda
        Route::get('/dashboard', [DashboardController::class, 'index']) -> name('admin.dashboard.index');

        //route kategori, as digunakan biar sblm kategori ada klimat admin nya
        Route::resource('/kategori', KategoriController::class, ['as' => 'admin']);

        //route order, ada pengecualian buat create, store, edit, update, destroy
        Route::resource('/order', OrderController::class, ['except' => ['create', 'store', 'edit', 'update', 'destroy'], 'as' => 'admin']);

        //route customer
        Route::get('/customer', [CustomerController::class, 'index'])->name('admin.customer.index');

        //route slider, ada pengecualian kecuali show, create, edit, update
        Route::resource('/slider', SliderController::class, ['except' => ['show', 'create', 'edit', 'update'], 'as' => 'admin']);

        //profile
        Route::get('/profile', [ProfileController::class, 'index'])->name('admin.profile.index');

        //route user
        Route::resource('/user', UserController::class, ['except' => ['show'], 'as' => 'admin']);

        //route product 
        Route::resource('/produk', ProdukController::class, ['as' => 'admin']);
    });
});