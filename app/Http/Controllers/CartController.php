<?php

namespace App\Http\Controllers;

use App\Models\Nota;
use Illuminate\Support\Facades\DB;
use App\Models\Pesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;
use App\Events\NewOrderNotification;


class CartController extends Controller {
    //
    public function indexCart() {
        $data = Session::get('cart');
        $totalHarga = 0;

        if($data) {
            foreach($data as $item) {
                $totalHarga += $item['quantity'] * $item['harga'];
            }
        }

        return view('{id}.cart.index', [
            'data' => $data ?? [], // Jika $data null, berikan nilai array kosong
            'total_harga' => $totalHarga
        ]);
    }
    public function updateCart(Request $request) {
        // Mendapatkan data cart dari session
        $action = $request->input('action');
        $cart = Session::get('cart', []);

        // Menambahkan item baru ke dalam cart
        $foundItemIndex = array_search($request->nama, array_column($cart, 'nama'));

        // Mendapatkan data yang diperbarui
        if($action == 'add') {
            // Logic for adding to the cart
            if($foundItemIndex !== false) {
                $cart[$foundItemIndex]['quantity'] += 1;
                // Item ditemukan, lanjutkan dengan menambah atau mengurangi quantity
            } else {
                // Item tidak ditemukan
                $newItem = $request->all();
                $cart[] = $newItem;
            }
        } elseif($action == 'minus') {
            // Logic for subtracting from the cart
            if($foundItemIndex !== false) {
                // Item ditemukan, lanjutkan dengan menambah atau mengurangi quantity
                if($cart[$foundItemIndex]['quantity'] > 1) {
                    $cart[$foundItemIndex]['quantity'] -= 1;
                }
                if($cart[$foundItemIndex]['quantity'] <= 1) {
                    unset($cart[$foundItemIndex]);
                }
            }
        }

        $totalHarga = 0;

        foreach($cart as $item) {
            $totalHarga += $item['quantity'] * $item['harga'];
        }

        // Simpan kembali cart yang diperbarui ke dalam session
        Session::put('cart', $cart);

        return view('{id}.cart.index', [
            'data' => $cart,
            'total_harga' => $totalHarga
        ]);
    }
    function pesan(Request $request, $id_toko) {
        $namaPemesan = $request->input('nama');
        $totalHarga = $request->input('total_harga');

        // Inisialisasi status pesanan
        $pesananResult = [
            'status' => false,
            'data' => null,
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
                'pembayaran' => 'unpaid',
                'status' => 'unpaid',
                'id_toko' => $id_toko,
            ];

            // Menyimpan data Nota ke dalam tabel Nota
            $nota = Nota::create($notaData);

            // Mendapatkan data item pesanan dari form
            $items = [];
            $index = 1;

            while($request->has("nama_menu{$index}")) {
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

        } catch (\Exception $e) {
            // Rollback transaksi jika terjadi kesalahan
            DB::rollBack();
            // Handle kesalahan sesuai kebutuhan Anda
        }

        // Redirect atau return response
        event(new NewOrderNotification($pesananResult));
        Session::remove('cart');
        return view('{id}.cart.pesanan', $pesananResult);
    }

    private function generateNotaNumber($e) {
        // Mendapatkan tanggal hari ini dengan format ddmmyy
        $tanggal = Carbon::now()->format('dmy');

        // Mendapatkan jam sekarang dengan format His
        $jam = Carbon::now()->format('His');

        // Menggabungkan komponen-komponen tersebut untuk membentuk nomor nota
        $nomorNota = 'NOT'.$e.$tanggal.$jam;

        return $nomorNota;
    }
}