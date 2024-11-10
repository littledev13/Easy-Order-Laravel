<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\Menu;
use App\Models\Nota;
use App\Models\Toko;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;

class PesanController extends Controller
{
    //
    public function index(Toko $id_toko)
    {
        $id = request()->segment(1);
        $kategori = Kategori::where('id_toko', $id)->groupBy("nama");
        $menu = Menu::where('id_toko', $id)->get();
        $toko = Toko::where('id', $id)->get();

        $pilihan = [];
        foreach ($kategori->get() as $key => $value) {
            if ($value->image_url != "") {
                array_push($pilihan, $value);
            }
        }
        $cart = Session::get('cart');
        $quantity = 0;
        if ($cart !== null) {
            foreach ($cart as $item) {
                $quantity += intval($item['quantity']);
            }
        }
        // dd($quantity);
        return view('{id}.index', [
            'pilihan' => $pilihan,
            'menu' => $menu,
            'kategori' => $kategori->select('nama')->get(),
            'quantity' => $quantity,
            'toko' => $toko

        ]);
    }
    public function showMenu($id_toko, $kategori)
    {

        $menu = Menu::where([
            ['id_toko', '=', $id_toko],
            ['kategori', '=', $kategori],
        ])->get();
        $cart = Session::get('cart');
        $quantity = 0;
        if ($cart !== null) {
            foreach ($cart as $item) {
                $quantity += intval($item['quantity']);
            }
        }
        return view('{id}.kategori.kategori', [
            'menu' => $menu,
            'quantity' => $quantity

        ]);
    }
    public function cart()
    {
        $data = Session::get('cart');
        return view('{id}.cart.index', [
            'data' => $data
        ]);
    }
    function details($id_Toko, $kategori, $menu)
    {
        $details = Menu::where('id', $menu)->first();
        $cart = Session::get('cart');
        $quantity = 0;
        if ($cart !== null) {
            foreach ($cart as $item) {
                $quantity += intval($item['quantity']);
            }
        }
        return view('{id}.details', [
            'menu' => $details,
            'quantity' => $quantity
        ]);
    }
}