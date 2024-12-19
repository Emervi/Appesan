<?php

namespace App\Http\Controllers;

use App\Http\Requests\MenuRequest;
use App\Models\Admin;
use App\Models\Cashier;
use App\Models\Chef;
use App\Models\Customer;
use App\Models\Menu;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redis;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function dashboard() {

        $name = isset(session('admin')['name']) ? session('admin')['name'] : null;

        $todayOrders = Order::where('status', 'Selesai')
        ->whereDate('created_at', Carbon::today())
        ->count();

        $todayIncomes = Transaction::whereDate('created_at', Carbon::today())
        ->sum('income');

        $todayMenus = OrderDetail::where('status', 'Disajikan')
        ->whereDate('created_at', Carbon::today())
        ->count();

        return view('admin.dashboard', [
            'name' => $name,
            'todayOrders' => $todayOrders,
            'todayIncomes' => $todayIncomes,
            'todayMenus' => $todayMenus,
        ]);

    }

    // CRUD CUSTOMER ====================================================================================================
    public function daftarCustomer() {

        $customers = Customer::all();

        return view('admin.daftar-customer', [
            'customers' => $customers
        ]);

    }

    public function tambahCustomer() {

        return view('admin.tambah-customer');

    }

    public function simpanCustomer(Request $request) {

        $request->validate([
            'name' => ['required', 'string'],
            'username' => ['required', 'string'],
            'email' => ['required', 'email'],
            'password' => ['required', 'min:8'],
        ],[
            'name.required' => 'Nama wajib diisi.',
            'name.string' => 'Nama wajib terdiri dari huruf.',
            'username.required' => 'Alamat wajib diisi.',
            'username.string' => 'Alamat wajib terdiri dari huruf.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email salah.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 8 karakter.',
        ]);

        Customer::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('admin.daftar-customer')->with('success', 'Pelanggan berhasil dibuat!');

    }

    public function ubahCustomer($customer_id) {

        $customer = Customer::where('customer_id', $customer_id)->get();

        return view('admin.ubah-customer', compact('customer'));

    }

    public function updateCustomer(Request $request, $customer_id) {

        $request->validate([
            'name' => ['required', 'string'],
            'username' => ['required', 'string'],
            'email' => ['required', 'email'],
        ],[
            'name.required' => 'Nama wajib diisi.',
            'name.string' => 'Nama wajib terdiri dari huruf.',
            'username.required' => 'Alamat wajib diisi.',
            'username.string' => 'Alamat wajib terdiri dari huruf.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email salah.',
        ]);

        Customer::where('customer_id', $customer_id)->update([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
        ]);

        return redirect()->route('admin.daftar-customer')->with('success', 'Pelanggan berhasil diubah!');

    }

    public function hapusCustomer($customer_id) {

        Customer::where('customer_id', $customer_id)
        ->delete();

        return redirect()->back()->with('swal', ['type' => 'success', 'message' => 'Pelanggan berhasil dihapus!']);

    }
    // CRUD CUSTOMER \\



    // CRUD MENU ====================================================================================================
    public function daftarMenu() {

        $menus = Menu::all();

        return view('admin.daftar-menu', [
            'menus' => $menus
        ]);

    }

    public function tambahMenu() {

        return view('admin.tambah-menu');

    }

    public function simpanMenu(MenuRequest $request) {

        $image = $request->image;
        $imageName = time() . '.' . $image->extension();
        $image->move(public_path('images'), $imageName);

        Menu::create([
            'image' => $imageName,
            'name' => $request->name,
            'price' => $request->price,
            'description' => $request->description,
            'category' => $request->category,
            'stock' => $request->stock
        ]);

        return redirect()->route('admin.daftar-menu')->with('success', 'Menu berhasil dibuat!');

    }

    public function ubahMenu($menu_id) {

        $menu = Menu::where('menu_id', $menu_id)->get();

        return view('admin.ubah-menu', compact('menu'));

    }

    public function updateMenu(Request $request, $menu_id) {

        $request->validate([
            'image' => ['nullable', 'image', 'mimes:png,jpg,jpeg', 'max:2048'],
            'name' => ['required', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'description' => ['required', 'string'],
            'category' => ['required'],
            'stock' => ['required', 'numeric', 'min:0'],
        ], [
            'image.image' => 'File yang diunggah harus berupa gambar.',
            'image.mimes' => 'Gambar harus berformat png, jpg, atau jpeg.',
            'image.max' => 'Gambar tidak boleh lebih dari 2MB.',
            
            'name.required' => 'Nama menu harus diisi.',
            'name.string' => 'Nama menu harus berupa teks.',
            
            'price.required' => 'Harga harus diisi.',
            'price.numeric' => 'Harga harus berupa angka.',
            'price.min' => 'Harga tidak boleh kurang dari 0.',
            
            'description.required' => 'Deskripsi harus diisi.',
            'description.string' => 'Deskripsi harus berupa teks.',
            
            'category.required' => 'Kategori harus dipilih.',
            
            'stock.required' => 'Stok harus diisi.',
            'stock.numeric' => 'Stok harus berupa angka.',
            'stock.min' => 'Stok tidak boleh kurang dari 0.',
        ]);

        // logic untuk memasukan foto
        if ($request->has('image')) {
            $image = $request->image;
            $imageName = time() . '.' . $image->extension();
            $image->move(public_path('images'), $imageName);
        } else {
            $imageName = Menu::where('menu_id', $menu_id)
                ->pluck('image')
                ->first();
        }
        

        Menu::where('menu_id', $menu_id)->update([
            'image' => $imageName,
            'name' => $request->name,
            'price' => $request->price,
            'description' => $request->description,
            'category' => $request->category,
            'stock' => $request->stock,
        ]);

        return redirect()->route('admin.daftar-menu')->with('success', 'Menu berhasil diubah!');

    }

    public function hapusMenu($menu_id) {

        Menu::where('menu_id', $menu_id)
        ->delete();

        return redirect()->back()->with('swal', ['type' => 'success', 'message' => 'Menu berhasil dihapus!']);

    }
    // CRUD MENU \\



    // CRUD ADMIN ====================================================================================================
    public function daftarAdmin() {

        $admins = Admin::all();

        return view('admin.daftar-admin', [
            'admins' => $admins
        ]);

    }

    public function tambahAdmin() {

        return view('admin.tambah-admin');

    }

    public function simpanAdmin(Request $request) {

        $request->validate([
            'name' => ['required', 'string'],
            'email' => ['required', 'email'],
            'password' => ['required', 'min:8'],
            'address' => ['required', 'string'],
        ],[
            'name.required' => 'Nama wajib diisi.',
            'name.string' => 'Nama wajib terdiri dari huruf.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email salah.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 8 karakter.',
            'address.required' => 'Alamat wajib diisi.',
            'address.string' => 'Alamat wajib terdiri dari huruf.',
        ]);

        Admin::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'address' => $request->address,
        ]);

        return redirect()->route('admin.daftar-admin')->with('success', 'Admin berhasil dibuat!');

    }

    public function ubahAdmin($admin_id) {

        $admin = Admin::where('admin_id', $admin_id)->get();

        return view('admin.ubah-admin', compact('admin'));

    }

    public function updateAdmin(Request $request, $admin_id) {

        $request->validate([
            'name' => ['required', 'string'],
            'email' => ['required', 'email'],
            'address' => ['required', 'string'],
            // 'password' => ['required', 'min:8'],
        ],[
            'name.required' => 'Nama wajib diisi.',
            'name.string' => 'Nama wajib terdiri dari huruf.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email salah.',
            'address.required' => 'Alamat wajib diisi.',
            'address.string' => 'Alamat wajib terdiri dari huruf.',
            // 'password.required' => 'Password wajib diisi.',
            // 'password.min' => 'Password minimal 8 karakter.',
        ]);

        Admin::where('admin_id', $admin_id)->update([
            'name' => $request->name,
            'email' => $request->email,
            'address' => $request->address,
            // 'password' => Hash::make($request->password),
        ]);

        return redirect()->route('admin.daftar-admin')->with('success', 'Admin berhasil diubah!');

    }

    public function hapusAdmin($admin_id) {

        Admin::where('admin_id', $admin_id)
        ->delete();

        return redirect()->back()->with('swal', ['type' => 'success', 'message' => 'Admin berhasil dihapus!']);

    }
    // CRUD ADMIN \\



    // CRUD CASHIER ====================================================================================================
    public function daftarCashier() {

        $cashiers = Cashier::all();

        return view('admin.daftar-cashier', [
            'cashiers' => $cashiers
        ]);

    }

    public function tambahCashier() {

        return view('admin.tambah-cashier');

    }

    public function simpanCashier(Request $request) {

        $request->validate([
            'name' => ['required', 'string'],
            'email' => ['required', 'email'],
            'password' => ['required', 'min:8'],
            'address' => ['required', 'string'],
        ],[
            'name.required' => 'Nama wajib diisi.',
            'name.string' => 'Nama wajib terdiri dari huruf.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email salah.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 8 karakter.',
            'address.required' => 'Alamat wajib diisi.',
            'address.string' => 'Alamat wajib terdiri dari huruf.',
        ]);

        Cashier::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'address' => $request->address,
        ]);

        return redirect()->route('admin.daftar-cashier')->with('success', 'Kasir berhasil dibuat!');

    }

    public function ubahCashier($cashier_id) {

        $cashier = Cashier::where('cashier_id', $cashier_id)->get();

        return view('admin.ubah-cashier', compact('cashier'));

    }

    public function updateCashier(Request $request, $cashier_id) {

        $request->validate([
            'name' => ['required', 'string'],
            'email' => ['required', 'email'],
            'address' => ['required', 'string'],
        ],[
            'name.required' => 'Nama wajib diisi.',
            'name.string' => 'Nama wajib terdiri dari huruf.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email salah.',
            'address.required' => 'Alamat wajib diisi.',
            'address.string' => 'Alamat wajib terdiri dari huruf.',
        ]);

        Cashier::where('cashier_id', $cashier_id)->update([
            'name' => $request->name,
            'email' => $request->email,
            'address' => $request->address,
        ]);

        return redirect()->route('admin.daftar-cashier')->with('success', 'Kasir berhasil diubah!');

    }

    public function hapusCashier($cashier_id) {

        Cashier::where('cashier_id', $cashier_id)
        ->delete();

        return redirect()->back()->with('swal', ['type' => 'success', 'message' => 'Kasir berhasil dihapus!']);

    }
    // CRUD CASHIER \\



    // CRUD CHEF ====================================================================================================
    public function daftarChef() {

        $chefs = Chef::all();

        return view('admin.daftar-chef', [
            'chefs' => $chefs
        ]);

    }

    public function tambahChef() {

        return view('admin.tambah-chef');

    }

    public function simpanChef(Request $request) {

        $request->validate([
            'name' => ['required', 'string'],
            'email' => ['required', 'email'],
            'password' => ['required', 'min:8'],
            'address' => ['required', 'string'],
        ],[
            'name.required' => 'Nama wajib diisi.',
            'name.string' => 'Nama wajib terdiri dari huruf.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email salah.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 8 karakter.',
            'address.required' => 'Alamat wajib diisi.',
            'address.string' => 'Alamat wajib terdiri dari huruf.',
        ]);

        Chef::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'address' => $request->address,
        ]);

        return redirect()->route('admin.daftar-chef')->with('success', 'Koki berhasil dibuat!');

    }

    public function ubahChef($chef_id) {

        $chef = Chef::where('chef_id', $chef_id)->get();

        return view('admin.ubah-chef', compact('chef'));

    }

    public function updateChef(Request $request, $chef_id) {

        $request->validate([
            'name' => ['required', 'string'],
            'email' => ['required', 'email'],
            'address' => ['required', 'string'],
        ],[
            'name.required' => 'Nama wajib diisi.',
            'name.string' => 'Nama wajib terdiri dari huruf.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email salah.',
            'address.required' => 'Alamat wajib diisi.',
            'address.string' => 'Alamat wajib terdiri dari huruf.',
        ]);

        Chef::where('chef_id', $chef_id)->update([
            'name' => $request->name,
            'email' => $request->email,
            'address' => $request->address,
        ]);

        return redirect()->route('admin.daftar-chef')->with('success', 'Koki berhasil diubah!');

    }

    public function hapusChef($chef_id) {

        Chef::where('chef_id', $chef_id)
        ->delete();

        return redirect()->back()->with('swal', ['type' => 'success', 'message' => 'Koki berhasil dihapus!']);

    }
    // CRUD CHEF \\

    // CRUD TRANSACTION ====================================================================================================
    public function daftarTransaction() {

        $transactions = Transaction::leftJoin('cashiers', 'cashiers.cashier_id', '=', 'transactions.cashier_id')
        ->select('transactions.*', 'cashiers.name')
        ->get();

        return view('admin.daftar-transaction', compact('transactions'));

    }

    public function detailTransaction($transaction_id) {

        $transaction = TransactionDetail::leftJoin('menus', 'menus.menu_id', '=', 'detail_transactions.menu_id')
        ->leftJoin('transactions', 'transactions.transaction_id', '=', 'detail_transactions.transaction_id')
        ->select('detail_transactions.*', 'transactions.income')
        ->where('detail_transactions.transaction_id', $transaction_id)
        ->get();

        dd($transaction);

        return view('admin.detail-transaction', compact('transaction'));

    }
    // CRUD TRANSACTION \\

}
