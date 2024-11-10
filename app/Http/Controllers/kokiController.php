<?php

namespace App\Http\Controllers;

use App\Events\MatangNotification;
use App\Models\Nota;
use App\Models\Pesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class kokiController extends Controller
{
    function index(Request $request)
    {
        // $data = Nota::where('id_toko', Auth::user()->id_toko)
        //     ->where('status', 'dimasak')
        //     ->paginate(15);
        if ($request->has('search')) {
            $searchTerm = $request->search;
            $data = Nota::where('id_toko', Auth::user()->id_toko)
                ->where('status', 'dimasak')
                ->where(function ($query) use ($searchTerm) {
                    $query->where('pembeli', 'LIKE', '%' . $searchTerm . '%')
                        ->orWhere('no_nota', 'LIKE', '%' . $searchTerm . '%')
                        ->orWhere('status', 'LIKE', '%' . $searchTerm . '%');
                })
                ->paginate(15);
        } elseif ($request->has('date')) {
            $dateFilter = $request->date;
            $data = Nota::whereDate('created_at', $dateFilter)->where('id_toko', Auth::user()->id_toko)
                ->where('status', 'dimasak')->paginate(15);
        } else {
            $data = Nota::whereNotIn('status', ['taked', 'cancel'])->paginate(15);
        }
        return view('admin.koki.index', [
            'data' => $data
        ]);
    }
    function details($no_nota)
    {
        $nota = Nota::where('no_nota', $no_nota)->get();
        $pesanan = Pesanan::where('no_nota', $no_nota)->get();
        return view('admin.koki.details', [
            'nota' => $nota,
            'pesanan' => $pesanan,
        ]);
    }
    function matang($no_nota)
    {
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