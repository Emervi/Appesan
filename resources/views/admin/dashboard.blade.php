<x-app-layout :title="'Beranda Admin'">

    <div class="flex flex-col items-center w-full">
        <div class="flex justify-between w-full mb-10">
            <h1 class="text-3xl font-poppins">Halo {{ $name }}!</h1>
            <div id="clock" class="text-3xl font-poppins"></div>
        </div>

        <div class="grid grid-cols-3 w-full">
            <div class="bg-mY p-2 border-2 border-black rounded-md shadow-md col-span-1 flex flex-col gap-5">
                <div class="flex flex-col items-center justify-evenly gap-2">
                    <span class="font-bold font-poppins text-2xl text-center">Menu Yang Paling Banyak Dipesan Bulan Ini</span>

                    @if (isset($mostOrderedMenu))
                        <div
                            class="bg-gray-50 rounded-md border border-black p-1 flex items-center justify-evenly gap-2 text-sm font-semibold w-1/2">
                            <img src="{{ asset('images/' . $mostOrderedMenu->image) }}" alt="Foto menu"
                                class="size-20 rounded object-cover">
                            <div class="text-center">
                                <p>{{ $mostOrderedMenu->name }}</p>
                                <p>({{ $mostOrderedMenu->category }})</p>
                            </div>
                        </div>
                    @else
                        <div
                            class="bg-gray-50 rounded-md border border-black p-1 flex items-center justify-evenly gap-2 text-sm font-semibold w-1/2">
                            <span>Belum ada!</span>
                        </div>
                    @endif
                </div>

                <div class="flex flex-col items-center justify-evenly gap-2">
                    <span class="font-bold font-poppins text-2xl text-center">Menu Populer Bulan Ini</span>

                    <div class="flex justify-between gap-2 w-full">
                        <div
                            class="bg-gray-50 rounded-md border border-black p-1 flex items-center justify-evenly gap-2 text-sm font-semibold w-1/2">
                            @if (isset($mostOrderedFood))
                                <img src="{{ asset('images/' . $mostOrderedFood->image) }}" alt="Foto menu"
                                    class="size-20 rounded object-cover">
                                <div class="text-center">
                                    <p>{{ $mostOrderedFood->name }}</p>
                                    <p>({{ $mostOrderedFood->category }})</p>
                                </div>
                            @else
                                Belum ada
                            @endif
                        </div>

                        <div
                            class="bg-gray-50 rounded-md border border-black p-1 flex items-center justify-evenly gap-2 text-sm font-semibold w-1/2">
                            @if (isset($mostOrderedBev))
                                <img src="{{ asset('images/' . $mostOrderedBev->image) }}" alt="Foto menu"
                                    class="size-20 rounded object-cover">
                                <div class="text-center">
                                    <p>{{ $mostOrderedBev->name }}</p>
                                    <p>({{ $mostOrderedBev->category }})</p>
                                </div>
                            @else
                                Belum ada
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-span-2 flex flex-col gap-3">
                <div class="flex justify-evenly">
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

                <div class="flex justify-center">
                    <div class="w-2/3 p-3 bg-mY border-2 border-black rounded-md shadow-md">
                        <h2 class="text-2xl font-poppins text-center mb-5">Jumlah pendapatan hari ini</h2>
                        <div class="flex justify-evenly text-5xl">
                            <i class="fas fa-money-bill-1"></i>
                            <p>Rp {{ number_format($todayIncomes, 0, ',', '.') }}</p>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>

    {{-- Script mereload halaman setiap 10 detik --}}
    <script>
        setTimeout(function() {
            window.location.reload();
        }, 15000); // 15 detik
    </script>

</x-app-layout>
