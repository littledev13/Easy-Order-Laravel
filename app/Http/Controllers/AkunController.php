<?php

namespace App\Http\Controllers;

use App\Models\Akun;
use App\Models\User;
use App\Models\Toko;
use Illuminate\Http\Request;

class AkunController extends Controller
{
    //
    public function showAkun(Request $request)
    {
        // $tokos = Toko::all();
        // $Users = User::where('id', '>', 1)->paginate(15);
        $tokos = Toko::where('id', '>', 1)->get();
        if ($request->has('search')) {
            $searchTerm = $request->search;
            $Users = User::where('id', '>', 1)
                ->where(function ($query) use ($searchTerm) {
                    $query->where('nama', 'LIKE', '%' . $searchTerm . '%')
                        ->orWhere('username', 'LIKE', '%' . $searchTerm . '%')
                        ->orWhere('no_hp', 'LIKE', '%' . $searchTerm . '%')
                        ->orWhere('id_toko', 'LIKE', '%' . $searchTerm . '%')
                        ->orWhere('level', 'LIKE', '%' . $searchTerm . '%');
                })
                ->paginate(15);
        } else {
            $Users = User::where('id', '>', 1)->paginate(15);
        }
        return view('admin.administrator.akun.index', [
            'akuns' => $Users,
            'tokos' => $tokos,
        ]);
    }
    // ! Create
    public function createAkun(Request $request)
    {
        $request->validate(
            [
                'nama' => 'required|string|max:50',
                'username' => 'required|string|max:25|unique:users,username,',
                'password' => 'required|string|max:18',
                'no_hp' => 'required|string|max:13',
                'level' => 'required|string|max:15',
                'id_toko' => 'required|string|max:100',
            ],
            [
                'nama.required' => 'Gagal membuat akun, errorr nama',
                'username.required' => 'Gagal membuat akun, errorr username',
                'password.required' => 'Gagal membuat akun, errorr password',
                'no_hp.required' => 'Gagal membuat akun, errorr nohp',
                'level.required' => 'Gagal membuat akun, errorr level',
                'id_toko.required' => 'Gagal membuat akun, errorr toko',
            ]
        );
        // dd($request);
        $user = User::create([
            'nama' => $request->input('nama'),
            'username' => $request->input('username'),
            'password' => $request->input('password'),
            'no_hp' => $request->input('no_hp'),
            'level' => $request->input('level'),
            'id_toko' => $request->input('id_toko'),
        ]);
        return redirect()->route('akun')->with('berhasil', 'Data akun berhasil disimpan.');
    }
    // ! Delete

    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('akun')->with('success', 'Data akun berhasil dihapus.');
    }


    // ! Edit & Update
    public function edit(User $akun)
    {
        return view('admin.administrator.akun.{id}.index', compact('akun'));
    }
    public function update(Request $request, User $akun)
    {
        $request->validate([
            'nama' => 'required|string|max:50',
            'username' => 'required|string|max:25',
            // 'password' => 'string|max:18',
            'no_hp' => 'required|string|max:13',
            'level' => 'required|string|max:15',
        ], [
            'nama.required' => 'Gagalmengubah nama',
            'username.required' => 'Username sudah ada',
            // 'password' => 'Gagal mengubah password',
            'no_hp.required' => 'Gagal mengubah No Hp',
            'level.required' => 'Gagal Mengubah level',
        ]);
        $data = [
            'nama' => $request->input('nama'),
            'username' => $request->input('username'),
            'no_hp' => $request->input('no_hp'),
            'level' => $request->input('level'),
        ];
        if ($request->filled('password')) {
            // $data['password'] = bcrypt($request->input('password'));
            $data['password'] = bcrypt($request->input('password'));
        }
        $akun->update($data);

        return redirect()->route('akun')->with('berhasil', 'Data akun berhasil diupdate.');
    }
}