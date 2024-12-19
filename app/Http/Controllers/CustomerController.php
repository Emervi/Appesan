<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Menu;
use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Str;

class CustomerController extends Controller
{

    // function untuk membuat kode unik order
    private function generateUniqueCode($customer_id)
    {
        $randomString = Str::upper(Str::random(4)); // String acak sepanjang 4 karakter
        return '#' . $customer_id . $randomString; // Contoh hasil: STRUK-101-ABCD
    }



    // MENU
    public function menu()
    {

        $customer_id = session('customer')['id'];
        $menus = Menu::all();

        $selectedMenu = Cart::where('customer_id', $customer_id)->pluck('menu_id')->toArray();

        return view('customer.menu', [
            'menus' => $menus,
            'selectedMenu' => $selectedMenu,
        ]);
    }

    public function detailMenu($menu_id)
    {

        $menu = Menu::where('menu_id', $menu_id)->get();

        return view('customer.detail-menu', [
            'menu' => $menu,
        ]);
    }
    // MENU \\



    // CART
    public function keranjang()
    {

        $customer_id = session('customer')['id'];
        $carts = Cart::leftJoin('menus', 'menus.menu_id', '=', 'carts.menu_id') // Menyesuaikan join dengan kolom yang benar
            ->select('carts.*', 'menus.*', DB::raw('SUM(menus.price * carts.quantity) as total')) // Menggunakan DB::raw untuk menghitung total
            ->where('carts.customer_id', $customer_id) // Filter berdasarkan customer_id
            ->orderBy('carts.created_at', 'asc') // Urutkan berdasarkan waktu
            ->groupBy('carts.cart_id') // Diperlukan karena menggunakan fungsi agregasi
            ->get();


        return view('customer.keranjang', compact('carts'));
    }

    public function tambahKeranjang(Request $request)
    {

        Cart::create([
            'customer_id' => $request->customer_id,
            'menu_id' => $request->menu_id,
            'quantity' => $request->quantity,
        ]);

        return redirect()->back()->with('success', 'Menu berhasil ditambahkan!');
    }

    public function hapusMenu($menu_id)
    {

        $customer_id = session('customer')['id'];
        Cart::where('customer_id', $customer_id)
            ->where('menu_id', $menu_id)
            ->delete();

        return redirect()->back()->with('success', 'Menu berhasil dihapus dari keranjang!');
    }

    public function tambahKuantitas($menu_id)
    {

        $customer_id = session('customer')['id'];
        $cart = Cart::where('customer_id', $customer_id)
            ->where('menu_id', $menu_id);

        $cartQuantity = $cart->first()->quantity;

        $cart->update([
            'quantity' => $cartQuantity + 1,
        ]);

        return redirect()->back()->with('success', 'Kuantitas +1');
    }

    public function kurangiKuantitas($menu_id)
    {

        $customer_id = session('customer')['id'];
        $cart = Cart::where('customer_id', $customer_id)
            ->where('menu_id', $menu_id);

        $cartQuantity = $cart->first()->quantity;

        $cart->update([
            'quantity' => $cartQuantity - 1,
        ]);

        return redirect()->back()->with('success', 'Kuantitas -1');
    }
    // CART \\



    // ORDER
    public function pesanan()
    {
        $customer_id = session('customer')['id'];
        $orders = Order::where('customer_id', $customer_id)
            ->whereIn('status', ['Dipesan', 'Diproses'])
            ->get();

        return view('customer.pesanan', [
            'orders' => $orders,
        ]);
    }

    public function tambahOrder(Request $request)
    {
        $customer_id = session('customer')['id'];
        $order = Order::create([
            'customer_id' => $customer_id,
            'order_date' => now(),
            'receipt_code' => $this->generateUniqueCode($customer_id),
            'status' => 'Dipesan',
        ]);

        $orderDetailId = $order->order_id;

        foreach ($request->menu_id as $index => $menu) {
            OrderDetail::create([
                'order_id' => $orderDetailId,
                'menu_id' => $menu,
                'quantity' => $request->quantity[$index],
                'sub_total' => $request->price[$index] * $request->quantity[$index],
                'stastus' => 'Dipesan',
            ]);
        }

        Cart::where('customer_id', $customer_id)->delete();

        return redirect()->route('pesanan')->with('success', 'Pesanan berhasil dibuat!');
    }

    public function hapusOrder($order_id)
    {

        Order::where('order_id', $order_id)->delete();

        return redirect()->back()->with('success', 'Order berhasil dibatalkan!');
    }

    public function detailOrder($order_id)
    {

        $ordersDetail = OrderDetail::leftJoin('menus', 'menus.menu_id', '=', 'detail_orders.menu_id')
            ->select('detail_orders.*', 'menus.name', 'menus.image')
            ->where('order_id', $order_id)
            ->get();

        $totalPrice = OrderDetail::where('order_id', $order_id)
            ->sum('sub_total');

        return view('customer.detail-pesanan', [
            'ordersDetail' => $ordersDetail,
            'totalPrice' => $totalPrice,
        ]);
    }
    // ORDER \\

}
