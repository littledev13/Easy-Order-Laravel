<?php


use App\Http\Controllers\AdminController;
use App\Http\Controllers\AkunController;
use App\Http\Controllers\CartController;
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
    });

    // Manager Routes
    Route::middleware(['role:manager'])->group(function () {
        Route::get('/manager', [ManagerController::class, 'index'])->name('manager');
        Route::get('/manager/akun/', [ManagerController::class, 'showAkun'])->name('manager.akun');
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
});
Route::get('/{id_toko}', [PesanController::class, 'index'])->name('pesan');
Route::get('/{id_toko}/{kategori}', [PesanController::class, 'showMenu'])->name('menuPesanan');
Route::post('/{id}/cart', [CartController::class, 'addToCart'])->name('addCart');
Route::get('/{id}/cart', [CartController::class, 'indexCart'])->name('indexCart');
// Route::get('/{id}/cart', [CartController::class, 'index'])->name('cart');