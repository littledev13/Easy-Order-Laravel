<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Toko;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    //
    public function index()
    {
        $data = Menu::all();
        $tokos = Toko::where('id', '>', 1)->get();

        return view('admin.administrator.menu.index', [
            'menus' => $data,
            'tokos' => $tokos
        ]);
    }
    public function destroy(Menu $menu)
    {
        $menu->delete();

        return redirect()->route('menu')->with('success', 'Data Menu berhasil dihapus.');
    }

    public function addMenu(request $request)
    {
        $request->validate([
            'image_url' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Menentukan aturan validasi untuk file foto
            'nama' => 'required|string|max:50',
            'kategori' => 'required',
            'deskripsi' => 'required',
            'harga' => 'required',
            'id_toko' => 'required',
        ], [
            'image_url.required' => 'Format file salah atau file terlalu besar',
            'nama.required' => 'Nama menu belum diisi atau Nama menu sudah ada',
            'kategori.required' => 'Harap pilih kategori',
            'deskripsi.required' => 'Harap isi deskripsi',
            'harga.required' => 'Harap isi harga',
            'id_toko.required' => 'Harap pilih toko',
        ]);
        $data = Menu::create($request->all());
        if ($request->hasFile('image_url')) {
            $request->file('image_url')->move('img/menu/', $request->file('image_url')->getClientOriginalName());
            $data->image_url = $request->file('image_url')->getClientOriginalName();
            $data->save();
        }
        return redirect()->route('menu')->with('success', 'Data Berhasil Disimpan');
    }
    public function edit(Menu $menu)
    {
        return view('admin.administrator.menu.{id}.index', compact('menu'));
    }
    public function update(Request $request, Menu $menu)
    {
        $request->validate([
            'image_url' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // Menentukan aturan validasi untuk file foto
            'nama' => 'required|string|max:50',
            'kategori' => 'required',
            'deskripsi' => 'required',
            'harga' => 'required',
        ], [
            'image_url.mimes' => 'format image harus jpeg,png,jpg,gif', // Menentukan aturan validasi untuk file foto
            'image_url.max' => 'max:2048 atau 2mb', // Menentukan aturan validasi untuk file foto
            'nama.required' => 'nama wajib diisi',
            'kategori.required' => 'kategori wajib diisi',
            'deskripsi.required' => 'deskripsi wajib diisi',
            'harga.required' => 'harga wajib diisi',
        ]);
        if ($request->hasFile('image_url')) {
            // Menghasilkan nama file yang unik dengan menggabungkan timestamp
            $imageName = time() . '_' . $request->file('image_url')->getClientOriginalName();
            $request->file('image_url')->move('img/menu/', $imageName);

            // Update record dengan nama file gambar yang baru
            $menu->update([
                'image_url' => $imageName,
                'nama' => $request->input('nama'),
                'kategori' => $request->input('kategori'),
                'deskripsi' => $request->input('deskripsi'),
                'harga' => $request->input('harga'),
            ]);
            return redirect()->route('menu')->with('success', 'Data Menu berhasil diupdate. gambar');
        } else {
            // Jika tidak ada gambar yang diunggah, update data tanpa perubahan gambar
            $menu->update([
                'nama' => $request->input('nama'),
                'kategori' => $request->input('kategori'),
                'deskripsi' => $request->input('deskripsi'),
                'harga' => $request->input('harga'),
            ]);
            return redirect()->route('menu')->with('success', 'Data Menu berhasil diupdate. ');
        }


    }

}