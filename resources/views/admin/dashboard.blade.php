<x-app-layout :title="'Beranda Admin'">

    <div class="flex flex-col items-center w-full">
        <div class="flex justify-between w-full mb-10">
            <h1 class="text-3xl font-poppins">Halo {{ $name }}!</h1>
            <div id="clock" class="text-3xl font-poppins"></div>
        </div>

        <div class="w-full flex justify-evenly mb-5">

            <div class="w-1/3 p-3 bg-mY border-2 border-black rounded-md shadow-md">
                <h2 class="text-2xl font-poppins text-center mb-3">Jumlah pesanan hari ini</h2>
                <div class="flex justify-evenly text-5xl">
                    <i class="fas fa-receipt"></i>
                    <p>{{ $todayOrders }}</p>
                </div>
            </div>

            <div class="w-1/3 p-3 bg-mY border-2 border-black rounded-md shadow-md">
                <h2 class="text-2xl font-poppins text-center mb-3">Jumlah menu yang dipesan hari ini</h2>
                <div class="flex justify-evenly text-5xl">
                    <i class="fas fa-scroll"></i>
                    <p>{{ $todayMenus }}</p>
                </div>
            </div>

        </div>

        <div class="w-1/2 justify-center">
            <div class="p-3 bg-mY border-2 border-black rounded-md shadow-md">
                <h2 class="text-2xl font-poppins text-center mb-5">Jumlah pendapatan hari ini</h2>
                <div class="flex justify-evenly text-5xl">
                    <i class="fas fa-money-bill-1"></i>
                    <p>Rp. {{ number_format($todayIncomes, 0, ',', '.') }}</p>
                </div>
            </div>
        </div>

    </div>

</x-app-layout>
