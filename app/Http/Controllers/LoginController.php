<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    //
    public function index()
    {
        return view('auth.index');
    }
    public function index2()
    {
        $users = Auth::user();
        return view('index', [
            'users' => $users
        ]);
    }
    public function authenticate(Request $request): RedirectResponse
    {

        $credentials = $request->validate([
            'username' => ['required'],
            'password' => ['required'],
        ]);


        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()->intended('/dashboard');
        }

        return back()->with([
            'loginError' =>
                'error'
        ])->onlyInput('username');
    }
    public function logout()
    {
        Auth::logout();
        return redirect('/auth');
    }
}