<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    //
    public function indexCart($id)
    {
        $data = Session::get('cart');
        return view('{id}.cart.index', [
            'data' => $data,
            'id' => $id
        ]);
    }
    public function addToCart(Request $request)
    {
        // Mendapatkan data cart dari session
        $cart = Session::get('cart', []);

        // Menambahkan item baru ke dalam cart
        $newItem = $request->all();
        $cart[] = $newItem;

        // Menyimpan kembali data cart yang diperbarui ke dalam session
        Session::put('cart', $cart);

        // Mendapatkan data yang diperbarui
        $data = Session::get('cart');

        return view('{id}.cart.index', [
            'data' => $data
        ]);
    }
}