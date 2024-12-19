<x-app-layout :title="'Beranda Kasir'">

    <div class="w-full font-poppins flex flex-col">
        <div class="flex justify-between w-full mb-10">
            <h1 class="text-3xl font-poppins">Halo {{ $name }}!</h1>
            <div id="clock" class="text-3xl font-poppins"></div>
        </div>

        <div class="flex justify-evenly">
            <a href="{{ route('pesanan-masuk') }}" class="p-2 bg-mY group rounded-md shadow-md flex flex-col justify-between items-center text-3xl border-2 border-black w-1/6 hover:bg-dY">
                <i class="fas fa-arrow-right-to-bracket"></i>
                <p class="text-center">Pesanan Masuk</p>
                <div class="bg-white rounded-full w-1/3 text-center group-hover:bg-gray-300">
                    {{ $unconfirmedOrder }}
                </div>
            </a>

            <a href="{{ route('pesanan-aktif') }}" class="p-2 bg-mY group rounded-md shadow-md flex flex-col justify-between items-center text-3xl border-2 border-black w-1/6 hover:bg-dY">
                <i class="fas fa-clock"></i>
                <p class="text-center">Pesanan Aktif</p>
                <div class="bg-white rounded-full w-1/3 text-center group-hover:bg-gray-300">
                    {{ $waitingOrder }}
                </div>
            </a>

            <a href="{{ route('pesanan-aktif') }}" class="p-2 bg-mY group rounded-md shadow-md flex flex-col justify-between gap-2 items-center text-3xl border-2 border-black w-1/6 hover:bg-dY">
                <i class="fas fa-check"></i>
                <p class="text-center">Pesanan Selesai</p>
                <div class="bg-white rounded-full w-1/3 text-center group-hover:bg-gray-300">
                    {{ $completeOrder }}
                </div>
            </a>
        </div>
    </div>

    {{-- Script mereload halaman setiap 10 detik --}}
    <script>
        setTimeout(function() {
            window.location.reload();
        }, 10000); // 10 detik
    </script>

</x-app-layout>