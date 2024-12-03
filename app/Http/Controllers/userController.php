<?php

namespace App\Http\Controllers;

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
        $user = User::find(Auth::user()->id);
        return view('user.pages.booking.booking', [
            'title' => 'Booking',
            'user' => $user,
        ]);
    }

    public function show_ulasan()
    {
        $user = User::find(Auth::user()->id);
        return view('user.pages.ulasan.ulasan', [
            'title' => 'Ulasan',
            'user' => $user
        ]);
    }
}
