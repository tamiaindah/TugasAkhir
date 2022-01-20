<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaksi; //ambil data dari transaksi
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    //
    public function index() //index nya nanti nampilin isi data tabel transaksi
    {
        //ngatur status transaksi
        $pending = Transaksi::where('status', 'pending')->count(); //status pending
        $sukses = Transaksi::where('status', 'sukses')->count(); //status sukses
        $expired = Transaksi::where('status', 'expired')->count(); //status expired
        $gagal = Transaksi::where('status', 'gagal')->count(); //status gagal

        //tahun sama bulan, buat mendapatkan pendapatan
        $year = date('Y');
        $month = date('m');

        //nampilin pendapatan bulan sama tahun sekarang
        $revenueMonth = Transaksi::where('status', 'sukses')->whereMonth('created_at', '=', $month)->whereYear('created_at', $year)->sum('total');
        
        //nampilin pendapatan tahun sekarang
        $revenueYear = Transaksi::where('status', 'sukses')->whereYear('created_at', $year)->sum('total');
        
        //nampilin semua pendapatan
        $revenueAll = Transaksi::where('status', 'sukses')->sum('total');
        
        //pake helper compact biar variabel masuk ke view dashboard
        return view('admin.dashboard.index', compact('pending', 'sukses', 'expired', 'gagal', 'revenueMonth', 'revenueYear', 'revenueAll'));
    }
}
