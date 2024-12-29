<x-app-layout :title="'Bayar Selesai'">

    <div class="p-2 w-1/3 bg-white rounded-md shadow-md border-2 border-black font-roboto flex flex-col items-center">
        <div>
            <h1 class="text-center text-3xl font-bold">
                Pembayaran Berhasil
            </h1>
            <span>==============================================</span>
        </div>

        <div class="overflow-y-auto w-full max-h-64 mt-2 mb-2">
            @foreach ($orders as $order)
                <div class="flex justify-between items-center p-1 border-b border-black">
                    <div class="flex flex-col">
                        <span>{{ $order->name }}</span>
                        <span>{{ $order->quantity }} x Rp {{ number_format($order->price, 0, ',', '.') }}</span>
                    </div>
                    <span>Rp {{ number_format($order->sub_total, 0, ',', '.') }}</span>
                </div>
            @endforeach
        </div>

        <div>
            <div class="font-semibold flex flex-col">
                <span>Total: Rp {{ number_format($totalPrice, 0, ',', '.') }}</span>
                <span>Uang Pembayaran: Rp {{ number_format($payment, 0, ',', '.') }}</span>
                <span>Kembalian: Rp {{ number_format($change, 0, ',', '.') }}</span>
            </div>
            <span>==============================================</span>
        </div>

        <div class="w-full flex justify-between">
            <a href="{{ route('pesanan-aktif') }}"
                class="p-2 rounded-md border border-black bg-mY hover:bg-dY hover:text-white">
                <i class="fas fa-arrow-left mr-1"></i>
                Pesanan Aktif
            </a>
            <a href="{{ route('struk-pembayaran', ['order_id' => $order_id, 'payment' => $payment]) }}" class="p-2 rounded-md border border-black bg-mB hover:bg-dB hover:text-white">
                <i class="fas fa-print"></i>
                Cetak Struk
            </a>
        </div>
    </div>

</x-app-layout>
