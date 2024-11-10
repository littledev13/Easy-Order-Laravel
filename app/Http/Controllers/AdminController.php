<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Nota;
use App\Models\Pesanan;
use App\Models\Toko;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Support\Collection;

class AdminController extends Controller
{
    //
    public function index()
    {
        $user = Auth::user()->level;
        return view('admin.administrator.index');
    }
    public function showToko(Request $request)
    {
        // $tokos = Toko::all();
        if ($request->has('search')) {
            $searchTerm = $request->search;
            $tokos = Toko::where('id', '>', 1)
                ->where(function ($query) use ($searchTerm) {
                    $query->where('nama', 'LIKE', '%' . $searchTerm . '%')
                        ->orWhere('alamat', 'LIKE', '%' . $searchTerm . '%')
                        ->orWhere('deskripsi', 'LIKE', '%' . $searchTerm . '%')
                        ->orWhere('pemilik', 'LIKE', '%' . $searchTerm . '%');
                })
                ->paginate(15);
        } else {
            $tokos = Toko::where('id', '>', 1)->paginate(15);
        }

        return view('admin.administrator.toko.index', [
            'tokos' => $tokos
        ]);
    }
    // ! Create
    public function createToko(Request $request)
    {
        $request->validate([
            'nama' => [
                'required',
                'string',
                'max:25',
                Rule::unique('tokos', 'nama')->ignore($request->id),
            ],
            'pemilik' => 'required|string|max:25',
            'deskripsi' => 'required|string|max:150',
            'alamat' => 'required|string|max:150',
        ], [
            // Pesan error sesuai dengan aturan validasi
            'nama.required' => 'Gagal menginput nama. Harap gunakan nama lain!',
            'pemilik.required' => 'Gagal menginput pemilik.',
            'deskripsi.required' => 'Gagal menginput deskripsi.',
            'alamat.required' => 'Gagal menginput alamat.',
            'nama.unique' => 'Nama toko sudah terdaftar. Harap gunakan nama lain!',
        ]);

        // if ($validator->fails()) {
        //     // Jika validasi gagal, redirect kembali ke halaman sebelumnya dengan pesan error
        //     return redirect()->back()->withErrors($validator)->withInput();
        // }
        // dd($request);
        // Jika validasi sukses, simpan data toko dan arahkan ke halaman yang diinginkan
        Toko::create([
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
    function pesanan(Request $request)
    {
        // $nota = Nota::whereNotIn('status', ['taked', 'cancel'])->paginate(15);
        // $today = Carbon::now()->format('Y-m-d');
        if ($request->has('search')) {
            $searchTerm = $request->search;
            $nota = Nota::whereNotIn('status', ['taked', 'cancel'])
                ->where(function ($query) use ($searchTerm) {
                    $query->where('pembeli', 'LIKE', '%' . $searchTerm . '%')
                        ->orWhere('no_nota', 'LIKE', '%' . $searchTerm . '%')
                        ->orWhere('status', 'LIKE', '%' . $searchTerm . '%');
                })
                ->paginate(15);
        } elseif ($request->has('date')) {
            $dateFilter = $request->date;
            $nota = Nota::whereDate('created_at', $dateFilter)->whereNotIn('status', ['taked', 'cancel'])->paginate(15);
        } else {
            $nota = Nota::whereNotIn('status', ['taked', 'cancel'])->paginate(15);
        }
        return view('admin.administrator.pesanan.index', ['nota' => $nota]);
    }
    function detailsPesanan($no_nota)
    {
        $nota = Nota::where('no_nota', '=', $no_nota)->get();
        $pesanan = Pesanan::where('no_nota', '=', $no_nota)->get();

        return view('admin.administrator.pesanan.{id}.index', [
            'nota' => $nota,
            'pesanan' => $pesanan
        ]);
    }

    public function deletePesanan($no_nota)
    {
        // Mulai transaksi database
        DB::beginTransaction();
        try {
            // Ambil data nota dengan nomor nota tertentu
            $nota = Nota::where('no_nota', $no_nota)->first();
            // dd($nota);
            if ($nota) {
                // Hapus pesanan yang terkait
                Pesanan::where('no_nota', $no_nota)->delete();

                // Hapus nota
                $nota->update([
                    'status' => 'cancel'
                ]);

                // Commit transaksi jika berhasil
                DB::commit();

                return redirect()->route('pesanan')->with(
                    'berhasil',
                    'Nota Pesanan berhasil dihapus'
                );
            } else {
                // Rollback transaksi jika nota tidak ditemukan
                DB::rollback();

                return redirect()->route('pesanan')->with('gagal', 'Nota Pesanan gagal dihapus');
            }
        } catch (\Exception $e) {
            // Rollback transaksi jika terjadi kesalahan lainnya
            DB::rollback();

            return redirect()->route('pesanan')->with('gagal', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
    function taked(Request $request, $no_nota)
    {
        $nota = Nota::where('no_nota', $no_nota)->first();
        if ($nota) {
            $nota->update([
                'status' => $request->status
            ]);
            return redirect()->route('pesanan')->with('berhasil', 'Pesanan Telah diambil');
        }
        return redirect()->route('pesanan')->with('gagal', 'Error taked');
    }
    function updatePesanan(Request $request, $no_nota)
    {
        // dd($request->input("quantity1"));
        DB::beginTransaction();
        $index = 1;
        $totalHarga = $this->calculateTotalPrice($request->all());
        if ($totalHarga > $request->pembayaran) {
            return redirect()->route('admin.details', $no_nota)->withErrors(['gagal' => 'Uang Pembayaran kurang']);
        }
        // dd($totalHarga);
        // dd($request->all());
        try {
            // Ambil data nota dengan nomor nota tertentu
            $nota = Nota::where('no_nota', $no_nota)->first();
            if ($nota) {
                // Hapus pesanan yang terkait
                while ($request->has("menu{$index}")) {
                    if ($request->input("quantity{$index}") >= "1") {
                        $itemData = [
                            'quantity' => $request->input("quantity{$index}"),
                        ];
                        // dd($itemData);
                        Pesanan::where('menu', $request->input("menu{$index}"))->update($itemData);
                    } else {
                        dd('hapus');
                        Pesanan::where('menu', $request->input("menu{$index}"))->delete();
                    }
                    $index++;
                }
                Nota::where('no_nota', $no_nota)->update([
                    'kembalian' => floatval($request->pembayaran) - $totalHarga,
                    'total_harga' => $totalHarga,
                    'pembayaran' => floatval($request->pembayaran),
                    'status' => 'dimasak'
                ]);

                // Commit transaksi jika berhasil
                DB::commit();
                return redirect()->route('pesanan')->with(
                    'berhasil',
                    'Nota Pesanan berhasil diupdate'
                );
            } else {
                // Rollback transaksi jika nota tidak ditemukan
                DB::rollback();

                return redirect()->route('pesanan')->with('gagal', 'Nota Pesanan gagal diupdate');
            }
        } catch (\Exception $e) {
            // Rollback transaksi jika terjadi kesalahan lainnya
            DB::rollback();

            return redirect()->route('pesanan')->with('gagal', 'Terjadi kesalahan: ' . $e->getMessage());
        }



    }
    function laporan()
    {
        // $nota = Nota::all();
        $toko = Toko::where('id', '>', '1')->get();
        $data = [];
        foreach ($toko as $key => $value) {
            $nota = Nota::where('id_toko', $value->id)->whereIn('status', ['taked']);
            $temp = [];
            foreach ($nota->get() as $key => $e) {
                # code...
                array_push($temp, Pesanan::where('no_nota', $e->no_nota)->count());
            }
            // dd(array_sum($temp));
            array_push($data, [
                'nama' => $value->nama,
                'alamat' => $value->alamat,
                'pemilik' => $value->pemilik,
                'id_toko' => $value->id,
                'menu' => Menu::where('id_toko', $value->id)->count(),
                'nota' => $nota->count(),
                'total_pesanan' => array_sum($temp),
            ], );
        }
        $summary = [
            "toko" => Toko::where('id', '>', '1')->count(),
            "nota" => Nota::where('status', 'taked')->count(),
            "menu" => Menu::all()->count(),
            "total_harga" => Nota::where('status', 'taked')->sum('total_harga'),
        ];
        $collection = new Collection($data);

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
        return view('admin.administrator.laporan.index', [
            "data" => $paginatedData,
            'summary' => $summary
        ]);
    }
    private function calculateTotalPrice($data)
    {
        $totalPrice = 0;

        // Menghitung total harga untuk setiap item
        for ($i = 1; $i <= 4; $i++) {
            $menuKey = "menu{$i}";
            $hargaKey = "harga{$i}";
            $quantityKey = "quantity{$i}";

            // Pastikan data untuk item tersedia
            if (isset($data[$menuKey], $data[$hargaKey], $data[$quantityKey])) {
                $harga = (int) $data[$hargaKey];
                $quantity = (int) $data[$quantityKey];

                // Menambahkan hasil perkalian harga dan quantity ke total
                $totalPrice += $harga * $quantity;
            }
        }

        return $totalPrice;
    }
}