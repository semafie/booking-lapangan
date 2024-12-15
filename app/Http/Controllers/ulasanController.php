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
            return redirect()->route('ulasan_user')->with(Session::flash('kosong_tambah', true));
        }

        $ulasan = ulasanModel::create([
            'id_user' => $request->user_id,
            'komentar' => $request->komentar,
            'rating' => $request->rating,
        ]);

        if ($ulasan) {
            return redirect()->route('ulasan_user')->with(Session::flash('berhasil_tambah', true));
        } else {
            return redirect()->route('ulasan_user')->with(Session::flash('gagal_tambah', true));
        }
    }



    public function hapus(Request $request, $id)
    {
        $ulasan = ulasanModel::findorFAil($id);

        $ulasan->delete();

        return redirect()->route('ulasan_user')->with(Session::flash('berhasil_hapus', true));
    }

    public function edit(Request $request, $id)
    {
        // dd($request);
        $ulasan = ulasanModel::findOrFail($id);

        $ulasan->komentar = $request->input('komentar');
        $ulasan->rating = $request->input('rating');



        $ulasan->save();

        return redirect()->route('ulasan_user')->with(Session::flash('berhasil_edit', true));
    }
}
