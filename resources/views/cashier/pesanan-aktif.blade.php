<x-app-layout :title="'Pesanan Aktif'">

    <div class="flex flex-col justify-center w-11/12">
        <div class="bg-mY w-full p-5 border-2 border-black rounded-tr-md rounded-tl-md flex relative">
            <a href="{{ route('cashier-dashboard') }}" class="z-20">
                <i class="fas fa-arrow-left text-3xl"></i>
            </a>
            <div class="absolute inset-0 flex items-center justify-center">
                <h1 class="font-poppins text-3xl font-bold">Pesanan Aktif</h1>
            </div>

        </div>

        @if ($activeOrders->isNotEmpty())
        <div
            class="bg-mB p-3 border-2 border-t-0 border-black rounded-bl-md rounded-br-md overflow-x-auto overflow-y-auto">
            <table class="min-w-full bg-gray-50 w-full border border-black table-auto">

                <thead>
                    <tr>
                        <th class="border border-black p-2">No</th>
                        <th class="border border-black w-2/12">Username Pelanggan</th>
                        <th class="border border-black w-4/12">Kode Struk</th>
                        <th class="border border-black w-4/12">Tanggal & Waktu</th>
                        <th class="w-2/12">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($activeOrders as $index => $order)
                        <tr class="odd:bg-gray-200 hover:bg-gray-300 text-center">
                            <td class="border border-black">{{ $index + 1 }}</td>
                            <td class="px-2 border border-black">{{ $order->username }}</td>
                            <td class="px-2 border border-black font-semibold">{{ $order->receipt_code }}</td>
                            <td class="px-2 border border-black">{{ $order->order_date }}</td>
                            <td class="p-2 flex gap-2 justify-evenly">

                                <a href="{{ route('bayar-pesanan', [$order->order_id]) }}"
                                    class="bg-green-600 p-1.5 rounded text-white border border-black hover:bg-yellow-600">
                                    <i class="fas fa-check"></i>
                                    Selesaikan
                                </a>

                            </td>
                        </tr>
                    @endforeach
                </tbody>

            </table>
        </div>
        @else
        <div class="bg-white border border-black p-3 text-center text-2xl">
            <p>Belum ada pesanan aktif!</p>
        </div>
        @endif
        
    </div>

</x-app-layout>