<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Http\Request;

class CashierController extends Controller
{

    public function dashboard()
    {

        $name = session('cashier')['name'];

        $unconfirmedOrder = Order::where('status', 'Dipesan')->count();

        $waitingOrder = Order::where('status', 'Disajikan')->count();

        $completeOrder = Order::where('status', 'Selesai')->count();

        return view('cashier.dashboard', compact(
            'name',
            'unconfirmedOrder',
            'waitingOrder',
            'completeOrder'
        ));
    }

    public function pesananMasuk()
    {

        $unconfirmedOrders = Order::leftJoin('customers', 'customers.customer_id', '=', 'orders.customer_id')
            ->select('orders.*', 'customers.username')
            ->where('status', 'Dipesan')
            ->get();

        return view('cashier.pesanan-masuk', compact('unconfirmedOrders'));
    }

    public function hapusPesananMasuk($order_id)
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

    public function detailPesananMasuk($order_id)
    {

        $ordersDetail = OrderDetail::leftJoin('menus', 'menus.menu_id', '=', 'detail_orders.menu_id')
            ->leftJoin('orders', 'orders.order_id', '=', 'detail_orders.order_id')
            ->select('detail_orders.*', 'menus.name', 'menus.image', 'orders.receipt_code')
            ->where('detail_orders.order_id', $order_id)
            ->get();

        $totalPrice = OrderDetail::where('order_id', $order_id)
            ->sum('sub_total');

        return view('cashier.detail-pesanan-masuk', [
            'order' => $ordersDetail,
            'totalPrice' => $totalPrice,
        ]);
    }

    public function konfirmasiPesananMasuk($order_id)
    {

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

    public function pesananAktif()
    {

        $activeOrders = Order::leftJoin('customers', 'customers.customer_id', '=', 'orders.customer_id')
            ->select('orders.*', 'customers.username')
            ->where('status', 'Disajikan')
            ->get();

        return view('cashier.pesanan-aktif', compact('activeOrders'));
    }

    public function bayarPesanan($order_id)
    {

        $order = OrderDetail::leftJoin('menus', 'menus.menu_id', '=', 'detail_orders.menu_id')
            ->where('order_id', $order_id)
            ->get();

        $total = OrderDetail::where('order_id', $order_id)
            ->sum('sub_total');

        return view('cashier.bayar-pesanan', compact('order', 'total'));
    }

    public function terimaTransaksi(Request $request)
    {

        if ($request->uangPembayaran < $request->total) {

            return redirect()->back()->with('fail', 'Uang pembayaran kurang!');
        }

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

        foreach ($request->menu_id as $index => $menu_id) {
            TransactionDetail::create([
                'transaction_id' => $transactionDetailId,
                'menu_id' => $menu_id,
                'quantity' => $request->quantity[$index],
                'sub_total' => $request->sub_total[$index]
            ]);
        }

        return redirect()
            ->route('bayar-selesai', ['order_id' => $request->order_id, 'payment' => $request->uangPembayaran])
            ->with('success', 'Transaksi berhasil!');
    }

    public function bayarSelesai($order_id, $payment)
    {

        $orders = OrderDetail::leftJoin('menus', 'menus.menu_id', '=', 'detail_orders.menu_id')
            ->select('detail_orders.*', 'menus.name', 'menus.price')
            ->where('order_id', $order_id)
            ->get();

        $totalPrice = OrderDetail::where('order_id', $order_id)
            ->sum('sub_total');

        $change = $payment - $totalPrice;

        return view('cashier.bayar-selesai', compact(
            'orders', 
            'totalPrice', 
            'payment', 
            'change', 
            'order_id'
        ));
    }

    public function strukPembayaran($order_id, $payment)
    {

        $cashier_name = session('cashier')['name'];

        $orders = OrderDetail::leftJoin('menus', 'menus.menu_id', '=', 'detail_orders.menu_id')
            ->select('detail_orders.*', 'menus.name', 'menus.price')
            ->where('order_id', $order_id)
            ->get();

        $totalPrice = OrderDetail::where('order_id', $order_id)
            ->sum('sub_total');

        $change = $payment - $totalPrice;

        $printDate = now();

        // Set opsi DomPDF
        $options = new Options();
        $options->set('defaultFont', 'Courier');
        $dompdf = new Dompdf($options);

        // Render HTML ke PDF
        $html = view('cashier.struk', compact(
            'cashier_name', 
            'orders', 
            'totalPrice', 
            'payment', 
            'change',
            'printDate',
            ))->render();

        $dompdf->loadHtml($html);
        $dompdf->setPaper([0, 0, 226.8, 652.05], 'portrait'); // L = 8cm, P = 23cm
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
        // $pdfPath = public_path('pdf/Laporan Transaksi.pdf');
        // file_put_contents($pdfPath, $output);

        // Mengarahkan ke halaman untuk membuka file PDF
        return response()->stream(
            function () use ($output) {
                echo $output;
            },
            200,
            [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'inline; filename="Laporan Transaksi.pdf"',
            ]
        );

        // return view('cashier.struk');

    }

    public function pesananSelesai()
    {
        $doneOrders = Order::leftJoin('customers', 'customers.customer_id', '=', 'orders.customer_id')
        ->where('status', 'Selesai')
        ->get();

        return view('cashier.pesanan-selesai', compact('doneOrders'));
    }

    public function detailPesananSelesai($order_id)
    {

        $ordersDetail = OrderDetail::leftJoin('menus', 'menus.menu_id', '=', 'detail_orders.menu_id')
            ->leftJoin('orders', 'orders.order_id', '=', 'detail_orders.order_id')
            ->select('detail_orders.*', 'menus.name', 'menus.image', 'orders.receipt_code')
            ->where('detail_orders.order_id', $order_id)
            ->get();

        $totalPrice = OrderDetail::where('order_id', $order_id)
            ->sum('sub_total');

        return view('cashier.detail-pesanan-selesai', [
            'order' => $ordersDetail,
            'totalPrice' => $totalPrice,
        ]);
    }
}
