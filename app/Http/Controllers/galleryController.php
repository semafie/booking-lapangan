<?php

namespace App\Http\Controllers;

use App\Models\galleryModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class galleryController extends Controller
{
    public function tambah(Request $request)
    {
        // dd($request);
        $halo = [
            'gambar' => 'required',



        ];

        $validasi = Validator::make($request->all(), $halo);

        // If validation fails
        if ($validasi->fails()) {
            return redirect()->route('gallery', $request->id_gallery)->with(Session::flash('kosong_tambah', true));
        }

        $fileName = null;


        // Handle image upload
        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            $fileName = time() . '.' . $file->getClientOriginalExtension(); // Generate a unique name for the file
            $file->move(public_path('gambar_gallery'), $fileName); // Move the image to the public/gambar_gallery folder
        }



        $gallery = galleryModel::create([
            'gambar' => 'gambar_gallery/' . $fileName,

        ]);

        if ($gallery) {
            return redirect()->route('gallery', $request->id_gallery)->with(Session::flash('berhasil_tambah', true));
        } else {
            return redirect()->route('gallery', $request->id_gallery)->with(Session::flash('gagal_tambah', true));
        }
    }



    public function hapus(Request $request, $id)
    {
        $gallery = galleryModel::findorFAil($id);

        $gallery->delete();

        return redirect()->route('gallery', $request->id_gallery)->with(Session::flash('berhasil_hapus', true));
    }

    public function edit(Request $request, $id)
    {

        $gallery = galleryModel::findOrFail($id);



        // Handle image update
        if ($request->hasFile('gambar')) {
            // Delete the old image file if it exists
            $oldImagePath = public_path($gallery->gambar);
            if (file_exists($oldImagePath)) {
                unlink($oldImagePath); // Delete the old image
            }

            $file = $request->file('gambar');
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('gambar_gallery'), $fileName);

            // Update the database with the new image path
            $gallery->gambar = 'gambar_gallery/' . $fileName;
        }

        $gallery->save();

        return redirect()->route('gallery')->with(Session::flash('berhasil_edit', true));
    }
}
