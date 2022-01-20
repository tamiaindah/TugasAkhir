<?php

namespace App\Http\Controllers\Admin;

use App\Models\Kategori; //buat manipulasi data kategori
use Illuminate\Support\Str; //buat bikin slug tb kategori
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage; //pake facade buat upload fotonya
use App\Http\Controllers\Controller;


class KategoriController extends Controller
{
    //
    public function index() //buat ambil data tb kategori trus ditampilin di index 
    {
        $kategoris = Kategori::latest() -> when(request() -> q, //menampilkan nama berdasarkan request q
            function($kategoris) {
                $kategoris = $kategoris -> where('nama', 'like', '%'.request() -> q. '%'); 
            }) -> paginate(10); //paginatccion menampilkan sepuluh data per halaman
       
            return view('admin.kategori.index', compact('kategoris'));
    }

    public function create() { //nampilin form tambah data kategori
        return view('admin.kategori.create');
    }

    public function store(Request $request) { //buat proses nyimpen datanya
        $this -> validate($request, [ //buat validasi upload
            'foto' => 'required|image|mimes:jpeg,jpg,png|max:2000', //ketentuan gambar wajib dimasukkin, uk max 2kb (jpeg, jpg, png)
            'nama' => 'required|unique:kategoris' //nama jg diisi gaboleh ada data yang sama
        ]);

        //upload foto trus dimasukkin ke folder storage/app/public/kategori
        $foto = $request -> file('foto');
        $foto -> storeAs('public/kategori', $foto -> hashName());

        //nyimpen/masukkin datanya ke databasenya tabel kategori
        $kategori = Kategori::create([
            'foto' => $foto -> hashName(),
            'nama' => $request -> nama,
            'slug' => Str::slug($request -> nama, '-') //url slug sesuai nama kategori pake helper str
        ]);

        if ($kategori) { //kondisi upload nya sukses atau error
            //kalo sukses muncul data berhasil disimpan
            return
            redirect() -> route('admin.kategori.index') -> with(['sukses' => 'Data Berhasil Disimpan!']);
                    }
                    else {
                        //kalo sukses muncul data tidak dapat disimpan
                        return
                        redirect() -> route('admin.kategori.index') -> with(['error' => 'Data tidak dapat disimpan!']);
                            }
                        }
                        
                        public function edit(Kategori $kategori) {
                            return view('admin.kategori.edit', compact('kategori')); //buat nampilin proses edit data, pake compact buat parshing variabel nya
                        }

                        public function update(Request $request, Kategori $kategori) {
                            $this -> validate($request, [ //buat validasi proses update
                                'nama' => 'required|unique:kategoris,nama,'.$kategori -> id //field nama ga boleh kosomg, gaboleh ada isi  yang sama
                            ]);

                            //check jika foto
                            if ($request -> file('foto') == '') {
                                //update data tanpa foto
                                $kategori = Kategori::findOrFail($kategori -> id);
                                $kategori -> update([
                                    'nama' => $request -> nama,
                                    'slug' => Str::slug($request -> nama, '-')
                                ]);
                            } else {
                                //hapus foto lama
                                Storage::disk('local') -> delete('public/kategoris/'.$kategori -> foto);

                                //upload foto baru
                                $foto = $request -> file('foto');
                                $foto -> storeAs('public/kategoris', $foto -> hashName());

                                //update dengan foto baru
                                $kategori = Kategori::findOrFail($kategori -> id);
                                $kategory -> update([
                                    'foto' => $foto -> hashName(),
                                    'nama' => $request -> nama,
                                    'slug' => Str::slug($request -> nama, '-')
                                ]);
                            }
                            if ($kategori) {
                                //redirect dengan pesan sukses
                                return
                                redirect() -> route('admin.kategori.index') -> with(['sukses' => 'Data Berhasil Diupdate!']);
                                        }
                                        else {
                                            //redirect dengan pesan error
                                            return
                                            redirect() -> route('admin.kategori.index') -> with(['error' => 'Data tidak dapat Diupdate!']);
                                                }
                                            }
                                            
                                            public function destroy($id) {
                                                //cari data berdasarkan id
                                                $kategori = Kategori::findOrFail($id);
                                                //hapus foto kategori dari server
                                                $foto =
                                                    Storage::disk('local') -> delete('public/kategoris/'.$kategori -> foto);

                                                    //hapus  kategori dari db
                                                    $kategori -> delete();

                                                    //mengembalikan nilai dalam bentuk json
                                                    if ($kategori) {

                                                        return response() -> json([
                                                            'status' => 'sukses'
                                                        ]);
                                                    } else {
                                                        return response() -> json([
                                                            'status' => 'error'
                                                        ]);
                                                    }
                                                }
                                            }
