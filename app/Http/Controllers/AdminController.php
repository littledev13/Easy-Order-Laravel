<?php

namespace App\Http\Controllers;

use App\Models\Toko;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    //
    public function index()
    {
        $user = Auth::user()->level;
        return view('admin.administrator.index');
    }
    public function showToko()
    {
        // $tokos = Toko::all();
        $tokos = Toko::where('id', '>', 1)->get();
        return view('admin.administrator.toko.index', [
            'tokos' => $tokos
        ]);
    }
    // ! Create
    public function createToko(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:25',
            'pemilik' => 'required|string|max:25',
            'deskripsi' => 'required|string|max:150',
            'alamat' => 'required|string|max:150',
        ]);
        $toko = Toko::create([
            'nama' => $request->input('nama'),
            'pemilik' => $request->input('pemilik'),
            'deskripsi' => $request->input('deskripsi'),
            'alamat' => $request->input('alamat'),
        ]);
        return redirect()->route('toko')->with('berhasil', 'Data toko berhasil disimpan.');
    }
    // ! Delete

    public function destroy(Toko $toko)
    {
        $toko->delete();

        return redirect()->route('toko')->with('success', 'Data toko berhasil dihapus.');
    }


    // ! Edit & Update
    public function edit(Toko $toko)
    {
        return view('admin.administrator.toko.{id}.index', compact('toko'));
    }

    public function update(Request $request, Toko $toko)
    {
        $request->validate([
            'nama' => 'required|string|max:25',
            'pemilik' => 'required|string|max:25',
            'deskripsi' => 'required|string|max:150',
            'alamat' => 'required|string|max:150',
        ]);
        $toko->update([
            'nama' => $request->input('nama'),
            'pemilik' => $request->input('pemilik'),
            'deskripsi' => $request->input('deskripsi'),
            'alamat' => $request->input('alamat'),
        ]);

        return redirect()->route('toko')->with('success', 'Data toko berhasil diupdate.');
    }
}