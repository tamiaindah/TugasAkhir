<?php

namespace App\Http\Controllers\Api;

use App\Models\Kota;
use App\Models\Provinsi;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Kavist\RajaOngkir\Facades\RajaOngkir;

class RajaOngkirController extends Controller {
    /**
     * getProvinces
     *
     * @param mixed $request
     * @return void
     */
    public function getProvinsi() {
        $provinsis = Provinsi::all();
        return response() -> json([
            'success' => true,
            'message' => 'Daftar Data provinsi',
            'data' => $provinsis
        ]);
    }

    /**
     * getKota
     *
     * @param mixed $request
     * @return void
     */
    public function getKota(Request $request) {
        $kota = Kota::where('provinsi_id', $request -> provinsi_id) -> get();
        return response() -> json([
            'success' => true,
            'message' => 'Daftar Kota bedasarkan Provinsi',
            'data' => $kota
        ]);
    }

    /**
     * checkOngkir
     *
     * @param mixed $request
     * @return void
     */
    public function checkOngkir(Request $request)
    {
        $cost = RajaOngkir::ongkosKirim([
            'origin' => 113, // ID kota/kabupaten asal, 113 adalah kode kota demak
            'destination' => $request->city_destination, // ID kota/kabupaten tujuan
            'weight' => $request->weight, // berat barang dalam gram
            'courier' => $request->courier // kode kurir pengiriman: ['jne', 'tiki', 'pos'] untuk starter
        ])->get();

        return response()->json([
        'success' => true,
        'message' => 'List Data Cost All Courir: '.$request->courier,
        'data' => $cost
        ]);
    }
}