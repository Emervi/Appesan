<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use Illuminate\Http\Request;

class CashierController extends Controller
{
    
    public function dashboard() {

        $unconfirmedOrder = Order::where('status', 'Dipesan')->count();

        $waitingOrder = Order::where('status', 'Disajikan')->count();

        $completeOrder = Order::where('status', 'Selesai')->count();

        $name = session('cashier')['name'];

        return view('cashier.dashboard', [
            'unconfirmedOrder' => $unconfirmedOrder,
            'waitingOrder' => $waitingOrder,
            'completeOrder' => $completeOrder,
            'name' => $name,
        ]);

    }

    public function pesananMasuk() {

        $unconfirmedOrders = Order::leftJoin('customers', 'customers.customer_id', '=', 'orders.customer_id')
        ->select('orders.*', 'customers.username')
        ->where('status', 'Dipesan')
        ->get();

        return view('cashier.pesanan-masuk', [
            'unconfirmedOrders' => $unconfirmedOrders,
        ]);

    }

    public function hapusPesananMasuk($order_id) {

        Order::where('order_id', $order_id)->delete();

        return redirect()->back()->with('success', 'Pesanan berhasil dibatalkan!');

    }

    public function detailPesananMasuk($order_id) {

        $ordersDetail = OrderDetail::leftJoin('menus', 'menus.menu_id', '=', 'detail_orders.menu_id')
            ->select('detail_orders.*', 'menus.name', 'menus.image')
            ->where('order_id', $order_id)
            ->get();

        $totalPrice = OrderDetail::where('order_id', $order_id)
            ->sum('sub_total');

        return view('cashier.detail-pesanan-masuk', [
            'order' => $ordersDetail,
            'totalPrice' => $totalPrice,
        ]);

    }

    public function konfirmasiPesananMasuk($order_id) {

        Order::where('order_id', $order_id)
        ->update([
            'status' => 'Diproses',
        ]);

        OrderDetail::where('order_id', $order_id)
        ->update([
            'status' => 'Dimasak',
        ]);

        return redirect()->back()->with('success', 'Pesanan berhasil dikonfirmasi!');

    }

    public function pesananAktif() {
        
        $activeOrders = Order::leftJoin('customers', 'customers.customer_id', '=', 'orders.customer_id')
        ->select('orders.*', 'customers.username')
        ->where('status', 'Disajikan')
        ->get();

        return view('cashier.pesanan-aktif', [
            'activeOrders' => $activeOrders,
        ]);

    }

    public function bayarPesanan($order_id) {
        
        $order = OrderDetail::leftJoin('menus', 'menus.menu_id', '=', 'detail_orders.menu_id')
        ->where('order_id', $order_id)
        ->get();

        $total = OrderDetail::where('order_id', $order_id)
        ->sum('sub_total');

        return view('cashier.bayar-pesanan', [
            'order' => $order,
            'total' => $total,
        ]);

    }

    public function terimaTransaksi(Request $request) {

        if($request->uangPembayaran < $request->total) {

            return redirect()->back()->with('fail', 'Uang pembayaran kurang!');

        }

        $kembalian = $request->uangPembayaran - $request->total;
        
        $cashier_id = session('cashier')['id'];
        Order::where('order_id', $request->order_id)
        ->update([
            'status' => 'Selesai'
        ]);

        $transaction = Transaction::create([
            'cashier_id' => $cashier_id,
            'transaction_date' => now(),
            'income' => $request->total,
        ]);

        $transactionDetailId = $transaction->transaction_id;

        foreach($request->menu_id as $index => $menu_id) {
            TransactionDetail::create([
                'transaction_id' => $transactionDetailId,
                'menu_id' => $menu_id,
                'quantity' => $request->quantity[$index],
                'sub_total' => $request->sub_total[$index]
            ]);
        }

        return redirect()->route('struk-pembayaran')->with('success', 'Transaksi berhasil!');

    }

    public function strukPembayaran() {

    }

}
