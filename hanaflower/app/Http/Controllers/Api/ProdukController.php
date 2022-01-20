<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Produk;
use Illuminate\Http\Request;


class ProdukController extends Controller {
    /**
     * index
     *
     * @return void
     */
    public function index() {
        $produks = Produk::latest() -> get();
        return response() -> json([
            'success' => true,
            'message' => 'Daftar Data Produk',
            'produks' => $produks
        ], 200);
    }
    /**
     * show
     *
     * @param mixed $slug
     * @return void
     */
    public function show($slug) {
        $produk = Produk::where('slug', $slug) -> first();
        if ($produk) {
            return response() -> json([
                'success' => true,
                'message' => 'Detail Data Produk',
                'produk' => $produk
            ], 200);
        } else {
            return response() -> json([
                'success' => false,
                'message' => 'Data Produk Tidak Ditemukan',
            ], 404);
        }
    }
}