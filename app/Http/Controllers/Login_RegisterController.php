<?php

namespace App\Http\Controllers;

use App\Mail\KirimEmail;
use App\Models\Kamar;
use App\Models\Penghuni;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Laravel\Sanctum\HasApiTokens;

class Login_RegisterController extends Controller
{

    public function __construct()
    {
        Auth::logout();
        return redirect('/');
    }
    // public function __construct()
    //     {


    //     $adminEmail = 'admin';


    //     $adminUser = User::where('username', $adminEmail)->first();



    //     if (!$adminUser) {
    //         User::create([

    //             'username' => 'admin',
    //             'role' => 'admin',
    //             'password' => Hash::make('admin123'),
    //         ]);
    //     }

    // }

    public function show_login()
    {
        return view('login_register.login');
    }

    public function loginakun(Request $request)
    {

        // dd($request->all());

        $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);

        $credentials = $request->only('email', 'password'); // Hanya ambil email dan password

        if (Auth::attempt(['email' => $request->input('email'), 'password' => $request->input('password')], true)) {


            if (Auth::user()->role == 'admin') {

                return redirect()->intended('admin/dashboard')->with(Session::flash('success_message', true));
            }
        } else {
            return redirect()->back()->with('error')->with(Session::flash('gagal_login', true));
            // Autentikasi gagal
            // Lakukan sesuatu
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/')->with(Session::flash('berhasil_logout', true));
    }

    public function api_register(Request $request)
    {
        // Validasi input
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'password' => 'required',
        ]);

        // Simpan user ke database
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role' => 'user',
            'password' => Hash::make($request->password),

        ]);

        // Buat token untuk autentikasi
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Registration successful',
            'user' => $user,
            'token' => $token,
        ], 201);
    }

    /**
     * Login a user
     */
    public function api_login(Request $request)
    {
        // Validasi input
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        // Cek kredensial
        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
                'message' => 'Invalid login credentials',
            ], 401);
        }

        // Ambil user yang login
        $user = Auth::user();

        // Cek apakah user sudah register (validasi tambahan tidak diperlukan karena `register` membuat user otomatis)
        if (!$user) {
            return response()->json([
                'message' => 'User not found or not registered',
            ], 404);
        }

        if ($user->role !== 'user') {
            return response()->json([
                'message' => 'You do not have permission to access this area',
            ], 403); // Return 403 Forbidden jika role bukan 'user'
        }

        // Buat token untuk autentikasi
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Login successful',
            'user' => $user,
            'token' => $token,
        ], 200);
    }

    /**
     * Logout a user
     */
    public function api_logout(Request $request)
    {
        // Hapus token autentikasi
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Logged out successfully',
        ]);
    }
}
