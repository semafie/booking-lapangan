<?php

namespace App\Http\Controllers;

use App\Models\lapanganModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class lapanganController extends Controller
{
    public function tambah(Request $request)
    {

        $halo = [
            'nama' => 'required',
            'deskripsi' => 'required',
            'ukuran' => 'required', // Validate image types
            'harga' => 'required', // Validate image types
            'status' => 'required', // Validate image types
            'tipe' => 'required', // Validate image types

        ];

        $validasi = Validator::make($request->all(), $halo);

        // If validation fails
        if ($validasi->fails()) {
            return redirect()->route('lapangan')->with(Session::flash('kosong_tambah', true));
        }


        $fileName = null;


        // Handle image upload
        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            $fileName = time() . '.' . $file->getClientOriginalExtension(); // Generate a unique name for the file
            $file->move(public_path('gambar_lapangan'), $fileName); // Move the image to the public/gambar_lapangan folder
        }

        $lapangan = lapanganModel::create([
            'nama' => $request->nama,
            'deskripsi' => $request->deskripsi,
            'ukuran' => $request->ukuran,
            'harga_per_jam' => $request->harga,
            'status' => $request->status,
            'tipe' => $request->tipe,
            'gambar' => 'gambar_lapangan/' . $fileName, // Save the path to the database
        ]);

        if ($lapangan) {
            return redirect()->route('lapangan')->with(Session::flash('berhasil_tambah', true));
        } else {
            return redirect()->route('lapangan')->with(Session::flash('gagal_tambah', true));
        }
    }



    public function hapus(Request $request, $id)
    {
        $lapangan = lapanganModel::findorFAil($id);

        $lapangan->delete();

        return redirect()->route('lapangan')->with(Session::flash('berhasil_hapus', true));
    }

    public function edit(Request $request, $id)
    {
        // dd($request);
        $lapangan = lapanganModel::findOrFail($id);

        $lapangan->nama = $request->input('nama');
        $lapangan->deskripsi = $request->input('deskripsi');
        $lapangan->ukuran = $request->input('ukuran');
        $lapangan->harga_per_jam = $request->input('harga');
        $lapangan->status = $request->input('status');
        $lapangan->tipe = $request->input('tipe');


        // Handle image update
        if ($request->hasFile('gambar')) {
            // Delete the old image file if it exists
            $oldImagePath = public_path($lapangan->gambar);
            if (file_exists($oldImagePath)) {
                unlink($oldImagePath); // Delete the old image
            }

            $file = $request->file('gambar');
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('gambar_lapangan'), $fileName);

            // Update the database with the new image path
            $lapangan->gambar = 'gambar_lapangan/' . $fileName;
        }

        $lapangan->save();

        return redirect()->route('lapangan')->with(Session::flash('berhasil_edit', true));
    }
}
