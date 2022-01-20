<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Kavist\RajaOngkir\Facades\RajaOngkir;

use App\Models\Provinsi;

use App\Models\Kota;

class LokasiSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $daftarProvinsi = RajaOngkir::provinsi() -> all();
        foreach($daftarProvinsi as $provinsiRow) {
            Provinsi::create([
                'provinsi_id' => $provinsiRow['province_id'],
                'nama' => $provinsiRow['province'],
            ]);
            $daftarKota =
                RajaOngkir::kota() -> dariProvinsi($provinsiRow['province_id']) -> get();
            foreach($daftarKota as $kotaRow) {
                Kota::create([
                    'provinsi_id' => $provinsiRow['province_id'],
                    'kota_id' => $kotaRow['city_id'],
                    'nama' => $kotaRow['city_name'],
                ]);
            }
        }
    }
}