<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class userController extends Controller
{
    public function show_dashboard()
    {
        return view('user.pages.dashboard.dashboard', [
            'title' => 'Dashboard User',
        ]);
    }

    public function show_transaksi()
    {
        return view('user.pages.booking.booking', [
            'title' => 'Booking',
        ]);
    }

    public function show_ulasan()
    {
        return view('user.pages.ulasan.ulasan', [
            'title' => 'Ulasan',
        ]);
    }
}
