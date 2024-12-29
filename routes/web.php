<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CashierController;
use App\Http\Controllers\ChefController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\TestController;
use App\Models\Admin;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// TEST AREA
Route::get('/success', [TestController::class, 'sendSuccess'])->name('send-success');
Route::get('/fail', [TestController::class, 'sendFail'])->name('send-fail');
Route::get('/test', function () {
    return view('test');
});
// TEST AREA \\

// LOGOUT
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');  

// LOGOUT PEGAWAI
Route::post('/logout-pegawai', [AuthController::class, 'logoutPegawai'])->name('logout-pegawai');  

Route::middleware('cekNullRole')->group(function () {

    // HOME
    Route::get('/', function () {
        return redirect()->route('login');
    });

    // REGISTER
    Route::get('/register', [AuthController::class, 'tampilanRegister'])->name('register');

    // LOGIN
    Route::get('/login', [AuthController::class, 'tampilanLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    // LOGIN PEGAWAI
    Route::get('/login-pegawai', [AuthController::class, 'tampilanLoginPegawai'])->name('login-pegawai');
    Route::post('/login-pegawai', [AuthController::class, 'loginPegawai']);

});


// HALAMAN CUSTOMER
Route::middleware('cekRoleCustomer')->group(function () {

    // menu
    Route::get('/menu', [CustomerController::class, 'menu'])->name('menu');

    // detail menu
    Route::get('/detail-menu/{menu_id}', [CustomerController::class, 'detailMenu'])->name('detail-menu');



    // tampilan keranjang
    Route::get('/keranjang', [CustomerController::class, 'keranjang'])->name('keranjang');

    // tambah menu ke keranjang
    Route::post('/tambah-keranjang-menu', [CustomerController::class, 'tambahKeranjang'])->name('tambah-menu');

    // hapus menu dari keranjang
    Route::delete('/hapus-keranjang-menu/{customer_id}', [CustomerController::class, 'hapusMenu'])->name('hapus-keranjang-menu');

    // mengatur kuantitas
    Route::put('/tambah-kuantitas/{menu_id}', [CustomerController::class, 'tambahKuantitas'])->name('tambah-kuantitas');
    Route::put('/kurangi-kuantitas/{menu_id}', [CustomerController::class, 'kurangiKuantitas'])->name('kurangi-kuantitas');

    // tambah order
    Route::post('/tambah-pesanan', [CustomerController::class, 'tambahOrder'])->name('tambah-pesanan');



    // tampilan pesanan
    Route::get('/pesanan', [CustomerController::class, 'pesanan'])->name('pesanan');

    // hapus / batalkan pesanan
    Route::put('/pesanan/batalkan-pesanan/{order_id}', [CustomerController::class, 'batalkanOrder'])->name('batalkan-pesanan');

    // detail pesanan
    Route::get('/pesanan/detail-pesanan/{order_id}', [CustomerController::class, 'detailOrder'])->name('detail-pesanan');
});



// HALAMAN CHEF
Route::prefix('chef')->middleware('cekRolePegawai:chef')->group(function () {

    // dashboard chef
    Route::get('/dashboard', [ChefController::class, 'dashboard'])->name('chef-dashboard');

    // selesaikan menu pesanan
    Route::put('/selesaikan-menu/{order_id}/{menu_id}', [ChefController::class, 'selesaikanMenu'])->name('selesaikan-menu');
});



// HALAMAN CASHIER
Route::prefix('cashier')->middleware('cekRolePegawai:cashier')->group(function () {

    // dashboard cashier
    Route::get('/dashboard', [CashierController::class, 'dashboard'])->name('cashier-dashboard');



    // tampilan pesanan masuk
    Route::get('/pesanan-masuk', [CashierController::class, 'pesananMasuk'])->name('pesanan-masuk');

    // detail pesanan masuk
    Route::get('/pesanan-masuk/detail/{order_id}', [CashierController::class, 'detailPesananMasuk'])->name('detail-pesanan-masuk');

    // batalkan pesanan masuk
    Route::delete('/pesanan-masuk/hapus/{order_id}', [CashierController::class, 'hapusPesananMasuk'])->name('hapus-pesanan-masuk');

    // konfirmasi pesanan masuk
    Route::put('/pesanan-masuk/konfirmasi/{order_id}', [CashierController::class, 'konfirmasiPesananMasuk'])->name('konfirmasi-pesanan-masuk');



    // tampilan pesanan aktif
    Route::get('/pesanan-aktif', [CashierController::class, 'pesananAktif'])->name('pesanan-aktif');

    // tampilan bayar pesanan
    Route::get('/bayar-pesanan/{order_id}', [CashierController::class, 'bayarPesanan'])->name('bayar-pesanan');

    // terima transaksi
    Route::post('/terima-transaksi', [CashierController::class, 'terimaTransaksi'])->name('terima-transaksi');

    // tampilan bayar selesai
    Route::get('/bayar-selesai/{order_id}/{payment}', [CashierController::class, 'bayarSelesai'])->name('bayar-selesai');

    // struk pembayaran
    Route::get('/struk-pembayaran/{order_id}/{payment}', [CashierController::class, 'strukPembayaran'])->name('struk-pembayaran');



    // tampilan pesanan selesai
    Route::get('/pesanan-selesai', [CashierController::class, 'pesananSelesai'])->name('pesanan-selesai');

    // detail pesanan selesai
    Route::get('/pesanan-selesai/detail/{order_id}', [CashierController::class, 'detailPesananSelesai'])->name('detail-pesanan-selesai');



    // tampilan pesanan batal
    Route::get('/pesanan-batal', [CashierController::class, 'pesananBatal'])->name('pesanan-batal');

    // detail pesanan batal
    Route::get('/pesanan-batal/detail/{order_id}', [CashierController::class, 'detailPesananBatal'])->name('detail-pesanan-batal');
});



// HALAMAN ADMIN
Route::prefix('admin')->middleware('cekRolePegawai:admin')->group(function () {

    // dashboard admin
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin-dashboard');



    // daftar customer ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    Route::get('/daftar-pelanggan', [AdminController::class, 'daftarCustomer'])->name('admin.daftar-customer');

    // tambah customer
    Route::get('/tambah-pelanggan', [AdminController::class, 'tambahCustomer'])->name('admin.tambah-customer');
    Route::post('/simpan-pelanggan', [AdminController::class, 'simpanCustomer'])->name('admin.simpan-customer');

    // ubah customer
    Route::get('/ubah-pelanggan/{customer_id}/ubah', [AdminController::class, 'ubahCustomer'])->name('admin.ubah-customer');
    Route::put('/update-pelanggan/{customer_id}', [AdminController::class, 'updateCustomer'])->name('admin.update-customer');

    // hapus customer
    Route::delete('/hapus-pelanggan/{customer_id}', [AdminController::class, 'hapusCustomer'])->name('admin.hapus-customer');



    // daftar menu ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    Route::get('/daftar-menu', [AdminController::class, 'daftarMenu'])->name('admin.daftar-menu');

    // tambah menu
    Route::get('/tambah-menu', [AdminController::class, 'tambahMenu'])->name('admin.tambah-menu');
    Route::post('/simpan-menu', [AdminController::class, 'simpanMenu'])->name('admin.simpan-menu');

    // ubah menu
    Route::get('/ubah-menu/{menu_id}/ubah', [AdminController::class, 'ubahMenu'])->name('admin.ubah-menu');
    Route::put('/update-menu/{menu_id}', [AdminController::class, 'updateMenu'])->name('admin.update-menu');

    // hapus menu
    Route::delete('/hapus-menu/{menu_id}', [AdminController::class, 'hapusMenu'])->name('admin.hapus-menu');



    // daftar admin ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    Route::get('/daftar-admin', [AdminController::class, 'daftarAdmin'])->name('admin.daftar-admin');

    // tambah admin
    Route::get('/tambah-admin', [AdminController::class, 'tambahAdmin'])->name('admin.tambah-admin');
    Route::post('/simpan-admin', [AdminController::class, 'simpanAdmin'])->name('admin.simpan-admin');

    // ubah admin
    Route::get('/ubah-admin/{admin_id}/ubah', [AdminController::class, 'ubahAdmin'])->name('admin.ubah-admin');
    Route::put('/update-admin/{admin_id}', [AdminController::class, 'updateAdmin'])->name('admin.update-admin');

    // hapus admin
    Route::delete('/hapus-admin/{admin_id}', [AdminController::class, 'hapusAdmin'])->name('admin.hapus-admin');



    // daftar cashier ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    Route::get('/daftar-kasir', [AdminController::class, 'daftarCashier'])->name('admin.daftar-cashier');

    // tambah cashier
    Route::get('/tambah-kasir', [AdminController::class, 'tambahCashier'])->name('admin.tambah-cashier');
    Route::post('/simpan-kasir', [AdminController::class, 'simpanCashier'])->name('admin.simpan-cashier');

    // ubah cashier
    Route::get('/ubah-kasir/{cashier_id}/ubah', [AdminController::class, 'ubahCashier'])->name('admin.ubah-cashier');
    Route::put('/update-kasir/{cashier_id}', [AdminController::class, 'updateCashier'])->name('admin.update-cashier');

    // hapus cashier
    Route::delete('/hapus-kasir/{cashier_id}', [AdminController::class, 'hapusCashier'])->name('admin.hapus-cashier');



    // daftar chef ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    Route::get('/daftar-koki', [AdminController::class, 'daftarChef'])->name('admin.daftar-chef');

    // tambah chef
    Route::get('/tambah-koki', [AdminController::class, 'tambahChef'])->name('admin.tambah-chef');
    Route::post('/simpan-koki', [AdminController::class, 'simpanChef'])->name('admin.simpan-chef');

    // ubah chef
    Route::get('/ubah-koki/{chef_id}/ubah', [AdminController::class, 'ubahChef'])->name('admin.ubah-chef');
    Route::put('/update-koki/{chef_id}', [AdminController::class, 'updateChef'])->name('admin.update-chef');

    // hapus chef
    Route::delete('/hapus-koki/{chef_id}', [AdminController::class, 'hapusChef'])->name('admin.hapus-chef');



    // daftar transaksi ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    Route::get('/daftar-transaksi', [AdminController::class, 'daftarTransaction'])->name('admin.daftar-transaksi');

    // detail transaksi
    Route::get('/detail-transaksi/{transaction_id}', [AdminController::class, 'detailTransaction'])->name('admin.detail-transaksi');

    // laporan keuangan
    Route::post('/laporan-keuangan', [AdminController::class, 'laporanKeuangan'])->name('laporan-keuangan');
});