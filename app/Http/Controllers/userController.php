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
}
