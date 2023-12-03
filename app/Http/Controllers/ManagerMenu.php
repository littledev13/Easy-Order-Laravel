<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ManagerMenu extends Controller
{
    //
    public function indexMenu()
    {
        $data = Menu::all();
        return view('admin.manager.menu.index', [
            'menus' => $data
        ]);
    }
    // ? Akun
    public function index()
    {
        $user = Auth::user()->level;
        return view('admin.manager.index', [
            'level' => $user
        ]);
    }

    public function showAkun()
    {
        // $toko = Auth::user()->id_toko;

        $Users = User::where('id_toko', '=', Auth::user()->id_toko)->get();
        return view('admin.manager.akun.index', [
            'akuns' => $Users,
        ]);
    }
    public function addAkun(Request $request)
    {
        $request->validate(
            [
                'nama' => 'required|string|max:50',
                'username' => 'required|string|max:25|unique:users,username,',
                'password' => 'required|string|max:18',
                'no_hp' => 'required|string|max:13',
                'level' => 'required|string|max:15',
            ],
            [
                'nama.required' => 'Gagal membuat akun, errorr nama',
                'username.required' => 'Gagal membuat akun, errorr username',
                'password.required' => 'Gagal membuat akun, errorr password',
                'no_hp.required' => 'Gagal membuat akun, errorr nohp',
                'level.required' => 'Gagal membuat akun, errorr level',
            ]
        );
        // dd($request);
        $user = User::create([
            'nama' => $request->input('nama'),
            'username' => $request->input('username'),
            'password' => $request->input('password'),
            'no_hp' => $request->input('no_hp'),
            'level' => $request->input('level'),
            'id_toko' => Auth::user()->id_toko,
        ]);
        return redirect()->route('manager.akun')->with('berhasil', 'Data akun berhasil disimpan.');
        // $toko = Auth::user()->id_toko;
    }
    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('manager.akun')->with('success', 'Data akun berhasil dihapus.');
    }
    public function edit(User $user)
    {
        return view('admin.manager.akun.{id}.index', compact('user'));
    }
    public function update(Request $request, User $user)
    {
        // dd('Sebelum update', $akun->toArray());
        $request->validate([
            'nama' => 'required|string|max:50',
            'username' => 'required|string|max:25',
            'no_hp' => 'required|string|max:13',
            'level' => 'required|string|max:15',
        ], [
            'nama.required' => 'Gagalmengubah nama',
            'username.required' => 'Username sudah ada',
            'no_hp.required' => 'Gagal mengubah No Hp',
            'level.required' => 'Gagal Mengubah level',
        ]);
        $data = [
            'nama' => $request->input('nama'),
            'username' => $request->input('username'),
            'no_hp' => $request->input('no_hp'),
            'level' => $request->input('level'),
            'id_toko' => Auth::user()->id_toko
        ];
        if ($request->filled('password')) {
            // $data['password'] = bcrypt($request->input('password'));
            $data['password'] = bcrypt($request->input('password'));
        }
        $user->update($data);
        // dd('Update selesai');
        // dd('Setelah update', $akun->toArray());

        return redirect()->route('manager.akun')->with('berhasil', 'Data akun berhasil diupdate');
    }
}