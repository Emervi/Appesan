<x-app-layout :title="'Keranjang'">

    <div class="flex flex-col w-full font-roboto">
        <div class="bg-mY p-2 border-2 border-b-0 border-black rounded-tl-lg rounded-tr-lg font-poppins">
            <h1 class="text-center font-bold text-3xl">Keranjang</h1>
        </div>

        <div class="bg-mB p-2 border-2 border-black rounded-bl-md rounded-br-md shadow-md mb-5">
            @if ($carts->isNotEmpty())
                @foreach ($carts as $cart)
                    <div class="p-1.5 flex items-center gap-2 bg-white border border-black rounded-md shadow-md mb-3">

                        <div>
                            <img src="{{ asset('images/' . $cart->image) }}" alt="Foto menu" class="size-20 rounded">
                        </div>

                        <div class="flex flex-col flex-1">
                            <p class="text-xl">{{ $cart->name }}</p>
                            <p class="font-bold mb-3">{{ $cart->formatted_price }}</p>
                            <div class="flex flex-col">
                                <p>Subtotal:</p>
                                <p>Rp. {{ number_format($cart->price * $cart->quantity, 0, ',', '.') }}</p>
                            </div>
                        </div>

                        <div class="flex-1 flex flex-col items-center gap-5">
                            <div>
                                <form action="{{ route('hapus-keranjang-menu', [$cart->menu_id]) }}" method="POST">
                                    @csrf
                                    @method('delete')
                                    <button type="submit"
                                        class="p-2 bg-red-500 rounded flex justify-center items-center hover:bg-red-700">
                                        <i class="fas fa-trash text-xl text-white"></i>
                                    </button>
                                </form>
                            </div>

                            <div class="flex justify-between items-center w-full">
                                <form action="{{ route('kurangi-kuantitas', [$cart->menu_id]) }}" method="POST">
                                    @csrf
                                    @method('put')
                                    @if ($cart->quantity <= 1)
                                        <button disabled
                                            class="flex items-center justify-center size-7 rounded-full bg-gray-400">
                                            <span class="text-white text-2xl leading-none">-</span>
                                        </button>
                                    @else
                                        <button type="submit"
                                            class="flex items-center justify-center size-7 rounded-full bg-black">
                                            <span class="text-white text-2xl leading-none">-</span>
                                        </button>
                                    @endif
                                </form>
                                <p class="text-xl">{{ $cart->quantity }}</p>
                                <form action="{{ route('tambah-kuantitas', [$cart->menu_id]) }}" method="POST">
                                    @csrf
                                    @method('put')
                                    <button type="submit"
                                        class="flex items-center justify-center size-7 rounded-full bg-black">
                                        <span class="text-white text-2xl leading-none">+</span>
                                    </button>
                                </form>
                            </div>
                        </div>

                    </div>
                @endforeach
            @else
                <div class="p-2 flex justify-center items-center bg-white border border-black rounded-md shadow-md">
                    <p>Keranjang masih kosong!</p>
                </div>
            @endif
        </div>

        @if ($carts->isNotEmpty())
        <p class="text-3xl mb-5 font-semibold">Total: Rp. {{ number_format($carts->sum('total'), 0, ',', '.') }}</p>

        <form action="{{ route('tambah-pesanan') }}" method="POST">
            @csrf
            @foreach ($carts as $cart)
                <input type="hidden" name="menu_id[]" value="{{ $cart->menu_id }}">
                <input type="hidden" name="total_price" value="{{ $carts->sum('total') }}">
                <input type="hidden" name="quantity[]" value="{{ $cart->quantity }}">
                <input type="hidden" name="price[]" value="{{ $cart->price }}">
            @endforeach
            <button type="submit"
                class="font-semibold text-3xl text-center p-3 rounded-md shadow-md w-full bg-mY border-2 border-black">Konfirmasi</button>
        </form>
        @else  
        @endif
    </div>

</x-app-layout>