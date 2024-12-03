<?php

namespace App\Http\Controllers;

use App\Models\ulasanModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class ulasanController extends Controller
{
    public function tambah(Request $request)
    {

        $halo = [
            'user_id' => 'required',
            'komentar' => 'required',
            'rating' => 'required',


        ];

        $validasi = Validator::make($request->all(), $halo);

        // If validation fails
        if ($validasi->fails()) {
            return redirect()->route('ulasan')->with(Session::flash('kosong_tambah', true));
        }

        $ulasan = ulasanModel::create([
            'user_id' => $request->nama,
            'komentar' => $request->deskripsi,
            'rating' => $request->ukuran,
        ]);

        if ($ulasan) {
            return redirect()->route('ulasan')->with(Session::flash('berhasil_tambah', true));
        } else {
            return redirect()->route('ulasan')->with(Session::flash('gagal_tambah', true));
        }
    }



    public function hapus(Request $request, $id)
    {
        $ulasan = ulasanModel::findorFAil($id);

        $ulasan->delete();

        return redirect()->route('ulasan')->with(Session::flash('berhasil_hapus', true));
    }

    public function edit(Request $request, $id)
    {
        // dd($request);
        $ulasan = ulasanModel::findOrFail($id);

        $ulasan->nama = $request->input('nama');
        $ulasan->deskripsi = $request->input('deskripsi');
        $ulasan->ukuran = $request->input('ukuran');
        $ulasan->harga_per_jam = $request->input('harga');
        $ulasan->status = $request->input('status');
        $ulasan->tipe = $request->input('tipe');


        // Handle image update
        if ($request->hasFile('gambar')) {
            // Delete the old image file if it exists
            $oldImagePath = public_path($ulasan->gambar);
            if (file_exists($oldImagePath)) {
                unlink($oldImagePath); // Delete the old image
            }

            $file = $request->file('gambar');
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('gambar_ulasan'), $fileName);

            // Update the database with the new image path
            $ulasan->gambar = 'gambar_ulasan/' . $fileName;
        }

        $ulasan->save();

        return redirect()->route('ulasan')->with(Session::flash('berhasil_edit', true));
    }
}
