<x-app-layout :title="'Menu'">

    <div class="w-full flex flex-col">

        <div class="mb-5">
            <form action="{{ route('menu') }}" method="GET">
                @csrf

                <select name="category" onchange="this.form.submit()"
                    class="bg-mY w-full p-2 text-center border-2 border-black font-poppins rounded-md">
                    <option value="">Semua Kategori</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category }}" {{ request('category') == $category ? 'selected' : '' }}>
                            {{ $category }}</option>
                    @endforeach
                </select>
            </form>
        </div>

        <div class="grid grid-cols-2 gap-3 lg:grid-cols-4 font-roboto">
            @foreach ($menus as $menu)
                @if ($menu->status == 'Tersedia')
                    <div class="bg-mY p-2 rounded-md shadow-md border-2 border-black flex flex-col h-full relative">

                        @if (isset($mostOrderedFood) && $menu->name == $mostOrderedFood->name)
                            <div class="absolute -top-5 -left-5 -rotate-12">
                                <img src="{{ asset('images/assets/bs_label.png') }}" alt="Best seller label"
                                    class="size-20">
                            </div>
                        @elseif (isset($mostOrderedBev) && $menu->name == $mostOrderedBev->name)
                            <div class="absolute -top-5 -left-5 -rotate-12">
                                <img src="{{ asset('images/assets/bs_label.png') }}" alt="Best seller label"
                                    class="size-20">
                            </div>
                        @endif

                        <div>
                            <img src="{{ asset('images/' . $menu->image) }}" alt="Foto menu"
                                class="w-full h-36 object-cover rounded">
                        </div>

                        <div class="flex flex-col h-full">
                            <h2 class="text-xl mb-1">{{ $menu->name }}</h2>
                            <h2 class="text-lg font-semibold mb-3">Rp {{ number_format($menu->price, 0, ',', '.') }}
                            </h2>
                            <div class="flex justify-between gap-2 mt-auto text-sm">
                                <!-- mt-auto agar tombol ke bawah -->
                                <a href="{{ route('detail-menu', [$menu->menu_id]) }}" title="Detail menu"
                                    class="bg-dY flex flex-col justify-between items-center gap-1 rounded border border-black text-center px-2 py-1 w-3/4 hover:bg-mY">
                                    <i class="fas fa-info-circle"></i>
                                    Detail
                                </a>
                                @if (in_array($menu->menu_id, $selectedMenu))
                                    <button title="Menu sudah ditambahkan." disabled
                                        class="bg-gray-400 text-gray-600 w-3/4 h-full flex flex-col justify-between items-center rounded border border-black text-center px-2 py-1">
                                        <i class="fas fa-plus"></i>
                                        Tambah
                                    </button>
                                @else
                                    <form action="{{ route('tambah-menu') }}" method="POST" class="w-3/4">
                                        @csrf
                                        <input type="hidden" name="customer_id"
                                            value="{{ session('customer')['id'] }}">
                                        <input type="hidden" name="menu_id" value="{{ $menu->menu_id }}">
                                        <input type="hidden" name="quantity" value="1">
                                        <button title="Tambah menu ke keranjang."
                                            class="bg-dY w-full h-full flex flex-col justify-between items-center rounded border border-black text-center px-2 py-1 hover:bg-mY">
                                            <i class="fas fa-plus"></i>
                                            Tambah
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                @else
                    <div class="bg-gray-300 p-2 rounded-md shadow-md border-2 border-black flex flex-col h-full">
                        <div>
                            <img src="{{ asset('images/' . $menu->image) }}" alt="Foto menu"
                                class="w-full h-36 object-cover rounded grayscale">
                        </div>

                        <div class="flex flex-col h-full">
                            <h2 class="text-xl mb-1">{{ $menu->name }}</h2>
                            <h2 class="text-lg font-semibold mb-3">Rp {{ number_format($menu->price, 0, ',', '.') }}
                            </h2>
                            <div class="flex justify-between gap-2 mt-auto text-sm">
                                <!-- mt-auto agar tombol ke bawah -->
                                <button disabled
                                    class="bg-gray-400 text-gray-600 w-full h-full flex flex-col justify-between items-center rounded border border-black text-center px-2 py-1.5">
                                    <i class="fas fa-ban"></i>
                                    Kosong
                                </button>
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
    </div>

</x-app-layout>
