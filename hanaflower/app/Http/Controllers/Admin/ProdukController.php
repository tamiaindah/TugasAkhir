<?php

namespace App\Http\Controllers\Admin;

use App\Models\Produk;
use App\Models\Kategori;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class ProdukController extends Controller
{
    /**
     * index
     *
     * @return void
     */
    public function index()
    {
        $produks = Produk::latest()->when(request()->q, function($produks) {
            $produks = $produks->where('nama', 'like', '%'. request()->q . '%');
        })->paginate(10);

        return view('admin.produk.index', compact('produks'));
    }
    
    /**
     * create
     *
     * @return void
     */
    public function create()
    {
        $kategoris = Kategori::latest()->get();
        return view('admin.produk.create', compact('kategoris'));
    }
    
    /**
     * store
     *
     * @param  mixed $request
     * @return void
     */
    public function store(Request $request)
    {
       $this->validate($request, [
           'foto'          => 'required|image|mimes:jpeg,jpg,png|max:2000',
           'nama'          => 'required|unique:produks',
           'kategori_id'    => 'required',
           'konten'        => 'required',
           'warna'        => 'required',
           'berat'         => 'required',
           'harga'          => 'required',
           'diskon'       => 'required',
       ]); 

       //upload image
       $image = $request->file('foto');
       $image->storeAs('public/produks', $image->hashName());

       //save to DB
       $produk = Produk::create([
           'foto'          => $image->hashName(),
           'nama'          => $request->nama,
           'slug'           => Str::slug($request->nama, '-'),
           'kategori_id'    => $request->kategori_id,
           'konten'        => $request->konten,
           'warna'        => $request->warna,
           'unit'           => $request->unit,
           'berat'         => $request->berat,
           'harga'          => $request->harga,
           'diskon'       => $request->diskon,
           'keywords'       => $request->keywords,
           'description'    => $request->description
       ]);

       if($produk){
            //redirect dengan pesan sukses
            return redirect()->route('admin.produk.index')->with(['success' => 'Data Berhasil Disimpan!']);
        }else{
            //redirect dengan pesan error
            return redirect()->route('admin.produk.index')->with(['error' => 'Data Gagal Disimpan!']);
        }
    }
    
    /**
     * edit
     *
     * @param  mixed $product
     * @return void
     */
    public function edit(Produk $produk)
    {
        $kategoris = Kategory::latest()->get();
        return view('admin.produk.edit', compact('produk', 'kategoris'));
    }
    
    /**
     * update
     *
     * @param  mixed $request
     * @param  mixed $product
     * @return void
     */
    public function update(Request $request, Produk $produk)
    {
       $this->validate($request, [
           'nama'          => 'required|unique:produks,nama,'.$produk->id,
           'kategori_id'    => 'required',
           'konten'        => 'required',
           'warna'        => 'required',
           'berat'         => 'required',
           'harga'          => 'required',
           'diskon'       => 'required',
       ]); 

       //cek jika image kosong
       if($request->file('image') == '') {

            //update tanpa image
            $produk = Produk::findOrFail($produk->id);
            $produk->update([
                'nama'          => $request->nama,
                'slug'           => Str::slug($request->nama, '-'),
                'kategori_id'    => $request->kategori_id,
                'konten'        => $request->konten,
                'warna'        => $request->warna,
                'unit'           => $request->unit,
                'berat'         => $request->berat,
                'harga'          => $request->harga,
                'diskon'       => $request->diskon,
                'keywords'       => $request->keywords,
                'description'    => $request->description
            ]);

       } else {

            //hapus image lama
            Storage::disk('local')->delete('public/produks/'.$produk->image);

            //upload image baru
            $image = $request->file('foto');
            $image->storeAs('public/produks', $image->hashName());

            //update dengan image
            $produk = Produk::findOrFail($produk->id);
            $produk->update([
                'foto'          => $image->hashName(),
                'nama'          => $request->nama,
                'slug'           => Str::slug($request->nama, '-'),
                'kategori_id'    => $request->kategori_id,
                'konten'        => $request->konten,
                'warna'        => $request->warna,
                'unit'           => $request->unit,
                'berat'         => $request->berat,
                'harga'          => $request->harga,
                'diskon'       => $request->diskon,
                'keywords'       => $request->keywords,
                'description'    => $request->description
            ]);
       }

       if($produk){
            //redirect dengan pesan sukses
            return redirect()->route('admin.produk.index')->with(['success' => 'Data Berhasil Diupdate!']);
        }else{
            //redirect dengan pesan error
            return redirect()->route('admin.produk.index')->with(['error' => 'Data Gagal Diupdate!']);
        }
    }
    
    /**
     * destroy
     *
     * @param  mixed $id
     * @return void
     */
    public function destroy($id)
    {
        $produk = Produk::findOrFail($id);
        $image = Storage::disk('local')->delete('public/produks/'.$produk->image);
        $produk->delete();

        if($produk){
            return response()->json([
                'status' => 'success'
            ]);
        }else{
            return response()->json([
                'status' => 'error'
            ]);
        }
    }
}