<?php

namespace App\Http\Controllers;

use App\Events\MatangNotification;
use App\Models\Nota;
use App\Models\Pesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class kokiController extends Controller {
    function index() {
        $data = Nota::where('id_toko', Auth::user()->id_toko)
            ->where('status', 'dimasak')
            ->get();
        return view('admin.koki.index', [
            'data' => $data
        ]);
    }
    function details($no_nota) {
        $nota = Nota::where('no_nota', $no_nota)->get();
        $pesanan = Pesanan::where('no_nota', $no_nota)->get();
        return view('admin.koki.details', [
            'nota' => $nota,
            'pesanan' => $pesanan,
        ]);
    }
    function matang($no_nota) {
        Nota::where('no_nota', $no_nota)->update([
            'status' => 'matang'
        ]);
        event(new MatangNotification(Nota::where('no_nota', $no_nota)->get()));
        return redirect()->route('koki')->with(
            'berhasil',
            'Pesanan telah dimasak'
        );
    }
}