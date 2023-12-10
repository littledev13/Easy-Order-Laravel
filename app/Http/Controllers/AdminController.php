<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Nota;
use App\Models\Pesanan;
use App\Models\Toko;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
    function pesanan()
    {
        $nota = Nota::whereNotIn('status', ['taked', 'cancel'])->get();
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
    function taked($no_nota)
    {
        $nota = Nota::where('no_nota', $no_nota)->first();
        if ($nota) {
            $nota->update([
                'status' => 'taked'
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
        $totalHarga = 0;

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
                    $totalHarga += (($request->input("quantity{$index}")) * ($request->input("harga{$index}")));
                    $index++;
                }
                Nota::where('no_nota', $no_nota)->update([
                    'total_harga' => $totalHarga,
                    'pembayaran' => 'paid',
                    'status' => 'dimasak'
                ]);

                // Commit transaksi jika berhasil
                DB::commit();
                // $notif = [
                //     Nota::where('no_nota', $no_nota)->get(),
                //     Pesanan::where('no_nota', $no_nota)->get(),
                // ];
                // event(new NewCookNotification(Nota::where('no_nota', $no_nota)->get(), ));
                return redirect()->route('kasir.pesanan')->with(
                    'berhasil',
                    'Nota Pesanan berhasil diupdate'
                );
            } else {
                // Rollback transaksi jika nota tidak ditemukan
                DB::rollback();

                return redirect()->route('kasir.pesanan')->with('gagal', 'Nota Pesanan gagal diupdate');
            }
        } catch (\Exception $e) {
            // Rollback transaksi jika terjadi kesalahan lainnya
            DB::rollback();

            return redirect()->route('kasir.pesanan')->with('gagal', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
    function laporan()
    {
        // $nota = Nota::all();
        $toko = Toko::where('id', '>', '1')->get();
        // $nota = Nota::where('status', 'taked')->get();
        // $pesanan = Pesanan::all();
        // $tokoData = Toko::with(['notas', 'pesanans.menu'])->where('id', '>=', 2)->get();
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

        return view('admin.administrator.laporan.index', [
            "data" => $data,
            'summary' => $summary
        ]);
    }
}