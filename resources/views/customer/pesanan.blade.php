<x-app-layout :title="'Pesanan'">

    <div class="flex flex-col w-full font-roboto">

        <div class="mb-5">
            <form action="{{ route('pesanan') }}" method="GET">
                @csrf

                <select name="status" onchange="this.form.submit()"
                    class="bg-mY w-1/2 p-2 text-center border-2 border-black font-poppins rounded-md">
                    <option value="">Semua Status</option>
                    @foreach ($statuses as $status)
                        <option value="{{ $status }}" {{ request('status') == $status ? 'selected' : '' }}>
                            {{ $status }}</option>
                    @endforeach
                </select>
            </form>
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
                                <span>Atas Nama:</span>
                                <span>{{ $order->username }}</span>
                            </div>
                            <div class="flex justify-between text-sm font-semibold">
                                <span>Kode Struk:</span>
                                <span>{{ $order->receipt_code }}</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span>Tanggal:</span>
                                <span>{{ $order->order_date }}</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span>Status:</span>
                                <span>
                                    @if ($order->status == 'Dipesan')
                                        🛒Dipesan🛒
                                    @elseif ($order->status == 'Diproses')
                                        ⏳Diproses⏳
                                    @elseif ($order->status == 'Dibatalkan')
                                        ❌Dibatalkan❌
                                    @elseif ($order->status == 'Disajikan')
                                        🍴Disajikan🍴
                                    @else
                                        ✔Selesai✔
                                    @endif
                                </span>
                            </div>
                            <div class="mt-3 flex justify-end gap-2">
                                @if ($order->status == 'Dipesan')
                                <form action="{{ route('batalkan-pesanan', [$order->order_id]) }}" method="POST">
                                    @csrf
                                    @method('put')

                                    <button type="submit"
                                        class="bg-red-500 text-white px-3 py-1 rounded-md hover:bg-red-700 text-sm flex items-center gap-1 border border-black">
                                        <i class="fas fa-times"></i>
                                        Batalkan
                                    </button>
                                </form>
                                @endif

                                <a href="{{ route('detail-pesanan', [$order->order_id]) }}"
                                    class="bg-mY px-3 py-1 rounded-md hover:bg-dY text-sm flex items-center gap-1 border border-black">
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