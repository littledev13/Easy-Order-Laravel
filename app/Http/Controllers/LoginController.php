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

            $user = Auth::user();
            $redirectPath = $this->getRedirectPathByLevel($user->level);

            return redirect()->intended($redirectPath);
        }

        return back()->with([
            'loginError' => 'error'
        ])->onlyInput('username');
    }
    private function getRedirectPathByLevel(string $level)
    {
        switch ($level) {
            case 'administrator':
                return '/admin';
            case 'manager':
                return '/manager';
            case 'kasir':
                return '/kasir';
            case 'koki':
                return '/koki';
            // Add more cases for other levels if needed
            default:
                return '/';
        }
    }
    public function logout()
    {
        Auth::logout();
        return redirect('/auth');
    }
}