<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Http\Request;

class ChefController extends Controller
{

    public function dashboard()
    {

        // $orders = Order::leftJoin('customers', 'customers.customer_id', '=', 'orders.customer_id')
        // ->leftJoin('')
        //     ->select('orders.*', 'customers.username')
        //     ->where('status', 'Diproses')
        //     ->get();

        $orders = OrderDetail::leftJoin('menus', 'menus.menu_id', '=', 'detail_orders.menu_id')
        ->leftJoin('orders', 'orders.order_id', '=', 'detail_orders.order_id')
        ->leftJoin('customers', 'customers.customer_id', '=', 'orders.customer_id')
        ->select('detail_orders.*', 'menus.*', 'orders.*', 'customers.*')
        ->where('detail_orders.status', 'Dimasak')
        ->get();

        return view('chef.dashboard', [
            'orders' => $orders,
        ]);

    }

    public function selesaikanMenu($order_id, $menu_id)
    {

        OrderDetail::where('order_id', $order_id)
            ->where('menu_id', $menu_id)
            ->update([
                'status' => 'Disajikan'
            ]);

        $pesananDimasak = OrderDetail::where('order_id', $order_id)
            ->where('status', 'Dimasak')
            ->count();

        if ($pesananDimasak == 0) {
            Order::where('order_id', $order_id)
                ->update([
                    'status' => 'Disajikan',
                ]);
        }

        return redirect()->back()->with('success', 'Pesanan selesai!');
    }
}
