<?php

namespace App\Http\Controllers;

use App\Models\BookingModel;
use App\Models\jadwalModel;
use App\Models\transaksiModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class transaksiController extends Controller
{

    public function tambah(Request $request)
    {

        try {
            // Validasi input
            $validatedData = $request->validate([
                'id_user' => 'nullable',
                'nama' => 'nullable',
                'metode' => 'required',
                'tanggal' => 'required',
                'total_harga' => 'required',
                'selectedData' => 'required|json'
            ]);

            // Simpan data transaksi
            $transaksi = TransaksiModel::create([
                'id_user' => $validatedData['id_user'] ?? null,
                'nama' => $validatedData['nama'] ?? null,
                'metode' => $validatedData['metode'],
                'status' => "dibayar",
                'bukti_pembayaran' => $request->file('bukti_pembayaran') ? $request->file('bukti_pembayaran')->store('bukti_pembayaran') : null,
                'tanggal' => $validatedData['tanggal'],
                'total_harga' => $validatedData['total_harga'],
            ]);

            // Simpan data booking dari selectedData
            $selectedData = json_decode($validatedData['selectedData'], true);

            foreach ($selectedData as $data) {
                BookingModel::create([
                    'id_pembayaran' => $transaksi->id, // Asosiasi dengan transaksi
                    'id_jadwal' => $data['idjadwal'],
                    'tanggal' => $validatedData['tanggal'],
                    'sub_total' => $data['harga'],
                ]);

                $jadwal = jadwalModel::findOrFail($data['idjadwal']);
                $jadwal->update(['status' => 'dipesan']);
            }

            return redirect()->route('transaksi')->with(Session::flash('berhasil_tambah', true));
        } catch (\Exception $e) {
            return response()->json(['message' => 'Terjadi kesalahan: ' . $e->getMessage()], 500);
        }
    }

    public function tambah_u(Request $request)
    {

        try {
            // Validasi input
            $validatedData = $request->validate([
                'id_user' => 'nullable',
                'nama' => 'nullable',
                'metode' => 'required',
                'tanggal' => 'required',
                'total_harga' => 'required',
                'selectedData' => 'required|json'
            ]);

            // Simpan data transaksi
            $transaksi = TransaksiModel::create([
                'id_user' => $validatedData['id_user'] ?? null,
                'nama' => $validatedData['nama'] ?? null,
                'metode' => $validatedData['metode'],
                'status' => "dibayar",
                'bukti_pembayaran' => $request->file('bukti_pembayaran') ? $request->file('bukti_pembayaran')->store('bukti_pembayaran') : null,
                'tanggal' => $validatedData['tanggal'],
                'total_harga' => $validatedData['total_harga'],
            ]);

            // Simpan data booking dari selectedData
            $selectedData = json_decode($validatedData['selectedData'], true);

            foreach ($selectedData as $data) {
                BookingModel::create([
                    'id_pembayaran' => $transaksi->id, // Asosiasi dengan transaksi
                    'id_jadwal' => $data['idjadwal'],
                    'tanggal' => $validatedData['tanggal'],
                    'sub_total' => $data['harga'],
                ]);

                $jadwal = jadwalModel::findOrFail($data['idjadwal']);
                $jadwal->update(['status' => 'dipesan']);
            }

            return redirect()->route('transaksi_user')->with(Session::flash('berhasil_tambah', true));
        } catch (\Exception $e) {
            return response()->json(['message' => 'Terjadi kesalahan: ' . $e->getMessage()], 500);
        }
    }



    public function hapus(Request $request, $id)
    {
        $transaksi = transaksiModel::findorFAil($id);

        $transaksi->delete();

        return redirect()->route('transaksi')->with(Session::flash('berhasil_hapus', true));
    }

    public function hapus_u(Request $request, $id)
    {
        $transaksi = transaksiModel::findorFAil($id);

        $transaksi->delete();

        return redirect()->route('transaksi_user')->with(Session::flash('berhasil_hapus', true));
    }

    public function edit(Request $request, $id)
    {
        // dd($request);
        $transaksi = transaksiModel::findOrFail($id);

        $transaksi->user_id = $request->input('user_id');
        $transaksi->metode = $request->input('metode');
        $transaksi->status = $request->input('status');
        $transaksi->tanggal = $request->input('tanggal');
        $transaksi->total_harga = $request->input('total_harga');



        // Handle image update
        if ($request->hasFile('bukti')) {
            // Delete the old image file if it exists
            $oldImagePath = public_path($transaksi->bukti);
            if (file_exists($oldImagePath)) {
                unlink($oldImagePath); // Delete the old image
            }

            $file = $request->file('bukti');
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('gambar_transaksi'), $fileName);

            // Update the database with the new image path
            $transaksi->gambar = 'gambar_transaksi/' . $fileName;
        }

        $transaksi->save();

        return redirect()->route('transaksi')->with(Session::flash('berhasil_edit', true));
    }

    public function edit_u(Request $request, $id)
    {
        // dd($request);
        $transaksi = transaksiModel::findOrFail($id);

        $transaksi->user_id = $request->input('user_id');
        $transaksi->metode = $request->input('metode');
        $transaksi->status = $request->input('status');
        $transaksi->tanggal = $request->input('tanggal');
        $transaksi->total_harga = $request->input('total_harga');



        // Handle image update
        if ($request->hasFile('bukti')) {
            // Delete the old image file if it exists
            $oldImagePath = public_path($transaksi->bukti);
            if (file_exists($oldImagePath)) {
                unlink($oldImagePath); // Delete the old image
            }

            $file = $request->file('bukti');
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('gambar_transaksi'), $fileName);

            // Update the database with the new image path
            $transaksi->gambar = 'gambar_transaksi/' . $fileName;
        }

        $transaksi->save();

        return redirect()->route('transaksi_user')->with(Session::flash('berhasil_edit', true));
    }
}
