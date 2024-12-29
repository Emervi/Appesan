<x-app-layout :title="'Detail Pesanan'">

    <div class="w-full">

        {{-- Header --}}
        <div
            class="bg-mY flex justify-between relative font-poppins p-2 border-2 border-b-0 border-black rounded-tl-lg rounded-tr-lg">
            <a href="{{ route('pesanan') }}" class="z-20">
                <i class="fas fa-arrow-left text-3xl"></i>
            </a>
            <div class="absolute inset-0 flex justify-center items-center">
                <h1 class="text-center text-2xl font-bold">Detail Pesanan</h1>
            </div>
        </div>

        <div class="bg-mB p-4 border-2 border-black">
            @foreach ($ordersDetail as $data)
                <div class="flex items-center mb-1 border border-black rounded-lg p-2 bg-gray-50">
                    <img src="{{ asset('images/' . $data->image) }}" alt="Foto menu"
                        class="size-20 object-cover rounded-md">

                    <div class="ml-4 flex-1">
                        <h2 class="text-sm font-semibold text-gray-700">{{ $data->name }}</h2>
                        <p class="text-xs text-gray-500">Kuantitas: {{ $data->quantity }}</p>
                        <p class="text-sm text-gray-700 font-medium">Sub Total: Rp
                            {{ number_format($data->sub_total, 0, ',', '.') }}</p>
                        @if ($data->status == 'Diproses')
                            <p class="text-sm text-gray-500 font-medium">⏳Diproses⏳</p>
                        @elseif ($data->status == 'Dimasak')
                            <p class="text-sm text-gray-500 font-medium">👩‍🍳Sedang dimasak👨‍🍳</p>
                        @elseif ($data->status == 'Dibatalkan')
                            <p class="text-sm text-gray-500 font-medium">❌Dibatalkan❌</p>
                        @elseif ($data->status == 'Disajikan')
                            <p class="text-sm text-gray-500 font-medium">🍴Disajikan🍴</p>
                        @else
                            <p class="text-sm text-gray-500 font-medium">✔Selesai✔</p>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Footer status --}}
        <div class="bg-mY p-2 border-2 border-t-0 border-black rounded-bl-lg rounded-br-lg font-poppins">
            <h3 class="text-sm font-semibold text-gray-700">Total Harga Pesanan:</h3>
            <p class="font-semibold">Rp {{ number_format($totalPrice, 0, ',', '.') }}</p>
        </div>

    </div>
    
</x-app-layout>