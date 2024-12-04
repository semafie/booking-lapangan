<?php

namespace App\Http\Controllers;

use App\Models\jadwalModel;
use App\Models\lapanganModel;
use Illuminate\Http\Request;

class adminController extends Controller
{
    public function show_dashboard()
    {
        return view('admin.pages.dashboard.dashboard', [
            'title' => 'Dashboard',
        ]);
    }

    public function show_pelanggan()
    {
        return view('admin.pages.pelanggan.pelanggan', [
            'title' => 'Pelanggan',
        ]);
    }

    public function show_ulasan()
    {
        return view('admin.pages.ulasan.ulasan', [
            'title' => 'Ulasan',
        ]);
    }

    public function show_laporan()
    {
        return view('admin.pages.laporan.laporan', [
            'title' => 'Laporan',
        ]);
    }

    public function show_lapangan()
    {
        $lapangan = lapanganModel::all();
        return view('admin.pages.lapangan.lapangan', [
            'title' => 'Lapangan',
            'lapangan' => $lapangan,
        ]);
    }

    public function show_jadwal($id)
    {
        $jadwal = jadwalModel::with('lapangan')->where('id_lapangan', $id)->get();
        // dd($jadwal);
        return view('admin.pages.jadwal.jadwal', [
            'title' => 'Jadwal',
            'jadwal' => $jadwal,
            'id_lapangan' => $id
        ]);
    }

    public function show_transaksi()
    {
        $jadwal = jadwalModel::with('lapangan')->where('status', 'tersedia')->get();
        return view('admin.pages.transaksi.transaksi', [
            'title' => 'Transaksi',
            'jadwal' => $jadwal,
        ]);
    }
}
