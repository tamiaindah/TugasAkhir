<?php
namespace App\Http\Controllers\Api;

use App\Models\Keranjang;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class KeranjangController extends Controller {
    /**
     * __construct
     *
     * @return void
     */
    public function __construct() {
        $this -> middleware('auth:api');
    }
    /**
     * index
     *
     * @return void
     */
    public function index() {
        $keranjangs = Keranjang::with('produk') -> where('customer_id', auth() -> user() -> id) -> orderBy('created_at', 'desc') -> get();
        return response() -> json([
            'success' => true,
            'message' => 'Daftar Data Keranjang',
            'keranjang' => $keranjangs
        ]);
    }
    /**
     * store
     *
     * @param mixed $request
     * @return void
     */
    public function store(Request $request) {
        $item = Keranjang::where('produk_id',
            $request -> produk_id) -> where('customer_id', $request -> customer_id);
        if ($item -> count()) {
            //increment quantity
            $item -> increment('qty');
            $item = $item -> first();

            //sum price * quantity
            $price = $request -> harga * $item -> qty;

            //sum weight
            $weight = $request -> berat * $item -> qty;
            $item -> update([
                'harga' => $price
            ]);
        } else {
            $item = Keranjang::create([
                'produk_id' => $request -> produk_id,
                'customer_id' => $request -> customer_id,
                'qty' => $request -> qty,
                'harga' => $request -> harga
            ]);
        }
        return response() -> json([
            'success' => true,
            'message' => 'Berhasil dimasukkan ke dalam Keranjang',
            'qty' => $item -> qty,
            'produk' => $item -> produk
        ]);
    }
    /**
     * getTotalKeranjang
     *
     * @return void
     */
    public function getTotalKeranjang() {
        $keranjangs = Keranjang::with('produk') -> where('customer_id', auth() -> user() -> id) -> orderBy('created_at', 'desc') -> sum('harga');
        return response() -> json([
            'success' => true,
            'message' => 'Total Harga Keranjang ',
            'total' => $keranjangs
        ]);
    }

    public function getTotalBerat()
    {
        $keranjangs = Keranjang::with('produk') -> where('customer_id', auth() -> user() -> id) -> orderBy('created_at', 'desc') -> get();
        $berat = 0; //dalam gram
        foreach ($keranjangs as $keranjang) {
            $weight = $keranjang->qty * $keranjang->produk->berat;
            $berat += $weight;
        }
        return response() -> json([
            'success' => true,
            'message' => 'Total Berat Keranjang',
            'total' => $berat
        ]);
    }

    /**
     * removeKeranjang
     *
     * @param mixed $request
     * @return void
     */
    public function removeKeranjang(Request $request) {
        Keranjang::with('produk') -> whereId($request -> keranjang_id) -> delete();

        return response() -> json([
            'success' => true,
            'message' => 'Hapus Item Keranjang',
        ]);
    }
    /**
     * removeSemuaKeranjang
     *
     * @param mixed $request
     * @return void
     */
    public function removeSemuaKeranjang(Request $request) {
        Keranjang::with('produk') -> where('customer_id', auth() -> guard('api') -> user() -> id) -> delete();
        return response() -> json([
            'success' => true,
            'message' => 'Remove Semua Item di Keranjang',
        ]);
    }
}
