<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\Menu;
use App\Models\Nota;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class ManagerController extends Controller
{
    // ? Akun
    public function index()
    {
        $user = Auth::user();
        return view('admin.manager.index', [
            'level' => $user
        ]);
    }

    public function showAkun(Request $request)
    {
        // $toko = Auth::user()->id_toko;
        $user = Auth::user();
        $Users = User::where('id_toko', '=', Auth::user()->id_toko)->paginate(15);
        if ($request->has('search')) {
            $searchTerm = $request->search;
            $Users = User::where('id_toko', '=', Auth::user()->id_toko)
                ->where(function ($query) use ($searchTerm) {
                    $query->where('nama', 'LIKE', '%' . $searchTerm . '%')
                        ->orWhere('username', 'LIKE', '%' . $searchTerm . '%')
                        ->orWhere('no_hp', 'LIKE', '%' . $searchTerm . '%')
                        ->orWhere('level', 'LIKE', '%' . $searchTerm . '%');
                })
                ->paginate(15);
        } else {
            $Users = User::where('id_toko', '=', Auth::user()->id_toko)->paginate(15);
        }
        // $Users = User::where('id_toko', '=', Auth::user()->id_toko)->paginate(15);
        return view('admin.manager.akun.index', [
            'level' => $user,
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
        $level = Auth::user();
        return view('admin.manager.akun.{id}.index', compact('user', 'level'));
    }

    public function update(Request $request, User $user)
    {
        // dd('Sebelum update', $akun->toArray());
        $request->validate([
            'nama' => 'required|string|max:50',
            'username' => [
                'required',
                'string',
                'max:25',
                Rule::unique('users')->ignore($user->id),
            ],
            'no_hp' => [
                'required',
                'string',
                'max:13',
                Rule::unique('users')->ignore($user->id),
            ],
            'level' => 'required|string|max:15',
        ], [
            'nama.required' => 'Gagal mengubah nama',
            'username.required' => 'Username diperlukan',
            'username.unique' => 'Username sudah ada',
            'no_hp.required' => 'Gagal mengubah No Hp',
            // 'no_hp.unique' => 'No Hp sudah ada',
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
    // ? Menu
    public function indexMenu(Request $request)
    {
        // $data = Menu::where('id_toko', '=', Auth::user()->id_toko)->paginate(3);
        $kategori = Kategori::select('nama')->where('id_toko', '=', Auth::user()->id_toko)->groupBy('nama')->get();
        $user = Auth::user();
        // dd($kategori);
        if ($request->has('search')) {
            $searchTerm = $request->search;
            $data = Menu::where('id_toko', '=', Auth::user()->id_toko)
                ->where(function ($query) use ($searchTerm) {
                    $query->where('nama', 'LIKE', '%' . $searchTerm . '%')
                        ->orWhere('kategori', 'LIKE', '%' . $searchTerm . '%')
                        ->orWhere('stock', 'LIKE', '%' . $searchTerm . '%')
                        ->orWhere('harga', 'LIKE', '%' . $searchTerm . '%')
                        ->orWhere('deskripsi', 'LIKE', '%' . $searchTerm . '%');
                })
                ->paginate(15);
        } else {
            $data = Menu::where('id_toko', '=', Auth::user()->id_toko)->paginate(10);
        }
        return view('admin.manager.menu.index', [
            'menus' => $data,
            'kategori' => $kategori,
            'level' => $user

        ]);
    }
    public function addMenu(Request $request)
    {
        // Ambil id_toko dari user yang saat ini masuk
        $idToko = Auth::user()->id_toko;

        if ($request->tipe === 'kategori') {
            $request->validate([
                'nama' => [
                    'required',
                    'string',
                    'max:25',
                    Rule::unique('kategoris', 'nama')->ignore($request->id),
                ],
                'image_url' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ], [
                'nama.required' => 'Gagal menginput nama. Harap gunakan nama lain!',
                'image_url.image' => 'Format file salah atau file terlalu besar',
            ]);

            $data = Kategori::create([
                'nama' => $request->nama,
                'id_toko' => $idToko,
            ]);

            if ($request->hasFile('image_url')) {
                $fileName = $request->file('image_url')->getClientOriginalName();
                $destinationPath = public_path('img/kategori');

                // Buat direktori jika belum ada
                if (!File::exists($destinationPath)) {
                    File::makeDirectory($destinationPath, 0755, true, true);
                }

                // Pindahkan file
                $request->file('image_url')->move($destinationPath, $fileName);
                $data->image_url = $fileName;
                $data->save();
            }

            return redirect()->route('manager.menu')->with('success', 'Data Berhasil Disimpan');
        }

        if ($request->tipe === 'menu') {
            $request->validate([
                'image_url' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
                'nama' => 'required|string|max:50',
                'kategori' => 'required',
                'stock' => 'required',
                'deskripsi' => 'required|string|max:150',
                'harga' => 'required',
            ], [
                'image_url.required' => 'Format file salah atau file terlalu besar',
                'nama.required' => 'Nama menu belum diisi atau Nama menu sudah ada',
                'kategori.required' => 'Harap pilih kategori',
                'stock.required' => 'Harap pilih stock',
                'deskripsi.required' => 'Harap isi deskripsi',
                'harga.required' => 'Harap isi harga',
            ]);

            $kategori = Kategori::firstOrCreate([
                'nama' => $request->kategori,
                'id_toko' => $idToko,
            ]);

            // Membuat instans baru dari Menu dengan id_toko diisi
            $data = new Menu($request->except("tipe", "image_url"));
            $data->id_toko = $idToko; // Mengisi id_toko

            if ($request->hasFile('image_url')) {
                $fileName = $request->file('image_url')->getClientOriginalName();
                $destinationPath = public_path('img/menu');

                // Buat direktori jika belum ada
                if (!File::exists($destinationPath)) {
                    File::makeDirectory($destinationPath, 0755, true, true);
                }

                // Pindahkan file
                $request->file('image_url')->move($destinationPath, $fileName);
                $data->image_url = $fileName;
            } else {
                // Set default value for image_url if no file is uploaded
                $data->image_url = '';
            }

            $data->save(); // Menyimpan data ke database

            return redirect()->route('manager.menu')->with('success', 'Data Berhasil Disimpan');
        }
    }
    public function destroyMenu(Menu $menu)
    {
        $menu->delete();

        return redirect()->route('manager.menu')->with('success', 'Data Menu berhasil dihapus.');
    }
    public function editMenu(Menu $menu)
    {
        $kategori = Kategori::select('nama')->where('id_toko', '=', Auth::user()->id_toko)->groupBy('nama')->get();
        // dd($kategori);
        return view('admin.manager.menu.{id}.index', compact('menu'), [
            'kategori' => $kategori,
            'level' => Auth::user()
        ]);
    }
    public function updateMenu(Request $request, Menu $menu)
    {
        $request->validate([
            'image_url' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // Menentukan aturan validasi untuk file foto
            'nama' => 'required|string|max:50',
            'kategori' => 'required',
            'deskripsi' => 'required|string|max:150',
            'stock' => 'required',
            'harga' => 'required',
        ], [
            'image_url.mimes' => 'format image harus jpeg,png,jpg,gif', // Menentukan aturan validasi untuk file foto
            'image_url.max' => 'max:2048 atau 2mb', // Menentukan aturan validasi untuk file foto
            'nama.required' => 'nama wajib diisi',
            'kategori.required' => 'kategori wajib diisi',
            'deskripsi.required' => 'deskripsi wajib diisi',
            'stock.required' => 'stock wajib diisi',
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
                'stock' => $request->input('stock'),
                'harga' => $request->input('harga'),
            ]);
            return redirect()->route('manager.menu')->with('success', 'Data Menu berhasil diupdate. gambar');
        } else {
            // Jika tidak ada gambar yang diunggah, update data tanpa perubahan gambar
            $menu->update([
                'nama' => $request->input('nama'),
                'kategori' => $request->input('kategori'),
                'deskripsi' => $request->input('deskripsi'),
                'harga' => $request->input('harga'),
                'stock' => $request->input('stock'),
            ]);
            return redirect()->route('manager.menu')->with('success', 'Data Menu berhasil diupdate. ');
        }


    }
    function laporan()
    {
        $startDate = Carbon::now()->subDays(7)->startOfDay();

        // Mengambil data total nota dengan status 'taked' dan 'cancel'
        $data = Nota::select(
            DB::raw('DATE(updated_at) as tanggal'),
            DB::raw('count(*) as total_nota'),
            DB::raw('sum(CASE WHEN status = "taked" THEN 1 ELSE 0 END) as jumlah_nota_taked'),
            DB::raw('sum(CASE WHEN status = "taked" THEN total_harga ELSE 0 END) as total_harga_taked'),
            DB::raw('sum(CASE WHEN status = "cancel" THEN 1 ELSE 0 END) as jumlah_nota_cancel'),
            DB::raw('sum(CASE WHEN status = "cancel" THEN total_harga ELSE 0 END) as total_harga_cancel')
        )
            ->where('created_at', '>=', $startDate)
            ->groupBy('tanggal')
            ->orderBy('tanggal')
            ->get();

        // Mengelompokkan data ke dalam array berdasarkan tanggal
        $groupedData = [];
        foreach ($data as $item) {
            $groupedData[$item->tanggal]['total_nota'] = $item->total_nota;
            $groupedData[$item->tanggal]['jumlah_nota_taked'] = $item->jumlah_nota_taked;
            $groupedData[$item->tanggal]['total_harga_taked'] = $item->total_harga_taked;
            $groupedData[$item->tanggal]['jumlah_nota_cancel'] = $item->jumlah_nota_cancel;
            $groupedData[$item->tanggal]['total_harga_cancel'] = $item->total_harga_cancel;
        }

        $collection = new Collection($groupedData);

        // Menggunakan paginasi pada objek Collection
        $perPage = 15;
        $currentPage = request()->get('page', 1); // Mengambil halaman saat ini dari URL
        $pagedData = $collection->slice(($currentPage - 1) * $perPage, $perPage)->all();

        $paginatedData = new \Illuminate\Pagination\LengthAwarePaginator(
            $pagedData,
            $collection->count(),
            $perPage,
            $currentPage,
            ['path' => url('your-path')]
        );

        return view('admin.manager.laporan.index', [
            "data" => $paginatedData,
            'level' => Auth::user()
        ]);
    }

}