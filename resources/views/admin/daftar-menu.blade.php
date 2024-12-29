<x-app-layout title="Daftar Menu">

    <div class="flex flex-col justify-center w-11/12">
        <div class="bg-mB w-full p-5 border-2 border-black rounded-tr-md rounded-tl-md flex justify-between relative">

            {{-- Tombol filter categories --}}
            <form action="{{ route('admin.daftar-menu') }}" method="GET" class="z-10 font-roboto">
                @csrf

                <select name="category" onchange="this.form.submit()"
                    class="bg-mY p-2 rounded-md border border-black text-center cursor-pointer">
                    <option value="">Semua Kategori</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category }}" {{ request('category') == $category ? 'selected' : '' }}>
                            {{ $category }}</option>
                    @endforeach
                </select>
            </form>

            <div class="absolute inset-0 flex items-center justify-center">
                <h1 class="font-poppins text-4xl font-bold text-white">Daftar Menu</h1>
            </div>

            {{-- Tombol tambah --}}
            <a href="{{ route('admin.tambah-menu') }}"
                class="bg-green-600 p-2 border border-black text-white rounded-md hover:bg-green-700 z-10">
                <i class="fas fa-plus mr-2"></i>
                Tambah menu
            </a>
        </div>

        <div
            class="bg-lB p-3 border-2 border-t-0 border-black rounded-bl-md rounded-br-md overflow-x-auto overflow-y-auto">
            <table class="min-w-full bg-gray-50 w-full border border-black table-auto">

                <thead class="border border-black">
                    <tr>
                        <th class="border border-black p-2">No</th>
                        <th class="border border-black w-1/12">Gambar</th>
                        <th class="border border-black w-2/12">Nama</th>
                        <th class="border border-black w-2/12">Harga</th>
                        <th class="border border-black w-3/12">Deskripsi</th>
                        <th class="border border-black w-1/12">Kategori</th>
                        <th class="border border-black w-1/12">Status</th>
                        <th class="border border-black w-2/12">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($menus as $index => $menu)
                        <tr class="odd:bg-gray-200 hover:bg-gray-300 text-center">
                            <td class="text-center">{{ $offset + $index + 1 }}</td>
                            <td class="p-2">
                                <div class="flex justify-center items-center">
                                    <img src="{{ asset('images/' . $menu->image) }}" alt="Foto menu"
                                        class="size-16 rounded-md object-cover">
                                </div>
                            </td>
                            <td>{{ $menu->name }}</td>
                            <td>Rp {{ number_format($menu->price, 0, ',', '.') }}</td>
                            <td>{{ $menu->description }}</td>
                            <td>{{ $menu->category }}</td>
                            <td>{{ $menu->status }}</td>
                            <td class="p-2 flex gap-2 justify-evenly items-center mt-3">
                                <a href="{{ route('admin.ubah-menu', [$menu->menu_id]) }}"
                                    class="bg-yellow-400 p-1.5 rounded border border-black hover:bg-yellow-600">
                                    <i class="fas fa-pen"></i>
                                    Ubah
                                </a>

                                <form action="{{ route('admin.hapus-menu', [$menu->menu_id]) }}" method="POST">
                                    @csrf
                                    @method('delete')

                                    <button
                                        class="bg-red-600 p-1.5 rounded border border-black text-gray-100 hover:bg-red-800"
                                        onclick="confirmDelete(event)">
                                        <i class="fas fa-trash"></i>
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    @if (empty($menus[0]))
                        <tr>
                            <td colspan="8" class="text-center font-bold text-xl p-3">Tidak ada menu.</td>
                        </tr>
                    @endif
                </tbody>
            </table>
            <div class="mt-3">
                @if ($offset > -1)
                    {{-- pagination --}}
                    {{ $menus->links() }}
                @endif
            </div>
        </div>
    </div>

</x-app-layout>
