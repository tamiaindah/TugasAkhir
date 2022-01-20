<?php
namespace App\Http\Controllers\Admin;

use App\Models\Transaksi;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class OrderController extends Controller
{
/**
* index
*
* @return void
*/
    public function index()
    {
        $transaksis = Transaksi::latest()->when(request()->q,
        function($transaksis) {
            $transaksis = $transaksis->where('invoice', 'like', '%'.
            request()->q . '%');
        })->paginate(10);
        
        return view('admin.order.index', compact('transaksis'));
    }
    /**
    * show
    *
    * @param mixed $invoice
    * @return void
    */
    public function show($id)
    {
        $invoice = Transaksi::findOrFail($id);
        return view('admin.order.show', compact('invoice'));
    }
}