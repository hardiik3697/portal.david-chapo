<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * view
     */
    public function login(Request $request){
        return view('auth.login');
    }

    /**
     * signin
     */
    public function signin(LoginRequest $request)
    {
        $remember = $request->remember == '1' ? true : false;

        if (Auth::attempt(['username' => $request->username, 'password' => $request->password], $remember)) {
            $request->session()->regenerate();

            return response()->json(['message' => 'Login successful', 'status' => 'success'], 200);
        }

        return response()->json(['message' => 'The provided credentials do not match our records.', 'status' => 'error'], 201);
    }

    /**
     * logout
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
