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
use Carbon\Carbon;
use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public static function getMostOrderedMenu($category, $startOfMonth, $endOfMonth)
    {
        // BY APPEARANCE
        return TransactionDetail::leftJoin('menus', 'menus.menu_id', '=', 'detail_transactions.menu_id')
            ->leftJoin('transactions', 'transactions.transaction_id', '=', 'detail_transactions.transaction_id')
            ->select('menus.name', 'menus.image', 'menus.category')
            ->selectRaw('COUNT(detail_transactions.menu_id) as menu_appearance')
            ->whereBetween('transactions.transaction_date', [$startOfMonth, $endOfMonth])
            ->where('menus.category', $category)
            ->groupBy('detail_transactions.menu_id')
            ->orderBy('menu_appearance', 'desc')
            ->first();
    }



    public function dashboard()
    {

        $name = session('admin')['name'];

        $todayOrders = Order::where('status', 'Selesai')
            ->whereDate('order_date', Carbon::today())
            ->count();

        $todayIncomes = Transaction::whereDate('transaction_date', Carbon::today())
            ->sum('income');

        $todayMenus = OrderDetail::leftJoin('orders', 'orders.order_id', '=', 'detail_orders.order_id')
            ->where('detail_orders.status', 'Selesai')
            ->whereDate('orders.order_date', Carbon::today())
            ->count();

        $startOfMonth = Carbon::now()->startOfMonth()->toDateString();
        $endOfMonth = Carbon::now()->endOfMonth()->toDateString();
        
        // BY QUANTITY
        $mostOrderedMenu = TransactionDetail::leftJoin('menus', 'menus.menu_id', '=', 'detail_transactions.menu_id')
            ->leftJoin('transactions', 'transactions.transaction_id', '=', 'detail_transactions.transaction_id')
            ->select('menus.name', 'menus.image', 'menus.category')
            ->selectRaw('SUM(quantity) as total_quantity')
            ->whereBetween('transactions.transaction_date', [$startOfMonth, $endOfMonth])
            ->groupBy('detail_transactions.menu_id')
            ->orderBy('total_quantity', 'desc')
            ->first();

        $mostOrderedFood = $this->getMostOrderedMenu('Makanan', $startOfMonth, $endOfMonth);

        $mostOrderedBev = $this->getMostOrderedMenu('Minuman', $startOfMonth, $endOfMonth);

        return view('admin.dashboard', [
            'name' => $name,
            'todayOrders' => $todayOrders,
            'todayIncomes' => $todayIncomes,
            'todayMenus' => $todayMenus,
            'mostOrderedMenu' => $mostOrderedMenu,
            'mostOrderedFood' => $mostOrderedFood,
            'mostOrderedBev' => $mostOrderedBev,
        ]);
    }

    // CRUD CUSTOMER ====================================================================================================
    public function daftarCustomer(Request $request)
    {

        $perPage = 10;

        $filter = $request->query('username');

        if(empty($filter)){
            $customers = Customer::latest()->paginate($perPage);
        }else{
            $customers = Customer::where('username', 'LIKE', "%$filter%")->latest()->paginate($perPage);
        }

        $currentPage = $customers->currentPage();
        $offset = ($currentPage - 1) * $perPage;

        return view('admin.daftar-customer', compact('customers', 'offset'));
    }

    public function tambahCustomer()
    {

        return view('admin.tambah-customer');
    }

    public function simpanCustomer(Request $request)
    {

        $request->validate([
            'name' => ['required', 'regex:/^[a-zA-Z\s]+$/'],
            'username' => ['required', 'regex:/^[a-zA-Z\s]+$/', 'min:3'],
            'email' => ['required', 'email', 'unique:customers,email'],
            'password' => ['required', 'min:8'],
        ], [
            'name.required' => 'Nama wajib diisi.',
            'name.regex' => 'Nama hanya boleh mengandung huruf dan spasi.',
            'username.required' => 'Username wajib diisi.',
            'username.regex' => 'Username hanya boleh mengandung huruf dan spasi.',
            'username.min' => 'Username minimal 3 karakter.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email salah.',
            'email.unique' => 'Email sudah terdaftar.',
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

    public function ubahCustomer($customer_id)
    {

        $customer = Customer::where('customer_id', $customer_id)->get();

        return view('admin.ubah-customer', compact('customer'));
    }

    public function updateCustomer(Request $request, $customer_id)
    {

        $request->validate([
            'name' => ['required', 'regex:/^[a-zA-Z\s]+$/'],
            'username' => ['required', 'regex:/^[a-zA-Z\s]+$/', 'min:3'],
            'email' => ['required', 'email', 'unique:customers,email,' . $customer_id . ',customer_id'],
        ], [
            'name.required' => 'Nama wajib diisi.',
            'name.regex' => 'Nama hanya boleh mengandung huruf dan spasi.',
            'username.required' => 'Username wajib diisi.',
            'username.regex' => 'Username hanya boleh mengandung huruf dan spasi.',
            'username.min' => 'Username minimal 3 karakter.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email salah.',
            'email.unique' => 'Email sudah terdaftar.',
        ]);

        Customer::where('customer_id', $customer_id)->update([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
        ]);

        return redirect()->route('admin.daftar-customer')->with('success', 'Pelanggan berhasil diubah!');
    }

    public function hapusCustomer($customer_id)
    {

        Customer::where('customer_id', $customer_id)
            ->delete();

        return redirect()->back()->with('success', 'Pelanggan berhasil dihapus!');
    }
    // CRUD CUSTOMER \\



    // CRUD MENU ====================================================================================================
    public function daftarMenu(Request $request)
    {

        $categories = Menu::distinct()->pluck('category');

        $filter = $request->query('category');

        $perPage = 10;
        if (empty($filter)) {
            $menus = Menu::latest()->paginate($perPage);
        } else {
            $menus = Menu::where('category', $filter)
                ->latest()
                ->paginate($perPage);
        }
        $currentPage = $menus->currentPage();
        $offset = ($currentPage - 1) * $perPage;

        return view('admin.daftar-menu', compact('menus', 'offset', 'categories'));
    }

    public function tambahMenu()
    {

        return view('admin.tambah-menu');
    }

    public function simpanMenu(MenuRequest $request)
    {

        $image = $request->image;
        $imageName = time() . '.' . $image->extension();
        $image->move(public_path('images'), $imageName);

        Menu::create([
            'image' => $imageName,
            'name' => $request->name,
            'price' => $request->price,
            'description' => $request->description,
            'category' => $request->category,
            'status' => $request->status
        ]);

        return redirect()->route('admin.daftar-menu')->with('success', 'Menu berhasil dibuat!');
    }

    public function ubahMenu($menu_id)
    {

        $menu = Menu::where('menu_id', $menu_id)->get();

        return view('admin.ubah-menu', compact('menu'));
    }

    public function updateMenu(Request $request, $menu_id)
    {

        $request->validate([
            'image' => ['nullable', 'image', 'mimes:png,jpg,jpeg', 'max:2048'],
            'name' => ['required', 'regex:/^[a-zA-Z\s]+$/'],
            'price' => ['required', 'numeric', 'min:0'],
            'description' => ['required', 'string'],
            'category' => ['required'],
            'status' => ['required'],
        ], [
            'image.image' => 'File yang diunggah harus berupa gambar.',
            'image.mimes' => 'Gambar harus berformat png, jpg, atau jpeg.',
            'image.max' => 'Gambar tidak boleh lebih dari 2MB.',

            'name.required' => 'Nama menu harus diisi.',
            'name.regex' => 'Nama menu hanya boleh mengandung huruf dan spasi.',

            'price.required' => 'Harga harus diisi.',
            'price.numeric' => 'Harga harus berupa angka.',
            'price.min' => 'Harga tidak boleh kurang dari 0.',

            'description.required' => 'Deskripsi harus diisi.',
            'description.string' => 'Deskripsi harus berupa teks.',

            'category.required' => 'Kategori harus dipilih.',

            'status.required' => 'Status harus diisi.',
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
            'status' => $request->status,
        ]);

        return redirect()->route('admin.daftar-menu')->with('success', 'Menu berhasil diubah!');
    }

    public function hapusMenu($menu_id)
    {

        Menu::where('menu_id', $menu_id)
            ->delete();

        return redirect()->back()->with('success', 'Menu berhasil dihapus!');
    }
    // CRUD MENU \\



    // CRUD CASHIER ====================================================================================================
    public function daftarCashier()
    {

        $perPage = 10;

        $cashiers = Cashier::latest()->paginate($perPage);

        $currentPage = $cashiers->currentPage();
        $offset = ($currentPage - 1) * $perPage;

        return view('admin.daftar-cashier', compact('cashiers', 'offset'));
    }

    public function tambahCashier()
    {

        return view('admin.tambah-cashier');
    }

    public function simpanCashier(Request $request)
    {

        $request->validate([
            'name' => ['required', 'regex:/^[a-zA-Z\s]+$/'],
            'email' => ['required', 'email', 'unique:cashiers,email'],
            'password' => ['required', 'min:8'],
            'address' => ['required', 'string'],
        ], [
            'name.required' => 'Nama wajib diisi.',
            'name.regex' => 'Nama hanya boleh mengandung huruf dan spasi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email salah.',
            'email.unique' => 'Email sudah terdaftar.',
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

    public function ubahCashier($cashier_id)
    {

        $cashier = Cashier::where('cashier_id', $cashier_id)->get();

        return view('admin.ubah-cashier', compact('cashier'));
    }

    public function updateCashier(Request $request, $cashier_id)
    {

        $request->validate([
            'name' => ['required', 'regex:/^[a-zA-Z\s]+$/'],
            'email' => ['required', 'email', 'unique:cashiers,email,' . $cashier_id . ',cashier_id'],
            'address' => ['required', 'string'],
        ], [
            'name.required' => 'Nama wajib diisi.',
            'name.regex' => 'Nama hanya boleh mengandung huruf dan spasi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email salah.',
            'email.unique' => 'Email sudah terdaftar.',
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

    public function hapusCashier($cashier_id)
    {

        Cashier::where('cashier_id', $cashier_id)
            ->delete();

        return redirect()->back()->with('success', 'Kasir berhasil dihapus!');
    }
    // CRUD CASHIER \\



    // CRUD CHEF ====================================================================================================
    public function daftarChef()
    {

        $perPage = 10;

        $chefs = Chef::latest()->paginate($perPage);

        $currentPage = $chefs->currentPage();
        $offset = ($currentPage - 1) * $perPage;

        return view('admin.daftar-chef', compact('chefs', 'offset'));
    }

    public function tambahChef()
    {

        return view('admin.tambah-chef');
    }

    public function simpanChef(Request $request)
    {

        $request->validate([
            'name' => ['required', 'regex:/^[a-zA-Z\s]+$/'],
            'email' => ['required', 'email', 'unique:chefs,email'],
            'password' => ['required', 'min:8'],
            'address' => ['required', 'string'],
        ], [
            'name.required' => 'Nama wajib diisi.',
            'name.regex' => 'Nama hanya boleh mengandung huruf dan spasi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email salah.',
            'email.unique' => 'Email sudah terdaftar.',
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

    public function ubahChef($chef_id)
    {

        $chef = Chef::where('chef_id', $chef_id)->get();

        return view('admin.ubah-chef', compact('chef'));
    }

    public function updateChef(Request $request, $chef_id)
    {

        $request->validate([
            'name' => ['required', 'regex:/^[a-zA-Z\s]+$/'],
            'email' => ['required', 'email', 'unique:chefs,email,' . $chef_id . ',chef_id'],
            'address' => ['required', 'string'],
        ], [
            'name.required' => 'Nama wajib diisi.',
            'name.regex' => 'Nama hanya boleh mengandung huruf dan spasi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email salah.',
            'email.unique' => 'Email sudah terdaftar.',
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

    public function hapusChef($chef_id)
    {

        Chef::where('chef_id', $chef_id)
            ->delete();

        return redirect()->back()->with('success', 'Koki berhasil dihapus!');
    }
    // CRUD CHEF \\



    // CRUD TRANSACTION ====================================================================================================
    public function daftarTransaction()
    {
        $perPage = 10;

        $transactions = Transaction::leftJoin('cashiers', 'cashiers.cashier_id', '=', 'transactions.cashier_id')
            ->select('transactions.*', 'cashiers.name')
            ->latest()
            ->paginate($perPage);

        $currentPage = $transactions->currentPage();
        $offset = ($currentPage - 1) * $perPage;

        $raw_transaction_date = Transaction::latest()->pluck('transaction_date');
        $transaction_date = [];
        
        foreach($raw_transaction_date as $date) {
            $transaction_date[] = Carbon::parse($date)->format('d-m-Y');
        }        

        return view('admin.daftar-transaction', compact('transactions', 'transaction_date', 'offset'));
    }

    public function detailTransaction($transaction_id)
    {

        $transaction = TransactionDetail::leftJoin('menus', 'menus.menu_id', '=', 'detail_transactions.menu_id')
            ->leftJoin('transactions', 'transactions.transaction_id', '=', 'detail_transactions.transaction_id')
            ->select('detail_transactions.*', 'transactions.income', 'menus.*')
            ->where('detail_transactions.transaction_id', $transaction_id)
            ->get();

        return view('admin.detail-transaction', compact('transaction'));
    }

    public function laporanKeuangan(Request $request)
    {

        $startDate = Carbon::parse($request->startDate);
        $endDate = Carbon::parse($request->endDate);

        if ($startDate->gt($endDate)) {
            return redirect()->back()->with('fail', 'Tanggal awal tidak boleh lebih besar dari tanggal akhir');
        }

        $totalIncome = Transaction::whereBetween('transaction_date', [$startDate, $endDate])->sum('income');

        $transactions = Transaction::select('transaction_date', DB::raw('SUM(income) as total_pendapatan'))
        ->groupBy('transaction_date')
        ->get();
        
        // Set opsi DomPDF
        $options = new Options();
        $options->set('defaultFont', 'Courier');
        $dompdf = new Dompdf($options);

        $displayStartDate = $startDate->format('Y-m-d');
        $displayEndDate = $endDate->format('Y-m-d');

        // Render HTML ke PDF
        $html = view('admin.buat-laporan', compact(
            'transactions',
            'totalIncome',
            'displayStartDate',
            'displayEndDate',
        ))->render();

        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        // menambahkan nomor halaman
        $canvas = $dompdf->getCanvas();
        $fontMetrics = $dompdf->getFontMetrics();
        $pageCount = $dompdf->getCanvas()->get_page_count();

        for ($i = 1; $i <= $pageCount; $i++) {
            $canvas->page_script(function ($pageNumber, $pageCount, $canvas, $fontMetrics) {
                $text = "$pageNumber";
                $width = $fontMetrics->getTextWidth($text, 'Courier', 12);
                $canvas->text(560 - $width, 815, $text, null, 12); // Ubah posisi x dan y sesuai kebutuhan
            });
        }

        // Menyimpan PDF di public path
        $output = $dompdf->output();

        // Mengarahkan ke halaman untuk membuka file PDF
        return response()->stream(
            function () use ($output) {
                echo $output;
            },
            200,
            [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'inline; filename="Laporan Keuangan.pdf"',
            ]
        );
    }

    // CRUD TRANSACTION \\



    // CRUD ADMIN ====================================================================================================
    // public function daftarAdmin()
    // {

    //     $perPage = 10;

    //     $admins = Admin::latest()->paginate($perPage);

    //     $currentPage = $admins->currentPage();
    //     $offset = ($currentPage - 1) * $perPage;

    //     return view('admin.daftar-admin', compact('admins', 'offset'));
    // }

    // public function tambahAdmin()
    // {

    //     return view('admin.tambah-admin');
    // }

    // public function simpanAdmin(Request $request)
    // {

    //     $request->validate([
    //         'name' => ['required', 'string'],
    //         'email' => ['required', 'email', 'unique:admins,email'],
    //         'password' => ['required', 'min:8'],
    //         'address' => ['required', 'string'],
    //     ], [
    //         'name.required' => 'Nama wajib diisi.',
    //         'name.string' => 'Nama wajib terdiri dari huruf.',
    //         'email.required' => 'Email wajib diisi.',
    //         'email.email' => 'Format email salah.',
    //         'email.unique' => 'Email sudah terdaftar.',
    //         'password.required' => 'Password wajib diisi.',
    //         'password.min' => 'Password minimal 8 karakter.',
    //         'address.required' => 'Alamat wajib diisi.',
    //         'address.string' => 'Alamat wajib terdiri dari huruf.',
    //     ]);

    //     Admin::create([
    //         'name' => $request->name,
    //         'email' => $request->email,
    //         'password' => Hash::make($request->password),
    //         'address' => $request->address,
    //     ]);

    //     return redirect()->route('admin.daftar-admin')->with('success', 'Admin berhasil dibuat!');
    // }

    // public function ubahAdmin($admin_id)
    // {

    //     $admin = Admin::where('admin_id', $admin_id)->get();

    //     return view('admin.ubah-admin', compact('admin'));
    // }

    // public function updateAdmin(Request $request, $admin_id)
    // {

    //     $request->validate([
    //         'name' => ['required', 'string'],
    //         'email' => ['required', 'email', 'unique:admins,email,' . $admin_id . ',admin_id'],
    //         'address' => ['required', 'string'],
    //         // 'password' => ['required', 'min:8'],
    //     ], [
    //         'name.required' => 'Nama wajib diisi.',
    //         'name.string' => 'Nama wajib terdiri dari huruf.',
    //         'email.required' => 'Email wajib diisi.',
    //         'email.email' => 'Format email salah.',
    //         'email.unique' => 'Email sudah terdaftar.',
    //         'address.required' => 'Alamat wajib diisi.',
    //         'address.string' => 'Alamat wajib terdiri dari huruf.',
    //         // 'password.required' => 'Password wajib diisi.',
    //         // 'password.min' => 'Password minimal 8 karakter.',
    //     ]);

    //     Admin::where('admin_id', $admin_id)->update([
    //         'name' => $request->name,
    //         'email' => $request->email,
    //         'address' => $request->address,
    //         // 'password' => Hash::make($request->password),
    //     ]);

    //     return redirect()->route('admin.daftar-admin')->with('success', 'Admin berhasil diubah!');
    // }

    // public function hapusAdmin($admin_id)
    // {

    //     Admin::where('admin_id', $admin_id)
    //         ->delete();

    //     return redirect()->back()->with('success', 'Admin berhasil dihapus!');
    // }
    // CRUD ADMIN \\
}
