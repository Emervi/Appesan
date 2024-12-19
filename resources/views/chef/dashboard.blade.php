<x-app-layout :title="'Beranda Koki'">

    <div class="w-1/2">
        <div class="bg-mB rounded-tr-md rounded-tl-md p-3 border-2 border-b-0 border-black">
            <p class="font-poppins text-3xl font-bold text-center text-gray-100">!Pesanan!</p>
        </div>

        <div class="bg-dY p-3 border-2 border-black rounded-br-md rounded-bl-md shadow-md font-roboto">
            @if ($orders->isNotEmpty())
            @foreach ($orders as $detail)
                <div
                    class="bg-mB w-full mb-1 flex justify-between items-center p-2 rounded-md shadow-md border border-black">

                    <div
                        class="flex flex-col text-sm items-center font-semibold bg-white rounded-md p-2 border border-black">
                        <p>Atas nama:</p>
                        <p>{{ $detail->username }}</p>
                    </div>
                    <div class="flex gap-2 font-semibold bg-white rounded-md p-2 border border-black">
                        <p>{{ $detail->quantity }}</p>
                        <p>{{ $detail->menu->name }}</p>
                    </div>

                    <div>
                        <form
                            action="{{ route('selesaikan-menu', ['order_id' => $detail->order_id, 'menu_id' => $detail->menu_id]) }}"
                            method="POST">
                            @csrf
                            @method('put')

                            <button
                                class="bg-green-600 p-2 border border-black rounded-md text-white hover:bg-green-800">
                                <i class="fas fa-check"></i>
                                Selesai
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
            @else
            <div class="bg-white text-center p-2 text-xl font-semibold border border-black rounded-md">
                <p>Belum ada pesanan.</p>
            </div>
            @endif
        </div>
    </div>

    {{-- Script mereload halaman setiap 10 detik --}}
    <script>
        setTimeout(function() {
            window.location.reload();
        }, 10000); // 10 detik
    </script>

</x-app-layout>
