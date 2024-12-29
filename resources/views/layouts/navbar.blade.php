<div class="flex justify-between bg-lB p-5 border-b-2 border-black sticky top-0 z-30">

    {{-- Navbar Label --}}
    @if (session()->has('admin'))
        <a href="{{ route('admin-dashboard') }}">
            <img src="{{ asset('images/assets/Label Appesan.png') }}" alt="Label Appesan" class="w-40">
        </a>
    @elseif (session()->has('cashier'))
        <a href="{{ route('cashier-dashboard') }}">
            <img src="{{ asset('images/assets/Label Appesan.png') }}" alt="Label Appesan" class="w-40">
        </a>
    @elseif (session()->has('customer'))
        <a href="{{ route('menu') }}">
            <img src="{{ asset('images/assets/Label Appesan.png') }}" alt="Label Appesan" class="w-40">
        </a>
    @else
        <img src="{{ asset('images/assets/Label Appesan.png') }}" alt="Label Appesan" class="w-40">
    @endif

    {{-- Navbar Button --}}
    @if (session()->has('admin'))
        <div class="w-8/12 flex justify-evenly ">
            <a href="{{ route('admin.daftar-menu') }}"
                class="{{ $judul == 'Daftar Menu' || $judul == 'Tambah Menu' || $judul == 'Ubah Menu' ? 'bg-dY' : 'bg-mY shadow-xl' }} text-black font-poppins border border-black p-2 rounded-md hover:bg-dY">Daftar
                Menu</a>
            <a href="{{ route('admin.daftar-transaksi') }}"
                class="{{ $judul == 'Daftar Transaksi' || $judul == 'Detail Transaksi' ? 'bg-dY' : 'bg-mY shadow-xl' }} text-black font-poppins border border-black p-2 rounded-md hover:bg-dY">Daftar
                Transaksi</a>
            <a href="{{ route('admin.daftar-cashier') }}"
                class="{{ $judul == 'Daftar Kasir' || $judul == 'Tambah Kasir' || $judul == 'Ubah Kasir' ? 'bg-dY' : 'bg-mY shadow-xl' }} text-black font-poppins border border-black p-2 rounded-md hover:bg-dY">Daftar
                Kasir</a>
            <a href="{{ route('admin.daftar-chef') }}"
                class="{{ $judul == 'Daftar Koki' || $judul == 'Tambah Koki' || $judul == 'Ubah Koki' ? 'bg-dY' : 'bg-mY shadow-xl' }} text-black font-poppins border border-black p-2 rounded-md hover:bg-dY">Daftar
                Koki</a>
            <a href="{{ route('admin.daftar-customer') }}"
                class="{{ $judul == 'Daftar Pelanggan' || $judul == 'Tambah Pelanggan' || $judul == 'Ubah Pelanggan' ? 'bg-dY' : 'bg-mY shadow-xl' }} text-black font-poppins border border-black p-2 rounded-md hover:bg-dY">Daftar
                Pelanggan</a>
        </div>
    @else
        <div></div>
    @endif

    {{-- Navbar Logout --}}
    @if (session()->has('admin') || session()->has('cashier') || session()->has('chef'))
        <form action="{{ route('logout-pegawai') }}" method="POST">
            @csrf

            <button type="submit"
                class="text-black w-full h-full bg-mY border border-black px-2 font-poppins bg-midyellow rounded-md shadow-md hover:bg-dY flex justify-center items-center gap-2">
                Logout
                <i class="fas fa-sign-out"></i>
            </button>
        </form>
    @elseif (session()->has('customer'))
        {{-- DROPDOWN --}}
        <div class="relative inline-block text-left font-poppins">

            <!-- Tombol Dropdown -->
            @if ($judul == 'Menu')
                <button id="dropdownButton"
                    class="p-2 w-28 flex justify-center items-center bg-mY border border-black rounded-md shadow-md">
                    <i class="fas fa-utensils mr-1 text-sm"></i>
                    Menu
                    <i class="fas fa-chevron-down ml-2"></i>
                </button>
            @elseif ($judul == 'Keranjang')
                <button id="dropdownButton"
                    class="p-2 w-28 flex justify-center items-center bg-mY border border-black rounded-md shadow-md">
                    <i class="fas fa-cart-shopping mr-1 text-xs"></i>
                    Keranjang
                    <i class="fas fa-chevron-down ml-1 text-xs"></i>
                </button>
            @elseif ($judul == 'Pesanan')
                <button id="dropdownButton"
                    class="p-2 w-28 flex justify-center items-center bg-mY border border-black rounded-md shadow-md">
                    <i class="fas fa-scroll mr-1 text-xs"></i>
                    Pesanan
                    <i class="fas fa-chevron-down ml-1 text-xs"></i>
                </button>
            @endif

            <!-- Menu Dropdown -->
            <div id="dropdownMenu"
                class="hidden absolute right-0 w-28 rounded-br-md rounded-bl-md text-white border border-black shadow-2xl bg-dY">
                <div class="py-1">

                    @if ($judul == 'Menu')
                        <a href="{{ route('keranjang') }}"
                            class="px-3 py-2 flex justify-center items-center text-sm border-b border-black hover:bg-mY hover:text-black">
                            <i class="fas fa-cart-shopping text-sm mr-1"></i>
                            Keranjang
                        </a>
                    @elseif ($judul == 'Keranjang' || $judul == 'Pesanan')
                        <a href="{{ route('menu') }}"
                            class="px-3 py-2 flex justify-center items-center text-sm border-b border-black hover:bg-mY hover:text-black">
                            <i class="fas fa-utensils text-sm mr-1"></i>
                            Menu
                        </a>
                    @endif

                    @if ($judul == 'Pesanan')
                        <a href="{{ route('keranjang') }}"
                            class="px-3 py-2 flex justify-center items-center text-sm border-b border-black hover:bg-mY hover:text-black">
                            <i class="fas fa-cart-shopping text-sm mr-1"></i>
                            Keranjang
                        </a>
                    @elseif ($judul == 'Menu' || $judul == 'Keranjang')
                        <a href="{{ route('pesanan') }}"
                            class="px-3 py-2 flex justify-center items-center text-sm border-b border-black hover:bg-mY hover:text-black">
                            <i class="fas fa-scroll text-sm mr-1"></i>
                            Pesanan
                        </a>
                    @endif

                    <form action="{{ route('logout') }}" method="POST">
                        @csrf

                        <button type="submit"
                            class="px-4 w-full h-full py-2 flex justify-center items-center text-sm hover:bg-mY hover:text-black">
                            <i class="fas fa-sign-out text-sm mr-1"></i>
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    @else
    @endif

    <script>
        const dropdownButton = document.getElementById('dropdownButton');
        const dropdownMenu = document.getElementById('dropdownMenu');

        dropdownButton.addEventListener('click', () => {
            dropdownMenu.classList.toggle('hidden'); // Tampilkan/Sembunyikan menu
            if (!dropdownMenu.classList.contains("hidden")) {
                dropdownButton.classList.remove('rounded-md')
                dropdownButton.classList.remove('bg-mY')
                dropdownButton.classList.remove('text-black')
                dropdownButton.classList.add("rounded-tr-md")
                dropdownButton.classList.add("rounded-tl-md")
                dropdownButton.classList.add("border-b-0")
                dropdownButton.classList.add("bg-dY")
                dropdownButton.classList.add("text-white")
            } else {
                dropdownButton.classList.add('rounded-md')
                dropdownButton.classList.add('bg-mY')
                dropdownButton.classList.add('text-black')
                dropdownButton.classList.remove("rounded-tr-md")
                dropdownButton.classList.remove("rounded-tl-md")
                dropdownButton.classList.remove("border-b-0")
                dropdownButton.classList.remove("bg-dY")
                dropdownButton.classList.remove("text-white")
            }
        });

        // Tutup dropdown jika klik di luar elemen dropdown
        document.addEventListener('click', (event) => {
            if (!dropdownButton.contains(event.target) && !dropdownMenu.contains(event.target)) {
                dropdownMenu.classList.add('hidden')
                dropdownButton.classList.add('rounded-md')
                dropdownButton.classList.add('bg-mY')
                dropdownButton.classList.add('text-black')
                dropdownButton.classList.remove("rounded-tr-md")
                dropdownButton.classList.remove("rounded-tl-md")
                dropdownButton.classList.remove("border-b-0")
                dropdownButton.classList.remove("bg-dY")
                dropdownButton.classList.remove("text-white")
            }
        });
    </script>

</div>
