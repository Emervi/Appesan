<x-app-layout :title="'Menu'">

    {{-- <div class="grid grid-cols-2 gap-3 lg:grid-cols-4 font-roboto">
        @foreach ($menus as $menu)
        <div class="bg-mY p-1 rounded-md shadow-md border-2 border-black">
            <div>
                <img src="{{ asset('images/' . $menu->image) }}" alt="Foto menu" class="w-full h-40 object-cover rounded">
            </div>
            <div class="flex flex-col bg-red-500 flex-grow">
                <h2 class="text-xl">{{ $menu->name }}</h2>
                <h2 class="text-lg">{{ $menu->formatted_price }}</h2>
                <div class="flex justify-between text-sm">
                    <a href="" class="bg-dY rounded border border-black flex justify-center items-center">
                        Detail
                    </a>
                    <a href="" class="bg-dY rounded border border-black text-center">
                        Tambah
                    </a>
                </div>
            </div>
        </div>
        @endforeach        
    </div> --}}

    <div class="grid grid-cols-2 gap-3 lg:grid-cols-4 font-roboto">
        @foreach ($menus as $menu)
            <div class="bg-mY p-2 rounded-md shadow-md border-2 border-black flex flex-col h-full">
                <div>
                    <img src="{{ asset('images/' . $menu->image) }}" alt="Foto menu"
                        class="w-full h-36 object-cover rounded">
                </div>
                <!-- Flex-grow pada div ini -->
                <div class="flex flex-col h-full">
                    <h2 class="text-xl mb-1">{{ $menu->name }}</h2>
                    <h2 class="text-lg font-semibold mb-3">{{ $menu->formatted_price }}</h2>
                    {{-- <div class="line-clamp-2 w-36 text-sm text-gray-600">{{ $menu->description }}</div> --}}
                    <div class="flex justify-between gap-2 mt-auto text-sm"> <!-- mt-auto agar tombol ke bawah -->
                        <a href="{{ route('detail-menu', [$menu->menu_id]) }}" title="Detail menu"
                            class="bg-dY flex flex-col justify-between items-center gap-1 rounded border border-black text-center px-2 py-1 w-3/4 hover:bg-mY">
                            <i class="fas fa-info-circle"></i>
                            Detail
                        </a>
                        @if (in_array($menu->menu_id, $selectedMenu))
                            <button
                                title="Menu sudah ditambahkan." disabled class="bg-gray-400 text-gray-600 w-3/4 h-full flex flex-col justify-between items-center rounded border border-black text-center px-2 py-1">
                                <i class="fas fa-plus"></i>
                                Tambah
                            </button>
                        @else
                            <form action="{{ route('tambah-menu') }}" method="POST" class="w-3/4">
                                @csrf
                                <input type="hidden" name="customer_id" value="{{ session('customer')['id'] }}">
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
        @endforeach
    </div>

    {{-- data-id="{{ $menu->menu_id }}" id="tambah-menu-{{ $menu->menu_id }}" --}}
    {{-- <script>
        $(document).on('click', ''[id^="tambah-menu-"]'', function() {
            var idMakanan = $(this).data('id');
            
            $.ajax({
                url: "{{ route('tambah-keranjang') }}", // Mengirim request ke route yang dibuat
                type: 'POST',
                data: {
                    id_makanan: idMakanan,
                    _token: '{{ csrf_token() }}' // CSRF token untuk keamanan
                },
                // success: function(response) {
                //     if(response.success) {
                //         alert(response.message); // Menampilkan pesan jika berhasil
                //     }
                // },
                // error: function(xhr, status, error) {
                //     alert("Terjadi kesalahan, coba lagi.");
                // }
            });
        });
    </script> --}}

</x-app-layout>
