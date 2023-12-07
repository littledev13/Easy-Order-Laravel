<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Nota;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ManagerController extends Controller {
    // ? Akun
    public function index() {
        $user = Auth::user()->level;
        return view('admin.manager.index', [
            'level' => $user
        ]);
    }

    public function showAkun() {
        // $toko = Auth::user()->id_toko;

        $Users = User::where('id_toko', '=', Auth::user()->id_toko)->get();
        return view('admin.manager.akun.index', [
            'akuns' => $Users,
        ]);
    }
    public function addAkun(Request $request) {
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
    public function destroy(User $user) {
        $user->delete();

        return redirect()->route('manager.akun')->with('success', 'Data akun berhasil dihapus.');
    }
    public function edit(User $user) {
        return view('admin.manager.akun.{id}.index', compact('user'));
    }
    public function update(Request $request, User $user) {
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
        if($request->filled('password')) {
            // $data['password'] = bcrypt($request->input('password'));
            $data['password'] = bcrypt($request->input('password'));
        }
        $user->update($data);
        // dd('Update selesai');
        // dd('Setelah update', $akun->toArray());

        return redirect()->route('manager.akun')->with('berhasil', 'Data akun berhasil diupdate');
    }
    // ? Menu
    public function indexMenu() {
        $data = Menu::where('id_toko', '=', Auth::user()->id_toko)->get();
        return view('admin.manager.menu.index', [
            'menus' => $data,
        ]);
    }
    public function addMenu(request $request) {
        $request->validate([
            'image_url' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Menentukan aturan validasi untuk file foto
            'nama' => 'required|string|max:50',
            'kategori' => 'required',
            'deskripsi' => 'required',
            'harga' => 'required',
        ], [
            'image_url.required' => 'Format file salah atau file terlalu besar',
            'nama.required' => 'Nama menu belum diisi atau Nama menu sudah ada',
            'kategori.required' => 'Harap pilih kategori',
            'deskripsi.required' => 'Harap isi deskripsi',
            'harga.required' => 'Harap isi harga',
            'id_toko.required' => 'Harap pilih toko',
        ]);
        $data = Menu::create($request->all());
        $data->id_toko = Auth::user()->id_toko;
        if($request->hasFile('image_url')) {
            $request->file('image_url')->move('img/menu/', $request->file('image_url')->getClientOriginalName());
            $data->image_url = $request->file('image_url')->getClientOriginalName();
            $data->save();
        }
        return redirect()->route('manager.menu')->with('success', 'Data Berhasil Disimpan');
    }
    public function destroyMenu(Menu $menu) {
        $menu->delete();

        return redirect()->route('manager.menu')->with('success', 'Data Menu berhasil dihapus.');
    }
    public function editMenu(Menu $menu) {
        return view('admin.manager.menu.{id}.index', compact('menu'));
    }
    public function updateMenu(Request $request, Menu $menu) {
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
        if($request->hasFile('image_url')) {
            // Menghasilkan nama file yang unik dengan menggabungkan timestamp
            $imageName = time().'_'.$request->file('image_url')->getClientOriginalName();
            $request->file('image_url')->move('img/menu/', $imageName);

            // Update record dengan nama file gambar yang baru
            $menu->update([
                'image_url' => $imageName,
                'nama' => $request->input('nama'),
                'kategori' => $request->input('kategori'),
                'deskripsi' => $request->input('deskripsi'),
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
            ]);
            return redirect()->route('manager.menu')->with('success', 'Data Menu berhasil diupdate. ');
        }


    }
    function laporan() {
        $startDate = Carbon::now()->subDays(7)->startOfDay();

        // Mengambil data total nota dengan status 'taked' dan 'cancel'
        $data = Nota::select(
            DB::raw('DATE(created_at) as tanggal'),
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
        foreach($data as $item) {
            $groupedData[$item->tanggal]['total_nota'] = $item->total_nota;
            $groupedData[$item->tanggal]['jumlah_nota_taked'] = $item->jumlah_nota_taked;
            $groupedData[$item->tanggal]['total_harga_taked'] = $item->total_harga_taked;
            $groupedData[$item->tanggal]['jumlah_nota_cancel'] = $item->jumlah_nota_cancel;
            $groupedData[$item->tanggal]['total_harga_cancel'] = $item->total_harga_cancel;
        }
        // dd($groupedData);
        return view('admin.manager.laporan.index', ["data" => $groupedData]);
    }

}