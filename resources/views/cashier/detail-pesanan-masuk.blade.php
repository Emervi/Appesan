<x-app-layout :title="'Detail Pesanan Masuk'">

    <div class="w-2/3">

        {{-- Header --}}
        <div
            class="bg-mY flex justify-between relative font-poppins p-2 border-2 border-b-0 border-black rounded-tl-lg rounded-tr-lg">
            <a href="{{ route('pesanan-masuk') }}" class="z-20">
                <i class="fas fa-arrow-left text-3xl"></i>
            </a>
            <div class="absolute inset-0 flex justify-center items-center">
                <h1 class="text-center text-2xl font-bold">Detail Pesanan Masuk</h1>
            </div>
        </div>

        <div class="bg-mB p-4 border-2 border-black flex flex-col items-center max-h-96 overflow-y-auto">
            @foreach ($order as $data)
                <div class="flex items-center border border-black rounded-lg p-2 bg-gray-50 mb-1 w-2/3">
                    <img src="{{ asset('images/' . $data->image) }}" alt="Foto menu"
                        class="size-20 object-cover rounded-md">

                    <div class="ml-4 flex-1 flex justify-between">
                        <div>
                            <h2 class="font-semibold text-gray-700">{{ $data->name }}</h2>
                            <p class="text-gray-500">Kuantitas: {{ $data->quantity }}</p>
                        </div>
                        <div class="font-medium">
                            <h3>Sub Total:</h3>
                            <p>Rp {{ number_format($data->sub_total, 0, ',', '.') }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Footer status --}}
        <div class="bg-mY font-semibold text-xl flex flex-col justify-between p-2 border-2 border-t-0 border-black rounded-bl-lg rounded-br-lg font-poppins">
            <h3>{{ $order[0]->receipt_code }}</h3>
            <div class="flex justify-between">
                <h3>Total Harga Pesanan:</h3>
                <p>Rp {{ number_format($totalPrice, 0, ',', '.') }}</p>
            </div>
        </div>

    </div>

</x-app-layout>