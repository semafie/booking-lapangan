<?php

namespace App\Http\Controllers;

use App\Models\jadwalModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class jadwalController extends Controller
{
    public function tambah(Request $request)
    {
        // dd($request);
        $halo = [
            'jam_mulai' => 'required',
            'jam_selesai' => 'required',


        ];

        $validasi = Validator::make($request->all(), $halo);

        // If validation fails
        if ($validasi->fails()) {
            return redirect()->route('jadwal', $request->id_lapangan)->with(Session::flash('kosong_tambah', true));
        }




        $jadwal = jadwalModel::create([
            'jam_mulai' => $request->jam_mulai,
            'jam_selesai' => $request->jam_selesai,
            'status' => 'tersedia',
            'id_lapangan' => $request->id_lapangan,

        ]);

        if ($jadwal) {
            return redirect()->route('jadwal', $request->id_lapangan)->with(Session::flash('berhasil_tambah', true));
        } else {
            return redirect()->route('jadwal', $request->id_lapangan)->with(Session::flash('gagal_tambah', true));
        }
    }



    public function hapus(Request $request, $id)
    {
        $jadwal = jadwalModel::findorFAil($id);

        $jadwal->delete();

        return redirect()->route('jadwal', $request->id_lapangan)->with(Session::flash('berhasil_hapus', true));
    }

    public function edit(Request $request, $id)
    {

        $jadwal = jadwalModel::findOrFail($id);

        $jadwal->jam_mulai = $request->input('jam_mulai');
        $jadwal->jam_selesai = $request->input('jam_selesai');

        $jadwal->save();

        return redirect()->route('jadwal', $request->id_lapangan)->with(Session::flash('berhasil_edit', true));
    }
}
