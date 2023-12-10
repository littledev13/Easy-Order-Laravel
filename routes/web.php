<?php


use App\Http\Controllers\AdminController;
use App\Http\Controllers\AkunController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\kasirController;
use App\Http\Controllers\kokiController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ManagerController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\PesanController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::middleware(['guest'])->group(function () {
    Route::get('/auth', [LoginController::class, 'index'])->name('login');
    Route::post('/auth', [LoginController::class, 'authenticate']);
    Route::get('/auth/register', function () {
        return view('auth.register.index');
    });
    Route::get('/home', function () {
        return redirect('/auth');
    });
    Route::get('/', [LoginController::class, 'index2']);
});

Route::middleware(['auth'])->group(function () {
    Route::get('/logout.php', [LoginController::class, 'logout']);

    // Admin Routes
    Route::middleware(['role:administrator'])->group(function () {
        Route::get('/admin', [AdminController::class, 'index']);
        Route::get('/admin/toko', [AdminController::class, 'showToko'])->name('toko');
        Route::post('/admin/toko', [AdminController::class, 'createToko']);
        Route::delete('/admin/toko/{toko}', [AdminController::class, 'destroy'])->name('toko.destroy');
        Route::get('/admin/toko/{toko}/', [AdminController::class, 'edit'])->name('toko.edit');
        Route::put('/admin/toko/{toko}/', [AdminController::class, 'update'])->name('toko.update');
        Route::get('/admin/akun/', [AkunController::class, 'showAkun'])->name('akun');
        Route::get('/admin/akun/{akun}/', [AkunController::class, 'edit'])->name('akun.edit');
        Route::post('/admin/akun', [AkunController::class, 'createAkun']);
        Route::delete('/admin/akun/{user}', [AkunController::class, 'destroy'])->name('akun.destroy');
        Route::put('/admin/akun/{akun}', [AkunController::class, 'update'])->name('akun.update');
        Route::get('/admin/menu', [MenuController::class, 'index'])->name('menu');
        Route::post('/admin/menu', [MenuController::class, 'addMenu'])->name('menu.add');
        Route::delete('/admin/menu/{menu}', [MenuController::class, 'destroy'])->name('menu.destroy');
        Route::get('/admin/menu/{menu}/', [MenuController::class, 'edit'])->name('menu.edit');
        Route::put('/admin/menu/{menu}', [MenuController::class, 'update'])->name('menu.update');
        Route::get('/admin/pesanan/', [AdminController::class, 'pesanan'])->name('pesanan');
        Route::delete('/admin/pesanan/{no_nota}', [AdminController::class, 'deletePesanan'])->name('pesanan.delete');
        Route::put('/admin/pesanan/{no_nota}', [AdminController::class, 'taked'])->name('pesanan.taked');
        Route::post('/admin/pesanan/{no_nota}', [AdminController::class, 'updatePesanan'])->name('pesanan.update');
        Route::get('/admin/pesanan/{no_nota}', [AdminController::class, 'detailsPesanan'])->name('admin.details');
        Route::get('/admin/laporan/', [AdminController::class, 'laporan'])->name('admin.laporan');

    });

    // Manager Routes
    Route::middleware(['role:manager'])->group(function () {
        Route::get('/manager', [ManagerController::class, 'index'])->name('manager');
        Route::get('/manager/akun/', [ManagerController::class, 'showAkun'])->name('manager.akun');
        Route::get('/manager/laporan/', [ManagerController::class, 'laporan'])->name('manager.laporan');
        Route::post('/manager/akun/', [ManagerController::class, 'addAkun'])->name('manager.akun.add');
        Route::delete('/manager/akun/{user}', [ManagerController::class, 'destroy'])->name('manager.akun.destroy');
        Route::get('/manager/akun/{user}', [ManagerController::class, 'edit'])->name('manager.akun.edit');
        Route::put('/manager/akun/{user}', [ManagerController::class, 'update'])->name('manager.akun.update');

        Route::get('/manager/menu', [ManagerController::class, 'indexMenu'])->name('manager.menu');
        Route::post('/manager/menu', [ManagerController::class, 'addMenu'])->name('manager.menu.add');
        Route::delete('/manager/menu/{menu}', [ManagerController::class, 'destroyMenu'])->name('manager.menu.destroy');
        Route::get('/manager/menu/{menu}/', [ManagerController::class, 'editMenu'])->name('manager.menu.edit');
        Route::put('/manager/menu/{menu}', [ManagerController::class, 'updateMenu'])->name('manager.menu.update');

    });
    // Kasir Routes
    Route::middleware(['role:kasir'])->group(function () {
        Route::get('/kasir', [kasirController::class, 'index'])->name('kasir');
        Route::get('/kasir/pesanan/', [kasirController::class, 'pesanan'])->name('kasir.pesanan');
        Route::PUT('/kasir/pesanan/', [kasirController::class, 'takedPesanan'])->name('kasir.taked');
        Route::get('/kasir/pesanan/{no_nota}', [kasirController::class, 'detailsPesanan'])->name('kasir.details');
        Route::PUT('/kasir/pesanan/{no_nota}', [kasirController::class, 'updatePesanan'])->name('kasir.update');
        Route::delete('/kasir/pesanan/{no_nota}', [kasirController::class, 'deletePesanan'])->name('kasir.delete');
        Route::get('/kasir/history/', [kasirController::class, 'history'])->name('kasir.history');
        Route::get('/kasir/laporan/', [kasirController::class, 'laporan'])->name('kasir.laporan');


    });
    Route::middleware(['role:koki'])->group(function () {
        Route::get('/koki', [kokiController::class, 'index'])->name('koki');
        Route::get('/koki/{id}', [kokiController::class, 'details'])->name('koki.details');
        Route::PUT('/koki/{id}', [kokiController::class, 'matang'])->name('koki.matang');


    });
});
Route::get('/notif', [kasirController::class, 'notif'])->name('kasir.notif');
Route::get('/{id_toko}', [PesanController::class, 'index'])->name('pesan');
Route::post('/{id_toko}/pesanan', [CartController::class, 'pesan'])->name('addPesanan');
Route::get('/{id}/cart', [CartController::class, 'indexCart'])->name('indexCart');
Route::post('/{id}/cart', [CartController::class, 'updateCart'])->name('updateCart');
Route::get('/{id_toko}/{kategori}', [PesanController::class, 'showMenu'])->name('menuPesanan');

// Route::get('/{id}/cart', [CartController::class, 'index'])->name('cart');