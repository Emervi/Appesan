<x-app-layout :title="'Bayar Pesanan'">

    <div class="w-full">
        <div class="bg-mY p-5 border-2 border-black border-b-0 rounded-tr-md rounded-tl-md flex relative">
            <a href="{{ route('pesanan-aktif') }}" class="z-20">
                <i class="fas fa-arrow-left text-3xl"></i>
            </a>
            <div class="absolute inset-0 flex items-center justify-center">
                <h1 class="font-poppins text-3xl font-bold">Pembayaran</h1>
            </div>

        </div>

        <div class="bg-mB grid grid-cols-2 items-center p-2 rounded-bl-md rounded-br-md shadow-md border-2 border-black">

            <div class="p-1 flex flex-col gap-1 h-96 max-h-96 overflow-y-auto">
                @foreach ($order as $index => $data)
                    <div
                        class="bg-white border border-black rounded-md p-2 flex justify-between items-center hover:bg-gray-200">
                        <div class="flex items-center gap-2">
                            <img src="{{ asset('images/' . $data->image) }}" alt="Foto menu"
                                class="size-20 rounded-md object-cover">
                            <div class="flex flex-col">
                                <span>{{ $data->name }}</span>
                                <span>{{ $data->quantity }} x Rp {{ number_format($data->price, 0, ',', '.') }}</span>
                            </div>
                        </div>

                        <div class="flex flex-col items-center font-semibold">
                            <span>Sub Total:</span>
                            <span>Rp {{ number_format($data->sub_total, 0, ',', '.') }}</span>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="p-1 grid grid-rows-3 h-full">
                <div class="bg-gray-100 p-1 row-span-2 max-h-60 overflow-y-auto border border-black">
                    @foreach ($order as $index => $data)
                        <div class="flex justify-between border-b border-gray-500 p-1">
                            <span>{{ $data->name }} x {{ $data->quantity }}</span>
                            <span class="font-semibold">Rp {{ number_format($data->sub_total, 0, ',', '.') }}</span>
                        </div>
                    @endforeach
                </div>

                <div class="bg-yellow-500 row-span-1 border border-black p-1">
                    <form action="{{ route('terima-transaksi') }}" method="POST"
                        class="flex flex-col h-full justify-between">
                        @csrf

                        <input type="hidden" name="total" value="{{ $total }}">
                        @foreach ($order as $data)
                            <input type="hidden" name="order_id" value="{{ $data->order_id }}">
                            <input type="hidden" name="menu_id[]" value="{{ $data->menu_id }}">
                            <input type="hidden" name="quantity[]" value="{{ $data->quantity }}">
                            <input type="hidden" name="sub_total[]" value="{{ $data->sub_total }}">
                        @endforeach

                        <div class="text-xl font-semibold">
                            Total: Rp {{ number_format($total, 0, ',', '.') }}
                        </div>

                        <div class="w-full flex flex-col gap-2">
                            <input type="number" name="uangPembayaran"
                                class="rounded border border-black outline-none p-1">
                            <button onclick="confirmData(event)"
                                class="p-2 text-white border border-black rounded-md bg-green-600 hover:bg-green-800">
                                Bayar
                            </button>
                        </div>

                    </form>
                </div>
            </div>

        </div>
    </div>

</x-app-layout>
