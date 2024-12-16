<?php

namespace App\Http\Controllers;

use App\Models\jadwalModel;
use App\Models\ulasanModel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class userController extends Controller
{
    public function show_dashboard()
    {
        $user = User::find(Auth::user()->id);
        return view('user.pages.dashboard.dashboard', [
            'title' => 'Dashboard User',
            'user' => $user,
        ]);
    }

    public function show_transaksi()
    {
        $jadwal = jadwalModel::with('lapangan')->where('status', 'tersedia')->get();
        $user = User::find(Auth::user()->id);
        return view('user.pages.booking.booking', [
            'title' => 'Booking',
            'user' => $user,
            'jadwal' => $jadwal,
        ]);
    }

    public function show_ulasan()
    {
        $user = User::find(Auth::user()->id);
        $ulasan = ulasanModel::where('id_user', $user->id)->get();
        return view('user.pages.ulasan.ulasan', [
            'title' => 'Ulasan',
            'user' => $user,
            'ulasan' => $ulasan,
        ]);
    }
}
