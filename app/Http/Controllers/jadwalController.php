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

        // Cek apakah jam_mulai lebih kecil dari jam_selesai
        if (strtotime($request->jam_mulai) >= strtotime($request->jam_selesai)) {
            return redirect()->route('jadwal', $request->id_lapangan)
                ->with(Session::flash('error_jam', 'Jam mulai harus lebih kecil dari jam selesai'));
        }

        // Cek overlap dengan jadwal yang sudah ada
        $overlap = jadwalModel::where('id_lapangan', $request->id_lapangan)
            ->where(function($query) use ($request) {
                $query->whereBetween('jam_mulai', [$request->jam_mulai, $request->jam_selesai])
                    ->orWhereBetween('jam_selesai', [$request->jam_mulai, $request->jam_selesai])
                    ->orWhere(function($q) use ($request) {
                        $q->where('jam_mulai', '<=', $request->jam_mulai)
                          ->where('jam_selesai', '>=', $request->jam_selesai);
                    });
            })
            ->exists();

        if ($overlap) {
            return redirect()->route('jadwal', $request->id_lapangan)
                ->with(Session::flash('error_jam', 'Jadwal ini overlap dengan jadwal yang sudah ada'));
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

        // Cek apakah jam_mulai lebih kecil dari jam_selesai
        if (strtotime($request->jam_mulai) >= strtotime($request->jam_selesai)) {
            return redirect()->route('jadwal', $request->id_lapangan)
                ->with(Session::flash('error_jam', 'Jam mulai harus lebih kecil dari jam selesai'));
        }

        // Cek overlap dengan jadwal lain (kecuali jadwal yang sedang diedit)
        $overlap = jadwalModel::where('id_lapangan', $request->id_lapangan)
            ->where('id', '!=', $id)
            ->where(function($query) use ($request) {
                $query->whereBetween('jam_mulai', [$request->jam_mulai, $request->jam_selesai])
                    ->orWhereBetween('jam_selesai', [$request->jam_mulai, $request->jam_selesai])
                    ->orWhere(function($q) use ($request) {
                        $q->where('jam_mulai', '<=', $request->jam_mulai)
                          ->where('jam_selesai', '>=', $request->jam_selesai);
                    });
            })
            ->exists();

        if ($overlap) {
            return redirect()->route('jadwal', $request->id_lapangan)
                ->with(Session::flash('error_jam', 'Jadwal ini overlap dengan jadwal yang sudah ada'));
        }

        $jadwal->jam_mulai = $request->input('jam_mulai');
        $jadwal->jam_selesai = $request->input('jam_selesai');

        $jadwal->save();

        return redirect()->route('jadwal', $request->id_lapangan)->with(Session::flash('berhasil_edit', true));
    }
}
