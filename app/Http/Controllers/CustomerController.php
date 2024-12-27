<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Menu;
use App\Models\Order;
use App\Models\OrderDetail;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Str;

class CustomerController extends Controller
{

    // function untuk membuat kode unik order
    private function generateUniqueCode($customer_id, $increment)
    {
        $nowDate = Carbon::now()->format('d');
        $nowMonth = Carbon::now()->format('m');
        $nowCombine = $nowDate . $nowMonth;
        return '#' . $customer_id . $nowCombine . '-' . $increment;
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

        return redirect()->back()->with('success', 'Menu masuk ke keranjang!');
    }

    public function hapusMenu($menu_id)
    {

        $customer_id = session('customer')['id'];
        Cart::where('customer_id', $customer_id)
            ->where('menu_id', $menu_id)
            ->delete();

        return redirect()->back()->with('success', 'Menu dihapus dari keranjang!');
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

        return redirect()->back();
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

        return redirect()->back();
    }
    // CART \\



    // ORDER
    public function pesanan(Request $request)
    {
        $customer_id = session('customer')['id'];

        $statuses = Order::where('customer_id', $customer_id)
            ->distinct()
            ->pluck('status');

        $filter = $request->query('status');

        if ($filter == 'all' || empty($filter)) {
            $orders = Order::where('customer_id', $customer_id)
                ->orderBy('status')
                ->get();
        } else {
            $orders = Order::where('customer_id', $customer_id)
                ->where('status', $filter)
                ->get();
        }


        return view('customer.pesanan', compact('orders', 'statuses'));
    }

    public function tambahOrder(Request $request)
    {
        $customer_id = session('customer')['id'];

        $order = Order::create([
            'customer_id' => $customer_id,
            'order_date' => now(),
            'status' => 'Dipesan',
        ]);

        $orderDetailId = $order->order_id;

        Order::where('customer_id', $customer_id)
            ->where('order_id', $orderDetailId)
            ->update([
                'receipt_code' => $this->generateUniqueCode($customer_id, $orderDetailId),
            ]);

        foreach ($request->menu_id as $index => $menu) {
            OrderDetail::create([
                'order_id' => $orderDetailId,
                'menu_id' => $menu,
                'quantity' => $request->quantity[$index],
                'sub_total' => $request->price[$index] * $request->quantity[$index],
                'status' => 'Diproses',
            ]);
        }

        Cart::where('customer_id', $customer_id)->delete();

        return redirect()->route('pesanan')->with('success', 'Pesanan berhasil dibuat!');
    }

    public function batalkanOrder($order_id)
    {

        Order::where('order_id', $order_id)
            ->update([
                'status' => 'Dibatalkan',
            ]);

        OrderDetail::where('order_id', $order_id)
            ->update([
                'status' => 'Dibatalkan',
            ]);

        return redirect()->back()->with('success', 'Pesanan berhasil dibatalkan!');
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
