<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use Illuminate\Http\Request;

class OrderController extends Controller {
    public function __construct() {
        $this -> middleware('auth:api');
    }
    /**
     * index
     *
     * @return void
     */
    public function index() {
        $invoices = Transaksi::where('customer_id', auth() -> guard('api') -> user() -> id) -> latest() -> get();
            
        return response() -> json([
            'success' => true,
            'message' => 'Daftar Tagihan: '.auth()->guard('api')->user()->nama, 'data' => $invoices
        ], 200);
    }
    /**
     * show
     *
     * @param mixed $snap_token
     * @return void
     */
    public function show($snap_token) {
        $tagihan = Transaksi::where('customer_id', auth() -> guard('api') -> user() -> id) -> where('snap_token', $snap_token) -> latest() -> first();

        return response() -> json([
            'success' => true,
            'message' => 'Detail Tagihan: '.auth()->guard('api')->user()->nama,
            'data' => $tagihan,
            'product' => $tagihan -> orders
        ], 200);
    }
}