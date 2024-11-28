<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class adminController extends Controller
{
    public function show_dashboard()
    {
        return view('admin.pages.dashboard.dashboard', [
            'title' => 'Dashboard',
        ]);
    }
}
