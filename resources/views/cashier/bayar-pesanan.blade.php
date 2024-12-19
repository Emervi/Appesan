<x-app-layout :title="'Bayar Pesanan'">

    <div class="w-2/3">
        <div class="bg-mY p-5 border-2 border-black border-b-0 rounded-tr-md rounded-tl-md flex relative">
            <a href="{{ route('pesanan-aktif') }}" class="z-20">
                <i class="fas fa-arrow-left text-3xl"></i>
            </a>
            <div class="absolute inset-0 flex items-center justify-center">
                <h1 class="font-poppins text-3xl font-bold">Pembayaran</h1>
            </div>

        </div>

        <div class="bg-mB flex flex-col items-center p-2 rounded-bl-md rounded-br-md shadow-md border-2 border-black">
            <div class="overflow-y-scroll h-56 w-full">
                <table class="bg-white border border-black w-full">
                    <thead class="border border-black">
                        <tr>
                            <th>No</th>
                            <th>Gambar</th>
                            <th>Nama</th>
                            <th>Quantity</th>
                            <th>Sub Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($order as $index => $data)
                            <tr class="odd:bg-gray-200 hover:bg-gray-300 text-center">
                                <td class="text-center">{{ $index }}</td>
                                <td class="p-2 flex justify-center items-center">
                                    <img src="{{ asset('images/' . $data->image) }}" alt="Foto menu"
                                        class="size-20 rounded object-cover">
                                </td>
                                <td>{{ $data->name }}</td>
                                <td>{{ $data->quantity }}</td>
                                <td>{{ $data->sub_total }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="bg-mY p-1 rounded border border-black mt-3 w-1/2">
                <form action="{{ route('terima-transaksi') }}" method="POST" class="flex flex-col gap-2">
                    @csrf
                    <p class="text-xl font-semibold">Total: Rp. {{ number_format($total, 0, ',', '.') }}</p>
                    <input type="hidden" name="total" value="{{ $total }}">
                    <input type="number" name="uangPembayaran" class="rounded-md p-2 border border-black outline-none">
                    @foreach ($order as $data)
                    <input type="hidden" name="order_id" value="{{ $data->order_id }}">
                    <input type="hidden" name="menu_id[]" value="{{ $data->menu_id }}">
                    <input type="hidden" name="quantity[]" value="{{ $data->quantity }}">
                    <input type="hidden" name="sub_total[]" value="{{ $data->sub_total }}">
                    @endforeach

                    <button class="p-2 text-white border border-black rounded-md bg-green-600 hover:bg-green-800">
                        <i class="fas fa-check"></i>
                        Bayar
                    </button>
                </form>
            </div>
        </div>
    </div>

</x-app-layout>
