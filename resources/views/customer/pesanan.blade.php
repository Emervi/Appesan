<x-app-layout :title="'Pesanan'">

    <div class="flex flex-col w-full font-roboto">
        
        <div class="mb-5">
            <a href="" class="bg-mY w-1/3 p-2 border-2 border-black font-poppins rounded-md">
                <i class="fas fa-filter"></i>
                Status: Diproses
                <i class="fas fa-chevron-down ml-1"></i>
            </a>
        </div>

        <div class="bg-mY p-2 border-2 border-b-0 border-black rounded-tl-lg rounded-tr-lg font-poppins">
            <h1 class="text-center font-bold text-3xl">Pesanan</h1>
        </div>

        <div class="bg-mB p-2 border-2 border-black rounded-bl-md rounded-br-md shadow-md mb-5">
            @if ($orders->isNotEmpty())            
            <!-- Responsive Design for Mobile -->
            <div class="grid gap-4">
                @foreach ($orders as $index => $order)
                <div class="border border-black rounded-md bg-white p-4">
                    <div class="flex justify-between text-sm font-semibold">
                        <span>No:</span>
                        <span>{{ $index + 1 }}</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span>Kode Struk:</span>
                        <span>{{ $order->receipt_code }}</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span>Tanggal:</span>
                        <span>{{ $order->order_date }}</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span>Status:</span>
                        <span>{{ $order->status }}</span>
                    </div>
                    <div class="mt-3 flex justify-end gap-2">
                        <a href="{{ route('hapus-pesanan', [$order->order_id]) }}" class="bg-red-500 text-white px-3 py-1 rounded-md hover:bg-blue-600 text-sm flex items-center gap-1">
                            <i class="fas fa-times"></i>
                            Batalkan
                        </a>
                        <a href="{{ route('detail-pesanan', [$order->order_id]) }}" class="bg-blue-500 text-white px-3 py-1 rounded-md hover:bg-blue-600 text-sm flex items-center gap-1">
                            <i class="fas fa-info-circle"></i>
                            Detail
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
            
            @else
                <div class="p-2 flex justify-center items-center bg-white border border-black rounded-md shadow-md">
                    <p>Anda belum pernah memesan!</p>
                </div>
            @endif
        </div>
    </div>

</x-app-layout>
