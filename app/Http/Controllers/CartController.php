<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Nota;
use App\Models\Toko;
use Illuminate\Support\Facades\DB;
use App\Models\Pesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;
use App\Events\NewOrderNotification;


class CartController extends Controller
{
    //
    public function indexCart()
    {
        $data = Session::get('cart');
        $totalHarga = 0;

        if ($data) {
            foreach ($data as $item) {
                $totalHarga += $item['quantity'] * $item['harga'];
            }
        }
        $cart = Session::get('cart');
        $quantity = 0;
        if ($cart !== null) {
            foreach ($cart as $item) {
                $quantity += intval($item['quantity']);
            }
        }
        return view('{id}.cart.index', [
            'data' => $data ?? [], // Jika $data null, berikan nilai array kosong
            'total_harga' => $totalHarga,
            'quantity' => $quantity

        ]);
    }
    public function updateCart(Request $request)
    {
        // $data = [];
        // array_push($data, $request->except(['_token', '_method', 'action']));
        // Mendapatkan data cart dari session
        $action = $request->input('action');
        $cart = Session::get('cart', []);
        // dd($cart);
        // Menambahkan item baru ke dalam cart
        $foundItemIndex = array_search($request->nama, array_column($cart, 'nama'));

        // Mendapatkan data yang diperbarui
        if ($action == 'add') {
            // Logic for adding to the cart
            if ($foundItemIndex !== false) {
                // dd('tambah');
                $cart[$foundItemIndex]['quantity'] += $request->quantity;
                // Item ditemukan, lanjutkan dengan menambah atau mengurangi quantity
            } else {
                // dd('baru');
                // Item tidak ditemukan
                $newItem = $request->except(['_token', '_method', 'action']);
                $cart[] = $newItem;
            }
        }
        $totalHarga = 0;

        foreach ($cart as $item) {
            $totalHarga += $item['quantity'] * $item['harga'];
        }

        // Simpan kembali cart yang diperbarui ke dalam session
        Session::put('cart', $cart);
        // dd(Session::get('cart', []));
        return redirect()->route('pesan', $request->id_toko);
    }
    function pesan(Request $request, $id_toko)
    {
        // dd($request->all());
        $namaPemesan = $request->input('nama');
        $noMeja = $request->input('nomor_meja');
        $totalHarga = $request->input('total_harga');

        // Inisialisasi status pesanan
        $pesananResult = [
            'status' => false,
            'data' => null,
            'no_meja' => '',
            'toko' => Toko::where('id', $id_toko)->first(),
            'pesanan' => [], // Menambah array untuk menyimpan informasi pesanan
        ];

        // Inisialisasi nomor nota
        $noNota = $this->generateNotaNumber($id_toko);

        // Memulai transaksi database
        DB::beginTransaction();

        try {
            // Membuat data untuk Nota
            $notaData = [
                'pembeli' => $namaPemesan,
                'total_harga' => $totalHarga,
                'no_nota' => $noNota,
                'no_meja' => $noMeja,
                'pembayaran' => 'unpaid',
                'kembalian' => 'unpaid',
                'status' => 'unpaid',
                'id_toko' => $id_toko,
            ];

            // Menyimpan data Nota ke dalam tabel Nota
            $nota = Nota::create($notaData);

            // Mendapatkan data item pesanan dari form
            $items = [];
            $index = 1;
            while ($request->has("nama_menu{$index}")) {
                $itemData = [
                    'menu' => $request->input("nama_menu{$index}"),
                    'quantity' => $request->input("quantity{$index}"),
                    'harga' => $request->input("harga{$index}"),
                    'no_nota' => $noNota,
                    'id_toko' => $id_toko,
                ];

                $items[] = $itemData;

                // Menambah informasi pesanan ke dalam array pesananResult
                $pesananResult['pesanan'][] = [
                    'menu' => $itemData['menu'],
                    'quantity' => $itemData['quantity'],
                    'harga' => $itemData['harga'],
                ];

                $index++;
            }

            // Menyimpan data item pesanan ke dalam tabel Pesanan
            Pesanan::insert($items);

            // Commit transaksi jika semua operasi berhasil
            DB::commit();

            // Set status pesanan berhasil
            $pesananResult['status'] = true;
            $pesananResult['data'] = $nota;
            $pesananResult['no_meja'] = $noMeja;

        } catch (\Exception $e) {
            // Rollback transaksi jika terjadi kesalahan
            DB::rollBack();
            dd($e->getMessage());
            // Handle kesalahan sesuai kebutuhan Anda
        }

        // Redirect atau return response
        event(new NewOrderNotification($pesananResult));
        Session::remove('cart');
        return view('{id}.cart.pesanan', $pesananResult);
    }
    function delete($id, $nama)
    {
        $id = request()->segment(1);
        $cart = Session::get('cart', []);

        // $foundItemIndex = array_search($nama, array_column($cart, 'nama'));

        $cartItemsBaru = array_filter($cart, function ($item) use ($nama) {
            return $item['nama'] !== $nama;
        });
        // dd($cartItemsBaru);

        Session::put('cart', $cartItemsBaru);
        // dd(Session::get('cart', []));

        return redirect()->route('indexCart', $id);
    }

    private function generateNotaNumber($e)
    {
        // Mendapatkan tanggal hari ini dengan format ddmmyy
        $tanggal = Carbon::now()->format('dmy');

        // Mendapatkan jam sekarang dengan format His
        $jam = Carbon::now()->format('His');

        // Menggabungkan komponen-komponen tersebut untuk membentuk nomor nota
        $nomorNota = 'NOT' . $e . $tanggal . $jam;

        return $nomorNota;
    }


}