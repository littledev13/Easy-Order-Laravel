<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Toko;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;

class PesanController extends Controller
{
    //
    public function index(Toko $id_toko)
    {
        // $url = Toko::where('id' . '==' . $id_toko->id)->get();
        return view('{id}.index', [
            'toko' => $id_toko->nama
        ]);
    }
    public function showMenu($id_toko, $kategori)
    {
        $menu = Menu::where([
            ['id_toko', '=', $id_toko],
            ['kategori', '=', $kategori],
        ])->get();
        return view('{id}.kategori.kategori', [
            'menu' => $menu
        ]);
    }
    public function cart()
    {
        $data = Session::get('cart');
        return view('{id}.cart.index', [
            'data' => $data
        ]);
    }
}