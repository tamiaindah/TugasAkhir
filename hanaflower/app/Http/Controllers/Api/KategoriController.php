<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Kategori;
use Illuminate\Http\Request;

class KategoriController extends Controller {
    /**
     * index
     *
     * @return void
     */
    public function index() {
        $kategoris = Kategori::latest() -> get();
        return response() -> json([
            'success' => true,
            'message' => 'Data Kategori',
            'kategoris' => $kategoris
        ]);
    }
    /**
     * show
     *
     * @param mixed $slug
     * @return void
     */
    public function show($slug) {
        $kategori = Kategori::where('slug', $slug) -> first();

        if ($kategori) {
            return response() -> json([
                'success' => true,
                'message' => 'Data Produk berdasar Kategori: '. $kategori -> name,
                'produk' => $kategori->produks()->latest()->get()
            ], 200);
        } else {
            return response() -> json([
                'success' => false,
                'message' => 'Data Produk Berdasar Kategori Tidak Ditemukan',
            ], 404);
        }
    }
    /**
     * categoryHeader
     *
     * @return void
     */
    public function categoryHeader() {
        $kategoris = Kategori::latest() -> take(5) -> get();
        return response() -> json([
            'success' => true,
            'message' => 'Data Kategori Header',
            'kategoris' => $kategoris
        ]);
    }
}