<?php

namespace App\Http\Controllers\Api;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/**
* Route API Auth dengan method POST
*/
Route::post('/login', [AuthController::class, 'login'])->name('api.customer.login');
Route::post('/register', [AuthController::class, 'register'])->name('api.customer.register');
Route::get('/user', [AuthController::class, 'getUser'])->name('api.customer.user');

/**
* Router Order
*/
Route::get('/order', [OrderController::class, 'index'])->name('api.order.index');
Route::get('/order/{snap_token?}', [OrderController::class, 'show'])->name('api.order.show');

/**
* Route API KategorI    
*/
Route::get('/kategoris', [KategoriController::class, 'index'])->name('customer.kategori.index');
Route::get('/kategori/{slug?}', [KategoriController::class, 'show'])->name('customer.kategori.show');
Route::get('/kategoriHeader', [KategoriController::class, 'categoryHeader'])->name('customer.kategori.kategoriHeader');

/**
* Route API Produk
*/
Route::get('/produks', [ProdukController::class, 'index'])->name('customer.produk.index');
Route::get('/produks/{slug?}', [ProdukController::class, 'show'])->name('customer.produk.show');

/**
* Route API Keranjang
*/
Route::get('/keranjang', [KeranjangController::class, 'index'])->name('customer.keranjang.index');
Route::post('/keranjang', [KeranjangController::class, 'store'])->name('customer.keranjang.store');
Route::get('/keranjang/total', [KeranjangController::class, 'getCartTotal'])->name('customer.keranjang.total');
Route::post('/keranjang/remove', [KeranjangController::class, 'removeCart'])->name('customer.keranjang.remove');
Route::post('/keranjang/removeSemua', [KeranjangController::class, 'removeAllCart'])->name('customer.keranjang.removeSemua');

/**
* Route Raja Ongkir
*/
Route::get('/rajaongkir/provinsi', [RajaOngkirController::class, 'getProvinsi'])->name('customer.rajaongkir.getProvinsi');
Route::get('/rajaongkir/kota', [RajaOngkirController::class, 'getKota'])->name('customer.rajaongkir.getKota');
Route::post('/rajaongkir/checkOngkir', [RajaOngkirController::class, 'checkOngkir'])->name('customer.rajaongkir.checkOngkir');

/**
* Route Checkout
*/
Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
Route::post('/notificationHandler', [CheckoutController::class, 'notificationHandler'])->name('notificationHanlder');

/**
* Route API Slider
*/
Route::get('/sliders', [SliderController::class, 'index'])->name('customer.slider.index');