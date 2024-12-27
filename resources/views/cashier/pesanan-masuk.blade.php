<x-app-layout :title="'Pesanan Masuk'">

    <div class="flex flex-col justify-center w-11/12">
        <div class="bg-mY w-full p-5 border-2 border-black rounded-tr-md rounded-tl-md flex relative">
            <a href="{{ route('cashier-dashboard') }}" class="z-20">
                <i class="fas fa-arrow-left text-3xl"></i>
            </a>
            <div class="absolute inset-0 flex items-center justify-center">
                <h1 class="font-poppins text-3xl font-bold">Pesanan Masuk</h1>
            </div>

        </div>

        @if ($unconfirmedOrders->isNotEmpty())
        <div
            class="bg-mB p-3 border-2 border-t-0 border-black rounded-bl-md rounded-br-md overflow-x-auto overflow-y-auto">
            <table class="min-w-full bg-gray-50 w-full border border-black table-auto">

                <thead>
                    <tr>
                        <th class="border border-black p-2">No</th>
                        <th class="border border-black w-2/12">Username Pelanggan</th>
                        <th class="border border-black w-2/12">Kode Struk</th>
                        <th class="border border-black w-4/12">Tanggal</th>
                        <th class="w-4/12">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($unconfirmedOrders as $index => $order)
                        <tr class="odd:bg-gray-200 hover:bg-gray-300 text-center">
                            <td class="border border-black">{{ $index + 1 }}</td>
                            <td class="px-2 border border-black">{{ $order->username }}</td>
                            <td class="px-2 border border-black font-semibold">{{ $order->receipt_code }}</td>
                            <td class="px-2 border border-black">{{ $order->order_date }}</td>
                            <td class="p-2 flex gap-2 justify-evenly">

                                <form action="{{ route('hapus-pesanan-masuk', [$order->order_id]) }}" method="POST">
                                    @csrf
                                    @method('delete')

                                    <button
                                        class="bg-red-600 p-1.5 rounded border border-black text-gray-100 hover:bg-red-800"
                                        onclick="confirmDelete(event)">
                                        <i class="fas fa-times"></i>
                                        Batalkan
                                    </button>
                                </form>

                                <a href="{{ route('detail-pesanan-masuk', [$order->order_id]) }}"
                                    class="bg-yellow-400 p-1.5 rounded border border-black hover:bg-yellow-600">
                                    <i class="fas fa-info-circle"></i>
                                    Detail
                                </a>

                                <form action="{{ route('konfirmasi-pesanan-masuk', [$order->order_id]) }}" method="POST">
                                    @csrf
                                    @method('put')

                                    <button
                                        class="bg-green-600 p-1.5 rounded border border-black text-gray-100 hover:bg-red-800"
                                        onclick="confirmData(event)">
                                        <i class="fas fa-check"></i>
                                        Konfirmasi
                                    </button>
                                </form>

                            </td>
                        </tr>
                    @endforeach
                </tbody>

            </table>
        </div>
        @else
        <div class="bg-white border border-black p-3 text-center text-2xl">
            <p>Belum ada pesanan masuk!</p>
        </div>
        @endif
        
    </div>

</x-app-layout>