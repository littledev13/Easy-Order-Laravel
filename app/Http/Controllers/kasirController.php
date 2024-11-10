<?php

namespace App\Http\Controllers;

use App\Events\NewCookNotification;
use App\Events\NewOrderNotification;
use App\Models\Nota;
use App\Models\Pesanan;
use App\Models\Toko;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;


class kasirController extends Controller
{
    //
    function index()
    {

        return view('admin.kasir.index');
    }
    function pesanan(Request $request)
    {

        // $data = Nota::where('id_toko', Auth::user()->id_toko)
        //     ->whereNotIn('status', ['taked', 'cancel'])
        //     ->paginate(15);
        if ($request->has('search')) {
            $searchTerm = $request->search;
            $data = Nota::where('id_toko', Auth::user()->id_toko)
                ->whereNotIn('status', ['taked', 'cancel'])
                ->where(function ($query) use ($searchTerm) {
                    $query->where('pembeli', 'LIKE', '%' . $searchTerm . '%')
                        ->orWhere('no_nota', 'LIKE', '%' . $searchTerm . '%')
                        ->orWhere('status', 'LIKE', '%' . $searchTerm . '%');
                })
                ->paginate(15);
        } elseif ($request->has('date')) {
            $dateFilter = $request->date;
            $data = Nota::where('id_toko', Auth::user()->id_toko)
                ->whereDate('created_at', $dateFilter)->whereNotIn('status', ['taked', 'cancel'])->paginate(15);
        } else {
            $data = Nota::where('id_toko', Auth::user()->id_toko)
                ->whereNotIn('status', ['taked', 'cancel'])->paginate(15);
        }
        return view('admin.kasir.pesanan.index', [
            'data' => $data
        ]);
    }
    function detailsPesanan($no_nota)
    {
        $nota = Nota::where('no_nota', '=', $no_nota)->get();
        $pesanan = Pesanan::where('no_nota', '=', $no_nota)->get();

        // dd($nota);
        return view('admin.kasir.pesanan.{id}.index', [
            'nota' => $nota,
            'pesanan' => $pesanan
        ]);
    }
    function updatePesanan(Request $request, $no_nota)
    {
        // dd($request->input("quantity1"));
        DB::beginTransaction();
        $index = 1;
        $totalHarga = $this->calculateTotalPrice($request->all());
        if ($totalHarga > $request->pembayaran) {
            return redirect()->route('kasir.details', $no_nota)->withErrors(['gagal' => 'Uang Pembayaran kurang']);
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
                // $notif = [
                //     Nota::where('no_nota', $no_nota)->get(),
                //     Pesanan::where('no_nota', $no_nota)->get(),
                // ];
                event(new NewCookNotification(Nota::where('no_nota', $no_nota)->get(), ));
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
    public function deletePesanan($no_nota)
    {
        // Mulai transaksi database
        DB::beginTransaction();
        $data = Nota::where('id_toko', '=', Auth::user()->id_toko)->get();

        try {
            // Ambil data nota dengan nomor nota tertentu
            $nota = Nota::where('no_nota', $no_nota)->first();

            if ($nota) {
                // Hapus pesanan yang terkait
                Pesanan::where('no_nota', $no_nota)->delete();

                // Hapus nota
                $nota->update([
                    'status' => 'cancel'
                ]);

                // Commit transaksi jika berhasil
                DB::commit();

                return redirect()->route('kasir.pesanan')->with(
                    'berhasil',
                    'Nota Pesanan berhasil dihapus'
                );
            } else {
                // Rollback transaksi jika nota tidak ditemukan
                DB::rollback();

                return redirect()->route('kasir.pesanan')->with('gagal', 'Nota Pesanan gagal dihapus');
            }
        } catch (\Exception $e) {
            // Rollback transaksi jika terjadi kesalahan lainnya
            DB::rollback();

            return redirect()->route('kasir.pesanan')->with('gagal', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
    function takedPesanan(Request $request)
    {
        $no_nota = $request->input('no_nota');
        $status = $request->input('status');
        Nota::where('no_nota', $no_nota)->update([
            'status' => $status
        ]);
        return redirect()->route('kasir.pesanan')->with(
            'berhasil',
            'Nota Pesanan berhasil diselesaikan'
        );
    }
    // History

    function history(Request $request)
    {

        // $data = Nota::where('id_toko', Auth::user()->id_toko)
        //     ->whereIn('status', ['taked', 'cancel'])
        //     ->paginate(15);
        if ($request->has('search')) {
            $searchTerm = $request->search;
            $data = Nota::where('id_toko', Auth::user()->id_toko)
                ->whereNotIn('status', ['taked', 'cancel'])
                ->where(function ($query) use ($searchTerm) {
                    $query->where('pembeli', 'LIKE', '%' . $searchTerm . '%')
                        ->orWhere('no_nota', 'LIKE', '%' . $searchTerm . '%')
                        ->orWhere('status', 'LIKE', '%' . $searchTerm . '%');
                })
                ->paginate(15);
        } elseif ($request->has('date')) {
            $dateFilter = $request->date;
            $data = Nota::where('id_toko', Auth::user()->id_toko)
                ->whereDate('created_at', $dateFilter)
                ->whereIn('status', ['taked', 'cancel'])->paginate(15);
        } else {
            $data = Nota::where('id_toko', Auth::user()->id_toko)
                ->whereIn('status', ['taked', 'cancel'])->paginate(15);
        }

        return view('admin.kasir.history.index', [
            'data' => $data
        ]);
    }
    // Laporam
    function laporan()
    {
        $startDate = Carbon::now()->subDays(7)->startOfDay();

        // Mengambil data total nota dengan status 'taked' dan 'cancel'
        $data = Nota::select(
            DB::raw('DATE(updated_at) as tanggal'),
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
        foreach ($data as $item) {
            $groupedData[$item->tanggal]['total_nota'] = $item->total_nota;
            $groupedData[$item->tanggal]['jumlah_nota_taked'] = $item->jumlah_nota_taked;
            $groupedData[$item->tanggal]['total_harga_taked'] = $item->total_harga_taked;
            $groupedData[$item->tanggal]['jumlah_nota_cancel'] = $item->jumlah_nota_cancel;
            $groupedData[$item->tanggal]['total_harga_cancel'] = $item->total_harga_cancel;
        }

        $collection = new Collection($groupedData);

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
        return view('admin.kasir.laporan.index', ["data" => $paginatedData]);
    }
    public function print($no_nota)
    {
        $nota = Nota::where('no_nota', $no_nota)->first();
        $pesanan = Pesanan::where('no_nota', $no_nota)->get();
        $toko = Toko::where('id', Auth::user()->id_toko)->first();
        $data = [
            'nota' => $nota,
            'pesanan' => $pesanan,
            'toko' => $toko
        ];
        // dd($data);
        return view('admin.kasir.history.struk', $data);
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