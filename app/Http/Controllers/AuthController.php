<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{

    public function loginFormAdmin()
    {
        return view('layouts.login.app');
    }
    public function auth(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();


        //dd($request->all());
        $credentials = $request->only('username', 'password');


        if (Auth::attempt($credentials)) {
            // Authentication passed...
            // Periksa status pengguna
            $user = Auth::user();
            if ($user->status == 1) {
                return redirect()->intended('/home');
            } else {
                Auth::logout(); // Logout jika status pengguna bukan 1
                return redirect()->back()->withErrors(['username' => 'Your account is not active']);
            }
        }

        return redirect()->back()->withInput()->withErrors(['username' => 'Invalid username or password']);
    }

    public function logout(Request $request)
    {
        $guard = 'web';



        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();
        return redirect('/login');
    }

    public function gantiPassword()
    {
        return view('auth.ganti-password');
    }

    public function saveGantiPassword(Request $request)
    {
        try {
            $request->validate([
                'current_password' => 'required',
                'new_password' => 'required|different:current_password',
                'confirm_password' => 'required|same:new_password',
            ]);

            $user = Auth::user();

            if (Hash::check($request->current_password, $user->password)) {
                $user->update([
                    'password' => Hash::make($request->new_password),
                ]);

                return redirect('logout');
            }

            return back()->with('error', 'Password lama tidak cocok');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function LoginApi(Request $request)
    {
        $credentials = $request->only('username', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $token = $user->createToken('API')->plainTextToken;

            return response()->json(['token' => $token], 200);
        } else {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
    }
}
