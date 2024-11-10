<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\Menu;
use App\Models\Toko;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    //
    public function index(Request $request)
    {
        // $data = Menu::paginate(15);
        $tokos = Toko::where('id', '>', 1)->get();

        $kategori = Kategori::select('nama')->groupBy("nama")->get();
        // dd($kategori);
        if ($request->has('search')) {
            $searchTerm = $request->search;
            $data = Menu::where(function ($query) use ($searchTerm) {
                $query->where('nama', 'LIKE', '%' . $searchTerm . '%')
                    ->orWhere('kategori', 'LIKE', '%' . $searchTerm . '%')
                    ->orWhere('stock', 'LIKE', '%' . $searchTerm . '%')
                    ->orWhere('deskripsi', 'LIKE', '%' . $searchTerm . '%')
                    ->orWhere('harga', 'LIKE', '%' . $searchTerm . '%')
                    ->orWhere('id_toko', 'LIKE', '%' . $searchTerm . '%');
            })
                ->paginate(15);
        } else {
            $data = Menu::where('id', '>', 1)->paginate(15);
        }

        return view('admin.administrator.menu.index', [
            'menus' => $data,
            'tokos' => $tokos,
            'kategori' => $kategori
        ]);
    }
    public function destroy(Menu $menu)
    {
        $menu->delete();

        return redirect()->route('menu')->with('success', 'Data Menu berhasil dihapus.');
    }

    public function addMenu(Request $request)
    {
        // dd($request->tipe);
        if ($request->tipe == 'kategori') {
            // dd($request->type);
            # code...
            $request->validate([
                'nama' => [
                    'required',
                    'string',
                    'max:25',
                    Rule::unique('kategoris', 'nama')->ignore($request->id),
                ],
                'image_url' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
                'id_toko' => 'required',
            ], [
                // Pesan error sesuai dengan aturan validasi
                'nama.required' => 'Gagal menginput nama. Harap gunakan nama lain!',
                'image_url.image' => 'Format file salah atau file terlalu besar',
                'id_toko.required' => 'Harap pilih toko',
            ]);
            $data = Kategori::create($request->all());
            if ($request->hasFile('image_url')) {
                $request->file('image_url')->move('img/kategori/', $request->file('image_url')->getClientOriginalName());
                $data->image_url = $request->file('image_url')->getClientOriginalName();
                $data->save();
            }
            return redirect()->route('menu')->with('success', 'Data Berhasil Disimpan');
        }
        if ($request->tipe == 'menu') {
            // dd($chechkKategori);
            $request->validate([
                'image_url' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Menentukan aturan validasi untuk file foto
                'nama' => [
                    'required',
                    'string',
                    'max:25',
                    Rule::unique('menus', 'nama')->ignore($request->id),
                ],
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
            $chechkKategori = Kategori::where('id_toko', $request->id_toko)->whereIn('nama', [$request->kategori])->first();
            if (!$chechkKategori) {
                Kategori::create([
                    "nama" => $request->kategori,
                    'id_toko' => $request->id_toko
                ]);
            }

            $data = Menu::create($request->except('tipe'));
            if ($request->hasFile('image_url')) {
                $request->file('image_url')->move('img/menu/', $request->file('image_url')->getClientOriginalName());
                $data->image_url = $request->file('image_url')->getClientOriginalName();
                $data->save();
            }
            return redirect()->route('menu')->with('success', 'Data Berhasil Disimpan');
        }
    }
    // public function addKategori(request $request)
    // {

    // }
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