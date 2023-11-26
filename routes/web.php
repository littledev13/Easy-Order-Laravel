<?php

use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::middleware(['guest'])->group(function () {

    Route::get('/auth', [LoginController::class, 'index'])->name('login');
    Route::post('/auth', [LoginController::class, 'authenticate']);
    Route::get('/auth/register', function () {
        return view('auth.register.index');
    });
    Route::get('/home', function () {
        return redirect('/auth');
    });
    Route::get('/', [LoginController::class, 'index2']);
});
Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', function () {
        $user = Auth::user()->level;
        if ($user === 'administrator') {
            return view('admin.administrator.index', [
                'user' => $user
            ]);
        } elseif ($user === 'manager') {
            return view('admin.administrator.index', [
                'user' => 'manager'
            ]);
        } elseif ($user === 'kasir') {
            return view('admin.administrator.index', [
                'user' => 'kasir'
            ]);
        } elseif ($user === 'koki') {
            return view('admin.administrator.index', [
                'user' => 'koki'
            ]);
        } else {
            return view('admin.administrator.index', [
                'user' => 'gajelas akun mana'
            ]);
        }
    });
    Route::get('/logout.php', [LoginController::class, 'logout']);
});