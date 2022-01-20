<?php
namespace App\Http\Controllers\Admin;

use App\Models\Slider;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class SliderController extends Controller {
    /**
     * index
     *
     * @return void
     */
    public
    function index() {
        $sliders = Slider::latest() -> paginate(5); //nampilin 5 slide
        return view('admin.slider.index', compact('sliders'));
    }
    /**
     * store
     *
     * @param mixed $request
     * @return void
     */
    public
    function store(Request $request) {
        $this -> validate($request, [
            'foto' => 'required|image|mimes:jpeg,jpg,png|max:2000',
            'link' => 'required'
        ]);
        //upload image
        $foto = $request -> file('foto');
        $foto -> storeAs('public/sliders', $foto -> hashName());
        //save to DB
        $slider = Slider::create([
            'foto' => $foto -> hashName(),
            'link' => $request -> link
        ]);
        if ($slider) {
            //redirect dengan pesan sukses
            return
            redirect() -> route('admin.slider.index') -> with(['sukses' => 'Data Berhasil Disimpan!']);
            }
            else {
                //redirect dengan pesan error
                return
                redirect() -> route('admin.slider.index') -> with(['error' => 'Data Gagal Disimpan!']);
                }
            }
            /**
            * destroy
            *
            * @param mixed $id
            * @return void
            */
            public
            function destroy($id) {
                $slider = Slider::findOrFail($id);
                $foto = Storage::disk('local') -> delete('public/sliders/'.$slider -> foto);
                $slider -> delete();
                if ($slider) {
                    return response() -> json([ 'status' => 'sukses' ]);
                    } else {
                            return response() -> json([ 'status' => 'error' ]);
                            }
                        }
                    }
